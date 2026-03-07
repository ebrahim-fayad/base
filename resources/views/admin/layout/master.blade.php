@include('admin.layout.partial.header')
@include('admin.layout.partial.navbar')
@include('admin.layout.partial.sidebar') 
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        @yield('breadcrumb')
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="dashboard-ecommerce" class="dashboard-shell">
                @yield('content')
            </section>
        </div>
    </div>
</div>
@include('admin.layout.partial.footer')