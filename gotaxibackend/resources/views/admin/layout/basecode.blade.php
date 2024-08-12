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

        .select2-container--default .select2-results__options {
            scrollbar-width: thin;
            /* Firefox */
            scrollbar-color: #888 #eee;
            /* Firefox */
        }

        .select2-container--default .select2-results__options::-webkit-scrollbar {
            width: 8px;
            /* Webkit browsers */
        }

        .select2-container--default .select2-results__options::-webkit-scrollbar-track {
            background: #eee;
        }

        .select2-container--default .select2-results__options::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .select2-container--default .select2-results__options::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .select2-results__option--selected{
            background-color: {{ Setting::get('site_color') }}!important;
        }

        .main-header, .main-sidebar, .content-wrapper{
            background: #EBEEF3 !important;
        }

    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper">
        @include('admin.include.navbar')
        @include('admin.include.topheader')
        @yield('content')
        @yield('scripts')
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>


    <script src="{{ url('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ url('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('admin/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ url('admin/dist/js/demo.js') }}"></script>
    <!-- Country picker with phone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        function translateLanguage(langUrl) {
            window.location.href = langUrl;
        }
    </script>
    @if (Setting::get('multilanguage_enabled', 0) == 1)
        <script type="text/javascript"
            src="{{ url('admin///translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'en'
                }, 'google_translate_element')
            }
        </script>
    @endif

</body>

</html>
