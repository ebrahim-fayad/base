<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('admin.analytics_points_report') }}</title>
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
    <h3>{{ __('admin.analytics_points_report') }}</h3>
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
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.analytics_total_points') }}</td>
                <td class="center">{{ number_format($totalPoints) }}</td>
            </tr>
            <tr>
                <td class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">عدد السجلات</td>
                <td class="center">{{ $totalRecords }}</td>
            </tr>
        </tbody>
    </table>

    <h4>{{ __('admin.analytics_points_by_type') }}</h4>
    <table>
        <thead>
            <tr>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">نوع النقاط</th>
                <th class="center">عدد السجلات</th>
                <th class="center">إجمالي النقاط</th>
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

    <h4>سجل النقاط</h4>
    <table>
        <thead>
            <tr>
                <th class="center">#</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.name') }}</th>
                <th class="center">النقاط</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">النوع</th>
                <th class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'center' }}">{{ __('admin.program') }}</th>
                <th class="center">التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pointsList as $point)
                <tr>
                    <td class="center">{{ $point->id }}</td>
                    <td>{{ $point->user?->name }}</td>
                    <td class="center">{{ $point->points }}</td>
                    <td>{{ $point->type?->label() ?? $point->type }}</td>
                    <td>{{ $point->level ? (is_array($point->level->name) ? ($point->level->name[app()->getLocale()] ?? '') : $point->level->name) : '-' }}</td>
                    <td class="center">{{ $point->created_at?->translatedFormat('Y-m-d') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="center">{{ __('admin.no_data') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
