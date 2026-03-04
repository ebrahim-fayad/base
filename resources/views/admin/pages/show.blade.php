@extends('admin.layout.master')

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('admin.view') . ' ' . __('admin.pages')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form  class="show form-horizontal" >
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="imgMontg col-12 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="image" class="imageUploader">
                                                        </label>
                                                        <div class="uploadedBlock">
                                                            <a href="{{$row->image}}" target="_blank">
                                                                <img src="{{$row->image}}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach (languages() as $lang)
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{__('site.title_'.$lang)}}</label>
                                                <div class="controls">
                                                    <input type="text" value="{{$row->getTranslations('title')[$lang]}}" name="title[{{$lang}}]" class="form-control" placeholder="{{__('site.write') . __('site.title_'.$lang)}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @foreach (languages() as $lang)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.description')}}</label>
                                                    <textarea class="form-control" name="content[{{$lang}}]" id="" cols="30" rows="10" placeholder="{{__('admin.about_the_application_in_english')}}">{{$row->getTranslations('content')[$lang]}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
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
        $('.show input').attr('disabled' , true)
        $('.show textarea').attr('disabled' , true)
        $('.show select').attr('disabled' , true)
    </script>
@endsection
