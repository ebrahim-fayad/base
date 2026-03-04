<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('admin.dashboard_report') }}</title>
    <style>
        /* mPDF - دعم عربي ممتاز مع تشكيل الحروف واتصالها */
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
    <h3>{{ __('admin.dashboard_report') }}</h3>
    <p class="date">{{ now()->translatedFormat('l d F Y - H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.indicator') }}</th>
                <th class="center">{{ __('admin.value') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.registered_users') }}</td>
                <td class="center">{{ $stats['registered_users'] ?? 0 }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.active_users') }}</td>
                <td class="center">{{ $stats['active_users'] ?? 0 }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.programs_count') }}</td>
                <td class="center">{{ $stats['programs_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.total_subscriptions') }}</td>
                <td class="center">{{ $stats['total_subscriptions'] ?? 0 }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.subscription_rate') }}</td>
                <td class="center">{{ $stats['subscription_rate'] ?? 0 }}%</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.compliance_rate') }}</td>
                <td class="center">{{ $engagementStats['compliance_rate'] ?? 0 }}%</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.completed_days') }}</td>
                <td class="center">{{ $engagementStats['total_completed_days'] ?? 0 }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.incomplete_days') }}</td>
                <td class="center">{{ $engagementStats['total_incomplete_days'] ?? 0 }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.active_subscriptions') }}</td>
                <td class="center">{{ $engagementStats['active_subscriptions'] ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    @if(count($subscriptionRatesByProgram) > 0)
    <h4>{{ __('admin.subscription_rates_by_program') }}</h4>
    <table>
        <thead>
            <tr>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.program') }}</th>
                <th class="center">{{ __('admin.subscriptions_count') }}</th>
                <th class="center">{{ __('admin.subscription_rate') }} %</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptionRatesByProgram as $item)
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ $item['name'] }}</td>
                <td class="center">{{ $item['subscriptions'] ?? 0 }}</td>
                <td class="center">{{ $item['rate'] ?? 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>
</html>
