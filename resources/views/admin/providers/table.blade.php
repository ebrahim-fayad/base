@php use App\Enums\ApprovementStatusEnum;
// use App\Helpers\EnumHelper;
@endphp
<div class="position-relative">
    {{-- table loader  --}}
    <div class="table_loader">
        {{ __('admin.loading') }}
    </div>
    {{-- table loader  --}}

    {{-- table content --}}
    <table class="table " id="tab">
        <thead>
        <tr>
            <th>
                <label class="container-checkbox">
                    <input type="checkbox" value="value1" name="name1" id="checkedAll">
                    <span class="checkmark"></span>
                </label>

            </th>
            <th>{{ __('admin.image') }}</th>
            <th>{{ __('admin.name') }}</th>
            <th>{{ __('admin.email') }}</th>
            <th>{{ __('admin.country_code') }}</th>
            <th>{{ __('admin.phone') }}</th>
            <th class="text-center">{{ __('admin.approvement_status') }}</th>
            <th class="text-center">{{ __('admin.ban_status') }}</th>
            <th>{{ __('admin.control') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($rows as $row)
            <tr class="delete_row">
                <td class="text-center">
                    <label class="container-checkbox">
                        <input type="checkbox" class="checkSingle" id="{{ $row->id }}">
                        <span class="checkmark"></span>
                    </label>
                </td>
                <td><img src="{{ $row->image }}" width="50px" height="50px" alt=""></td>
                <td>
                    {{ $row->name }}
                </td>
                <td>{{ $row->email ?? __('admin.not_found') }}</td>
                <td>{{ $row->country_code }}+</td>
                <td>{{ $row->phone }}</td>

                <td class="text-center">
                    @if($row->is_approved == ApprovementStatusEnum::PENDING->value)
                        <span class="btn btn-sm round btn-outline-success toggle_provider_status" data-action ="{{ ApprovementStatusEnum::APPROVED->value }}"
                              data-id="{{ $row->id }}">
                                {{ __('admin.approve') }} <i class="la la-close font-medium-2"></i>
                        </span>
                        <span class="btn btn-sm round btn-outline-danger toggle_provider_status" data-action ="{{ ApprovementStatusEnum::REJECTED->value }}"
                              data-id="{{ $row->id }}">
                                {{ __('admin.reject') }} <i class="la la-close font-medium-2"></i>
                        </span>
                    @else
                        <span class="btn btn-sm round btn-outline-{{$row->is_approved == ApprovementStatusEnum::APPROVED->value ? 'success' : 'danger'}}">
                            {{ApprovementStatusEnum::getTranslatedName($row->is_approved,'approvementStatusEnum') }} <i class="la la-close font-medium-2"></i>
                        </span>
                    @endif
                </td>
                <td>
                    @if ($row->is_blocked)
                        <span class="btn btn-sm round btn-outline-danger">
                                {{ __('admin.Prohibited') }} <i class="la la-close font-medium-2"></i>
                            </span>
                        <span class="btn btn-sm round btn-outline-success block_user"
                              data-id="{{ $row->id }}">{{ __('admin.unblock') }}</span>
                    @else
                        <span class="btn btn-sm round btn-outline-success">
                                {{ __('admin.Unspoken') }} <i class="la la-check font-medium-2"></i>
                            </span>
                        <span class="btn btn-sm round btn-outline-danger block_user"
                              data-id="{{ $row->id }}">{{ __('admin.block') }}</span>
                    @endif
                </td>

                <td class="product-action">
                        <span class="text-primary"><a href="{{ route('admin.providers.show', ['id' => $row->id]) }}"><i
                                    class="feather icon-eye"></i></a></span>
                    <span class="action-edit text-primary"><a
                            href="{{ route('admin.providers.edit', ['id' => $row->id]) }}"><i
                                class="feather icon-edit"></i></a></span>
                    <span data-toggle="modal" data-target="#notify" class="text-info notify"
                          data-id="{{ $row->id }}" data-type="providers"
                          data-url="{{ url('admins/providers/notify') }}"><i class="feather icon-bell"></i></span>
                    <span class="delete-row text-danger" data-url="{{ url('admin/providers/' . $row->id) }}"><i
                            class="feather icon-trash"></i></span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($rows->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{ asset('/storage/images/no_data.png') }}" width="200px" style="" alt="">
            <span class="mt-2"
                  style="font-family: cairo ;margin-right: 35px">{{ __('admin.there_are_no_matches_matching') }}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($rows->count() > 0 && $rows instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="d-flex justify-content-center mt-3">
        {{ $rows->links('pagination::bootstrap-4') }}
    </div>
@endif
{{-- pagination  links div --}}
