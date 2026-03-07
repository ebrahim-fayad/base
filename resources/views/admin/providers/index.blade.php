@php use App\Enums\ApprovementStatusEnum; @endphp
@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/index_page.css') }}">
@endsection

@section('content')
    <div class="content-body">

        <div class="mb-1 d-flex justify-content-between m-0">

            <x-admin.buttons extrabuttons="true" addbutton="{{ route('admin.providers.create') }}"
                             deletebutton="{{ route('admin.providers.deleteAll') }}">
              <x-slot name="extrabuttonsdiv">
                    @if ($modelCount)
                        <a type="button" data-toggle="modal" data-target="#notify"
                            class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light notify" data-type="users"><i
                                class="feather icon-bell"></i> {{ __('admin.Send_notification') }}</a>

                        <a class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light export-btn" id="export-btn"
                            data-export="{{ App\Models\AllUsers\Provider::class }}"
                            href="{{ route('admin.master-export', ['model' => App\Models\AllUsers\Provider::class]) }}"><i
                                class="fa fa-file-excel-o"></i>
                            {{ __('admin.export') }}</a>
                    @endif
                </x-slot>
            </x-admin.buttons>

            <x-admin.filter datefilter="true" order="true" :searchArray="[
                'name' => [
                    'input_type' => 'text',
                    'input_name' => __('admin.name'),
                ],
                'phone' => [
                    'input_type' => 'text',
                    'input_name' => __('admin.phone'),
                ],
                'email' => [
                    'input_type' => 'text',
                    'input_name' => __('admin.email'),
                ],
                'is_blocked' => [
                    'input_type' => 'select',
                    'rows' => [
                        '1' => [
                            'name' => 'محظور',
                            'id' => 1,
                        ],
                        '2' => [
                            'name' => 'غير محظور',
                            'id' => 0,
                        ],
                    ],
                    'input_name' => __('admin.ban_status'),
                ],
                'is_approved' => [
                    'input_type' => 'select',
                    'rows' => [
                        '1' => [
                            'name' => __('admin.pending'),
                            'id' => ApprovementStatusEnum::PENDING->value,
                        ],
                        '2' => [
                            'name' => __('admin.approved'),
                            'id' => ApprovementStatusEnum::APPROVED->value,
                        ],
                        '3' => [
                            'name' => __('admin.rejected'),
                            'id' => ApprovementStatusEnum::REJECTED->value,
                        ],
                    ],
                    'input_name' => __('admin.status'),
                ],
            ]"/>

        </div>

        <div class="table_content_append">

        </div>
    </div>
    {{-- notify users model --}}
    <x-admin.NotifyAll route="{{ route('admin.providers.notify') }}"/>
    {{-- notify users model --}}
@endsection

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
    @include('admin.shared.deleteAll')
    @include('admin.shared.deleteOne')
    @include('admin.shared.filter_js', ['index_route' => route('admin.providers.index')])
    @include('admin.providers.parts.change_provider_approvement', ['route' => route('admin.providers.toggleApprovement')])
    @include('admin.shared.notify')
    @include('admin.shared.block',['route'=>route('admin.providers.block')])

@endsection
