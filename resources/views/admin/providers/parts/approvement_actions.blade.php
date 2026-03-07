@php use App\Enums\ApprovementStatusEnum;use App\Helpers\EnumHelper; @endphp
<div class="card border-left-info">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ __('admin.approvement_status') }}</h4>
    </div>
    <div class="card-body">
        <div class="d-flex gap-2">
    <span class="btn btn-md flex-fill round btn-outline-success toggle_provider_status"
          data-action="{{ ApprovementStatusEnum::APPROVED->value }}"
          data-id="{{ $row->id }}">
        <i class="la la-check font-medium-2"></i> {{ __('admin.approve') }}
    </span>

            <span class="btn btn-md flex-fill round btn-outline-danger toggle_provider_status"
                  data-action="{{ ApprovementStatusEnum::REJECTED->value }}"
                  data-id="{{ $row->id }}">
        <i class="la la-close font-medium-2"></i> {{ __('admin.reject') }}
    </span>
        </div>

    </div>
</div>
