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
                    <h4 class="card-title">{{ __('admin.add') }} {{ __('admin.levels.level') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.levels.store') }}" class="store form-horizontal" novalidate>
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    @foreach (languages() as $lang)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{ __('admin.levels.level_name') }} {{ __('site.title_'.$lang) }}</label>
                                                <input type="text" class="form-control" name="name[{{ $lang }}]" placeholder="{{ __('admin.write_the_name') }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('admin.levels.level_number') }}</label>
                                            <input type="text" class="form-control" name="level_number" placeholder="{{ __('admin.levels.level_number_placeholder') }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('admin.programs.subscription_price') }}</label>
                                            <input type="number" step="0.01" min="0" class="form-control" name="subscription_price" value="0" placeholder="0">
                                            <small class="text-muted">{{ __('admin.programs.zero_free_subscription') }}</small>
                                        </div>
                                    </div>
                                    @foreach (languages() as $lang)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{ __('admin.description') }} {{ __('site.title_'.$lang) }}</label>
                                                <textarea class="form-control ckeditor-desc" name="description[{{ $lang }}]" id="description_{{ $lang }}" rows="4"></textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>{{ __('admin.active_status') }}</label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="active" id="active" value="1" checked>
                                                <label class="custom-control-label" for="active">{{ __('admin.activate') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.add') }}</button>
                                        <a href="{{ route('admin.levels.index') }}" type="button" class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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
    <script src="https://cdn.ckeditor.com/4.16.2/full-all/ckeditor.js"></script>
    <script>
        @foreach (languages() as $lang)
            CKEDITOR.replace('description_{{ $lang }}');
        @endforeach
        $(document).on('submit', '.store', function() {
            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances) {
                for (var i in CKEDITOR.instances) {
                    CKEDITOR.instances[i].updateElement();
                }
            }
        });
    </script>
    @include('admin.shared.submitAddForm')
@endsection
