@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
@endsection
{{-- extra css files --}}
@section('content')
    <div class="content-body">
        <!-- account setting page start -->
        <section id="page-account-settings">
            <div class="row">
                <!-- left menu section -->
                <div class="col-md-3 mb-2 mb-md-0">
                    <ul class="nav nav-pills flex-column mt-md-0 mt-1">

                        <li class="nav-item">
                            <a class="nav-link d-flex py-75 active" id="account-pill-main" data-toggle="pill"
                                href="#account-vertical-main" aria-expanded="true">
                                <i class="feather icon-settings mr-50 font-medium-3"></i>
                                {{ __('admin.app_setting') }}
                            </a>
                        </li>
                       {{-- <li class="nav-item " style="margin-top: 3px">
                            <a class="nav-link d-flex py-75" id="account-pill-smtp" data-toggle="pill"
                                href="#account-vertical-smtp" aria-expanded="false">
                                <i class="feather icon-mail mr-50 font-medium-3"></i>
                                {{ __('admin.email_data') }}
                            </a>
                        </li>
                         <li class="nav-item " style="margin-top: 3px">
                            <a class="nav-link d-flex py-75" id="account-pill-notifications" data-toggle="pill"
                                href="#account-vertical-notifications" aria-expanded="false">
                                <i class="feather icon-bell mr-50 font-medium-3"></i>
                                {{ __('admin.notification_data') }}
                            </a>
                        </li>
                        <li class="nav-item " style="margin-top: 3px">
                            <a class="nav-link d-flex py-75" id="account-pill-api" data-toggle="pill"
                                href="#account-vertical-api" aria-expanded="false">
                                <i class="feather icon-droplet mr-50 font-medium-3"></i>
                                {{ __('admin.api_data') }}
                            </a>
                        </li> --}}
                        <li class="nav-item " style="margin-top: 3px">
                            <a class="nav-link d-flex py-75" id="currency-pill-commission" data-toggle="pill"
                               href="#general-settings" aria-expanded="false">
                                <i class="feather icon-settings mr-50 font-medium-3"></i>
                                {{ __('admin.general_settings') }}
                            </a>
                        </li>
                        {{-- <li class="nav-item " style="margin-top: 3px">
                            <a class="nav-link d-flex py-75" id="currency-pill-commission" data-toggle="pill"
                                href="#currency-vertical-commission" aria-expanded="false">
                                <i class="feather icon-paperclip mr-50 font-medium-3"></i>
                                {{ __('admin.vat_and_commission') }}
                            </a>
                        </li> --}}

                    </ul>
                </div>
                <!-- right content section -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="tab-content">

                                    <x-admin.settings.app-settings :data="$data" />

                                    <x-admin.settings.smtp :data="$data" />

                                    {{-- <x-admin.settings.notifications :data="$data" /> --}}

                                    <x-admin.settings.api-data :data="$data" />

                                    <x-admin.settings.general-settings :data="$data" />

                                    {{-- <x-admin.settings.vat-commission-deleivery-price :data="$data" /> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- account setting page end -->

    </div>
@endsection
@section('js')
    <script>
        window.language = "{{ app()->getLocale() }}";
    </script>
    <script src="{{ asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/full-all/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('terms_ar_editor');
        CKEDITOR.replace('terms_en_editor');
        CKEDITOR.replace('privacy_ar_editor');
        CKEDITOR.replace('privacy_en_editor');
        CKEDITOR.replace('about_ar_editor');
        CKEDITOR.replace('about_en_editor');
    </script>
    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}
@endsection
