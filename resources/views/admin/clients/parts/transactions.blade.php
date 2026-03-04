@php use App\Enums\WalletTransactionEnum; @endphp

<div class="card store" data-user-id="{{ $user->id ?? request()->route('id') }}"
    data-wallet-url="{{ route('admin.clients.show', ['id' => $user->id ?? request()->route('id'), 'type' => 'wallet']) }}">
    <div class="card-body">
        <div class="position-relative">
            {{-- table content --}}
            <div id="transactions-table-container">
                <table class="table " id="tab">
                    <thead>
                        <tr>
                            <th>{{ __('admin.date') }}</th>
                            <th>{{ __('admin.amount') }}</th>
                            <th>{{ __('admin.type') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="">
                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}</td>
                                <td
                                    class="{{ $transaction->type == WalletTransactionEnum::CHARGE->value ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->amount }}
                                    <span> {{ __('site.currency') }}</span>
                                </td>
                                <td>{{ $transaction->type_text }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- no data found div --}}
                @if ($transactions->count() == 0)
                    <div class="d-flex flex-column w-100 align-center mt-4">
                        <img src="{{ asset('/storage/images/no_data.png') }}" width="200px" style="" alt="">
                        <span class="mt-2"
                            style="font-family: cairo ;margin-right: 35px">{{ __('admin.there_are_no_matches_matching') }}</span>
                    </div>
                @endif
                {{-- no data found div --}}
            </div>
            {{-- table content --}}

        </div>
        {{-- JavaScript pagination container --}}
        @if ($transactions->count() > 0 && $transactions instanceof \Illuminate\Pagination\AbstractPaginator)
            <div class="d-flex justify-content-center mt-3">
                <div id="transactions-pagination" data-current-page="{{ $transactions->currentPage() }}"
                    data-last-page="{{ $transactions->lastPage() }}" data-total="{{ $transactions->total() }}">
                    <ul class="pagination">
                        @if ($transactions->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item"><a class="page-link transactions-pagination-link" href="#"
                                    data-page="{{ $transactions->currentPage() - 1 }}">&laquo;</a></li>
                        @endif

                        @for ($i = 1; $i <= $transactions->lastPage(); $i++)
                            @if ($i == $transactions->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link transactions-pagination-link" href="#"
                                        data-page="{{ $i }}">{{ $i }}</a></li>
                            @endif
                        @endfor

                        @if ($transactions->hasMorePages())
                            <li class="page-item"><a class="page-link transactions-pagination-link" href="#"
                                    data-page="{{ $transactions->currentPage() + 1 }}">&raquo;</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        @endif
        {{-- JavaScript pagination container --}}
    </div>
</div>
