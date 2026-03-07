@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/charts/apexcharts.css') }}">
@endsection
@section('content')
    @php
        $metricAccents = ['primary', 'success', 'warning', 'danger', 'info', 'secondary'];
        $heroTotal = collect($menus)->sum(fn($menu) => (int) ($menu['count'] ?? 0));
        $heroItems = collect($menus)->count();
    @endphp

    <div class="dashboard-page">
        <div class="admin-page-heading">
            <div>
                <span class="admin-page-heading__eyebrow">
                    <i class="feather icon-activity"></i>
                    {{ __('routes.main_page') }}
                </span>
                <h2 class="admin-page-heading__title">{{ __('admin.dashboard_overview_title') }}</h2>
                <p class="admin-page-heading__description">{{ __('admin.dashboard_overview_desc') }}</p>
            </div>
            <div class="admin-toolbar">
                <a href="{{ route('admin.dashboard.export.excel') }}" class="btn btn-success waves-effect">
                    <i class="feather icon-file-text"></i>
                    <span>{{ __('admin.export_excel') }}</span>
                </a>
                <a href="{{ route('admin.dashboard.export.pdf') }}" class="btn btn-danger waves-effect" target="_blank">
                    <i class="feather icon-file"></i>
                    <span>{{ __('admin.export_pdf') }}</span>
                </a>
            </div>
        </div>

        <div class="dashboard-hero">
            <div class="row align-items-center dashboard-hero__content">
                <div class="col-xl-7 col-lg-8 col-12">
                    <span class="admin-page-heading__eyebrow">
                        <i class="feather icon-layers"></i>
                        {{ __('admin.engagement_indicators') }}
                    </span>
                    <h3 class="mb-75">{{ __('admin.dashboard_overview_title') }}</h3>
                    <p class="admin-page-heading__description">
                        {{ __('admin.dashboard_overview_desc') }}
                    </p>
                    <div class="dashboard-hero__stats">
                        <div class="dashboard-hero__stat">
                            <small>{{ __('admin.users_count') }}</small>
                            <strong>{{ $heroTotal }}</strong>
                        </div>
                        <div class="dashboard-hero__stat">
                            <small>{{ __('admin.active_subscriptions') }}</small>
                            <strong>{{ $engagementStats['active_subscriptions'] }}</strong>
                        </div>
                        <div class="dashboard-hero__stat">
                            <small>{{ __('admin.compliance_rate') }}</small>
                            <strong>{{ $engagementStats['compliance_rate'] }}%</strong>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-4 col-12 mt-2 mt-lg-0">
                    <div class="insight-list">
                        <div class="insight-item">
                            <span class="insight-item__label">{{ __('admin.registered_users') }}</span>
                            <span class="insight-item__value">{{ $heroTotal }}</span>
                        </div>
                        <div class="insight-item">
                            <span class="insight-item__label">{{ __('admin.completed_days') }}</span>
                            <span class="insight-item__value">{{ $engagementStats['total_completed_days'] }}</span>
                        </div>
                        <div class="insight-item">
                            <span class="insight-item__label">{{ __('admin.incomplete_days') }}</span>
                            <span class="insight-item__value">{{ $engagementStats['total_incomplete_days'] }}</span>
                        </div>
                        <div class="insight-item">
                            <span class="insight-item__label">{{ __('admin.value') }}</span>
                            <span class="insight-item__value">{{ $heroItems }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="metric-grid">
            @foreach ($menus as $menu)
                @if (!isset($menu['count_type']) || $menu['count_type'] != __('admin.providers_count'))
                    @php $accent = $metricAccents[$loop->index % count($metricAccents)] @endphp
                    <div class="metric-grid__item">
                        <a href="{{ $menu['url'] }}" class="metric-card is-{{ $accent }} d-block">
                            <div class="metric-card__top">
                                <div>
                                    <div class="metric-card__label">{{ $menu['name'] }}</div>
                                    <h3 class="metric-card__value">{{ $menu['count'] }}</h3>
                                </div>
                                <span class="metric-card__icon">
                                    <i class="feather {!! $menu['icon'] !!}"></i>
                                </span>
                            </div>
                            <div class="metric-card__hint">
                                {{ $menu['count_type'] ?? __('admin.users_count') }}
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>

    <div class="row">
        <div class="col-xl-8 col-12 mb-2">
                <div class="dashboard-panel">
                    <div class="dashboard-panel__header">
                        <div>
                            <h4 class="dashboard-panel__title">{{ __('admin.registered_users_chart') }}</h4>
                            <p class="dashboard-panel__meta">{{ __('admin.dashboard_overview_desc') }}</p>
                        </div>
                        <span class="admin-icon-badge">
                            <i class="feather icon-trending-up"></i>
                        </span>
                    </div>
                    <div id="users-chart" class="dashboard-panel__chart"></div>
                </div>
            </div>

            <div class="col-xl-4 col-12 mb-2">
                <div class="dashboard-panel">
                    <div class="dashboard-panel__header">
                        <div>
                            <h4 class="dashboard-panel__title">{{ __('admin.engagement_indicators') }}</h4>
                            <p class="dashboard-panel__meta">{{ __('admin.dashboard_overview_desc') }}</p>
                        </div>
                        <span class="admin-icon-badge">
                            <i class="feather icon-bar-chart-2"></i>
                        </span>
                    </div>
                    <div class="insight-list mb-1">
                        <div class="insight-item">
                            <span class="insight-item__label">{{ __('admin.compliance_rate') }}</span>
                            <span class="insight-item__value">{{ $engagementStats['compliance_rate'] }}%</span>
                        </div>
                        <div class="insight-item">
                            <span class="insight-item__label">{{ __('admin.completed_days') }}</span>
                            <span class="insight-item__value">{{ $engagementStats['total_completed_days'] }}</span>
                        </div>
                        <div class="insight-item">
                            <span class="insight-item__label">{{ __('admin.incomplete_days') }}</span>
                            <span class="insight-item__value">{{ $engagementStats['total_incomplete_days'] }}</span>
                        </div>
                        <div class="insight-item">
                            <span class="insight-item__label">{{ __('admin.active_subscriptions') }}</span>
                            <span class="insight-item__value">{{ $engagementStats['active_subscriptions'] }}</span>
                        </div>
                    </div>
                    <div id="engagement-chart" class="dashboard-panel__chart"></div>
                </div>
            </div>
        </div>

        @if (count($subscriptionRatesByProgram) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-panel">
                        <div class="dashboard-panel__header">
                            <div>
                                <h4 class="dashboard-panel__title">{{ __('admin.subscription_rates_by_program') }}</h4>
                                <p class="dashboard-panel__meta">{{ __('admin.dashboard_overview_desc') }}</p>
                            </div>
                            <span class="admin-icon-badge">
                                <i class="feather icon-pie-chart"></i>
                            </span>
                        </div>
                        <div id="subscription-rates-chart" class="dashboard-panel__chart"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    <script>
        const usersChartData = @json($usersChartData);
        const subscriptionRatesData = @json($subscriptionRatesByProgram);
        let usersChart;
        let engagementChart;
        let subscriptionChart;

        function themeToken(name) {
            return getComputedStyle(document.body).getPropertyValue(name).trim();
        }

        function isDarkTheme() {
            return (document.body.dataset.theme || 'light') === 'dark';
        }

        function isRtlLayout() {
            return document.documentElement.getAttribute('dir') === 'rtl';
        }

        function buildChartBase(height) {
            return {
                chart: {
                    height: height,
                    toolbar: {
                        show: true,
                        tools: {
                            download: false,
                        }
                    },
                    foreColor: themeToken('--app-text-muted'),
                    fontFamily: getComputedStyle(document.body).fontFamily,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 650
                    }
                },
                grid: {
                    borderColor: themeToken('--app-chart-grid'),
                    strokeDashArray: 4
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    theme: isDarkTheme() ? 'dark' : 'light'
                },
                legend: {
                    labels: {
                        colors: themeToken('--app-text-muted')
                    }
                }
            };
        }

        function destroyCharts() {
            [usersChart, engagementChart, subscriptionChart].forEach(function(chart) {
                if (chart) {
                    chart.destroy();
                }
            });
        }

        function renderCharts() {
            destroyCharts();

            const baseArea = buildChartBase(360);
            const baseBar = buildChartBase(340);
            const axisColor = themeToken('--app-text-muted');
            const primary = themeToken('--app-primary');
            const primaryStrong = themeToken('--app-primary-strong');
            const success = themeToken('--app-success');
            const info = themeToken('--app-info');
            const warning = themeToken('--app-warning');
            const danger = themeToken('--app-danger');

            usersChart = new ApexCharts(document.querySelector('#users-chart'), {
                ...baseArea,
                chart: {
                    ...baseArea.chart,
                    type: 'area'
                },
                colors: [primary],
                stroke: {
                    curve: 'smooth',
                    width: 3.5
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: isDarkTheme() ? 'dark' : 'light',
                        gradientToColors: [primaryStrong],
                        opacityFrom: 0.4,
                        opacityTo: 0.02,
                        stops: [0, 100]
                    }
                },
                markers: {
                    size: 0,
                    hover: {
                        size: 5
                    }
                },
                xaxis: {
                    categories: usersChartData.categories,
                    labels: {
                        style: {
                            colors: axisColor
                        }
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    min: 0,
                    opposite: isRtlLayout(),
                    title: {
                        text: "{{ __('admin.users_count') }}",
                        style: {
                            color: axisColor
                        }
                    },
                    labels: {
                        style: {
                            colors: axisColor
                        },
                        formatter: function(val) {
                            return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
                        }
                    }
                },
                series: [{
                    name: "{{ __('admin.registered_users') }}",
                    data: usersChartData.data
                }]
            });
            usersChart.render();

            engagementChart = new ApexCharts(document.querySelector('#engagement-chart'), {
                ...baseBar,
                chart: {
                    ...baseBar.chart,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                colors: [success, primary, warning, info],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        columnWidth: '48%',
                        distributed: true
                    }
                },
                xaxis: {
                    categories: [
                        "{{ __('admin.compliance_rate') }}",
                        "{{ __('admin.completed_days') }}",
                        "{{ __('admin.incomplete_days') }}",
                        "{{ __('admin.active_subscriptions') }}"
                    ],
                    labels: {
                        style: {
                            colors: axisColor,
                            fontSize: '11px'
                        },
                        rotate: isRtlLayout() ? 20 : -20
                    }
                },
                yaxis: {
                    opposite: isRtlLayout(),
                    max: Math.max(
                        {{ $engagementStats['compliance_rate'] }},
                        {{ $engagementStats['total_completed_days'] }},
                        {{ $engagementStats['total_incomplete_days'] }},
                        {{ $engagementStats['active_subscriptions'] }},
                        10
                    ) * 1.2,
                    labels: {
                        style: {
                            colors: axisColor
                        }
                    }
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
            });
            engagementChart.render();

            @if (count($subscriptionRatesByProgram) > 0)
                const subscriptionCategories = subscriptionRatesData.map(function(item) {
                    return item.name;
                });
                const subscriptionRates = subscriptionRatesData.map(function(item) {
                    return item.rate;
                });

                subscriptionChart = new ApexCharts(document.querySelector('#subscription-rates-chart'), {
                    ...buildChartBase(360),
                    chart: {
                        ...buildChartBase(360).chart,
                        type: 'bar'
                    },
                    colors: [danger],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 12,
                            columnWidth: '54%'
                        }
                    },
                    xaxis: {
                        categories: subscriptionCategories,
                        labels: {
                            style: {
                                colors: axisColor
                            }
                        }
                    },
                    yaxis: {
                        opposite: isRtlLayout(),
                        title: {
                            text: "{{ __('admin.subscription_rate') }} %",
                            style: {
                                color: axisColor
                            }
                        },
                        labels: {
                            style: {
                                colors: axisColor
                            },
                            formatter: function(val) {
                                return val + '%';
                            }
                        }
                    },
                    tooltip: {
                        theme: isDarkTheme() ? 'dark' : 'light',
                        y: {
                            formatter: function(val) {
                                return val + '%';
                            }
                        }
                    },
                    series: [{
                        name: "{{ __('admin.subscription_rate') }}",
                        data: subscriptionRates
                    }]
                });
                subscriptionChart.render();
            @endif
        }

        document.addEventListener('DOMContentLoaded', renderCharts);
        window.addEventListener('admin:theme-changed', renderCharts);
    </script>
@endsection
