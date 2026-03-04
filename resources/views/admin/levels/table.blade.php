<div class="position-relative">
    <div class="table_loader">{{ __('admin.loading') }}</div>
    <table class="table" id="tab">
        <thead>
            <tr>
                <th>
                    <label class="container-checkbox">
                        <input type="checkbox" value="value1" name="name1" id="checkedAll">
                        <span class="checkmark"></span>
                    </label>
                </th>
                <th>{{ __('admin.levels.level_name') }}</th>
                <th>{{ __('admin.programs.subscription_price') }}</th>
                <th>{{ __('admin.active_status') }}</th>
                <th>{{ __('admin.control') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $level)
                <tr class="delete_level">
                    <td class="text-center">
                        <label class="container-checkbox">
                            <input type="checkbox" class="checkSingle" id="{{ $level->id }}">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td>{{ Str::limit($level->name, 30) }}</td>
                    <td>{{ $level->subscription_price }} {{ __('admin.currency') }}</td>
                    <td>
                        <a href="#" class="btn btn-sm {{ $level->active ? 'btn-success' : 'btn-secondary' }} level-toggle-status"
                           data-id="{{ $level->id }}"
                           data-url="{{ route('admin.levels.toggleStatus') }}">
                            {{ $level->active ? __('admin.activate') : __('admin.dis_activate') }}
                        </a>
                    </td>
                    <td class="product-action">
                        <span class="text-primary"><a href="{{ route('admin.levels.show', $level->id) }}"><i class="feather icon-eye"></i></a></span>
                        <span class="action-edit text-primary"><a href="{{ route('admin.levels.edit', $level->id) }}"><i class="feather icon-edit"></i></a></span>
                        <span class="delete-row text-danger" data-url="{{ route('admin.levels.delete', $level->id) }}"><i class="feather icon-trash"></i></span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($rows->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{ asset('/storage/images/no_data.png') }}" width="200px" alt="">
            <span class="mt-2" style="font-family: cairo; margin-right: 35px">{{ __('admin.there_are_no_matches_matching') }}</span>
        </div>
    @endif
</div>
@if ($rows->count() > 0 && $rows instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="d-flex justify-content-center mt-3">
        {{ $rows->links() }}
    </div>
@endif
