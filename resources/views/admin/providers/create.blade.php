@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <style>
        .categories-select + .select2-container .select2-selection--multiple {
            border: 2px solid #dfe3e7;
            border-radius: 0.5rem;
            min-height: 120px;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        .categories-select + .select2-container .select2-selection--multiple:hover {
            border-color: #7367f0;
        }
        .categories-select + .select2-container--focus .select2-selection--multiple {
            border-color: #7367f0;
            box-shadow: 0 3px 10px 0 rgba(115, 103, 240, 0.15);
        }
        .categories-select + .select2-container .select2-selection__choice {
            background-color: #7367f0;
            border: none;
            border-radius: 0.3rem;
            color: #fff;
            padding: 5px 10px;
            margin: 3px;
            font-size: 0.9rem;
        }
        .categories-select + .select2-container .select2-selection__choice__remove {
            color: #fff;
            margin-right: 5px;
            font-weight: bold;
            opacity: 0.8;
        }
        .categories-select + .select2-container .select2-selection__choice__remove:hover {
            opacity: 1;
        }
        .form-group label i.feather {
            margin-right: 5px;
        }

        /* Vuetify-style input group */
        .input-group .btn-outline-secondary {
            border-right: none;
            border-radius: 0.375rem 0 0 0.375rem;
            min-width: 120px;
            text-align: left;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.375rem 0.375rem 0;
        }

        .input-group .form-control:focus {
            border-color: #7367f0;
            box-shadow: 0 0 0 0.2rem rgba(115, 103, 240, 0.25);
        }

        .input-group .btn-outline-secondary:focus {
            box-shadow: 0 0 0 0.2rem rgba(115, 103, 240, 0.25);
        }

        .country-dropdown {
            background: #f8f9fa;
            border-color: #ced4da;
            color: #495057;
        }

        .country-dropdown:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }

        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
        }

        .country-item {
            cursor: pointer;
        }

        .country-item:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
{{-- extra css files --}}

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.add') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.providers.store') }}"
                                  class="store form-horizontal"
                                  novalidate>
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="imgMontg col-12 text-center">
                                                <div class="dropBox">
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*" name="image" class="imageUploader" required data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.name') }}</label>
                                                <div class="controls">
                                                    <input type="text" name="name" class="form-control"
                                                           placeholder="{{ __('admin.write_the_name') }}" required
                                                           data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.email') }}</label>
                                                <div class="controls">
                                                    <input type="email" name="email" class="form-control"
                                                           placeholder="{{ __('admin.enter_the_email') }}" required
                                                           data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                           data-validation-email-message="{{ __('admin.email_formula_is_incorrect') }}">
                                                </div>
                                            </div>
                                        </div>



                                        <x-admin.phone_with_code :countries="[]"/>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.identity_numb') }}</label>
                                                <div class="controls">
                                                    <input type="text" name="identity_numb" class="form-control" placeholder="{{ __('admin.enter_the_identity_numb') }}"
                                                        required data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                        data-validation-identity-numb-message="{{ __('admin.identity_numb_formula_is_incorrect') }}">
                                                </div>
                                            </div>
                                        </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="commercial_image">{{ __('admin.commercial_image') }}</label>
                                            <div class="imgMontg col-12 text-center">
                                                <div class="dropBox">
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*" name="commercial_image" class="imageUploader" required
                                                                    data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.add') }}</button>
                                            <a href="{{ url()->previous() }}" type="reset"
                                               class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>

    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}

    {{-- submit add form script --}}
    @include('admin.shared.submitAddForm')
    {{-- submit add form script --}}
@endsection
