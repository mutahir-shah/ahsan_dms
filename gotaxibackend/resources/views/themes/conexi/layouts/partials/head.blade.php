<!--begin::Head-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" content="{{ Setting::get('meta_title', '') }}" />
    <meta name="keywords" content="{{ Setting::get('meta_keywords', '') }}" />
    <meta name="description" content="{{ Setting::get('meta_description', '') }}" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <title>{{ Setting::get('site_title', '') }} - {{ Setting::get('site_sub_title', 'Delivery/Transport Hub') }}</title>
    <link rel="icon" type="image/png" href="{{ Setting::get('site_icon', '') }}" />
    {{-- <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('conexi/images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('conexi/images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('conexi/images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('conexi/images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('conexi/images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('conexi/images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('conexi/images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('conexi/images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('conexi/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('conexi/images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('conexi/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('conexi/images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('conexi/images/favicon/favicon-16x16.png') }}"> --}}
    <link rel="manifest" href="{{ asset('conexi/images/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet"
        href="{{ asset('conexi/css/style-' . Setting::get('website_theme_color', 'default') . '.css') }}">
    <link rel="stylesheet" href="{{ asset('conexi/css/responsive.css') }}">
    @stack('styles')
    <style>
        div.logo-block a img {
            width: 80px;
        }

        .footer-logo img {
            width: 80px;
        }

        .btn-store {
            color: #777777;
            min-width: 215px;
            padding: 3px 8px !important;
            border-color: #dddddd !important;
            margin-left: 10px;
        }

        .banner-style-one .slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #111111;
            opacity: 0.7;
            z-index: 1;
            /* Ensure the overlay is above the background image */
        }

        .banner-style-one .slide {
            position: relative;
            /* Ensure the slide is the reference point for the pseudo-element */
            z-index: 0;
            /* Ensure the content inside the slide is above the overlay */
        }

        .banner-style-one .slide .container {
            position: relative;
            z-index: 2;
            /* Ensure the container content is above the overlay */
        }

        .language-btn {
            cursor: pointer;
            border: none;
            outline: none;
            width: 100%;
            background-color: #96DED1;
            height: 36px;
            border-radius: 33.5px;
            text-align: center;
            font-size: 12px;
            transition: all .4s ease;
            padding: 0px 23px;
        }

        .language-btn:hover {
            background-color: #fff;
            color: #111111;
        }

        .site-footer .footer-widget .subscribe-form {
            background-color: #acacac !important;
        }

        .menu-down {
            position: absolute;
            right: -103px;
            top: 30px;
            z-index: 99;
        }

        
    </style>
</head>
<!--end::Head-->