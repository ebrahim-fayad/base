@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/index_page.css') }}">
@endsection

@section('content')
<div class="content-body">
    <div class="mb-1 d-flex justify-content-between m-0">
        <x-admin.buttons
            addbutton="{{ route('admin.meal_items.create') }}"
            deletebutton="{{ route('admin.meal_items.deleteAll') }}"
        />
        <x-admin.filter
            datefilter="true"
            order="true"
            :searchArray="[
                'name' => [
                    'input_type' => 'text',
                    'input_name' => __('admin.name'),
                ],
                'active' => [
                    'input_type' => 'select',
                    'input_name' => __('admin.active_status'),
                    'rows' => [
                        '1' => [
                            'name' => __('admin.active'),
                            'id' => 1,
                        ],
                        '2' => [
                            'name' => __('admin.inactive'),
                            'id' => 0,
                        ],
                    ],
                ],
            ]"
        />
    </div>
    <div class="table_content_append"></div>
</div>
@endsection

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    @include('admin.shared.deleteAll')
    @include('admin.shared.deleteOne')
    @include('admin.shared.filter_js', ['index_route' => route('admin.meal_items.index')])
@endsection
