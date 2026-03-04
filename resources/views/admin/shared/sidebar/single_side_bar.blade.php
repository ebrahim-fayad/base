<li class="nav-item {{$value['routeName'] == Route::currentRouteName() ? 'active' : ''}}">
    <a href="{{route($value['routeName'])}}">
        {!! $value['icon'] !!} <span class="menu-title">{{__('routes.'.$value['title'])}}</span> 
    </a>
</li>