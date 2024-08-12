<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Title -->
    <title>{{ getWebContent()->site_title ?? '' }} - {{ getWebContent()->site_sub_title ?? '' }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('admin/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
        media="screen">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style>
        
        body>.skiptranslate {
            display: none;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 1.5 !important; 
        }

        .info-box {
            box-shadow: 0 0 2px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            border-radius: .25rem;
            background: #fff;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
            color: #000 !important;
            height: 120px;
            border-radius: 20px;
            padding: 10px;
        }
        
        .my-gradiant-card{
            background-repeat:no-repeat;
            background-size:cover !important;
        }
        
        .info-box-icon{
            font-size: 40px !important;
            color: #fff;
            width: 100px !important;
        }

        .info-box-content{
            height: 100%;
            font-size: 20px !important;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 0px !important;
        }

        .filter-container{
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-buttons{
            flex: 1;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 1.5 !important;
        }

        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 4px 8px rgba(0, 0, 0, .3) !important;
        }

        .tag-danger {
                background-color: #DC3913;
        }

        .tag-success {
            background-color: #0E3F30;
        }

        .tag {
            padding: 1.2em 1.4em 1.3em;
            font-size: 12px;
            min-width: 20px;
            border-radius: 0;
            text-transform: uppercase;
            border-radius: 10px;
        }  
        .nav-tabs .nav-link.active {
            border-color: #ddd #ddd #fff;
            background-color: {{ Setting::get('site_color') }}!important;
            color: #fff!important;
            border-bottom-color: transparent;
        }

        .nav-tabs .nav-link.active:hover {
            background-color: {{ Setting::get('site_color') }}!important;
            color: #fff;
        }

        .filter-buttons a{
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: {{ Setting::get('site_color') }};
            /* background-size: cover; */
            height:50px;
            border: none;
            font-weight: bold;
            font-size: 18px;
            border-radius: 10px;
        }

        .btn-primary{
            background-color:{{ Setting::get('site_color') }};
            border-color:{{ Setting::get('site_color') }};
        }
        .btn-primary:hover{
            background-color:{{ Setting::get('site_color') }};
            border-color:{{ Setting::get('site_color') }};
        }

        .select2-results__option--selected{
            background-color: {{ Setting::get('site_color') }}!important;
        }


    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper">
        @include('admin.include.navbar')
        @include('admin.include.topheader')
        @yield('content')
        @yield('script')
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <script src="{{ url('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('admin/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ url('admin/dist/js/demo.js') }}"></script>


    <!-- Country picker with phone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="{{ asset('asset/js/custom-phone-input.js') }}"></script>

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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        function translateLanguage(langUrl) {
            window.location.href = langUrl;
        }
    </script>

</body>

</html>
