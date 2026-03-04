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
                        <h4 class="card-title">{{ __('routes.meal_types.create') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.meal_types.store') }}" class="store form-horizontal" novalidate>
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
                                                <label for="active">{{ __('admin.active_status') }}</label>
                                                <div class="controls">
                                                    <select name="active" id="active" class="form-control" required>
                                                        <option value="1">{{ __('admin.activate') }}</option>
                                                        <option value="0">{{ __('admin.dis_activate') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.add') }}</button>
                                            <a href="{{ route('admin.meal_types.index') }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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
