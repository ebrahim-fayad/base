<div role="tabpanel" class="tab-pane" id="currency-vertical-commission" aria-labelledby="currency-pill-commission" aria-expanded="false">
    <form action="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="vat_ratio">{{__('admin.vat_ratio')}}</label>
                        <input type="number" class="form-control" name="vat_ratio" id="vat_ratio"
                               placeholder="{{__('admin.vat_ratio')}}" max="100" min="1" value="{{$data['vat_ratio']}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="provider_commission_ratio">{{__('admin.provider_commission_ratio')}}</label>
                        <input type="number" class="form-control" name="commission_from_providers" id="provider_commission_ratio"
                               placeholder="{{__('admin.provider_commission_ratio')}}" max="100" min="1" value="{{$data['commission_from_providers']}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="delegate_commission_ratio">{{__('admin.delegate_commission_ratio')}}</label>
                        <input type="number" class="form-control" name="commission_from_delegates" id="delegate_commission_ratio"
                               placeholder="{{__('admin.delegate_commission_ratio')}}" max="100" min="1" value="{{$data['commission_from_delegates']}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="price_per_kilo">{{__('admin.price_per_kilo')}}</label>
                        <input type="number" class="form-control" name="price_per_kilometer" id="price_per_kilo"
                               placeholder="{{__('admin.price_per_kilo')}}" max="9999999" min="1" value="{{$data['price_per_kilometer']}}">
                    </div>
                </div>
            </div>



            <div class="col-12 d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
            </div>
        </div>
    </form>
</div>
