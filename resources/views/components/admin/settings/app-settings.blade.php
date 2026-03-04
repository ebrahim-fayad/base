<div role="tabpanel" class="tab-pane active" id="account-vertical-main" aria-labelledby="account-pill-main"
     aria-expanded="true">
    <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data"
          class="form-horizontal" novalidate>
        @method('put')
        @csrf
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.the_name_of_the_application_in_arabic')}}</label>
                        <input type="text" class="form-control" name="name_ar" id="account-name"
                               placeholder="{{__('admin.the_name_of_the_application_in_arabic')}}"
                               value="{{$data['name_ar']}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.the_name_of_the_application_in_english')}}</label>
                        <input type="text" class="form-control" name="name_en" id="account-name"
                               placeholder="{{__('admin.the_name_of_the_application_in_english')}}"
                               value="{{$data['name_en']}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.email')}}</label>
                        <input type="email" class="form-control" name="email" id="account-name"
                               placeholder="{{__('admin.email')}}" value="{{$data['email']}}"
                               data-validation-email-message="{{__('admin.verify_the_email_format')}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.phone')}}</label>
                        <input type="text" class="form-control" name="phone" id="account-name"
                               placeholder="{{__('admin.phone')}}" value="{{$data['phone']}}" minlength="10" required
                               data-validation-required-message="{{__('admin.this_field_is_required')}}"
                               data-validation-minlength-message="{{__('admin.the_number_should_only_be_less_than_ten_numbers')}}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="controls">
                        <label for="account-name">{{__('admin.whatts_app_number')}}</label>
                        <input type="text" class="form-control" name="whatsapp" id="account-name"
                               placeholder="{{__('admin.whatts_app_number')}}" value="{{$data['whatsapp']}}"
                               minlength="10"
                               data-validation-minlength-message="{{__('admin.the_number_should_only_be_less_than_ten_numbers')}}">
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="account-name">is production </label>
                    <div class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                        <input name="is_production"
                               {{$data['is_production']  == '1' ? 'checked' : ''}}   type="checkbox"
                               class="custom-control-input" id="customSwitch11">
                        <label class="custom-control-label" for="customSwitch11">
                            <span class="switch-icon-left"><i class="feather icon-check"></i></span>
                            <span class="switch-icon-right"><i class="feather icon-check"></i></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">

                    <div class="imgMontg col-12 col-lg-4 col-md-6 text-center">
                        <div class="dropBox">
                            <div class="textCenter d-flex flex-column">
                                <div class="imagesUploadBlock">
                                    <label class="uploadImg">
                                        <span><i class="feather icon-image"></i></span>
                                        <input type="file" accept="image/*" name="logo" class="imageUploader">
                                    </label>
                                    <div class="uploadedBlock">
                                        <img src="{{$data['logo']}}">
                                        <button class="close"><i class="feather icon-trash-2"></i></button>
                                    </div>
                                </div>
                                <span>{{__('admin.logo_image')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="imgMontg col-12 col-lg-4 col-md-6 text-center">
                        <div class="dropBox">
                            <div class="textCenter d-flex flex-column">
                                <div class="imagesUploadBlock">
                                    <label class="uploadImg">
                                        <span><i class="feather icon-image"></i></span>
                                        <input type="file" accept="image/*" name="fav_icon" class="imageUploader">
                                    </label>
                                    <div class="uploadedBlock">
                                        <img src="{{$data['fav_icon']}}">
                                        <button class="close"><i class="feather icon-trash-2"></i></button>
                                    </div>
                                </div>
                                <span>{{__('admin.fav_icon_image')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="imgMontg col-12 col-lg-4 col-md-6 text-center">
                        <div class="dropBox">
                            <div class="textCenter d-flex flex-column">
                                <div class="imagesUploadBlock">
                                    <label class="uploadImg">
                                        <span><i class="feather icon-image"></i></span>
                                        <input type="file" accept="image/*" name="login_background"
                                               class="imageUploader">
                                    </label>
                                    <div class="uploadedBlock">
                                        <img src="{{$data['login_background']}}">
                                        <button class="close"><i class="feather icon-trash-2"></i></button>
                                    </div>
                                </div>
                                <span>{{__('admin.background_image')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="imgMontg col-12 col-lg-4 col-md-6 text-center">
                        <div class="dropBox">
                            <div class="textCenter d-flex flex-column">
                                <div class="imagesUploadBlock">
                                    <label class="uploadImg">
                                        <span><i class="feather icon-image"></i></span>
                                        <input type="file" accept="image/*" name="default_user" class="imageUploader">
                                    </label>
                                    <div class="uploadedBlock">
                                        <img src="{{$data['default_user']}}">
                                        <button class="close"><i class="feather icon-trash-2"></i></button>
                                    </div>
                                </div>
                                <span>{{__('admin.virtual_user_image')}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="imgMontg col-12 col-lg-4 col-md-6 text-center">
                        <div class="dropBox">
                            <div class="textCenter d-flex flex-column">
                                <div class="imagesUploadBlock">
                                    <label class="uploadImg">
                                        <span><i class="feather icon-image"></i></span>
                                        <input type="file" accept="image/*" name="banner_image" class="imageUploader">
                                    </label>
                                    <div class="uploadedBlock">
                                        <img src="{{$data['banner_image']}}">
                                        <button class="close"><i class="feather icon-trash-2"></i></button>
                                    </div>
                                </div>
                                <span>{{__('admin.banner_image')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="imgMontg col-12 col-lg-4 col-md-6 text-center">
                        <div class="dropBox">
                            <div class="textCenter d-flex flex-column">
                                <div class="imagesUploadBlock">
                                    <label class="uploadImg">
                                        <span><i class="feather icon-image"></i></span>
                                        <input type="file" accept="image/*" name="no_data_icon" class="imageUploader">
                                    </label>
                                    <div class="uploadedBlock">
                                        <img src="{{$data['no_data_icon']}}">
                                        <button class="close"><i class="feather icon-trash-2"></i></button>
                                    </div>
                                </div>
                                <span>{{__('admin.no_data_image')}}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 d-flex justify-content-center mt-3">
                <button type="submit"
                        class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                <a href="{{ url()->previous() }}" type="reset"
                   class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
            </div>
        </div>
    </form>
</div>
