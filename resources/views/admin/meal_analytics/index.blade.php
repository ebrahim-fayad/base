@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/charts/apexcharts.css') }}">
@endsection
@section('content')
    <div class="content-body">
        {{-- إحصائيات عامة --}}
        <div class="row">
            <div class="col-12">
                <h4 class="mb-2">{{ __('admin.meal_analytics_general_stats') }}</h4>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">{{ __('admin.total_meals_logged') }}</h5>
                        <h3 class="text-primary">{{ number_format($generalStats['total_meals_logged']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">{{ __('admin.users_with_meals') }}</h5>
                        <h3 class="text-success">{{ number_format($generalStats['users_with_meals']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">{{ __('admin.avg_daily_calories_overall') }}</h5>
                        <h3 class="text-info">{{ number_format($generalStats['avg_daily_calories_overall'], 1) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">{{ __('admin.total_calories_logged') }}</h5>
                        <h3 class="text-warning">{{ number_format($generalStats['total_calories_logged'], 0) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- أكثر الأصناف استخداماً --}}
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ __('admin.most_used_meal_items') }}</h4>
                        <div>
                            <a href="{{ route('admin.meal_types.index') }}" class="btn btn-sm btn-outline-secondary mr-1">{{ __('routes.meal_types_management') }}</a>
                            <a href="{{ route('admin.meal_items.index') }}" class="btn btn-sm btn-outline-primary">{{ __('admin.meal_items.index') }}</a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if($mostUsedItems->isEmpty())
                                <p class="text-muted">{{ __('admin.no_data') }}</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('admin.name') }}</th>
                                                <th>{{ __('admin.usage_count') }}</th>
                                                <th>{{ __('admin.total_grams_used') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($mostUsedItems as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ number_format($item['usage_count']) }}</td>
                                                    <td>{{ number_format($item['total_grams'], 1) }} {{ __('admin.grams') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- متوسط السعرات اليومية لكل مستخدم --}}
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.avg_daily_calories_by_users') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if($avgCaloriesByUsers->isEmpty())
                                <p class="text-muted">{{ __('admin.no_data') }}</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('admin.user_name') }}</th>
                                                <th>{{ __('admin.phone') }}</th>
                                                <th>{{ __('admin.days_logged') }}</th>
                                                <th>{{ __('admin.meals_count') }}</th>
                                                <th>{{ __('admin.avg_daily_calories') }}</th>
                                                <th>{{ __('admin.total_calories') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($avgCaloriesByUsers as $index => $row)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $row['user_name'] }}</td>
                                                    <td>{{ $row['user_phone'] }}</td>
                                                    <td>{{ $row['days_logged'] }}</td>
                                                    <td>{{ $row['meals_count'] }}</td>
                                                    <td>{{ number_format($row['avg_daily_calories'], 1) }}</td>
                                                    <td>{{ number_format($row['total_calories'], 0) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
