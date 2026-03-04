<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('admin.incentive_points_reports') }}</title>
    <style>
        html, body { margin: 0; padding: 0; }
        body { font-family: dejavusans; font-size: 11pt; line-height: 1.6; color: #333; {{ app()->getLocale() == 'ar' ? 'direction: rtl;' : '' }} }
        h3 { text-align: center; margin: 0 0 10px 0; font-size: 18pt; font-weight: bold; color: #2c3e50; }
        .date { text-align: center; color: #5a6c7d; margin: 0 0 15px 0; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; font-size: 10pt; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; }
        th { background-color: #337ab7; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        h4 { margin-top: 20px; margin-bottom: 10px; font-size: 13pt; color: #2c3e50; }
        .rtl { text-align: right; direction: rtl; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h3>{{ __('admin.incentive_points_reports') }}</h3>
    <p class="date">{{ now()->translatedFormat('l d F Y - H:i') }}</p>
    @if(($dateFrom ?? null) || ($dateTo ?? null))
        <p class="date">
            {{ $dateFrom?->translatedFormat('Y-m-d') ?? '—' }} {{ __('admin.analytics_date_to') }} {{ $dateTo?->translatedFormat('Y-m-d') ?? '—' }}
            ({{ __('admin.points_period_' . $period) }})
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.indicator') }}</th>
                <th class="center">{{ __('admin.value') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.analytics_total_points') }}</td>
                <td class="center">{{ number_format($totalPoints) }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.points_report_active_users') }}</td>
                <td class="center">{{ $activeUsersCount }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.points_report_total_records') }}</td>
                <td class="center">{{ $totalRecords }}</td>
            </tr>
        </tbody>
    </table>

    @if(isset($comparison))
    <h4>{{ __('admin.points_report_period_comparison') }}</h4>
    <table>
        <tbody>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.analytics_total_points') }}</td>
                <td class="center">{{ number_format($comparison['current_points']) }} ({{ $comparison['points_change_percent'] >= 0 ? '+' : '' }}{{ $comparison['points_change_percent'] }}%)</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.points_report_active_users') }}</td>
                <td class="center">{{ $comparison['current_users'] }} ({{ $comparison['users_change_percent'] >= 0 ? '+' : '' }}{{ $comparison['users_change_percent'] }}%)</td>
            </tr>
        </tbody>
    </table>
    @endif

    <h4>{{ __('admin.analytics_points_by_type') }}</h4>
    <table>
        <thead>
            <tr>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.points_report_type') }}</th>
                <th class="center">{{ __('admin.points_report_records_count') }}</th>
                <th class="center">{{ __('admin.analytics_total_points') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($byType as $row)
                <tr>
                    <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ $row['label'] }}</td>
                    <td class="center">{{ $row['count'] }}</td>
                    <td class="center">{{ number_format($row['points']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>{{ __('admin.points_report_top_users') }}</h4>
    <table>
        <thead>
            <tr>
                <th class="center">#</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.name') }}</th>
                <th class="center">{{ __('admin.analytics_total_points') }}</th>
                <th class="center">{{ __('admin.points_report_records_count') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topUsers as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $item->user?->name ?? '-' }}</td>
                    <td class="center">{{ number_format($item->total_points) }}</td>
                    <td class="center">{{ $item->records_count }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="center">{{ __('admin.no_data') }}</td></tr>
            @endforelse
        </tbody>
    </table>

    <h4>{{ __('admin.points_report_points_log_sample') }}</h4>
    <table>
        <thead>
            <tr>
                <th class="center">#</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.name') }}</th>
                <th class="center">{{ __('admin.client_points') }}</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.points_report_type') }}</th>
                <th class="center">{{ __('admin.created_at') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pointsList as $point)
                <tr>
                    <td class="center">{{ $point->id }}</td>
                    <td>{{ $point->user?->name }}</td>
                    <td class="center">{{ $point->points }}</td>
                    <td>{{ $point->type?->label() ?? $point->type }}</td>
                    <td class="center">{{ $point->created_at?->translatedFormat('Y-m-d') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="center">{{ __('admin.no_data') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
