{{--
  =============================================================================
  HORIZONTAL SCROLL TABLE COMPONENT – Reference
  =============================================================================
  Structure:
    .table-container > .table_content_append > [.table-scroll] + [.table-pagination]
  Scrolling: only .table-scroll (overflow-x: auto). Pagination fixed below.
  Loader: .table_loader inside .table-scroll. Select all: #checkedAll + .checkSingle.
  =============================================================================
--}}

{{-- ---------- 1) INDEX PAGE: wrapper (one per list page) ---------- --}}
<div class="table-container table-scroll-container">
    <div class="table_content_append">
        {{-- Filled by AJAX with .table-scroll + .table-pagination --}}
    </div>
</div>

{{-- ---------- 2) TABLE PARTIAL: scroll area + table + pagination (returned by controller) ---------- --}}
<div class="table-scroll position-relative">
    <div class="table_loader">{{ __('admin.loading') }}</div>
    <table class="table data-table" id="tab">
        <thead>
            <tr>
                <th><label class="container-checkbox"><input type="checkbox" id="checkedAll" aria-label="Select all"><span class="checkmark"></span></label></th>
                <th>{{ __('admin.image') }}</th>
                <th>{{ __('admin.name') }}</th>
                <th>{{ __('admin.control') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows ?? [] as $row)
            <tr>
                <td class="text-center"><label class="container-checkbox"><input type="checkbox" class="checkSingle" id="{{ $row->id }}"><span class="checkmark"></span></label></td>
                <td><img src="{{ asset($row->image ?? '') }}" width="50" height="50" alt=""></td>
                <td>{{ $row->name ?? '' }}</td>
                <td class="product-action"><a href="#"><i class="feather icon-eye"></i></a> <a href="#"><i class="feather icon-edit"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if (($rows ?? collect())->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{ asset('storage/images/no_data.png') }}" width="200" alt="">
            <span class="mt-2">{{ __('admin.there_are_no_matches_matching') }}</span>
        </div>
    @endif
</div>
<div class="table-pagination">
    @if (($rows ?? collect())->count() > 0 && ($rows ?? null) instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="d-flex justify-content-center">{{ $rows->links() }}</div>
    @endif
</div>
