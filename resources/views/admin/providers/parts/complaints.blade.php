@php use App\Enums\ComplaintStatusEnum;use App\Helpers\EnumHelper; @endphp

<div class="card store">
    <div class="card-body">
        <div class="position-relative" style="max-height: 500px; overflow-y: auto;">            {{-- table content --}}
            {{-- table content --}}
            <table class="table " id="tab">
                <thead>
                <tr>
                    <th>{{__('admin.date')}}</th>
                    <th>{{__('admin.subject')}}</th>
                    <th>{{__('admin.status')}}</th>
                    <th>{{__('admin.control')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($complaints as $complaint)
                    <tr class="delete_complaint">
                        <td>{{\Carbon\Carbon::parse($complaint->created_at)->format('d/m/Y')}}</td>
                        <td>{{$complaint->subject}}</td>
                        <td>
                            <span class="
                                @if($complaint->status == ComplaintStatusEnum::NEW->value) text-warning
                                @elseif($complaint->status == ComplaintStatusEnum::PENDING->value) text-info
                                @elseif($complaint->status == ComplaintStatusEnum::REPLAYED->value) text-success
                                @else text-secondary
                                @endif
                            ">
                                {{ EnumHelper::toResource(ComplaintStatusEnum::class, $complaint->status)['title'] }}
                            </span>
                        </td>
                        <td class="product-action">
                            <span class="action-edit text-primary"><a
                                    href="{{route('admin.complaints.show' , ['id' => $complaint->id])}}"><i
                                        class="feather icon-eye"></i></a></span>
                            {{-- <span cضlass="delete-row text-danger" data-url="{{url('admin/complaints/'.$complaint->id)}}"><i class="feather icon-trash"></i></span> --}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- table content --}}
            {{-- no data found div --}}
            @if ($complaints->count() == 0)
                <div class="d-flex flex-column w-100 align-center mt-4">
                    <img src="{{asset('storage/images/no_data.png')}}" width="200px" alt="">
                    <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
                </div>
            @endif
            {{-- no data found div --}}

        </div>
        {{-- pagination  links div --}}
        @if ($complaints->count() > 0 && $complaints instanceof \Illuminate\Pagination\AbstractPaginator )
            <div class="d-flex justify-content-center mt-3">
                {{$complaints->links()}}
            </div>
        @endif
        {{-- pagination  links div --}}
    </div>
</div>
