<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs admin-navbar-button" href="#">
                                <i class="ficon feather icon-menu"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="breadcrumb-text">
                        <a href="{{ url('admin/dashboard') }}" class="admin-navbar-home">
                            <i class="feather icon-home"></i>
                            <span>{{ __('site.home') }}</span>
                        </a>
                        <h1 class="admin-navbar-title">
                            {{ Route::currentRouteName() == 'admin.dashboard' ? __('admin.dashboard_overview_title') : __('routes.' . \Request::route()->getAction()['title']) }}
                        </h1>
                    </div>
                </div>

                <ul class="nav navbar-nav float-right resp-wrap-icon admin-navbar-actions">
                    <li class="dropdown dropdown-language nav-item">
                        <a class="dropdown-toggle admin-navbar-button" id="dropdown-flag" href="#" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            @if (lang() == 'ar')
                                <i class="flag-icon flag-icon-sa"></i>
                                <span class="selected-language">عربي</span>
                            @else
                                <i class="flag-icon flag-icon-us"></i>
                                <span class="selected-language">English</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                            <a class="dropdown-item" href="{{ url('admin/lang/ar') }}" data-language="ar">
                                <i class="flag-icon flag-icon-sa"></i>
                                <span>عربي</span>
                            </a>
                            <a class="dropdown-item" href="{{ url('admin/lang/en') }}" data-language="en">
                                <i class="flag-icon flag-icon-us"></i>
                                <span>English</span>
                            </a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="admin-theme-toggle" data-theme-toggle aria-label="Toggle theme"></a>
                    </li>

                    <li class="nav-item d-none d-lg-flex">
                        <a class="admin-navbar-button nav-link-expand" href="#">
                            <i class="ficon feather icon-maximize"></i>
                        </a>
                    </li>

                    <li class="nav-item d-none d-lg-flex">
                        <a class="admin-notification-link position-relative"
                            href="{{ route('admin.admins.notifications') }}">
                            @if (auth('admin')->user()->unreadNotifications->count() > 0)
                                <span id="countNotify" class="badge badge-pill badge-primary badge-up"
                                    data-num="{{ auth('admin')->user()->unreadNotifications->count() }}">
                                    {{ auth('admin')->user()->unreadNotifications->count() }}
                                </span>
                            @else
                                <span id="countNotify" class="badge badge-pill badge-primary badge-up" data-num="0"
                                    style="display: none;"></span>
                            @endif
                            <i class="ficon feather icon-bell"></i>
                        </a>
                    </li>

                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none flex-column">
                                <span class="user-name text-bold-600">{{ auth('admin')->user()->name }}</span>
                                <span class="user-status">{{ __('admin.available') }}</span>
                            </div>
                            <span>
                                <img class="round" src="{{ auth('admin')->user()->image }}" alt="image" height="40"
                                    width="40">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ url('admin/profile') }}">
                                <i class="feather icon-settings"></i>
                                <span>{{ __('site.profile') }}</span>
                            </a>
                            <a class="dropdown-item" href="{{ url('admin/logout') }}">
                                <i class="feather icon-power"></i>
                                <span>{{ __('site.logout') }}</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
