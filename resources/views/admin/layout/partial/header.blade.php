<!DOCTYPE html>
<html class="loading" lang="{{ app()->getLocale() }}" dir="{{ lang() == 'ar' ? 'rtl' : 'ltr' }}"
    data-textdirection="{{ lang() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    {{-- Must run first: set theme and direction before any CSS so layout renders correctly on first paint --}}
    <script>
(function(){
    var html = document.documentElement;
    var themeKey = 'caberz_currentLayout';
    var theme = null;
    try { var s = localStorage.getItem(themeKey); if (s === 'dark' || s === 'light') theme = s; } catch (e) {}
    if (theme !== 'dark' && theme !== 'light')
        theme = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
    html.setAttribute('data-theme', theme);
    html.setAttribute('data-bs-theme', theme);
    var dir = html.getAttribute('dir') || html.getAttribute('data-textdirection') || 'ltr';
    html.setAttribute('data-textdirection', dir);
})();
    </script>
    {{-- Critical dashboard layout: inline so it applies on first paint (fixes layout on refresh/language change) --}}
    <style id="admin-critical-spacing">body#content_body{background:var(--app-app-bg) !important}body#content_body .app-content .content-wrapper{padding:1.75rem 1.5rem 2.5rem !important;max-width:1600px !important;margin-inline:auto !important}body#content_body .dashboard-page{padding:2rem 1.5rem 2rem !important}body#content_body .dashboard-shell{display:grid !important;gap:2rem !important}body#content_body .metric-grid{display:grid !important;grid-template-columns:repeat(12,minmax(0,1fr)) !important;gap:1.75rem !important;margin-bottom:2.5rem !important}body#content_body .metric-grid__item{grid-column:span 3 !important}body#content_body .metric-grid+.row{margin-top:1.25rem !important}body#content_body .metric-grid .col-xl-3,body#content_body .metric-grid .col-lg-6,body#content_body .metric-grid .col-md-6,body#content_body .metric-grid .col-12{padding-left:0 !important;padding-right:0 !important}body#content_body .admin-toolbar{display:flex !important;align-items:center !important;flex-wrap:wrap !important;justify-content:flex-end !important;gap:1rem !important}body#content_body .admin-toolbar .btn{margin:0 !important}body#content_body .dashboard-hero__stats{display:grid !important;grid-template-columns:repeat(3,minmax(0,1fr)) !important;gap:1.25rem !important;margin-top:1.5rem !important}body#content_body .dashboard-hero__stat{padding:1.25rem 1.35rem !important;border-radius:1rem !important}body#content_body .dashboard-hero{padding:2rem 1.75rem !important;margin-bottom:2rem !important}body#content_body .footer.footer-light{position:relative !important;margin-top:2rem !important;margin-inline:1.25rem !important}body#content_body .row.mb-2{margin-bottom:1.5rem !important}body#content_body .dashboard-panel{margin-bottom:0 !important}@media (max-width:1399.98px){body#content_body .metric-grid__item{grid-column:span 4 !important}}@media (max-width:991.98px){body#content_body .content-wrapper{padding:1.5rem 1rem 2rem !important}body#content_body .dashboard-page{padding:1.5rem 0.75rem 1.5rem !important}body#content_body .metric-grid__item{grid-column:span 6 !important}body#content_body .dashboard-hero__stats{grid-template-columns:1fr !important}}@media (max-width:767.98px){body#content_body .content-wrapper{padding:1.25rem 0.75rem 1.5rem !important}body#content_body .dashboard-page{padding:1rem 0.5rem 1rem !important}body#content_body .metric-grid__item{grid-column:span 12 !important}}</style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="{{ Cache::get('settings')['fav_icon'] }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ Cache::get('settings')['fav_icon'] }}">

    <title>
        @yield('title', isset(\Request::route()->getAction()['title']) ? __('routes.' . \Request::route()->getAction()['title']) : '')
    </title>

    @if (lang() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/vendors-rtl.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/themes/dark-layout.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('admin/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('admin/app-assets/css-rtl/pages/dashboard-ecommerce.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/pages/card-analytics.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/custom-rtl.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style-rtl.css') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/vendors.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/themes/dark-layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/themes/semi-dark-layout.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('admin/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('admin/app-assets/css/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('admin/app-assets/css/pages/dashboard-ecommerce.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/pages/card-analytics.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/custom-rtl.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style_en.css') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Tajawal:wght@500;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/flatpickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    @vite(['resources/scss/admin.scss', 'resources/js/admin-dashboard.js'])
    @yield('css')

</head>

<body id="content_body"
    class="position-relative vertical-layout vertical-menu-modern 2-columns navbar-floating menu-expanded"
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <script>
        (function() {
            var theme = document.documentElement.getAttribute('data-theme') || 'light';
            var body = document.getElementById('content_body');

            if (!body) {
                return;
            }

            body.setAttribute('data-type', theme);
            body.setAttribute('data-theme', theme);
            body.classList.toggle('dark-layout', theme === 'dark');
            body.classList.toggle('light-mode', theme !== 'dark');
        })();
    </script>
    <audio class="d-none" controls="" id="soundNotify">
        <source src="{{ asset(Cache::get('settings')['notification_sound']) }}" type="audio/ogg">
    </audio>
    {{-- loader --}}
    <div class="loader">
        <div class="sk-chase">
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
        </div>
    </div>
    {{-- loader --}}
