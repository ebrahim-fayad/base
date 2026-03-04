@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
@endsection

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('routes.meal_items.create') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.meal_items.store') }}" class="store form-horizontal" novalidate enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        @foreach (languages() as $lang)
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name-{{ $lang }}">{{ __('site.name_' . $lang) }}</label>
                                                    <div class="controls">
                                                        <input type="text" name="name[{{ $lang }}]" class="form-control"
                                                            placeholder="{{ __('site.write') . ' ' . __('site.name_' . $lang) }}" required
                                                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="calories">{{ __('admin.calories_per_100g') }}</label>
                                                <div class="controls">
                                                    <input type="number" step="0.01" name="calories" id="calories" class="form-control"
                                                        placeholder="{{ __('admin.calories_per_100g') }}" required min="0"
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="protein">{{ __('admin.protein_per_100g') }}</label>
                                                <div class="controls">
                                                    <input type="number" step="0.01" name="protein" id="protein" class="form-control"
                                                        placeholder="{{ __('admin.protein_per_100g') }}" required min="0"
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="carbohydrates">{{ __('admin.carbohydrates_per_100g') }}</label>
                                                <div class="controls">
                                                    <input type="number" step="0.01" name="carbohydrates" id="carbohydrates" class="form-control"
                                                        placeholder="{{ __('admin.carbohydrates_per_100g') }}" required min="0"
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="fats">{{ __('admin.fats_per_100g') }}</label>
                                                <div class="controls">
                                                    <input type="number" step="0.01" name="fats" id="fats" class="form-control"
                                                        placeholder="{{ __('admin.fats_per_100g') }}" required min="0"
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="active">{{ __('admin.active_status') }}</label>
                                                <div class="controls">
                                                    <select name="active" id="active" class="form-control" required>
                                                        <option value="1">{{ __('admin.activate') }}</option>
                                                        <option value="0">{{ __('admin.dis_activate') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="image">{{ __('admin.image') }}</label>
                                                <div class="controls">
                                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.add') }}</button>
                                            <a href="{{ route('admin.meal_items.index') }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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
    @include('admin.shared.submitAddForm')
@endsection
