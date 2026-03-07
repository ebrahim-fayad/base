@php use App\Enums\WalletTransactionEnum; @endphp
<div class="card border-left-success">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ __('admin.add_or_deduct_balance') }}</h4>
    </div>
    <div class="card-body">

        <form class="updateBalance store" action="{{ route('admin.providers.updateBalance' , ['id' => $row->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-8">
                    <input type="text" name="balance" id="balance" class="form-control"  placeholder="{{  __('admin.amount') }}">
                </div>

                <div class="col-4">
                    <select name="type" id="" class="form-control">
                        <option value="{{WalletTransactionEnum::CHARGE->value}}">{{ __('admin.charge') }}</option>
                        <option value="{{WalletTransactionEnum::DEBT->value}}">{{ __('admin.debt') }}</option>
                    </select>
                </div>

            </div>

            <div class="d-flex align-items-center">
                <button type="submit"
                        class="submit-button btn  btn-labeled btn-labeled-right ml-auto legitRipple btn-primary mt-3"> <i class="feather icon-navigation"></i>{{  __('admin.send') }}</button>
            </div>
        </form>
    </div>
</div>
