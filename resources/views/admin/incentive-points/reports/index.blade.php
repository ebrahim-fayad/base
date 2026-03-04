@extends('admin.layout.master')

@section('content')
    <div class="content-body">
        <div class="row mb-2">
            <div class="col-12">
                <h4 class="text-bold-700">{{ __('admin.incentive_points_reports') }}</h4>
                <p class="text-muted">{{ __('admin.incentive_points_reports_desc') }}</p>
            </div>
        </div>

        @php
            $pdfParams = http_build_query(request()->only(['date_from', 'date_to', 'period']));
            $pdfSuffix = $pdfParams ? '?' . $pdfParams : '';
        @endphp

        {{-- فلتر التاريخ والفترة --}}
        <div class="row mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="get" action="{{ route('admin.incentive_points.reports') }}" class="form-inline flex-wrap gap-2 align-items-end">
                            <div class="form-group mr-2">
                                <label for="date_from" class="mr-1">{{ __('admin.analytics_date_from') }}:</label>
                                <input id="date_from" type="date" name="date_from" class="form-control" value="{{ request('date_from', now()->subDays(30)->format('Y-m-d')) }}">
                            </div>
                            <div class="form-group mr-2">
                                <label for="date_to" class="mr-1">{{ __('admin.analytics_date_to') }}:</label>
                                <input id="date_to" type="date" name="date_to" class="form-control" value="{{ request('date_to', now()->format('Y-m-d')) }}">
                            </div>
                            <div class="form-group mr-2">
                                <label for="period" class="mr-1">{{ __('admin.points_report_period') }}:</label>
                                <select name="period" id="period" class="form-control">
                                    <option value="daily" {{ request('period', 'daily') == 'daily' ? 'selected' : '' }}>{{ __('admin.points_period_daily') }}</option>
                                    <option value="weekly" {{ request('period') == 'weekly' ? 'selected' : '' }}>{{ __('admin.points_period_weekly') }}</option>
                                    <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>{{ __('admin.points_period_monthly') }}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('admin.analytics_filter') }}</button>
                            <a href="{{ route('admin.incentive_points.reports.exportPdf') }}{{ $pdfSuffix }}" class="btn btn-danger btn-sm" target="_blank">
                                <i class="feather icon-file"></i> {{ __('admin.analytics_export_pdf') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ملخص النقاط ومستوى النشاط --}}
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-light-primary">
                    <div class="card-body text-center">
                        <h5 class="text-muted">{{ __('admin.analytics_total_points') }}</h5>
                        <h3>{{ number_format($report['totalPoints']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light-info">
                    <div class="card-body text-center">
                        <h5 class="text-muted">{{ __('admin.points_report_active_users') }}</h5>
                        <h3>{{ $report['activeUsersCount'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light-success">
                    <div class="card-body text-center">
                        <h5 class="text-muted">{{ __('admin.points_report_total_records') }}</h5>
                        <h3>{{ number_format($report['totalRecords']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- مقارنة الفترات --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('admin.points_report_period_comparison') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">{{ __('admin.analytics_total_points') }}</p>
                                <p class="mb-0">
                                    <span class="font-weight-bold">{{ number_format($comparison['current_points']) }}</span>
                                    {{ __('admin.points_report_vs_previous') }}
                                    <span class="font-weight-bold">{{ number_format($comparison['previous_points']) }}</span>
                                    @if ($comparison['points_change_percent'] != 0)
                                        <span class="badge {{ $comparison['points_change_percent'] >= 0 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $comparison['points_change_percent'] >= 0 ? '+' : '' }}{{ $comparison['points_change_percent'] }}%
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">{{ __('admin.points_report_active_users') }}</p>
                                <p class="mb-0">
                                    <span class="font-weight-bold">{{ $comparison['current_users'] }}</span>
                                    {{ __('admin.points_report_vs_previous') }}
                                    <span class="font-weight-bold">{{ $comparison['previous_users'] }}</span>
                                    @if ($comparison['users_change_percent'] != 0)
                                        <span class="badge {{ $comparison['users_change_percent'] >= 0 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $comparison['users_change_percent'] >= 0 ? '+' : '' }}{{ $comparison['users_change_percent'] }}%
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- النقاط حسب الفترة (يومي/أسبوعي/شهري) --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('admin.points_report_by_period') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.points_report_period_key') }}</th>
                                            <th>{{ __('admin.analytics_total_points') }}</th>
                                            <th>{{ __('admin.points_report_records_count') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($report['pointsByPeriod'] as $row)
                                            <tr>
                                                <td>{{ $row['period_key'] ?? '-' }}</td>
                                                <td>{{ number_format($row['points'] ?? 0) }}</td>
                                                <td>{{ number_format($row['records'] ?? 0) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center">{{ __('admin.no_data') }}</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- النقاط حسب النوع --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('admin.analytics_points_by_type') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.points_report_type') }}</th>
                                            <th>{{ __('admin.points_report_records_count') }}</th>
                                            <th>{{ __('admin.analytics_total_points') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($report['byType'] as $row)
                                            <tr>
                                                <td>{{ $row['label'] }}</td>
                                                <td>{{ $row['count'] }}</td>
                                                <td>{{ number_format($row['points']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- أكثر المستخدمين حصولاً على نقاط --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('admin.points_report_top_users') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('admin.name') }}</th>
                                            <th>{{ __('admin.phone') }}</th>
                                            <th>{{ __('admin.analytics_total_points') }}</th>
                                            <th>{{ __('admin.points_report_records_count') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($report['topUsers'] as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->user?->name ?? '-' }}</td>
                                                <td>{{ ($item->user?->country_code ?? '') . ($item->user?->phone ?? '-') }}</td>
                                                <td>{{ number_format($item->total_points) }}</td>
                                                <td>{{ $item->records_count }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center">{{ __('admin.no_data') }}</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- عينة من سجل النقاط --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('admin.points_report_points_log_sample') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('admin.name') }}</th>
                                            <th>{{ __('admin.client_points') }}</th>
                                            <th>{{ __('admin.points_report_type') }}</th>
                                            <th>{{ __('admin.program') }}</th>
                                            <th>{{ __('admin.created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($report['pointsList'] as $point)
                                            <tr>
                                                <td>{{ $point->id }}</td>
                                                <td>{{ $point->user?->name ?? '-' }}</td>
                                                <td>{{ $point->points }}</td>
                                                <td>{{ $point->type?->label() ?? $point->type }}</td>
                                                <td>{{ $point->level ? (is_array($point->level->name) ? ($point->level->name[app()->getLocale()] ?? '') : $point->level->name) : '-' }}</td>
                                                <td>{{ $point->created_at?->translatedFormat('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="6" class="text-center">{{ __('admin.no_data') }}</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
