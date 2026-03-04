<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ url('admin/dashboard') }}">
                    @php $settings = Cache::get('settings') ?? []; @endphp
<img class="brand-logo img-logo w-auto" src="{{ ($settings['logo'] ?? '/storage/images/settings/logo.png') }}" alt="">
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ 'admin.dashboard' == Route::currentRouteName() ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="feather icon-home"></i> <span class="menu-title">{{ __('routes.main_page') }}</span>
                </a>
            </li>
            {!! \App\Traits\SideBarTrait::sidebar() !!}
        </ul>
    </div>
</div>
