@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/charts/apexcharts.css') }}">
    <style>
        .chart-shadow {
            filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.1));
            transition: all 0.3s ease;
        }

        .chart-shadow:hover {
            filter: drop-shadow(0px 8px 16px rgba(0, 0, 0, 0.15));
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection
@section('content')
    {{-- Page title & description per requirements --}}
    <div class="row mb-2">
        <div class="col-12">
            <h4 class="text-bold-700">{{ __('admin.dashboard_overview_title') }}</h4>
            <p class="text-muted mb-0">{{ __('admin.dashboard_overview_desc') }}</p>
        </div>
    </div>

    {{-- Export buttons --}}
    <div class="row mb-2">
        <div class="col-12">
            <div class="btn-group">
                <a href="{{ route('admin.dashboard.export.excel') }}" class="btn btn-success waves-effect">
                    <i class="feather icon-file-text"></i> {{ __('admin.export_excel') }}
                </a>
                <a href="{{ route('admin.dashboard.export.pdf') }}" class="btn btn-danger waves-effect" target="_blank">
                    <i class="feather icon-file"></i> {{ __('admin.export_pdf') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row align-center">
        @foreach ($menus as $key => $menu)
            @if (!isset($menu['count_type']) || $menu['count_type'] != __('admin.providers_count'))
                @php $color = $colors[array_rand($colors)] @endphp
                <a href="{{ $menu['url'] }}" class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="avatar bg-rgba-{{ $color }} p-50 m-0 mb-1">
                                    <div class="avatar-content">
                                        <i
                                            class="feather {!! $menu['icon'] !!} text-{!! $color !!} font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="text-bold-700">{{ $menu['count'] }}</h2>
                                @isset($menu['count_type'])
                                    <p class="text-bold-700">{{ $menu['count_type'] }}</p>
                                @endisset
                                <p class="mb-0 line-ellipsis" style="color: #6e6a6a">{{ $menu['name'] }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endif
        @endforeach
    </div>



    {{-- Engagement indicators --}}
    <div class="row mt-2">
        <div class="col-12">
            <h4 class="mb-2">{{ __('admin.engagement_indicators') }}</h4>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="text-muted">{{ __('admin.compliance_rate') }}</h5>
                    <h3 class="text-success">{{ $engagementStats['compliance_rate'] }}%</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="text-muted">{{ __('admin.completed_days') }}</h5>
                    <h3 class="text-primary">{{ $engagementStats['total_completed_days'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="text-muted">{{ __('admin.incomplete_days') }}</h5>
                    <h3 class="text-warning">{{ $engagementStats['total_incomplete_days'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="text-muted">{{ __('admin.active_subscriptions') }}</h5>
                    <h3 class="text-info">{{ $engagementStats['active_subscriptions'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row hight-card mt-2">
        {{-- Users registration chart --}}
        <div class="col-lg-6 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('admin.registered_users_chart') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div id="users-chart" class="chart-shadow"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Engagement overview chart --}}
        <div class="col-lg-6 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('admin.engagement_indicators') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div id="engagement-chart" class="chart-shadow"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Subscription rates by program --}}
        @if(count($subscriptionRatesByProgram) > 0)
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('admin.subscription_rates_by_program') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div id="subscription-rates-chart" class="chart-shadow"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    <script>
        // Users registration chart
        var usersChartData = @json($usersChartData);

        var usersChartOptions = {
            chart: {
                height: 400,
                toolbar: {
                    show: true,
                    tools: {
                        download: false,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                    }
                },
                type: 'area',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                },
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 3,
                    blur: 4,
                    opacity: 0.3
                }
            },
            stroke: {
                curve: 'smooth',
                width: 4,
            },
            grid: {
                borderColor: '#e7e7e7',
            },
            legend: {
                show: true,
            },
            colors: ['#FF9F43'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    inverseColors: false,
                    gradientToColors: ['#FF9F43'],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 0.8,
                    stops: [0, 100]
                },
            },
            markers: {
                size: 0,
                hover: {
                    size: 5
                }
            },
            xaxis: {
                labels: {
                    style: {
                        colors: '#b9c3cd',
                    }
                },
                axisTicks: {
                    show: false,
                },
                categories: usersChartData.categories,
                axisBorder: {
                    show: false,
                },
                tickPlacement: 'on',
            },
            yaxis: {
                title: {
                    text: "{{ __('admin.users_count') }}",
                },
                min: 0,
                tickAmount: 5,
                labels: {
                    style: {
                        color: '#b9c3cd',
                    },
                    formatter: function(val) {
                        return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
                    }
                }
            },
            tooltip: {
                x: {
                    show: true
                },
                y: {
                    formatter: function(value) {
                        return value;
                    }
                },
                theme: 'dark',
                shared: true,
                intersect: false,
                followCursor: true
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val;
                },
                style: {
                    fontSize: '10px',
                    colors: ['#fff']
                },
                background: {
                    enabled: true,
                    foreColor: '#FF9F43',
                    padding: 4,
                    borderRadius: 2,
                    borderWidth: 1,
                    borderColor: '#FF9F43',
                    opacity: 0.9
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 1,
                    opacity: 0.5
                }
            },
            series: [{
                name: "{{ __('admin.registered_users') }}",
                data: usersChartData.data
            }],
        };

        var usersChart = new ApexCharts(document.querySelector("#users-chart"), usersChartOptions);
        usersChart.render();

        // Engagement indicators chart
        var engagementChartOptions = {
            chart: {
                type: 'bar',
                height: 400,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    distributed: true,
                    dataLabels: { position: 'top' }
                }
            },
            colors: ['#28a745', '#007bff', '#ffc107', '#17a2b8'],
            dataLabels: {
                enabled: true,
                offsetY: -5
            },
            grid: {
                xaxis: { lines: { show: false } },
                padding: { left: 20, right: 20 }
            },
            xaxis: {
                categories: [
                    "{{ __('admin.compliance_rate') }}",
                    "{{ __('admin.completed_days') }}",
                    "{{ __('admin.incomplete_days') }}",
                    "{{ __('admin.active_subscriptions') }}"
                ],
                labels: {
                    style: { colors: '#b9c3cd', fontSize: '11px' },
                    rotate: -25
                }
            },
            yaxis: {
                max: Math.max(
                    {{ $engagementStats['compliance_rate'] }},
                    {{ $engagementStats['total_completed_days'] }},
                    {{ $engagementStats['total_incomplete_days'] }},
                    {{ $engagementStats['active_subscriptions'] }},
                    10
                ) * 1.2,
                labels: { style: { colors: '#b9c3cd' } }
            },
            series: [{
                name: "{{ __('admin.value') }}",
                data: [
                    {{ $engagementStats['compliance_rate'] }},
                    {{ $engagementStats['total_completed_days'] }},
                    {{ $engagementStats['total_incomplete_days'] }},
                    {{ $engagementStats['active_subscriptions'] }}
                ]
            }]
        };

        var engagementChart = new ApexCharts(document.querySelector("#engagement-chart"), engagementChartOptions);
        engagementChart.render();

        @if(count($subscriptionRatesByProgram) > 0)
        // Subscription rates by program chart
        var subscriptionRatesData = @json($subscriptionRatesByProgram);
        var subscriptionCategories = subscriptionRatesData.map(function(item) { return item.name; });
        var subscriptionRates = subscriptionRatesData.map(function(item) { return item.rate; });

        var subscriptionChartOptions = {
            chart: {
                type: 'bar',
                height: 400,
                toolbar: { show: true }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    dataLabels: { position: 'top' }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) { return val + '%'; }
            },
            xaxis: {
                categories: subscriptionCategories,
                labels: { style: { colors: '#b9c3cd' } }
            },
            yaxis: {
                title: { text: "{{ __('admin.subscription_rate') }} %" },
                labels: { formatter: function(val) { return val + '%'; } }
            },
            colors: ['#28C76F'],
            series: [{
                name: "{{ __('admin.subscription_rate') }}",
                data: subscriptionRates
            }],
            tooltip: {
                y: { formatter: function(val) { return val + '%'; } }
            }
        };

        var subscriptionChart = new ApexCharts(document.querySelector("#subscription-rates-chart"), subscriptionChartOptions);
        subscriptionChart.render();
        @endif
    </script>
@endsection
