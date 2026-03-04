@extends('admin.layout.master')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('routes.meal_types.show') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="store form-horizontal">
                            <div class="form-body">
                                <div class="row">
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
                                            <label>{{ __('admin.active_status') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" value="{{ $row->active ? __('admin.activate') : __('admin.dis_activate') }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ route('admin.meal_types.index') }}" class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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
