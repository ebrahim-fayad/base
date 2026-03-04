@extends('admin.layout.master')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('routes.meal_items.show') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="store form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    @if($row->image)
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label>{{ __('admin.image') }}</label>
                                            <div class="controls">
                                                <img src="{{ asset('storage/images/' . \App\Models\Meals\MealItem::IMAGEPATH . '/' . $row->image) }}" alt="" style="max-height: 200px; border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @foreach (languages() as $lang)
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>{{ __('site.name_' . $lang) }}</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" value="{{ $row->getTranslations('name')[$lang] ?? '' }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>{{ __('admin.calories_per_100g') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" value="{{ $row->calories }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>{{ __('admin.protein_per_100g') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" value="{{ $row->protein }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>{{ __('admin.carbohydrates_per_100g') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" value="{{ $row->carbohydrates }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>{{ __('admin.fats_per_100g') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" value="{{ $row->fats }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>{{ __('admin.active_status') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" value="{{ $row->active ? __('admin.activate') : __('admin.dis_activate') }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ route('admin.meal_items.index') }}" class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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
<script>
    $('.store input').attr('disabled', true);
    $('.store textarea').attr('disabled', true);
    $('.store select').attr('disabled', true);
</script>
@endsection
