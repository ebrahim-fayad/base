@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/index_page.css') }}">
@endsection

@section('content')
    <div class="content-body">

        <div class="mb-1 d-flex justify-content-between m-0">

            <x-admin.buttons extrabuttons="true" addbutton="{{ route('admin.categories.create', ['parent_id' => request()->route('parent_id')]) }}"
                deletebutton="{{ route('admin.categories.deleteAll') }}">

                <x-slot name="extrabuttonsdiv">
                    @if ($modelCount)
                        <a class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light export-btn" id="export-btn"
                            data-export="{{ App\Models\Category::class }}"
                            href="{{ route('admin.master-export', ['model' => App\Models\Category::class, 'conditions' => ['parent_id' => request()->route('parent_id') ?? 'null']]) }}"><i
                                class="fa fa-file-excel-o"></i>
                            {{ __('admin.export') }}</a>
                    @endif
                </x-slot>
            </x-admin.buttons>

            @php
                $filterArray = [
                    'name' => [
                        'input_type' => 'text',
                        'input_name' => __('admin.name'),
                    ],
                ];

                // Add parent category filter if parent categories exist
                if (isset($parentCategories) && $parentCategories->count() > 0) {
                    $parentRows = [
                        '1' => [
                            'name' => __('admin.all_parent_categories'),
                            'id' => '',
                        ],
                    ];
                    $index = 2;
                    foreach ($parentCategories as $category) {
                        $parentRows[$index] = [
                            'name' => $category->name,
                            'id' => $category->id,
                        ];
                        $index++;
                    }
                    $filterArray['parent_id'] = [
                        'input_type' => 'select',
                        'rows' => $parentRows,
                        'input_name' => __('admin.parent_category'),
                    ];
                }
            @endphp
            <x-admin.filter datefilter="true" order="true" :searchArray="$filterArray" />

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
    @include('admin.shared.filter_js', [
        'index_route' => route('admin.categories.index', [
            'parent_id' => request()->route('parent_id')
        ])
    ])
@endsection
