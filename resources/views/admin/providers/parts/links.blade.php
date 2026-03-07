<div class="row">
    <div class="col-12">
        <div class="profile-header mb-2 mt-5">

            <div class="relative">
                <div class="cover-container">

                    {{-- <img class="img-fluid bg-cover rounded-0 w-100" style="max-height: 200px" loading="lazy"
                        src="{{ settingsImage('banner_image') }}" alt="User Profile Image"> --}}

                </div>
                <div class="profile-img-container d-flex align-items-center justify-content-between">
                    <img loading="lazy" src="{{ $row->image }}" class="rounded-circle img-border box-shadow-1"
                        alt="Card image">
                    <div class="float-right">
                        <a href="{{ route('admin.providers.edit', $row->id) }}"
                            class="btn btn-icon btn-icon rounded-circle btn-primary mr-1">
                            <i class="feather icon-edit-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center profile-header-nav">
                <nav class="navbar navbar-expand-sm w-100 pr-0">
                    <button class="navbar-toggler pr-0" type="button" data-toggle="collapse"
                        data-target="navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="feather icon-align-justify"></i></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav w-75 ml-sm-auto show-details-links provider-tabs">

                            <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.providers.show', ['id' => $row->id, 'type' => 'main_data']) }}"
                                    data-tab="main_data"
                                    class="nav-link font-small-3 tab-link tab-main_data active">{{ __('admin.main_data') }}
                                </a>
                            </li>
                            <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.providers.show', ['id' => $row->id, 'type' => 'complaints']) }}"
                                    data-tab="complaints"
                                    class="nav-link font-small-3 tab-link tab-complaints">{{ __('admin.complaints') }} (
                                    {{ $row->complaints()->count() }} )</a>
                            </li>
                            <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.providers.show', ['id' => $row->id, 'type' => 'orders']) }}"
                                    data-tab="orders"
                                    class="nav-link font-small-3 tab-link tab-orders">{{ __('admin.orders') }} (
                                    {{ $row->orders()->count() }} )</a>
                            </li>
                            <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.providers.show', ['id' => $row->id, 'type' => 'wallet']) }}"
                                    data-tab="wallet"
                                    class="nav-link font-small-3 tab-link tab-wallet">{{ __('admin.wallet') }} (<span
                                        class="text-success available_balance">
                                        {{ round($row->wallet->balance ?? 0) . ' ' . __('site.currency') }}
                                    </span>)</a>
                            </li>


                            @php
                                $hasUpdateRequest = \App\Models\ProviderUpdate::where(
                                    'provider_id',
                                    $row->id,
                                )->exists();
                            @endphp
                            @if ($hasUpdateRequest)
                                <li class="nav-item px-sm-0">
                                    <a data-href="{{ route('admin.providers.getUpdates', $row->id) }}"
                                        data-tab="provider_updates"
                                        class="nav-link font-small-3 tab-link tab-provider_updates">
                                        {{ __('admin.provider_updates') }}
                                        <span class="badge badge-warning">1</span>
                                    </a>
                                </li>
                            @endif

                            {{-- <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.providers.show' , ['id' =>$row->id , 'type' => 'orders']) }}" class="nav-link font-small-3">{{ __('admin.orders') }} ( {{ round($row->orders()->count() ) }} )</a>
                            </li> --}}

                            {{-- <li class="nav-item px-sm-0">
                                <a data-href="{{ route('admin.providers.show' , ['id' =>$row->id , 'type' => 'settlements']) }}" class="nav-link font-small-3">{{ __('admin.settlements') }} ( {{ round($row->settlements()->count() ) }} )</a>
                            </li> --}}

                            <li class="nav-item px-sm-0">
                                <a class="nav-link font-small-3">
                                    <span
                                        class="
                                        @if ($row->is_approved == \App\Enums\ApprovementStatusEnum::PENDING->value) text-warning
                                        @elseif($row->status == \App\Enums\ApprovementStatusEnum::APPROVED->value) text-success
                                        @elseif($row->status == \App\Enums\ApprovementStatusEnum::REJECTED->value) text-danger
                                        @else text-secondary @endif
                                    ">
                                        {{ \App\Enums\ApprovementStatusEnum::getTranslatedName($row->is_approved, 'approvementStatusEnum') }}
                                    </span>
                                </a>
                            </li>

                        </ul>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
