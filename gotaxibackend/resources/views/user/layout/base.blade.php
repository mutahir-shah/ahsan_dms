<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ Setting::get('site_title', '') }} - @yield('title', 'User Home')</title>
    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}" />

    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset/css/slick.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/slick-theme.css') }}" />

    <link href="{{ asset('asset/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset/css/bootstrap-timepicker.css') }}" rel="stylesheet">

    <link href="{{ asset('asset/css/dashboard-style.css') }}" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}" />

    <link rel="stylesheet" href="{{ url('mainindex/vendors/bootstrap-datepicker/jquery.mobile.datepicker.css') }}">
    <link rel="stylesheet"
        href="{{ url('mainindex/vendors/bootstrap-datepicker/jquery.mobile.datepicker.theme.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/elagent-icon/style.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/themfiy/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/simple-line-icon/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/animation/animate.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/calender/dcalendar.picker.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/vendors/magnify-popup/magnific-popup.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('mainindex/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('mainindex/css/responsive.css') }}">

    @yield('styles')
    <style>
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }

        .nav {
            background: white;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none
        }

        .nav-link {
            display: block;
            padding: .5rem 1rem
        }

        .nav-link:focus,
        .nav-link:hover {
            text-decoration: none
        }

        .nav-link.disabled {
            color: #6c757d
        }

        .nav-tabs {
            border-bottom: 1px solid #dee2e6
        }

        .nav-tabs .nav-item {
            margin-bottom: -1px
        }

        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem
        }

        .nav-tabs .nav-link:focus,
        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6
        }

        .nav-tabs .nav-link.disabled {
            color: #6c757d;
            background-color: transparent;
            border-color: transparent
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff
        }

        .nav-tabs .dropdown-menu {
            margin-top: -1px;
            border-top-left-radius: 0;
            border-top-right-radius: 0
        }

        .nav-pills .nav-link {
            border-radius: .25rem
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #007bff
        }

        .nav-fill .nav-item {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            text-align: center
        }

        .nav-justified .nav-item {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            text-align: center
        }

        .tab-content>.tab-pane {
            display: none
        }

        .tab-content>.active {
            display: block
        }

        .navbar {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: .5rem 1rem
        }

        .navbar>.container,
        .navbar>.container-fluid {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between
        }

        .navbar-brand {
            display: inline-block;
            padding-top: .3125rem;
            padding-bottom: .3125rem;
            margin-right: 1rem;
            font-size: 1.25rem;
            line-height: inherit;
            white-space: nowrap
        }

        .navbar-brand:focus,
        .navbar-brand:hover {
            text-decoration: none
        }

        .navbar-nav {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none
        }

        .navbar-nav .nav-link {
            padding-right: 0;
            padding-left: 0
        }

        .navbar-nav .dropdown-menu {
            position: static;
            float: none
        }

        .navbar-text {
            display: inline-block;
            padding-top: .5rem;
            padding-bottom: .5rem
        }

        .navbar-collapse {
            -ms-flex-preferred-size: 100%;
            flex-basis: 100%;
            -ms-flex-positive: 1;
            flex-grow: 1;
            -ms-flex-align: center;
            align-items: center
        }

        .navbar-toggler {
            padding: .25rem .75rem;
            font-size: 1.25rem;
            line-height: 1;
            background-color: transparent;
            border: 1px solid transparent;
            border-radius: .25rem
        }

        .navbar-toggler:focus,
        .navbar-toggler:hover {
            text-decoration: none
        }

        .navbar-toggler:not(:disabled):not(.disabled) {
            cursor: pointer
        }

        .navbar-toggler-icon {
            display: inline-block;
            width: 1.5em;
            height: 1.5em;
            vertical-align: middle;
            content: "";
            background: no-repeat center center;
            background-size: 100% 100%
        }

        @media (max-width: 575.98px) {

            .navbar-expand-sm>.container,
            .navbar-expand-sm>.container-fluid {
                padding-right: 0;
                padding-left: 0
            }
        }

        @media (min-width: 576px) {
            .navbar-expand-sm {
                -ms-flex-flow: row nowrap;
                flex-flow: row nowrap;
                -ms-flex-pack: start;
                justify-content: flex-start
            }

            .navbar-expand-sm .navbar-nav {
                -ms-flex-direction: row;
                flex-direction: row
            }

            .navbar-expand-sm .navbar-nav .dropdown-menu {
                position: absolute
            }

            .navbar-expand-sm .navbar-nav .nav-link {
                padding-right: .5rem;
                padding-left: .5rem
            }

            .navbar-expand-sm>.container,
            .navbar-expand-sm>.container-fluid {
                -ms-flex-wrap: nowrap;
                flex-wrap: nowrap
            }

            .navbar-expand-sm .navbar-collapse {
                display: -ms-flexbox !important;
                display: flex !important;
                -ms-flex-preferred-size: auto;
                flex-basis: auto
            }

            .navbar-expand-sm .navbar-toggler {
                display: none
            }
        }

        @media (max-width: 767.98px) {

            .navbar-expand-md>.container,
            .navbar-expand-md>.container-fluid {
                padding-right: 0;
                padding-left: 0
            }
        }

        @media (min-width: 768px) {
            .navbar-expand-md {
                -ms-flex-flow: row nowrap;
                flex-flow: row nowrap;
                -ms-flex-pack: start;
                justify-content: flex-start
            }

            .navbar-expand-md .navbar-nav {
                -ms-flex-direction: row;
                flex-direction: row
            }

            .navbar-expand-md .navbar-nav .dropdown-menu {
                position: absolute
            }

            .navbar-expand-md .navbar-nav .nav-link {
                padding-right: .5rem;
                padding-left: .5rem
            }

            .navbar-expand-md>.container,
            .navbar-expand-md>.container-fluid {
                -ms-flex-wrap: nowrap;
                flex-wrap: nowrap
            }

            .navbar-expand-md .navbar-collapse {
                display: -ms-flexbox !important;
                display: flex !important;
                -ms-flex-preferred-size: auto;
                flex-basis: auto
            }

            .navbar-expand-md .navbar-toggler {
                display: none
            }
        }

        @media (max-width: 991.98px) {

            .navbar-expand-lg>.container,
            .navbar-expand-lg>.container-fluid {
                padding-right: 0;
                padding-left: 0
            }
        }

        @media (min-width: 992px) {
            .navbar-expand-lg {
                -ms-flex-flow: row nowrap;
                flex-flow: row nowrap;
                -ms-flex-pack: start;
                justify-content: flex-start
            }

            .navbar-expand-lg .navbar-nav {
                -ms-flex-direction: row;
                flex-direction: row
            }

            .navbar-expand-lg .navbar-nav .dropdown-menu {
                position: absolute
            }

            .navbar-expand-lg .navbar-nav .nav-link {
                padding-right: .5rem;
                padding-left: .5rem
            }

            .navbar-expand-lg>.container,
            .navbar-expand-lg>.container-fluid {
                -ms-flex-wrap: nowrap;
                flex-wrap: nowrap
            }

            .navbar-expand-lg .navbar-collapse {
                display: -ms-flexbox !important;
                display: flex !important;
                -ms-flex-preferred-size: auto;
                flex-basis: auto
            }

            .navbar-expand-lg .navbar-toggler {
                display: none
            }
        }

        @media (max-width: 1199.98px) {

            .navbar-expand-xl>.container,
            .navbar-expand-xl>.container-fluid {
                padding-right: 0;
                padding-left: 0
            }
        }

        @media (min-width: 1200px) {
            .navbar-expand-xl {
                -ms-flex-flow: row nowrap;
                flex-flow: row nowrap;
                -ms-flex-pack: start;
                justify-content: flex-start
            }

            .navbar-expand-xl .navbar-nav {
                -ms-flex-direction: row;
                flex-direction: row
            }

            .navbar-expand-xl .navbar-nav .dropdown-menu {
                position: absolute
            }

            .navbar-expand-xl .navbar-nav .nav-link {
                padding-right: .5rem;
                padding-left: .5rem
            }

            .navbar-expand-xl>.container,
            .navbar-expand-xl>.container-fluid {
                -ms-flex-wrap: nowrap;
                flex-wrap: nowrap
            }

            .navbar-expand-xl .navbar-collapse {
                display: -ms-flexbox !important;
                display: flex !important;
                -ms-flex-preferred-size: auto;
                flex-basis: auto
            }

            .navbar-expand-xl .navbar-toggler {
                display: none
            }
        }

        .navbar-expand {
            -ms-flex-flow: row nowrap;
            flex-flow: row nowrap;
            -ms-flex-pack: start;
            justify-content: flex-start
        }

        .navbar-expand>.container,
        .navbar-expand>.container-fluid {
            padding-right: 0;
            padding-left: 0
        }

        .navbar-expand .navbar-nav {
            -ms-flex-direction: row;
            flex-direction: row
        }

        .navbar-expand .navbar-nav .dropdown-menu {
            position: absolute
        }

        .navbar-expand .navbar-nav .nav-link {
            padding-right: .5rem;
            padding-left: .5rem
        }

        .navbar-expand>.container,
        .navbar-expand>.container-fluid {
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap
        }

        .navbar-expand .navbar-collapse {
            display: -ms-flexbox !important;
            display: flex !important;
            -ms-flex-preferred-size: auto;
            flex-basis: auto
        }

        .navbar-expand .navbar-toggler {
            display: none
        }

        .navbar-light .navbar-brand {
            color: rgba(0, 0, 0, .9)
        }

        .navbar-light .navbar-brand:focus,
        .navbar-light .navbar-brand:hover {
            color: rgba(0, 0, 0, .9)
        }

        .navbar-light .navbar-nav .nav-link {
            color: rgba(0, 0, 0, .5)
        }

        .navbar-light .navbar-nav .nav-link:focus,
        .navbar-light .navbar-nav .nav-link:hover {
            color: rgba(0, 0, 0, .7)
        }

        .navbar-light .navbar-nav .nav-link.disabled {
            color: rgba(0, 0, 0, .3)
        }

        .navbar-light .navbar-nav .active>.nav-link,
        .navbar-light .navbar-nav .nav-link.active,
        .navbar-light .navbar-nav .nav-link.show,
        .navbar-light .navbar-nav .show>.nav-link {
            color: rgba(0, 0, 0, .9)
        }

        .navbar-light .navbar-toggler {
            color: rgba(0, 0, 0, .5);
            border-color: rgba(0, 0, 0, .1)
        }

        .navbar-light .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='https://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")
        }

        .navbar-light .navbar-text {
            color: rgba(0, 0, 0, .5)
        }

        .navbar-light .navbar-text a {
            color: rgba(0, 0, 0, .9)
        }

        .navbar-light .navbar-text a:focus,
        .navbar-light .navbar-text a:hover {
            color: rgba(0, 0, 0, .9)
        }

        .navbar-dark .navbar-brand {
            color: #fff
        }

        .navbar-dark .navbar-brand:focus,
        .navbar-dark .navbar-brand:hover {
            color: #fff
        }

        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, .5)
        }

        .navbar-dark .navbar-nav .nav-link:focus,
        .navbar-dark .navbar-nav .nav-link:hover {
            color: rgba(255, 255, 255, .75)
        }

        .navbar-dark .navbar-nav .nav-link.disabled {
            color: rgba(255, 255, 255, .25)
        }

        .navbar-dark .navbar-nav .active>.nav-link,
        .navbar-dark .navbar-nav .nav-link.active,
        .navbar-dark .navbar-nav .nav-link.show,
        .navbar-dark .navbar-nav .show>.nav-link {
            color: #fff
        }

        .navbar-dark .navbar-toggler {
            color: rgba(255, 255, 255, .5);
            border-color: rgba(255, 255, 255, .1)
        }

        .navbar-dark .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='https://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")
        }

        .navbar-dark .navbar-text {
            color: rgba(255, 255, 255, .5)
        }

        .navbar-dark .navbar-text a {
            color: #fff
        }

        .navbar-dark .navbar-text a:focus,
        .navbar-dark .navbar-text a:hover {
            color: #fff
        }

        .dash-content {
            margin-top: 5%;
        }
    </style>

</head>

<body>

    @include('user.include.header')

    <div class="page-content dashboard-page">
        <div class="container-fluid">
            <section class="tj-login">
                <div class="row">
                    @include('user.include.nav')
                    @yield('content')
                </div>
            </section>

        </div>
    </div>


    @include('user.include.footer')


    
    {{-- this disabled for dasboard tab switching --}}
    {{-- <script src="{{ url('mainindex/js/jquery-3.2.1.min.js') }}"></script> --}}
    {{-- <script src="{{ url('mainindex/vendors/bootstrap/js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ url('mainindex/vendors/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ url('mainindex/vendors/slick/slick.min.js') }}"></script>
    <script src="{{ url('mainindex/vendors/calender/dcalendar.picker.js') }}"></script>
    <script src="{{ url('mainindex/vendors/bootstrap-datepicker/datepicker.js') }}"></script>
    <script src="{{ url('mainindex/js/wow.min.js') }}"></script>
    <script src="{{ url('mainindex/vendors/magnify-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ url('mainindex/js/smoothscroll.js') }}"></script>
    <script src="{{ url('mainindex/js/custom.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.min.js') }}"></script>

    <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('asset/js/jquery.mousewheel.js') }}"></script>

    <script type="text/javascript" src="{{ asset('asset/js/jquery-migrate-1.2.1.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('asset/js/slick.min.js') }}"></script>

    <script src="{{ asset('asset/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ asset('asset/js/bootstrap-timepicker.js') }}"></script>

    <script src="{{ asset('asset/js/dashboard-scripts.js') }}"></script>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script> --}}

    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
    @if (Setting::get('multilanguage_enabled', 0) == 1)
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
        </script>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'en'
                }, 'google_translate_element')
            }
        </script>
    @endif
    @yield('scripts')

</body>

</html>
