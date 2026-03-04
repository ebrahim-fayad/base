<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Thunder_Receipt">
    <link rel="icon" type="image/x-icon" href="/images/logo.png">
    <title>{{ __('apis.the_invoice') }} - {{ __('admin.order_num') }} #{{ $order->order_num }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('invoice-assets/css/style.css') }}">
</head>

<body>
    <div class="receipt_page">
        <div class="header">
            <div class="image">
                <img src="{{ asset(Cache::get('settings')['logo']) }}" alt="image" loading="lazy">
            </div>
            <h4>{{ __('apis.the_invoice') }}</h4>
            <div class="image">
                <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ route('user.negotiation_order.invoice', $order->order_num) }}"
                    alt="image" loading="lazy">
            </div>
        </div>
        <ul>
            <li>
                <span>{{ __('admin.order_num') }}</span>
                <span> #{{ $order->order_num }}</span>
            </li>
            <li>
                <span>{{ __('validation.attributes.delivery_method') }}</span>
                <span>{{ $order->receiving_method['text'] }}</span>
            </li>
            <li>
                <span>{{ __('apis.delivery_address') }} </span>
                <span> {{ $order->map_desc }} </span>
            </li>
            <li>
                <span>{{ __('apis.order_time') }} </span>
                <span>
                    {{ isset($order->schedule_execution_date) && isset($order->schedule_execution_time)
                        ? $order->schedule_execution_date . ' ' . $order->schedule_execution_time
                        : $order->created_at }}
                </span>
            </li>
            <li>
                <span>{{ __('validation.attributes.order_total') }}</span>
                <span>
                    {{ $invoice->total . ' ' . __('site.currency') }}</span>
            </li>
            @if ($order->receiving_method['value'] == App\Enums\ProductDeliveryTypesEnum::Home->value)
                <li>
                    <span>{{ __('apis.delivery_price') }}</span>
                    <span> {{ $order->delivery_price . ' ' . __('site.currency') }}</span>
                </li>
            @endif
            <li>
                <span>{{ __('apis.value_added_tax') }} {{ '(' . Cache::get('settings')['vat_ratio'] . '%)' }}</span>
                <span> {{ $invoice->vat_amount . ' ' . __('site.currency') }}</span>
            </li>
            <li>
                <span>{{ __('apis.final_total') }}</span>
                <span>{{ $invoice->final_total . ' ' . __('site.currency') }}</span>
            </li>
        </ul>
    </div>
</body>

</html>
