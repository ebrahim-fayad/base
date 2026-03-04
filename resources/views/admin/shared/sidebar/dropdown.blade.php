<li class="nav-item {{in_array(substr(Route::currentRouteName(), 6), $value['child']) ? 'has-sub sidebar-group-active open' : '' }}">
    <a href="javascript:void(0);">
        {!! $value['icon'] !!} {{__('routes.'. $value['title'])}}
    </a>
    <ul class="menu-content">
        @foreach ($value['child'] as $child)
            @if (isset($routes_data['"admin.' . $child . '"']) && $routes_data['"admin.' . $child . '"']['title'] && $routes_data['"admin.' . $child . '"']['sub_link'])
                <li class="{{('admin.'.$child) == Route::currentRouteName() ? 'active' : ''}}">
                    <a href="{{route('admin.'.$child)}}">
                        <i class="feather icon-circle mr-1 ml-1"></i>{{ __('routes.'.$routes_data['"admin.' . $child . '"']['title'])}}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</li>
