@extends('admin.layout.master')

@section('content')
    <div class="content-body">
        <div class="row mb-2">
            <div class="col-12">
                <h4 class="text-bold-700">{{ __('admin.analytics_reports') }}</h4>
                <p class="text-muted">{{ __('admin.dashboard_overview_desc') }}</p>
            </div>
        </div>

        {{-- Date filter --}}
        <div class="row mb-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="get" action="{{ route('admin.analytics.index') }}" class="form-inline flex-nowrap gap-2">
                            <label for="analytics-date-from" class="mr-1">{{ __('admin.analytics_date_from') }}:</label>
                            <input id="analytics-date-from" type="date" name="date_from" class="form-control mr-2" value="{{ request('date_from') }}">
                            <label for="analytics-date-to" class="mr-1">{{ __('admin.analytics_date_to') }}:</label>
                            <input id="analytics-date-to" type="date" name="date_to" class="form-control mr-2" value="{{ request('date_to') }}">
                            <button type="submit" class="btn btn-primary">{{ __('admin.analytics_filter') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @php
            $pdfParams = http_build_query(request()->only(['date_from', 'date_to']));
            $pdfSuffix = $pdfParams ? '?' . $pdfParams : '';
        @endphp

        {{-- 1. تقرير المستخدمين --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ __('admin.analytics_users_report') }}</h4>
                        <a href="{{ route('admin.analytics.export.usersPdf') }}{{ $pdfSuffix }}" class="btn btn-danger btn-sm" target="_blank">
                            <i class="feather icon-file"></i> {{ __('admin.analytics_export_pdf') }}
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <div class="card bg-light-primary">
                                        <div class="card-body text-center">
                                            <h5 class="text-muted">{{ __('admin.analytics_total_users') }}</h5>
                                            <h3>{{ $usersReport['totalUsers'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light-success">
                                        <div class="card-body text-center">
                                            <h5 class="text-muted">{{ __('admin.active_users') }}</h5>
                                            <h3>{{ $usersReport['activeUsers'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light-warning">
                                        <div class="card-body text-center">
                                            <h5 class="text-muted">{{ __('admin.analytics_inactive_users') }}</h5>
                                            <h3>{{ $usersReport['inactiveUsers'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('admin.name') }}</th>
                                            <th>{{ __('admin.phone') }}</th>
                                            <th>{{ __('admin.active_status') }}</th>
                                            <th>{{ __('admin.created_at') ?? 'التاريخ' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($usersReport['usersList'] as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->country_code ?? '' }}{{ $user->phone }}</td>
                                                <td>
                                                    @if($user->active)
                                                        <span class="badge badge-success">{{ __('admin.active') }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ __('admin.inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $user->created_at?->translatedFormat('Y-m-d') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center">{{ __('admin.no_data') ?? 'لا توجد بيانات' }}</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. تقرير الاشتراكات --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ __('admin.analytics_subscriptions_report') }}</h4>
                        <a href="{{ route('admin.analytics.export.subscriptionsPdf') }}{{ $pdfSuffix }}" class="btn btn-danger btn-sm" target="_blank">
                            <i class="feather icon-file"></i> {{ __('admin.analytics_export_pdf') }}
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="card bg-light-info">
                                        <div class="card-body text-center">
                                            <h5 class="text-muted">{{ __('admin.total_subscriptions') }}</h5>
                                            <h3>{{ $subscriptionsReport['totalSubscriptions'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light-success">
                                        <div class="card-body text-center">
                                            <h5 class="text-muted">{{ __('admin.active_subscriptions') }}</h5>
                                            <h3>{{ $subscriptionsReport['activeSubscriptions'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6>{{ __('admin.analytics_subscriptions_by_program') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('admin.program') }}</th>
                                            <th>{{ __('admin.subscriptions_count') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subscriptionsReport['byProgram'] as $row)
                                            <tr>
                                                <td>{{ is_array($row['name']) ? ($row['name'][app()->getLocale()] ?? reset($row['name'])) : $row['name'] }}</td>
                                                <td>{{ $row['count'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <h6 class="mt-2">{{ __('admin.analytics_report_title') }} الاشتراكات (عينة)</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('admin.name') }}</th>
                                            <th>{{ __('admin.phone') }}</th>
                                            <th>{{ __('admin.program') }}</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($subscriptionsReport['subscriptionsList'] as $sub)
                                            <tr>
                                                <td>{{ $sub->id }}</td>
                                                <td>
                                                    @if($sub->user)
                                                        <a href="{{ route('admin.clients.show', ['id' => $sub->user->id]) }}">{{ $sub->user->name }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $sub->user ? $sub->user->country_code . $sub->user->phone : '-' }}</td>
                                                <td>{{ $sub->level ? (is_array($sub->level->name) ? ($sub->level->name[app()->getLocale()] ?? '') : $sub->level->name) : '-' }}</td>
                                                <td>{{ $sub->active ? __('admin.active') : __('admin.inactive') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center">{{ __('admin.no_data') ?? 'لا توجد بيانات' }}</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. تقرير النقاط والتحفيز --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">{{ __('admin.analytics_points_report') }}</h4>
                        <a href="{{ route('admin.analytics.export.pointsPdf') }}{{ $pdfSuffix }}" class="btn btn-danger btn-sm" target="_blank">
                            <i class="feather icon-file"></i> {{ __('admin.analytics_export_pdf') }}
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="card bg-light-primary">
                                        <div class="card-body text-center">
                                            <h5 class="text-muted">{{ __('admin.analytics_total_points') }}</h5>
                                            <h3>{{ number_format($pointsReport['totalPoints']) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light-info">
                                        <div class="card-body text-center">
                                            <h5 class="text-muted">عدد السجلات</h5>
                                            <h3>{{ $pointsReport['totalRecords'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6>{{ __('admin.analytics_points_by_type') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>نوع النقاط</th>
                                            <th>عدد السجلات</th>
                                            <th>إجمالي النقاط</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pointsReport['byType'] as $row)
                                            <tr>
                                                <td>{{ $row['label'] }}</td>
                                                <td>{{ $row['count'] }}</td>
                                                <td>{{ number_format($row['points']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <h6 class="mt-2">سجل النقاط (عينة)</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('admin.name') }}</th>
                                            <th>النقاط</th>
                                            <th>النوع</th>
                                            <th>البرنامج</th>
                                            <th>التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pointsReport['pointsList'] as $point)
                                            <tr>
                                                <td>{{ $point->id }}</td>
                                                <td>{{ $point->user?->name }}</td>
                                                <td>{{ $point->points }}</td>
                                                <td>{{ $point->type?->label() ?? $point->type }}</td>
                                                <td>{{ $point->level ? (is_array($point->level->name) ? ($point->level->name[app()->getLocale()] ?? '') : $point->level->name) : '-' }}</td>
                                                <td>{{ $point->created_at?->translatedFormat('Y-m-d') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="6" class="text-center">{{ __('admin.no_data') ?? 'لا توجد بيانات' }}</td></tr>
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
