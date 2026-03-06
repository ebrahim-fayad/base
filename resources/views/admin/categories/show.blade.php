@extends('admin.layout.master')

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('routes.categories.show') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{ __('admin.image') }}</label>
                                            <div>
                                                @if ($row->image)
                                                    <img src="{{ $row->image }}" width="150px" height="150px"
                                                        alt="" style="object-fit: cover; border-radius: 8px;">
                                                @else
                                                    <span class="text-muted">{{ __('admin.no_image') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @foreach (languages() as $lang)
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>{{ __('site.name_' . $lang) }}</label>
                                                <p class="form-control-static">
                                                    {{ in_array($lang, array_keys($row->getTranslations('name'))) ? $row->getTranslations('name')[$lang] : '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($row->parent_id == 2)
                                        @foreach (languages() as $lang)
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>{{ __('site.description_' . $lang) }}</label>
                                                    <p class="form-control-static">
                                                        {{ in_array($lang, array_keys($row->getTranslations('description'))) ? $row->getTranslations('description')[$lang] : '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>{{ __('admin.parent_category') }}</label>
                                            <p class="form-control-static">
                                                @if ($row->parent)
                                                    <span class="badge badge-info">{{ $row->parent->name }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-primary">{{ __('admin.main_category') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>


                                    @if ($row->children && $row->children->count() > 0)
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>{{ __('admin.sub_categories') }}</label>
                                                <div>
                                                    @foreach ($row->children as $child)
                                                        <span
                                                            class="badge badge-secondary mr-1 mb-1">{{ $child->name }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ route('admin.categories.index') }}" type="button"
                                            class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
