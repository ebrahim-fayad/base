@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/index_page.css')}}">
@endsection

@section('content')
<div class="content-body">

    <div class="mb-1 d-flex justify-content-between m-0">

        <x-admin.buttons
            extrabuttons="true"
            addbutton="{{ route('admin.countries.create') }}"
            deletebutton="{{ route('admin.countries.deleteAll') }}"
        >

            <x-slot name="extrabuttonsdiv">
                <a class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light export-btn" id="export-btn"
                    data-export="{{ App\Models\Country::class }}"
                    href="{{ route('admin.master-export', ['model' => App\Models\Country::class]) }}"><i class="fa fa-file-excel-o"></i>
                    {{ __('admin.export') }}</a>
            </x-slot>

        </x-admin.buttons>

        <x-admin.filter
            datefilter="true"
            order="true"
            :searchArray="[
                'name' => [
                    'input_type' => 'text' ,
                    'input_name' => __('admin.name') ,
                ],
                'key' => [
                    'input_type' => 'text' ,
                    'input_name' => __('admin.country_code') ,
                ],

            ]"
        />

    </div>

    <div class="table_content_append">

    </div>
</div>

@endsection

@section('js')

    <script src="{{asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js')}}"></script>

    {{-- delete all script --}}
        @include('admin.shared.deleteAll')
    {{-- delete all script --}}

    {{-- delete one user script --}}
        @include('admin.shared.deleteOne')
    {{-- delete one user script --}}

    {{-- delete one user script --}}
        @include('admin.shared.filter_js' , [ 'index_route' => route('admin.countries.index')])
    {{-- delete one user script --}}
@endsection
