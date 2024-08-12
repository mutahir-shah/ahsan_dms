<head>

    <meta charset="utf-8">

    <meta name="description" content="Prime Cab HTML5 Responsive Template">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ Setting::get('site_title', '') }} - {{ Setting::get('site_sub_title', '') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
          media="screen">

    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>
    <link href="{{url('mainindex/css/bootstrap.css')}}" rel="stylesheet">

    <link href="{{url('mainindex/css/style3.css')}}" rel="stylesheet">

    <link href="{{url('mainindex/css/fontawesome-all.min.css')}}" rel="stylesheet">

    <link id="switcher" href="{{url('mainindex/css/color.css')}}" rel="stylesheet">

    <link href="{{url('mainindex/css/color-switcher.css')}}" rel="stylesheet">

    <link href="{{url('mainindex/css/owl.carousel.css')}}" rel="stylesheet">

    <link href="{{url('mainindex/css/responsive.css')}}" rel="stylesheet">

    <link href="{{url('mainindex/css/icomoon.css')}}" rel="stylesheet">

    <link href="{{url('mainindex/css/animate.css')}}" rel="stylesheet">

    <style>
        .input-group-addon-password {
            width: 35px !important;
            border-radius: 5px;
            position: absolute;
            right: 0%;
            top: 35%;
        }

        .input-group-addon-password1 {
            width: 35px !important;
            border-radius: 5px;
            position: absolute;
            right: 2%;
            top: 27%;
        }

        .input-group-addon-password2 {
            width: 35px !important;
            border-radius: 5px;
            position: absolute;
            right: 2%;
            top: 27%;
        }

        .about-widget .fsocial-links li a {
            padding-top: 10px;
        }

        .input-group-addon {
            width: 35px !important;
            border-radius: 5px;
        }

        .intl-tel-input {
            z-index: 15;
            width: 100% !important;
            margin-bottom: 15px;
        }

        .p-1 {
            padding: 1em;
        }
    </style>
    <style>
        body > .skiptranslate {
            display: none;
        }
    </style>
</head>

<body>

<!--Wrapper Content Start-->

<div class="tj-wrapper">

    <!--Style Switcher Section End-->

    <header class="tj-header">

        <!--Header Content Start-->

        <div class="container">

            <div class="row">

                <!--Toprow Content Start-->

                <div class="col-md-3 col-sm-4 col-xs-12">

                    <!--Logo Start-->

                    <div class="tj-logo">

                        <!-- <h1><a href="home-1.html">{{Setting::get('site_title', '')}}</a></h1> -->

                        <img src="{{Setting::get('site_logo', '')}}" alt="" style="max-width: 80px;">

                    </div>

                    <!--Logo End-->

                </div>

                <div class="col-md-3 col-sm-4 col-xs-12">

                    <div class="info_box">

                        <i class="fa fa-envelope"></i>

                        <div class="info_text">

                            <span class="info_title">{{ translateKeyword('email_us') }}</span>

                            <span><a href="mailto:{{Setting::get('contact_email_address', '')}}">{{Setting::get('contact_email_address', '')}}</a></span>

                        </div>

                    </div>

                </div>
                @if(Setting::get('contact_number_show', 0) == 1 && Setting::get('contact_number'))
                    <div class="col-md-3 col-xs-12">

                        <div class="phone_info">

                            <div class="phone_icon">

                                <i class="fas fa-phone-volume"></i>

                            </div>

                            <div class="phone_text">

                                <span><a href="tel:{{Setting::get('contact_number', '')}}">{{ str_replace(' ', '', Setting::get('contact_number', '')) }}</a></span>

                            </div>

                        </div>

                    </div>
                @endif


                <!--Toprow Content End-->

            </div>

        </div>


        <div class="tj-nav-row">

            <div class="container">

                <div class="row">

                    <!--Nav Holder Start-->

                    <div class="tj-nav-holder">

                        <!--Menu Holder Start-->

                        <nav class="navbar navbar-default">

                            <div class="navbar-header">

                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#tj-navbar-collapse" aria-expanded="false">

                                    <span class="sr-only">Menu</span>

                                    <span class="icon-bar"></span>

                                    <span class="icon-bar"></span>

                                    <span class="icon-bar"></span>

                                </button>

                            </div>

                            <!-- Navigation Content Start -->

                            <div class="collapse navbar-collapse" id="tj-navbar-collapse">

                                <ul class="nav navbar-nav">

                                    <li>

                                        <a href="../">{{ translateKeyword('home') }}</a>

                                    </li>

                                    {{-- <li>

                                        <a href="../login">Job</a>

                                    </li> --}}

                                    {{-- <li>

                                        <a href="../provider/login">Drive</a>

                                    </li> --}}

                                    <li>

                                        <a href="../contact">{{ translateKeyword('contact_us') }}</a>

                                    </li>

                                    <li><a href="{{ route('provider.login') }}">{{ translateKeyword('login') }}</a></li>
                                    <li><a href="{{ route('provider.register') }}">{{ translateKeyword('register') }}</a></li>

                                </ul>

                            </div>

                            <!-- Navigation Content Start -->

                        </nav>

                        <!--Menu Holder End-->

                        <div class="book_btn">


                        </div>

                    </div><!--Nav Holder End-->

                </div>

            </div>

        </div>

    </header>

    <!--Header Content End-->

    <!--Header Banner Content Start-->


    <!--Header Banner Content Start-->

    <section class="tj-banner-form"
             style="background: url('{{Setting::get('f_mainBanner', '')}}') no-repeat; background-size: cover;">

        <div class="container">

            <div class="row" style=" margin-top: -100px;">

                <!--Header Banner Caption Content Start-->

                <div class="col-md-12 col-sm-12">

                    <div class="banner-caption">

                        <div class="banner-inner bounceInLeft animated delay-0s text-center">

                            <h2>{{ translateKeyword('driver_web_pannel') }}</h2>

                            <h3 style="color: white;">{{ translateKeyword('login_register') }}</h3><br/>

                            <div class="banner-btns" style="margin-bottom: -100px;">

                                <a href="{{Setting::get('f_p_url', '')}}" target="_blank"
                                   style=" width: 155px; margin-right: 5px; " class="btn-style-1"><i
                                            class="fab fa-android"></i>{{ translateKeyword('android_app') }}</a>

                                <a href="{{Setting::get('driver_store_link_ios', '')}}" target="_blank"
                                   style=" width: 155px; margin-left: 5px; text-transform: none !important;"
                                   class="btn-style-2"><i class="fab fa-apple"></i>{{ translateKeyword('ios_app') }}</a>

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </section>


    <!--Header Banner Content End-->


    <!--Login Section Start-->

    <section class="tj-login">

        <div class="container">

            <div class="row" style="margin: auto;  padding: 10px;">

                <div class="col-md-12 col-sm-12">
                    <!--Tabs Nav Start-->

                    <div class="tj-tabs">

                        <ul class="nav nav-tabs" role="tablist">

                            <li class="active"><a href="#" data-toggle="tab">{{ translateKeyword('login') }}</a></li>

                            {{-- <li><a href="#" data-toggle="tab">Register</a></li> --}}

                        </ul>

                    </div>

                    <!--Tabs Nav End-->

                    <!--Tabs Content Start-->

                    <div class="tab-content">

                        <!--Login Tabs Content Start-->

                        <div class="tab-pane active" id="login">

                            

                            <div class="col-md-6 col-sm-6">
                                <div class="tj-tabs p-1">
                                    <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                        @if (Setting::get('email_field', 0) == 1)
                                            <li class="nav-item active">
                                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                                aria-controls="home" aria-selected="true">{{ translateKeyword('email') }}</a>
                                            </li>
                                        @endif
                                        @if (Setting::get('login_phone_hidden', 0) == 1)
                                        <li class="nav-item @if (Setting::get('email_field', 0) == 0) active @endif">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                               role="tab" aria-controls="profile" aria-selected="false">{{ translateKeyword('phone') }}</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane  @if(Setting::get('email_field', 0) == 1) active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <form class="login-frm" role="form" method="POST"
                                              action="{{ url('/provider/login') }}">

                                            {{ csrf_field() }}
                                            <div class="field-holder">

                                                <span class="far fa-envelope"></span>
                                                @if(Setting::get('show_preset_credentials') == 1)
                                                    <input type="email" name="email" required="true" id="email"
                                                           placeholder="{{ translateKeyword('email') }}"
                                                           value="{{ old('email', 'driver@meemcolart.com') }}"
                                                           placeholder="Enter your Email Address">
                                                @else
                                                    <input type="email" name="email" value="{{ old('email') }}"
                                                           required="true" id="email"
                                                           placeholder="{{ translateKeyword('email') }}">
                                                @endif

                                                @if ($errors->has('email'))

                                                    <span class="help-block alert-danger p-1">

															<strong>{{ $errors->first('email') }}</strong>

														</span>

                                                @endif

                                            </div>

                                            <div class="field-holder">

                                                <span class="fas fa-lock"></span>
                                                @if(Setting::get('show_preset_credentials') == 1)
                                                    <div id="show_hide_password">
                                                        <input type="password" name="password" id="password"
                                                               placeholder="{{ translateKeyword('password') }}" value="Quartz@1234">
                                                        <div class="input-group-addon-password">
                                                            <a href="javascript:"><i class="fa fa-eye-slash"
                                                                                     aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                    {{-- <input type="password" name="password" required="true" id="password" placeholder="Password" value="Quartz@1234"> --}}
                                                @else
                                                    <div id="show_hide_password">
                                                        <input type="password" name="password" id="password"
                                                               placeholder="{{ translateKeyword('password') }}">
                                                        <div class="input-group-addon-password">
                                                            <a href="javascript:"><i class="fa fa-eye-slash"
                                                                                     aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                    {{-- <input type="password" name="password" required="true" id="password" placeholder="Password"> --}}
                                                @endif

                                                @if ($errors->has('password'))

                                                    <span class="help-block alert-danger p-1">

															<strong>{{ $errors->first('password') }}</strong>

														</span>

                                                @endif

                                            </div>

                                            <a href="{{ route('provider.reset') }}" class="forget-pass">{{ translateKeyword('forget_password') }}?</a>

                                            <button type="submit" class="reg-btn">{{ translateKeyword('login') }} <i
                                                        class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                            </button>

                                            <!-- <button type="hidden" class="facebook-btn">Login with Facebook <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->

                                            <!-- <button type="hidden" class="google-btn">Login with Google <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->


                                        </form>
                                    </div>
                                    <div class="tab-pane @if(Setting::get('login_phone_hidden', 0) == 1 && Setting::get('email_field', 0) == 0) active @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <form class="login-frm" role="form" method="POST"
                                              action="{{ url('/provider/login') }}">

                                            {{ csrf_field() }}

                                            <div class="field-holder">

                                                <span class="far fa-envelope"></span>
                                                @if(Setting::get('show_preset_credentials') == 1)
                                                    <input type="text" id="mobile" minlength="10" maxlength="15"
                                                           name="mobile" required
                                                           placeholder="+46"
                                                           value="{{ old('mobile', '+921231231234') }}">
                                                @else
                                                    <input type="text" id="mobile" minlength="10" maxlength="15"
                                                           name="mobile" value="{{ old('mobile') }}" required
                                                           placeholder="+46">

                                                @endif

                                                @if ($errors->has('mobile'))

                                                    <span class="help-block alert-danger p-1">

															<strong>{{ $errors->first('mobile') }}</strong>

														</span>

                                                @endif

                                            </div>

                                            <div class="field-holder">

                                                <span class="fas fa-lock"></span>
                                                @if(Setting::get('show_preset_credentials') == 1)
                                                    <div id="show_hide_password">
                                                        <input type="password" name="password" id="password"
                                                               placeholder="{{ translateKeyword('password') }}" value="Quartz@1234">
                                                        <div class="input-group-addon-password">
                                                            <a href="javascript:"><i class="fa fa-eye-slash"
                                                                                     aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                    {{-- <input type="password" name="password" required="true" id="password" placeholder="Password" value="Quartz@1234"> --}}
                                                @else
                                                    <div id="show_hide_password">
                                                        <input type="password" name="password" id="password"
                                                               placeholder="{{ translateKeyword('password') }}">
                                                        <div class="input-group-addon-password">
                                                            <a href="javascript:"><i class="fa fa-eye-slash"
                                                                                     aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                    {{-- <input type="password" name="password" required="true" id="password" placeholder="Password"> --}}
                                                @endif

                                                @if ($errors->has('password'))

                                                    <span class="help-block alert-danger p-1">

															<strong>{{ $errors->first('password') }}</strong>

														</span>

                                                @endif

                                            </div>

                                            <a href="{{ route('provider.reset') }}" class="forget-pass">{{ translateKeyword('forget_password') }}?</a>

                                            <button type="submit" class="reg-btn">{{ translateKeyword('login') }} <i
                                                        class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                            </button>

                                            <!-- <button type="hidden" class="facebook-btn">Login with Facebook <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->

                                            <!-- <button type="hidden" class="google-btn">Login with Google <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->


                                        </form>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6 col-sm-6">

                                <div class="reg-cta">

                                    <ul class="cta-list" style="margin-top: 20px;">

                                        <li>

                                            <span class="icon-mail-envelope icomoon"></span>

                                            <div class="cta-card">

                                                <strong>{{ translateKeyword('customer_support') }}</strong>

                                                <p>{{ translateKeyword('customer_support_1') }}</p>

                                            </div>

                                        </li>

                                        <li>

                                            <span class="icon-lock icomoon"></span>

                                            <div class="cta-info">

                                                <strong>{{ translateKeyword('secure_payment') }}</strong>

                                                <p>{{ translateKeyword('secure_payment_1') }}</p>

                                            </div>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                        <!--Login Tabs Content End-->

                    </div>

                    <!--Tabs Content End-->

                </div>

            </div>

        </div>

    </section>

    <!--Login Section End-->


    <!--Footer Content Start-->

    <section class="tj-footer">

        <div class="container">

            <div class="row">

                <div class="col-md-4 text-center">

                    <div class="about-widget widget">

                        <h3>{{ translateKeyword('about') }}{{Setting::get('site_title', '')}}</h3>

                        <p>{{Setting::get('f_text27', '')}}</p>

                        <ul class="fsocial-links">

                            @if(Setting::get('f_f_link'))
                                <li><a target="_blank" href="{{Setting::get('f_f_link', '')}}"><i
                                                class="fab fa-facebook-f"></i></a></li>
                            @endif

                            @if(Setting::get('f_t_link'))
                                <li><a target="_blank" href="{{Setting::get('f_t_link', '')}}"><i
                                                class="fab fa-twitter"></i></a></li>
                            @endif

                            @if(Setting::get('f_l_link'))
                                <li><a target="_blank" href="{{Setting::get('f_l_link', '')}}"><i
                                                class="fab fa-linkedin-in"></i></a></li>
                            @endif

                            @if(Setting::get('f_i_link'))
                                <li><a target="_blank" href="{{Setting::get('f_i_link', '')}}"><i
                                                class="fab fa-instagram"></i></a></li>
                            @endif

                        </ul>

                    </div>

                </div>

                <div class="col-md-4 text-center">

                    <div class="links-widget widget">

                        <h3>{{ translateKeyword('explore_links') }}</h3>

                        <ul class="flinks-list">

                            <li><a href="../contact">{{ translateKeyword('contact_us') }}</a></li>

                            <li><a href="../privacy">{{ translateKeyword('privacy_policy') }}</a></li>

                            <li><a href="../terms">{{ translateKeyword('terms_conditions') }}</a></li>


                        </ul>

                    </div>

                </div>

                <div class="col-md-4 text-center">

                    <div class="contact-info widget">

                        <h3>{{ translateKeyword('contact_info') }}</h3>

                        <ul class="contact-box">
                            @if(Setting::get('contact_address'))
                                <li>

                                    <i class="fas fa-home"
                                       aria-hidden="true"></i> {{Setting::get('contact_address', '')}}

                                </li>
                            @endif
                            @if(Setting::get('contact_email'))
                                <li>

                                    <i class="far fa-envelope-open"></i>

                                    <a href="mailto:{{Setting::get('contact_email', '')}}">

                                        {{Setting::get('contact_email', '')}}</a>

                                </li>
                            @endif
                            @if(Setting::get('contact_number_show', 0) == 1 && Setting::get('contact_number'))
                                <li>

                                    <i class="fas fa-phone-square"></i>

                                    {{ str_replace(' ', '', Setting::get('contact_number', '')) }}

                                </li>
                            @endif
                            @if(Setting::get('site_link'))
                                <li>

                                    <i class="fas fa-globe-asia"></i>

                                    <a href="{{Setting::get('site_link', '')}}">{{Setting::get('site_link', '')}}</a>

                                </li>
                            @endif
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!--Footer Content End-->

    <!--Footer Copyright Start-->

    <section class="tj-copyright">

        <div class="container">

            <div class="row">

                <div class="col-md-6 col-sm-6">

                    <p>{{Setting::get('site_copyright', '')}}</p>

                </div>

                <div class="col-md-6 col-sm-6">

                    <ul class="payment-icons">

                        <li><i class="fab fa-cc-visa"></i></li>

                        <li><i class="fab fa-cc-mastercard"></i></li>

                        <li><i class="fab fa-cc-paypal"></i></li>

                        <li><i class="fab fa-cc-discover"></i></li>

                        <li><i class="fab fa-cc-jcb"></i></li>

                    </ul>

                </div>

            </div>

        </div>

    </section>

    <!--Footer Copyright End-->

</div>

<!--Wrapper Content End-->


<!-- Js Files Start -->

<script src="../mainindex/js/jquery-1.12.5.min.js"></script>

<script src="../mainindex/js/bootstrap.min.js"></script>

<script src="../mainindex/js/migrate.js"></script>

<script src="../mainindex/js/owl.carousel.min.js"></script>

<script src="../mainindex/js/color-switcher.js"></script>

<script src="../mainindex/js/jquery.counterup.min.js"></script>

<script src="../mainindex/js/waypoints.min.js"></script>

<script src="../mainindex/js/tweetie.js"></script>

{{-- <script src="../mainindex/js/custom.js"></script> --}}

<!-- Country picker with phone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="{{ asset('asset/js/custom-phone-input.js') }}"></script>

<!-- Js Files End -->
<script type="text/javascript">
    $('input[type=radio][name=gender]').click(function () {
        if (this.value == 'male') {
            $('#gender-error').show();
            $('input[type=radio][name=gender][value="female"]').prop('checked', true);
        } else {
            $('#gender-error').hide();
        }
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });

        $("#show_hide_password1 a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password1 input').attr("type") == "text") {
                $('#show_hide_password1 input').attr('type', 'password');
                $('#show_hide_password1 i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password1 input').attr("type") == "password") {
                $('#show_hide_password1 input').attr('type', 'text');
                $('#show_hide_password1 i').removeClass("fa-eye-slash");
                $('#show_hide_password1 i').addClass("fa-eye");
            }
        });

        $("#show_hide_password2 a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password2 input').attr("type") == "text") {
                $('#show_hide_password2 input').attr('type', 'password');
                $('#show_hide_password2 i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password2 input').attr("type") == "password") {
                $('#show_hide_password2 input').attr('type', 'text');
                $('#show_hide_password2 i').removeClass("fa-eye-slash");
                $('#show_hide_password2 i').addClass("fa-eye");
            }
        });

    });
</script>
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
</body>



