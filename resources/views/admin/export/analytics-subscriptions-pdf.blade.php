<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('admin.analytics_subscriptions_report') }}</title>
    <style>
        /* Same as dashboard PDF */
        html, body { margin: 0; padding: 0; }
        body { font-family: dejavusans; font-size: 11pt; line-height: 1.6; color: #333; {{ app()->getLocale() == 'ar' ? 'direction: rtl;' : '' }} }
        h3 { text-align: center; margin: 0 0 10px 0; font-size: 18pt; font-weight: bold; color: #2c3e50; }
        .date { text-align: center; color: #5a6c7d; margin: 0 0 15px 0; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; font-size: 10pt; }
        th, td { border: 1px solid #ddd; padding: 12px 15px; }
        th { background-color: #337ab7; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        h4 { margin-top: 25px; margin-bottom: 12px; font-size: 13pt; color: #2c3e50; }
        .rtl { text-align: right; direction: rtl; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h3>{{ __('admin.analytics_subscriptions_report') }}</h3>
    <p class="date">{{ now()->translatedFormat('l d F Y - H:i') }}</p>
    @if(($dateFrom ?? null) || ($dateTo ?? null))
        <p class="date">
            {{ $dateFrom?->translatedFormat('Y-m-d') ?? '—' }} {{ __('admin.analytics_date_to') }} {{ $dateTo?->translatedFormat('Y-m-d') ?? '—' }}
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
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.total_subscriptions') }}</td>
                <td class="center">{{ $totalSubscriptions }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.active_subscriptions') }}</td>
                <td class="center">{{ $activeSubscriptions }}</td>
            </tr>
        </tbody>
    </table>

    <h4>{{ __('admin.analytics_subscriptions_by_program') }}</h4>
    <table>
        <thead>
            <tr>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.program') }}</th>
                <th class="center">{{ __('admin.subscriptions_count') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($byProgram as $row)
                <tr>
                    <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ is_array($row['name']) ? ($row['name'][app()->getLocale()] ?? reset($row['name'])) : $row['name'] }}</td>
                    <td class="center">{{ $row['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>{{ __('admin.analytics_report_title') }} الاشتراكات</h4>
    <table>
        <thead>
            <tr>
                <th class="center">#</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.name') }}</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.phone') }}</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.program') }}</th>
                <th class="center">الحالة</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptionsList as $sub)
                <tr>
                    <td class="center">{{ $sub->id }}</td>
                    <td>{{ $sub->user?->name }}</td>
                    <td>{{ $sub->user ? ($sub->user->country_code ?? '') . $sub->user->phone : '-' }}</td>
                    <td>{{ $sub->level ? (is_array($sub->level->name) ? ($sub->level->name[app()->getLocale()] ?? '') : $sub->level->name) : '-' }}</td>
                    <td class="center">{{ $sub->active ? __('admin.active') : __('admin.inactive') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="center">{{ __('admin.no_data') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
