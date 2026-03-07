@php use App\Enums\ApprovementStatusEnum;use App\Helpers\EnumHelper; @endphp
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
                        <input type="text" name="phone" disabled value="{{ $row->full_phone }}"
                               class="form-control" placeholder="{{ __('admin.enter_phone_number') }}" required
                               data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="identity_numb">{{ __('admin.identity_numb') }}</label>
                    <div class="controls">
                        <input type="text" name="identity_numb" disabled value="{{ $row->identity_numb ?? __('admin.not_found') }}"
                               class="form-control">
                    </div>
                </div>
            </div>

            @if(!$row->parent_id)
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="commercial_image">{{ __('admin.commercial_image') }}</label>
                    <div class="controls">
                        @if($row->commercial_image)
                            <img src="{{ $row->commercial_image }}" alt="{{ __('admin.commercial_image') }}" style="max-width: 200px; max-height: 200px;">
                        @else
                            <span class="text-muted">{{ __('admin.not_found') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="status">{{ __('admin.approvement_status') }}</label>
                    <div class="controls">
                        <input type="text" name="status" disabled
                               value="{{ ApprovementStatusEnum::getTranslatedName($row->is_approved,'approvementStatusEnum') }}"
                               class="form-control
                                    @if($row->is_approved == ApprovementStatusEnum::PENDING->value) text-warning
                                    @elseif($row->is_approved == ApprovementStatusEnum::APPROVED->value) text-success
                                    @elseif($row->is_approved == ApprovementStatusEnum::REJECTED->value) text-danger
                                    @else text-secondary
                                    @endif
                               ">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="ban_status">{{ __('admin.ban_status') }}</label>
                    <div class="controls">
                        <input type="text" name="ban_status" disabled
                               value="{{ $row->is_blocked == 1 ? __('admin.Prohibited') : __('admin.Unspoken') }}"
                               class="form-control {{ $row->is_blocked ? 'text-danger' : 'text-success' }}">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="active">{{ __('admin.active') }}</label>
                    <div class="controls">
                        <input type="text" name="active" disabled
                               value="{{ $row->active == 1 ? __('admin.active') : __('admin.inactive') }}"
                               class="form-control {{ $row->active ? 'text-success' : 'text-danger' }}">
                    </div>
                </div>
            </div>



            @if($row->map_desc || $row->lat || $row->lng)
            <div class="col-md-12 col-12">
                <div class="form-group">
                    <label for="map_desc">{{ __('admin.location') }}</label>
                    <div class="controls">
                        <input type="text" name="map_desc" disabled value="{{ $row->map_desc ?? __('admin.not_found') }}"
                               class="form-control">

                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
