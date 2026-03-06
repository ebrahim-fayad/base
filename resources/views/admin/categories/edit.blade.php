@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
@endsection

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('routes.categories.edit') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.categories.update', ['id' => $row->id]) }}"
                                class="store form-horizontal" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="col-12">
                                        <div class="imgMontg col-12 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="image"
                                                                class="imageUploader">
                                                        </label>
                                                        @if ($row->image)
                                                            <div class="uploadedBlock">
                                                                <img src="{{ $row->image }}">
                                                                <button class="close"><i class="la la-times"></i></button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach (languages() as $lang)
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label
                                                        for="name_{{ $lang }}">{{ __('site.name_' . $lang) }}</label>
                                                    <div class="controls">
                                                        <input type="text"
                                                            value="{{ in_array($lang, array_keys($row->getTranslations('name'))) ? $row->getTranslations('name')[$lang] : '' }}"
                                                            name="name[{{ $lang }}]" id="name_{{ $lang }}"
                                                            class="form-control"
                                                            placeholder="{{ __('site.write') . __('site.name_' . $lang) }}"
                                                            required
                                                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($row->parent_id == 2)
                                            @foreach (languages() as $lang)
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label
                                                            for="description_{{ $lang }}">{{ __('site.description_' . $lang) }}</label>
                                                        <div class="controls">
                                                            <input type="text"
                                                                value="{{ in_array($lang, array_keys($row->getTranslations('description'))) ? $row->getTranslations('description')[$lang] : '' }}"
                                                                name="description[{{ $lang }}]"
                                                                id="description_{{ $lang }}" class="form-control"
                                                                placeholder="{{ __('site.write') . __('site.description_' . $lang) }}"
                                                                required
                                                                data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="parent_id">{{ __('admin.parent_category') }}
                                                    <small>({{ __('admin.optional') }})</small></label>
                                                <div class="controls">
                                                    <select name="parent_id" id="parent_id" class="form-control" {{ empty($row->parent_id) ? 'disabled' : '' }}>
                                                        <option value="">{{ __('admin.main_category') }}</option>
                                                        @foreach ($parentCategories as $parent)
                                                            <option value="{{ $parent->id }}"
                                                                {{ $row->parent_id == $parent->id ? 'selected' : '' }}>
                                                                {{ $parent->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if(empty($row->parent_id))
                                                        <input type="hidden" name="parent_id" value="">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit"
                                                class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.update') }}</button>
                                            <a href="{{ route('admin.categories.index') }}" type="reset"
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
    @include('admin.shared.addImage')
    @include('admin.shared.submitEditForm')
@endsection
