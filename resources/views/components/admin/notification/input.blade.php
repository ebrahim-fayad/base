<div class="col-md-{{ $col }} col-12">
    <div class="form-group">
        <label for="first-name-column">{{ $label }}</label>
        <div class="controls">
            <input name="{{ $name }}" class="form-control" required
                data-validation-required-message="{{ __('admin.this_field_is_required') }}" />
        </div>
    </div>
</div>
