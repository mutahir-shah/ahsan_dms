<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{Setting::get('site_title','')}} - @yield('title' , 'Website')</title>
    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>

    <link href="mainindex/css/bootstrap.css" rel="stylesheet">

    <link href="mainindex/css/style3.css" rel="stylesheet">

    <link href="{{url('mainindex/css/fontawesome-all.min.css')}}" rel="stylesheet">

    <link id="switcher" href="mainindex/css/color.css" rel="stylesheet">

    <link href="mainindex/css/color-switcher.css" rel="stylesheet">

    <link href="mainindex/css/owl.carousel.css" rel="stylesheet">

    <link href="mainindex/css/responsive.css" rel="stylesheet">

    <link href="mainindex/css/icomoon.css" rel="stylesheet">

    <link href="mainindex/css/animate.css" rel="stylesheet">

    <link rel="stylesheet" href="mainindex/css/style2.css">

    <link rel="stylesheet" href="mainindex/css/responsive2.css">

    @yield('styles')
</head>

<body>

@include('layout.header')

<div class="page-content dashboard-page">
    @yield('content')
</div>


@include('layout.footer')


<script src="mainindex/js/jquery-1.12.5.min.js"></script>

<script src="mainindex/js/bootstrap.min.js"></script>

<script src="mainindex/js/migrate.js"></script>

<script src="mainindex/js/owl.carousel.min.js"></script>

<script src="mainindex/js/color-switcher.js"></script>

<script src="mainindex/js/jquery.counterup.min.js"></script>

<script src="mainindex/js/waypoints.min.js"></script>

<script src="mainindex/js/tweetie.js"></script>

<script src="mainindex/js/custom.js"></script>

@yield('scripts')

</body>
</html>