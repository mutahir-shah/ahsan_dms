<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="title" content="{{ getWebContent()->meta_title ?? '' }}"/>
    <meta name="keywords" content="{{ getWebContent()->meta_keyword ?? '' }}"/>
    <meta name="description"
          content="{{ getWebContent()->meta_description ?? '' }}"/>
    <link rel="canonical" href="{{ url()->current() }}"/>

    <title>{{ getWebContent()->site_title ?? '' }} - {{ getWebContent()->site_sub_title ?? 'Delivery/Transport Hub' }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>

    <link rel="stylesheet" href="{{ asset('mainindex/vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/bootstrap-datepicker/jquery.mobile.datepicker.css') }}">
    <link rel="stylesheet"
          href="{{ asset('mainindex/vendors/bootstrap-datepicker/jquery.mobile.datepicker.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/elagent-icon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/themfiy/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/simple-line-icon/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/animation/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/calender/dcalendar.picker.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/magnify-popup/magnific-popup.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
          media="screen">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('mainindex/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/css/responsive.css') }}">
    @yield('styles')
    <style>
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        .intl-tel-input {
            z-index: 15;
            width: 100%;
            margin-bottom: 10px;
        }

        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
            position: absolute;
            right: 0%;
            top: 25%;
        }
    </style>
</head>

<body>
<div class="page-content dashboard-page">
    @yield('content')
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
{{-- <script src="{{ asset('mainindex/js/jquery-3.2.1.min.js') }}"></script> --}}
<script src="{{ asset('mainindex/vendors/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('mainindex/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('mainindex/vendors/slick/slick.min.js') }}"></script>
<script src="{{ asset('mainindex/vendors/calender/dcalendar.picker.js') }}"></script>
<script src="{{ asset('mainindex/vendors/bootstrap-datepicker/datepicker.js') }}"></script>
<script src="{{ asset('mainindex/js/wow.min.js') }}"></script>
<script src="{{ asset('mainindex/vendors/magnify-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('mainindex/js/smoothscroll.js') }}"></script>
<script src="{{ asset('mainindex/js/custom.js') }}"></script>
<!-- Country picker with phone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="{{ asset('asset/js/custom-phone-input.js') }}"></script>
@yield('scripts')
</body>

</html>
