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
                        <h4 class="card-title">{{ __('routes.meal_items.edit') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.meal_items.update', ['id' => $row->id]) }}" class="store form-horizontal" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        @foreach (languages() as $lang)
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="name-{{ $lang }}">{{ __('site.name_' . $lang) }}</label>
                                                    <div class="controls">
                                                        <input type="text" name="name[{{ $lang }}]" class="form-control"
                                                            value="{{ $row->getTranslations('name')[$lang] ?? '' }}"
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
                                                        value="{{ $row->calories }}"
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
                                                        value="{{ $row->protein }}"
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
                                                        value="{{ $row->carbohydrates }}"
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
                                                        value="{{ $row->fats }}"
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
                                                        <option value="1" {{ $row->active ? 'selected' : '' }}>{{ __('admin.activate') }}</option>
                                                        <option value="0" {{ !$row->active ? 'selected' : '' }}>{{ __('admin.dis_activate') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="image">{{ __('admin.image') }}</label>
                                                <div class="controls">
                                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                                    @if($row->image)
                                                        <div class="mt-2">
                                                            <img src="{{ $row->image ? asset('storage/images/' . \App\Models\Meals\MealItem::IMAGEPATH . '/' . $row->image) : asset('storage/images/no_data.png') }}" alt="" style="max-height: 120px; border-radius: 8px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.update') }}</button>
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
    @include('admin.shared.submitEditForm')
@endsection
