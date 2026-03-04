<div class="card store">
    <div class="card-body">
        <div class="position-relative">
            {{-- table content --}}
            <table class="table " id="tab">
                <thead>
                <tr>
                    <th>{{ __('admin.date') }}</th>
                    <th>{{ __('admin.amount') }}</th>
                    <th>{{ __('admin.type') }}</th>
                    <th>{{ __('admin.control') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr class="">
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                        <td class="text-success">
                            {{$order->final_total }}
                            <span> {{ __('site.currency') }}</span></td>
                        <td>{{ $order->attendence_type_text }}</td>
                        <td><span class="text-primary"><a href="{{route('admin.orders.show' , ['id' => $order->id])}}"><i
                                        class="feather icon-eye"></i></a></span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- table content --}}
            {{-- no data found div --}}
            @if ($orders->count() == 0)
                <div class="d-flex flex-column w-100 align-center mt-4">
                    <img src="{{ asset('admin/app-assets/images/pages/404.png') }}" alt="">
                    <span class="mt-2"
                          style="font-family: cairo">{{ __('admin.there_are_no_matches_matching') }}</span>
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
