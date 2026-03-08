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
                <th>
                    <label class="container-checkbox">
                        <input type="checkbox" value="value1" name="name1" id="checkedAll">
                        <span class="checkmark"></span>
                    </label>
                </th>
                <th>{{ __('admin.name') }}</th>
                <th>{{ __('admin.active_status') }}</th>
                <th>{{ __('admin.control') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    <td class="text-center">
                        <label class="container-checkbox">
                            <input type="checkbox" class="checkSingle" id="{{ $row->id }}">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td>{{ $row->name }}</td>
                    <td>
                        <span class="badge {{ $row->active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $row->active ? __('admin.activate') : __('admin.dis_activate') }}
                        </span>
                    </td>
                    <td class="product-action">
                        <span class="text-primary"><a href="{{ route('admin.meal_types.show', ['id' => $row->id]) }}"><i class="feather icon-eye"></i></a></span>
                        <span class="action-edit text-primary"><a href="{{ route('admin.meal_types.edit', ['id' => $row->id]) }}"><i class="feather icon-edit"></i></a></span>
                        <span class="delete-row text-danger" data-url="{{ url('admin/meal-types/' . $row->id) }}"><i class="feather icon-trash"></i></span>
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
