
@php use App\Enums\OrderStatusEnum;@endphp
<div class="card store">
    <div class="card-body">
        <div class="position-relative" style="max-height: 500px; overflow-y: auto;">
            {{-- table content --}}
            <table class="table " id="tab">
                <thead>
                <tr>
                    <th>{{ __('admin.date') }}</th>
                    <th>{{ __('admin.amount') }}</th>
                    <th>{{ __('admin.order_status') }}</th>
                    <th>{{ __('admin.control') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr class="">
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                        <td class="text-success">
                            {{$order->total }}
                            <span> {{ __('site.currency') }}</span></td>

                        <td>
                            <span class="badge
                                @if($order->status == OrderStatusEnum::NEW->value) badge-info
                                @elseif($order->status == OrderStatusEnum::WAIT_APPROVE->value) badge-warning
                                @elseif($order->status == OrderStatusEnum::FINISHED->value) badge-success
                                @elseif($order->status == OrderStatusEnum::CANCELLED->value) badge-danger
                                @endif">
                                {{ $order->status_text }}
                            </span>
                        </td>
                        <td>
                            <span class="text-primary">
                                <a href="{{ route('admin.orders.show', ['id' => $order->id]) }}">
                                    <i class="feather icon-eye"></i>
                                </a>
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- table content --}}
            {{-- no data found div --}}
            @if ($orders->count() == 0)
                <div class="d-flex flex-column w-100 align-center mt-4">
                    <img src="{{asset('/storage/images/no_data.png')}}" width="200px" style="" alt="">
                    <span class="mt-2"
                          style="font-family: cairo ;margin-right: 35px">{{ __('admin.there_are_no_matches_matching') }}</span>
                </div>
            @endif
            {{-- no data found div --}}

        </div>
        {{-- pagination  links div --}}
        @if ($orders->count() > 0 && $orders instanceof \Illuminate\Pagination\AbstractPaginator)
            <div class="d-flex justify-content-center mt-3">
                {{ $orders->links() }}
            </div>
        @endif
        {{-- pagination  links div --}}
    </div>
</div>
