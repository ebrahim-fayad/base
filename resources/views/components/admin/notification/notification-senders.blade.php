<div class="col-md-12 col-12">
    <div class="form-group">
        <label for="first-name-column">{{ __('admin.send_to') }}</label>
        <div class="controls">
            <select name="user_type" class="select2 form-control" required
                data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                <option value>{{ __('admin.Select_the_senders_category') }}</option>
                <option value="all">{{ __('admin.all_users') }}</option>
                <option value="users">{{ __('admin.users') }}</option>
                <option value="admins">{{ __('admin.admins') }}</option>
                <option value="providers">{{ __('admin.providers') }}</option>

            </select>
        </div>
    </div>
</div>
