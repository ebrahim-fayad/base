@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/index_page.css') }}">
@endsection

@section('content')
<div class="content-body">
    <div class="mb-1 d-flex justify-content-between m-0">
        <x-admin.buttons
            addbutton="{{ route('admin.levels.create') }}"
            deletebutton="{{ route('admin.levels.deleteAll') }}"
        />

        <x-admin.filter
            datefilter="true"
            order="true"
            :searchArray="[
                'name' => [
                    'input_type' => 'text',
                    'input_name' => __('admin.levels.level_name'),
                ],
                'description' => [
                    'input_type' => 'text',
                    'input_name' => __('admin.description'),
                ],
            ]"
        />
    </div>

    <div class="table-container table-scroll-container">
        <div class="table_content_append"></div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
    @include('admin.shared.deleteAll')
    @include('admin.shared.deleteOne')
    @include('admin.shared.filter_js', ['index_route' => route('admin.levels.index')])
    <script>
        $(document).on('click', '.level-toggle-status', function(e) {
            e.preventDefault();
            var $btn = $(this);
            $.ajax({
                url: $btn.data('url'),
                method: 'post',
                data: { id: $btn.data('id'), _token: '{{ csrf_token() }}' },
                dataType: 'json',
                success: function(r) {
                    Swal.fire({ position: 'top-start', icon: 'success', title: r.message, showConfirmButton: false, timer: 1200 });
                    getData({ searchArray: searchArray() });
                },
                error: function() {
                    Swal.fire({ position: 'top-start', icon: 'error', title: '{{ __("admin.an_error_occurred") }}', showConfirmButton: false, timer: 1500 });
                }
            });
        });
    </script>
@endsection
