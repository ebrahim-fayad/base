@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
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
                        <h4 class="card-title">{{ __('admin.edit') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.providers.update', ['id' => $row->id]) }}"
                                class="store form-horizontal" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                                <div class="imgMontg col-12 text-center">
                                                    <div class="dropBox">
                                                        <div class="textCenter">
                                                            <div class="imagesUploadBlock">
                                                                <label class="uploadImg">
                                                                    <span><i class="feather icon-image"></i></span>
                                                                    <input type="file" accept="image/*" name="image" class="imageUploader">
                                                                </label>
                                                                <div class="uploadedBlock">
                                                                    <img src="{{$row->image}}">
                                                                    <button class="close"><i class="la la-times"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.name') }}</label>
                                                <div class="controls">
                                                    <input type="text" name="name" value="{{ $row->name }}"
                                                        class="form-control" placeholder="{{ __('admin.write_the_name') }}"
                                                        required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.email') }}</label>
                                                <div class="controls">
                                                    <input type="email" name="email" value="{{ $row->email }}"
                                                        class="form-control"
                                                        placeholder="{{ __('admin.enter_the_email') }}" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                        data-validation-email-message="{{ __('admin.email_formula_is_incorrect') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="password">{{ __('admin.password') }}</label>
                                                <div class="controls">
                                                    <input type="password" name="password" class="form-control"
                                                           placeholder="{{ __('admin.enter_password') }}">
                                                    <small class="text-muted">{{ __('admin.leave_blank_to_keep_current_password') }}</small>
                                                </div>
                                            </div>
                                        </div>

                                      




                                        <x-admin.phone_with_code :countries="[]" :phone="$row->phone" :countryCode="$row->country_code" />

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.identity_numb') }}</label>
                                                <div class="controls">
                                                    <input type="text" name="identity_numb" value="{{ $row->identity_numb }}"
                                                        class="form-control" placeholder="{{ __('admin.enter_the_identity_numb') }}"
                                                        required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if(!$row->parent_id)
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="commercial_image">{{ __('admin.commercial_image') }}</label>
                                                <div class="imgMontg col-12 text-center">
                                                    <div class="dropBox">
                                                        <div class="textCenter">
                                                            <div class="imagesUploadBlock">
                                                                <label class="uploadImg">
                                                                    <span><i class="feather icon-image"></i></span>
                                                                    <input type="file" accept="image/*" name="commercial_image" class="imageUploader">
                                                                </label>
                                                                @if($row->commercial_image)
                                                                <div class="uploadedBlock">
                                                                    <img src="{{$row->commercial_image}}">
                                                                    <button class="close"><i class="la la-times"></i></button>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit"
                                                class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.update') }}</button>
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

    {{-- submit edit form script --}}
    @include('admin.shared.submitEditForm')
    {{-- submit edit form script --}}

    <script>
        $(document).ready(function() {
            // Enhanced Select2 for categories with search functionality
            $('.categories-select').select2({
                placeholder: "{{ __('admin.choose_categories') }}",
                allowClear: true,
                closeOnSelect: false,
                tags: false,
                width: '100%',
                // Enable search box
                minimumResultsForSearch: 0, // Always show search box
                // Search options
                matcher: function(params, data) {
                    // If there are no search terms, return all data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Do not display the item if there is no 'text' property
                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    // Search in both Arabic and English
                    var searchTerm = params.term.toLowerCase();
                    var text = data.text.toLowerCase();

                    // Match if search term is found in the text
                    if (text.indexOf(searchTerm) > -1) {
                        return data;
                    }

                    // Return null if the term should not be displayed
                    return null;
                },
                language: {
                    noResults: function() {
                        return "{{ __('admin.no_results_found') }}";
                    },
                    searching: function() {
                        return "{{ __('admin.searching') }}...";
                    },
                    inputTooShort: function() {
                        return "{{ __('admin.please_enter_search_term') }}";
                    },
                    maximumSelected: function(args) {
                        return "{{ __('admin.you_can_only_select') }} " + args.maximum + " {{ __('admin.items') }}";
                    }
                },
                // Highlight matched text
                templateResult: function(data) {
                    if (!data.id) {
                        return data.text;
                    }

                    var $result = $('<span></span>');
                    $result.text(data.text);

                    return $result;
                },
                // Custom template for selected items
                templateSelection: function(data) {
                    return data.text;
                }
            });
        });
    </script>
@endsection
