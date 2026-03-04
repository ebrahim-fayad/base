@extends('intro_site.layouts.master')

@section('content')
    <div class="body-content p-md-3">
        <div class="container p-md-5 ">
            <h1 class="mb-5"> @lang('intro_site.delete_account')</h1>
            <form class="row justify-content-center store" method="POST" novalidate>
                @csrf
                <div class="col-md-12 col-12 mt-2 mb-2 text-center">
                    <div class="controls">
                        <h3>{{ __('intro_site.want_delete_account') }}</h3>
                    </div>
                </div>
                <div class="col-md-5 col-12 mt-4 mb-4">
                    <div class="d-flex align-items-center justify-content-center" style="gap: 20px">
                        <button type="button" class="btn btn-success submit_button">
                            <span class="btnText">@lang('intro_site.yes')</span>
                        </button>
                        <button type="button" class="btn btn-danger submit_button">
                            <span class="btnText">@lang('intro_site.no')</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
