@php use App\Enums\ComplaintStatusEnum; @endphp
<div class="position-relative">
    {{-- table loader  --}}
    <div class="table_loader">
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
            <th>{{__('admin.date')}}</th>
            <th>{{__('admin.user_name')}}</th>
            <th>{{__('admin.phone')}}</th>
            <th>{{__('admin.complaint')}}</th>
            <th>{{__('admin.status')}}</th>
            <th>{{__('admin.control')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $complaint)
            <tr class="delete_complaint">
                <td class="text-center">
                    <label class="container-checkbox">
                        <input type="checkbox" class="checkSingle" id="{{$complaint->id}}">
                        <span class="checkmark"></span>
                    </label>
                </td>
                <td>{{\Carbon\Carbon::parse($complaint->created_at)->format('d/m/Y')}}</td>
                <td>{{$complaint->user_name?? $complaint->complaintable?->name}}</td>
                <td>{{$complaint->phone?? $complaint->complaintable?->full_phone}}</td>
                <td>{{Str::limit($complaint->complaint, 20)}}</td>
                <td><span class="badge badge-{{$complaint->status_badge}}">{{ComplaintStatusEnum::getTranslatedName($complaint->status, 'complaintStatusEnum')}}</span></td>
                <td class="product-action">
                    <span class="action-edit text-primary"><a
                                href="{{route('admin.complaints.show' , ['id' => $complaint->id])}}"><i
                                    class="feather icon-eye"></i></a></span>
                    <span class="delete-row text-danger" data-url="{{url('admin/complaints/'.$complaint->id)}}"><i
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
            <span class="mt-2"
                  style="font-family: cairo ;margin-right: 35px">{{__('admin.there_are_no_matches_matching')}}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($rows->count() > 0 && $rows instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$rows->links()}}
    </div>
@endif
{{-- pagination  links div --}}
