<div class="row">
    <div class="col-12">
        <div class="profile-header mb-2 mt-5">

            <div class="relative">
                <div class="cover-container">
<!--
                    <img class="img-fluid bg-cover rounded-0 w-100" style="max-height: 200px"
                        loading="lazy" src="{{ asset('storage/images/cover_image.png') }}"
                        alt="User Profile Image">
-->
                </div>
               
            </div>

            <div class="d-flex justify-content-end align-items-center profile-header-nav">
                <nav class="navbar navbar-expand-sm w-100 pr-0">
                    <button class="navbar-toggler pr-0" type="button" data-toggle="collapse"
                        data-target="navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i
                                class="feather icon-align-justify"></i></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav  w-75 ml-sm-auto show-details-links client-tabs">

                            <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.clients.show' , ['id' =>$row->id , 'type' => 'main_data']) }}" data-tab="main_data" class="nav-link font-small-3 tab-link tab-main_data active">{{ __('admin.main_data') }} </a>
                            </li>

                            <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.clients.show' , ['id' =>$row->id , 'type' => 'complaints']) }}" data-tab="complaints" class="nav-link font-small-3 tab-link tab-complaints">{{ __('admin.complaints') }} ( {{ $row->complaints()->count() }} )</a>
                            </li>

                            <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.clients.show' , ['id' =>$row->id , 'type' => 'wallet']) }}" data-tab="wallet" class="nav-link font-small-3 tab-link tab-wallet">{{ __('admin.wallet') }} (<span class="text-success available_balance"> {{ round($row->wallet->balance ?? 0) . ' ' . __('site.currency')}}  </span>)</a>
                            </li>

                            {{-- <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.clients.show' , ['id' =>$row->id , 'type' => 'orders']) }}" data-tab="orders" class="nav-link font-small-3 tab-link tab-orders">{{ __('admin.orders') }} ( {{ round($row->orders()->count() ) }} )</a>
                            </li> --}}

                        </ul>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
