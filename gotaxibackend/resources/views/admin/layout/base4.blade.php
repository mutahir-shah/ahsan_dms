<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/iofrm/html/register19.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 27 Jul 2024 12:50:17 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}">
    <title>{{ getWebContent()->site_title ?? '' }} - {{ getWebContent()->site_sub_title ?? '' }}</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/auth') }}/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/auth') }}/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/auth') }}/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/auth') }}/css/iofrm-theme19.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<body>
    <div class="form-body without-side">
        @yield('content')
    </div>
<script src="{{ URL::to('/auth') }}/js/jquery.min.js"></script>
<script src="{{ URL::to('/auth') }}/js/popper.min.js"></script>
<script src="{{ URL::to('/auth') }}/js/bootstrap.min.js"></script>
<script src="{{ URL::to('/auth') }}/js/main.js"></script>
</body>

<!-- Mirrored from brandio.io/envato/iofrm/html/register19.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 27 Jul 2024 12:50:17 GMT -->
</html>