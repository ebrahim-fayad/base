@extends('admin.layout.master')

@section('content')
  <!-- // Basic multiple Column Form section start -->
  <section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">{{ __('routes.admins.show') }}</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <form class="store form-horizontal">
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
                                <img src="{{ $row->image }}">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="first-name-column">{{ __('admin.name') }}</label>
                        <div class="controls">
                          <input type="text" name="name" value="{{ $row->name }}"
                                 class="form-control"
                                 placeholder="{{  __('admin.write_the_name') }}" required
                                 data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="first-name-column">{{ __('admin.phone_number') }}</label>
                        <div class="controls">
                          <input type="number" name="phone" value="{{ $row->full_phone }}"
                                 class="form-control"
                                 placeholder="{{ __('admin.enter_phone_number') }}" required
                                 data-validation-required-message="{{  __('admin.this_field_is_required') }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label
                               for="first-name-column">{{ __('admin.email') }}</label>
                        <div class="controls">
                          <input type="email" name="email" value="{{ $row->email }}"
                                 class="form-control"
                                 placeholder="{{ __('admin.enter_the_email') }}"
                                 required
                                 data-validation-required-message="{{  __('admin.this_field_is_required') }}">
                        </div>
                      </div>
                    </div>


                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label for="first-name-column">{{ __('admin.status') }}</label>
                        <div class="controls">
                          <input type="text" name="block" class="form-control" value="{{ $row->is_blocked == 1 ? __('admin.Prohibited') : __('admin.Unspoken')}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-12">
                      <div class="form-group">
                        <label for="first-name-column">{{ __('admin.Validity') }}</label>
                        <div class="controls">
                          <input type="text" name="role_id" class="form-control" value="{{ $row->role?->name }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center mt-3">
                      <a href="{{ route('admin.admins.index') }}" type="reset"
                         class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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
    $('.store input').attr('disabled', true)
    $('.store textarea').attr('disabled', true)
    $('.store select').attr('disabled', true)
  </script>
@endsection
