<div class="col-md-2 col-3">
    <div class="form-group">
        <label for="first-name-column">{{ __('admin.country_code') }}</label>
        <div class="controls select-icon">
            @if (!empty($countries) && count($countries) > 0)
                <select name="country_code" class="form-control country-code" required
                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                    @foreach ($countries as $flag)
                        <option value="{{ $flag->key }}" data-badge="" {{ isset($countryCode) && $countryCode == $flag->key ? 'selected' : '' }}
                            data-img="<img class='img-flag' style='max-width:20px' src='{{ $flag->flag }}'/>">
                            {{ $flag->key }}
                        </option>
                    @endforeach
                </select>
            @else
                <input type="text" class="form-control" value="966" disabled>
            @endif
        </div>
    </div>
</div>
<div class="col-md-4 col-9">
    <div class="form-group">
        <label for="first-name-column">{{ __('admin.phone_number') }}</label>
        <div class="controls">
            <input type="number" name="phone" class="form-control" placeholder="{{ __('admin.enter_phone_number') }}"
                value="{{ isset($phone) ? $phone : null }}" required
                data-validation-required-message="{{ __('admin.this_field_is_required') }}">
        </div>
    </div>
</div>
