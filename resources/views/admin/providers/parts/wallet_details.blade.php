@php
use App\Enums\WalletTransactionEnum;
$transactionsQuery = $row->wallet->transactions();
$debitTotal = round($transactionsQuery->whereIn('type', [WalletTransactionEnum::DEBT->value, WalletTransactionEnum::PAY_ORDER->value])->sum('amount'));
$creditTotal = round($row->wallet->transactions()->where('type', WalletTransactionEnum::CHARGE->value)->sum('amount'));
$transactionsCount = $row->wallet->transactions()->count();
@endphp
<div class="card store mb-2">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ __('admin.wallet_details') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="first-name-column">{{ __('admin.total') }}</label>
                    <div class="controls">
                        <input type="text" disabled
                            value="{{ round($row->wallet->balance) . ' ' . __('site.currency') }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="first-name-column">{{ __('admin.total_debits') }}</label>
                    <div class="controls">
                        <input type="text" disabled
                            value="{{ $debitTotal . ' ' . __('site.currency') }}"
                            class="form-control">
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
