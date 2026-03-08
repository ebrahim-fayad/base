<div class="table-scroll position-relative">

    {{-- table loader  --}}
        <div class="table_loader" >
            {{__('admin.loading')}}
        </div>
    {{-- table loader  --}}

    {{-- table content --}}
        <table class="table " id="tab">
        <thead>
            <tr>
                @if ($rows->count() > 0)
                    <th>
                        <label class="container-checkbox">
                            <input type="checkbox" value="value1" name="name1" id="checkedAll">
                            <span class="checkmark"></span>
                        </label>
                    </th>
                @endif
                <th>{{ __('admin.image') }}</th>
                <th>{{ __('admin.name') }}</th>
                @if(request()->route('parent_id') != null)
                    <th>{{ __('admin.parent_category') }}</th>
                @endif
                @if (request()->route('parent_id') == null)
                    <th>{{ __('admin.sub_categories') }}</th>
                @endif
                <th>{{ __('admin.control') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $category)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                            <input type="checkbox" class="checkSingle" id="{{ $category->id }}">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td><img src="{{ $category->image }}" width="50px" height="50px" alt=""></td>
                    <td>
                        <strong>{{ $category->name }}</strong>
                    </td>
                    @if(request()->route('parent_id') != null)
                    <td>
                        @if ($category->parent)
                            <a href="{{ route('admin.categories.show', ['id' => $category->parent->id]) }}"><span
                                    class="badge badge-info">{{ $category->parent->name }}</span></a>
                        @else
                            <span class="badge badge-primary">{{ __('admin.main_category') }}</span>
                        @endif
                    </td>
                    @endif
                    @if ($category->parent_id == null)
                        <td>
                            @if ($category->parent_id == null && $category->slug != 'marketing')
                                <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}"> <span
                                        class="badge badge-secondary">{{ $category->children->count() }}
                                        {{ __('admin.sub_categories') }}</span></a>
                            @else
                                <a href="#">
                                    {{-- <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}"></a> --}}
                                <span class="badge badge-secondary">{{ $category->children->count() }}
                                    {{ __('admin.budgets') }}
                                </span>
                                </a>
                            @endif
                        </td>
                    @endif

                    <td class="product-action">
                        <span class="text-primary"><a
                                href="{{ route('admin.categories.show', ['id' => $category->id]) }}"><i
                                    class="feather icon-eye"></i></a></span>
                        <span class="action-edit text-primary"><a
                                href="{{ route('admin.categories.edit', ['id' => $category->id]) }}"><i
                                    class="feather icon-edit"></i></a></span>
                            <span class="delete-row text-danger" data-url="{{ url('admin/categories/' . $category->id) }}"><i
                                    class="feather icon-trash"></i></span>

                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    {{-- table content --}}
    {{-- no data found div --}}
        @if ($rows->count() == 0)
            <div class="d-flex flex-column w-100 align-center mt-4">
                <img src="{{asset('/storage/images/no_data.png')}}" width="200px" style="" alt="">
                <span class="mt-2" style="font-family: cairo ;margin-right: 35px">{{__('admin.there_are_no_matches_matching')}}</span>
            </div>
        @endif
    {{-- no data found div --}}

</div>
<div class="table-pagination">
{{-- pagination  links div --}}
    @if ($rows->count() > 0 && $rows instanceof \Illuminate\Pagination\AbstractPaginator )
        <div class="d-flex justify-content-center">
            {{$rows->links()}}
        </div>
    @endif
{{-- pagination  links div --}}
</div>
