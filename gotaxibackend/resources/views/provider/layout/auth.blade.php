<!DOCTYPE html>

<html lang="en">
@section('title', 'Login')
<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ Setting::get('site_title', '') }} - {{ Setting::get('site_sub_title', '') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>


    <!-- Styles -->

    <link href="/css/app.css" rel="stylesheet">

    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">


    <!-- Scripts -->

    <script>

        window.Laravel = <?php echo json_encode([

            'csrfToken' => csrf_token(),

        ]); ?>

    </script>

</head>

<body>

<div class="full-page-bg" style="background-image: url('{{Setting::get('f_mainBanner', '')}}');">

    <div class="log-overlay"></div>

    <div class="full-page-bg-inner">

        <div class="row no-margin">

            <div class="col-md-6 log-left">

                <span class="login-logo" style="background:none"><a href="{{ route('provider.login') }}"><img
                                style="height:50px"
                                src="{{ Setting::get('site_icon') }}"></a></span>

                <h2>{{Setting::get('site_title','Tranxit')}} {{translateKeyword('.fp_1')}}</h2>

                <p>{{ translateKeyword('fp_2') }} {{ Setting::get('site_title', '') }} {{ translateKeyword('fp_3') }}</p>
            </div>

            <div class="col-md-6 log-right">

                <div class="login-box-outer">

                    <div class="login-box row no-margin">

                        @yield('content')

                    </div>

                    <div class="log-copy"><p class="no-margin">
                            &copy; {{ Setting::get('site_copyright', date('Y').' Meemcolart') }}</p></div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

<script src="{{ asset('asset/js/jquery.min.js') }}"></script>

<script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('asset/js/scripts.js') }}"></script>

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

