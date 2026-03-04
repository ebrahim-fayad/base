@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <style>
        .img-flag {
            width: 30px;
            /*margin-inline-end: 90%;*/
        }

        .flex-span {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: {{ app()->getLocale() == 'ar' ? 'row-reverse' : 'row' }};
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
                        <h4 class="card-title">{{ __('routes.countries.create') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.countries.store') }}" class="store form-horizontal"
                                novalidate>
                                @csrf
                                <div class="form-body">
                                    <div class="row">

                                        {{-- <div class="col-12">
                                        <div class="imgMontg col-12 text-center">
                                          <div class="dropBox">
                                            <div class="textCenter">
                                              <div class="imagesUploadBlock">
                                                <label class="uploadImg">
                                                  <span><i class="feather icon-image"></i></span>
                                                  <input type="file" accept="image/*" name="image"
                                                         class="imageUploader">
                                                </label>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div> --}}

                                        @foreach (languages() as $lang)
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">{{ __('site.name_' . $lang) }}</label>
                                                    <div class="controls">
                                                        <input type="text" name="name[{{ $lang }}]"
                                                            class="form-control"
                                                            placeholder="{{ __('site.write') . __('site.name_' . $lang) }}"
                                                            required
                                                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.country_code') }}</label>
                                                <div class="controls">
                                                    <input type="number" name="key" class="form-control"
                                                        placeholder="{{ __('admin.enter_country_code') }}" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                        data-validation-number-message="{{ __('admin.just_allows_the_numbers') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.flag') }}</label>
                                                <div class="controls">
                                                    <select name="flag" id="flag-select" class="form-control select2">
                                                        @foreach ($flags as $flag)
                                                            <option value="{{ $flag }}"
                                                                data-img="<img class='img-flag' src='{{ asset('admin/assets/flags/png/' . $flag) }}' alt='flag'/>">
                                                                {{ $flag }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit"
                                                class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.add') }}</button>
                                            <a href="{{ route('admin.countries.index') }}" type="reset"
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

    {{-- submit add form script --}}
    @include('admin.shared.submitAddForm')
    {{-- submit add form script --}}


    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}

    <script>
        $(document).ready(function() {
            $("#flag-select").select2({
                width: "100%",
                closeOnSelect: true,
                templateSelection: iformat,
                templateResult: iformat,
                allowHtml: true,
                allowClear: false,
                dir: "rtl",
            });

            function iformat(icon, badge, color) {
                var originalOption = icon.element;
                var originalOptionBadge = $(originalOption).data("badge");
                var originalOptionColor = $(originalOption).data("img");
                return $(
                    `<span class="flex-span">  ${originalOptionColor}
                        <sapn>${icon.text}</span>
            </span>`

                );
            }
        });
    </script>
@endsection
