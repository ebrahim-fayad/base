<div class="card store">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="first-name-column">{{ __('admin.name') }}</label>
                    <div class="controls">
                        <input type="text" name="name" disabled value="{{ $row->name }}" class="form-control"
                            placeholder="{{ __('admin.write_the_name') }}" required
                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="first-name-column">{{ __('admin.email') }}</label>
                    <div class="controls">
                        <input type="email" name="email" disabled value="{{ $row->email }}" class="form-control"
                            placeholder="{{ __('admin.enter_the_email') }}" required
                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="first-name-column">{{ __('admin.phone_number') }}</label>
                    <div class="controls">
                        <input type="text" name="phone" disabled value="{{ $row->full_phone }}+"
                            class="form-control" placeholder="{{ __('admin.enter_phone_number') }}" required
                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="first-name-column">{{ __('admin.country') }}</label>
                    <div class="controls">
                        <input type="text" name="country_id" disabled value="{{ $row->country?->name ?? __('admin.choose_the_country')  }}"
                               class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="first-name-column">{{ __('admin.city') }}</label>
                    <div class="controls">
                        <div class="controls">
                            <input type="text" name="city_id" disabled value="{{ $row->city?->name ?? __('admin.choose_the_city')  }}"
                                   class="form-control">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-6">
                <div class="form-group">
                    <label for="first-name-column">{{ __('admin.status') }}</label>
                    <div class="controls">
                        <input type="text" name="" disabled
                            value="{{ $row->is_blocked == 1 ? __('admin.Prohibited') : __('admin.Unspoken') }}"
                            class="form-control" required
                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
