@extends('admin.layout.master')

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('routes.countries.show')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form  class="store form-horizontal" >
                            <div class="form-body">
                                <div class="row">
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
                                                <div class="uploadedBlock">
                                                  <img src="{{ $row->flag }}">
                                                  <button class="close"><i
                                                       class="la la-times"></i></button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    @foreach (languages() as $lang)
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{__('site.name_'.$lang)}}</label>
                                                <div class="controls">
                                                    <input type="text" value="{{$row->getTranslations('name')[$lang]}}" name="name[{{$lang}}]" class="form-control" placeholder="{{__('site.write') . __('site.name_'.$lang)}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.country_code')}}</label>
                                            <div class="controls">
                                                <input type="text" name="key" class="form-control" placeholder="{{__('admin.enter_country_code')}}" value="{{$row->key}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ route('admin.countries.index') }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
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
        $('.store input').attr('disabled' , true)
        $('.store textarea').attr('disabled' , true)
        $('.store select').attr('disabled' , true)

    </script>
@endsection
