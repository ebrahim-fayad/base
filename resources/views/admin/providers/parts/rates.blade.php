@php use Carbon\Carbon; @endphp
<div class="card store">
    <div class="card-body">
        <div class="position-relative">
            {{-- table content --}}
            <table class="table " id="tab" style="overflow: auto">
                <thead>
                <tr>
                    <th>{{__('admin.date')}}</th>
                    <th>{{__('admin.rater')}}</th>
                    <th>{{__('admin.rate')}}</th>
                    <th>{{__('admin.comment')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rates->load('ratingable') as $rate)
                    <tr>
                        <td>{{Carbon::parse($rate->created_at)->format('d/m/Y')}}</td>
                        <td>
                            @if($rate->ratingable)
                                <a href="{{ route('admin.clients.show', ['id' => $rate->ratingable_id]) }}">
                                    {{ $rate->ratingable?->name }}
                                </a>
                            @else
                                {{ __('admin.not_found') }}
                            @endif
                        </td>
                        <td>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rate->rate)
                                        <i class="fa fa-star text-warning"></i>
                                    @else
                                        <i class="fa fa-star-o text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td>{{ Str::limit($rate->message,20) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- table content --}}
            {{-- no data found div --}}
            @if ($rates->count() == 0)
                <div class="d-flex flex-column w-100 align-center mt-4">
                    <img src="{{asset('storage/images/no_data.png')}}" width="200px" alt="">
                    <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
                </div>
            @endif
            {{-- no data found div --}}

        </div>
        {{-- pagination  links div --}}
        @if ($rates->count() > 0 && $rates instanceof \Illuminate\Pagination\AbstractPaginator )
            <div class="d-flex justify-content-center mt-3">
                {{$rates->links()}}
            </div>
        @endif
        {{-- pagination  links div --}}
    </div>
</div>
