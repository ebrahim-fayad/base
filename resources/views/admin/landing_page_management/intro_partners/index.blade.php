@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/index_page.css')}}">
@endsection

@section('content')
<div class="content-body">

    <div class="mb-1 d-flex justify-content-between m-0">
        <x-admin.buttons
            addbutton="{{ route('admin.introparteners.create') }}"
            deletebutton="{{ route('admin.introparteners.deleteAll') }}"
        />
    </div>
    <div class="table-container table-scroll-container">
        <div class="table_content_append"></div>
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
        @include('admin.shared.filter_js' , [ 'index_route' => route('admin.introparteners.index')])
    {{-- delete one user script --}}
@endsection
