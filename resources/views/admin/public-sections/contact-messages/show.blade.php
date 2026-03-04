@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
@endsection
@section('content')
    <section id="multiple-column-form">
        <div class="complaint match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('routes.customer_messages.show') }}</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <form>
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.user_name') }}</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control"
                                                           value="{{ $row->user_name?? $row->complaintable?->name }}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.phone') }}</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control"
                                                           value="{{ $row->phone?? $row->complaintable?->full_phone }}" disabled>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.message') }}</label>
                                                <div class="controls">
                                                    <textarea class="form-control" cols="30" complaints="10"
                                                              disabled>{{ $row->complaint }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <a href="{{ route('admin.all_contact_messages') }}" type="reset"
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
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
@endsection
