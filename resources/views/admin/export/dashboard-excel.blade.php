@extends('admin.excel_layouts.index-for-excel')
@section('content')
    <h3 style="text-align: center; margin-bottom: 20px;">{{ __('admin.dashboard_report') }}</h3>
    <p style="text-align: center; color: #666;">{{ now()->translatedFormat('l d F Y - H:i') }}</p>

    <table class="table m-b-xs" style="margin-top: 20px;">
        <tbody>
            <tr style="background-color: #337ab7; color: #FFF;">
                <th style="text-align: center;">{{ __('admin.indicator') }}</th>
                <th style="text-align: center;">{{ __('admin.value') }}</th>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.registered_users') }}</td>
                <td style="text-align: center;">{{ $stats['registered_users'] ?? 0 }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.active_users') }}</td>
                <td style="text-align: center;">{{ $stats['active_users'] ?? 0 }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.programs_count') }}</td>
                <td style="text-align: center;">{{ $stats['programs_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.total_subscriptions') }}</td>
                <td style="text-align: center;">{{ $stats['total_subscriptions'] ?? 0 }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.subscription_rate') }}</td>
                <td style="text-align: center;">{{ $stats['subscription_rate'] ?? 0 }}%</td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.compliance_rate') }}</td>
                <td style="text-align: center;">{{ $engagementStats['compliance_rate'] ?? 0 }}%</td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.completed_days') }}</td>
                <td style="text-align: center;">{{ $engagementStats['total_completed_days'] ?? 0 }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.incomplete_days') }}</td>
                <td style="text-align: center;">{{ $engagementStats['total_incomplete_days'] ?? 0 }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">{{ __('admin.active_subscriptions') }}</td>
                <td style="text-align: center;">{{ $engagementStats['active_subscriptions'] ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    @if(count($subscriptionRatesByProgram) > 0)
    <h4 style="margin-top: 30px;">{{ __('admin.subscription_rates_by_program') }}</h4>
    <table class="table m-b-xs" style="margin-top: 10px;">
        <tbody>
            <tr style="background-color: #337ab7; color: #FFF;">
                <th style="text-align: center;">{{ __('admin.program') }}</th>
                <th style="text-align: center;">{{ __('admin.subscriptions_count') }}</th>
                <th style="text-align: center;">{{ __('admin.subscription_rate') }} %</th>
            </tr>
            @foreach($subscriptionRatesByProgram as $item)
            <tr>
                <td style="text-align: center;">{{ $item['name'] }}</td>
                <td style="text-align: center;">{{ $item['subscriptions'] ?? 0 }}</td>
                <td style="text-align: center;">{{ $item['rate'] ?? 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
@stop
