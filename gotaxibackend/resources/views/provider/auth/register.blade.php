<head>

    <meta charset="utf-8">

    <meta name="description" content="Prime Cab HTML5 Responsive Template">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ Setting::get('site_title', '') }} - {{ Setting::get('site_sub_title', '') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
        media="screen">


    <link href="{{ url('mainindex/css/bootstrap.css') }}" rel="stylesheet">

    <link href="{{ url('mainindex/css/style3.css') }}" rel="stylesheet">

    <link href="{{ url('mainindex/css/fontawesome-all.min.css') }}" rel="stylesheet">

    <link id="switcher" href="{{ url('mainindex/css/color.css') }}" rel="stylesheet">

    <link href="{{ url('mainindex/css/color-switcher.css') }}" rel="stylesheet">

    <link href="{{ url('mainindex/css/owl.carousel.css') }}" rel="stylesheet">

    <link href="{{ url('mainindex/css/responsive.css') }}" rel="stylesheet">

    <link href="{{ url('mainindex/css/icomoon.css') }}" rel="stylesheet">

    <link href="{{ url('mainindex/css/animate.css') }}" rel="stylesheet">

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

        body>.skiptranslate {
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

                            <!-- <h1><a href="home-1.html">{{ Setting::get('site_title', '') }}</a></h1> -->

                            <img src="{{ Setting::get('site_logo', '') }}" alt="" style="max-width: 80px;">

                        </div>

                        <!--Logo End-->

                    </div>

                    <div class="col-md-3 col-sm-4 col-xs-12">

                        <div class="info_box">

                            <i class="fa fa-envelope"></i>

                            <div class="info_text">

                                <span class="info_title">{{ translateKeyword('email_us') }}</span>

                                <span><a
                                        href="mailto:{{ Setting::get('contact_email_address', '') }}">{{ Setting::get('contact_email_address', '') }}</a></span>

                            </div>

                        </div>

                    </div>
                    @if (Setting::get('contact_number_show', 0) == 1 && Setting::get('contact_number'))
                        <div class="col-md-3 col-xs-12">

                            <div class="phone_info">

                                <div class="phone_icon">

                                    <i class="fas fa-phone-volume"></i>

                                </div>

                                <div class="phone_text">

                                    <span><a
                                            href="tel:1-234-000-2345">{{ str_replace(' ', '', Setting::get('contact_number', '')) }}</a></span>

                                </div>

                            </div>

                        </div>
                    @endif
                    <div class="col-md-3 col-xs-12">
                        <div id="google_translate_element" style="margin-top: 20px; "></div>
                    </div>
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

                        </div>
                        <!--Nav Holder End-->

                    </div>

                </div>

            </div>

        </header>

        <!--Header Content End-->

        <!--Header Banner Content Start-->


        <!--Header Banner Content Start-->

        <section class="tj-banner-form"
            style="background: url('{{ Setting::get('f_mainBanner', '') }}') no-repeat; background-size: cover;">

            <div class="container">

                <div class="row" style=" margin-top: -100px;">

                    <!--Header Banner Caption Content Start-->

                    <div class="col-md-12 col-sm-12">

                        <div class="banner-caption">

                            <div class="banner-inner bounceInLeft animated delay-0s text-center">

                                <h2>{{ translateKeyword('driver_web_pannel') }}</h2>

                                <h3 style="color: white;">{{ translateKeyword('login_register') }}</h3><br />

                                <div class="banner-btns" style="margin-bottom: -100px;">

                                    <a href="{{ Setting::get('f_p_url', '') }}" target="_blank"
                                        style=" width: 155px; margin-right: 5px; " class="btn-style-1"><i
                                            class="fab fa-android"></i> {{ translateKeyword('android_app') }}</a>

                                    <a href="{{ Setting::get('driver_store_link_ios', '') }}" target="_blank"
                                        style=" width: 155px; margin-left: 5px; text-transform: none !important;"
                                        class="btn-style-2"><i class="fab fa-apple"></i> {{ translateKeyword('ios_app') }}</a>

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
                        {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif --}}
                        <!--Tabs Nav Start-->

                        <div class="tj-tabs">

                            <ul class="nav nav-tabs" role="tablist">


                                {{-- <li><a href="{{ route('provider.login') }}" data-toggle="tab">Login</a></li> --}}

                                <li class="active"><a href="#" data-toggle="tab">{{ translateKeyword('register') }}</a></li>


                            </ul>

                        </div>

                        <!--Tabs Nav End-->

                        <!--Tabs Content Start-->

                        <div class="tab-content" style="padding: 5%">

                        <p>{!! Setting::get('page_driver') !!}</p>
                            <!--Register Tabs Content Start-->

                            <div class="tab-pane active" id="register">

                              

                                <div class="col-md-6 col-sm-6">

                                    <form 
                                    @if(Setting::get('page_driver', '') == '')
                                        style="margin-top: 20px;"
                                    @else
                                        style="padding:0 !important;"
                                    @endif
                                    class="reg-frm"
                                    method="POST"
                                        action="{{ url('/provider/register') }}">

                                        {{ csrf_field() }}

                                        <div class="field-holder">

                                            <div class="row field-holder">

                                                <div class="col-sm-12 col-md-12">

                                                    {{-- <div class="col-sm-4 col-md-4">

                                                <input value="+27" type="text" placeholder="+27" id="country_code" name="country_code"  required/>

                                            </div> --}}

                                                    <div class="col-sm-12 col-md-12">

                                                        <input type="text" maxlength="15" autofocus id="mobile"
                                                            minlength="10" maxlength="15"
                                                            placeholder="{{ translateKeyword('enter_phone_number') }}" name="phone_number"
                                                            value="{{ old('phone_number') }}" required />
                                                        @if ($errors->has('phone_number'))
                                                            <span class="help-block alert-danger p-1">

                                                                <strong>{{ $errors->first('phone_number') }}</strong>

                                                            </span>
                                                        @endif

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="field-holder">

                                            <div class="row">

                                                <div class="col-sm-12 col-md-12">

                                                    <div class="col-md-6 col-sm-6">

                                                        <span class="fas fa-user" style="margin-left: 10px;"></span>

                                                        <input type="text" placeholder="{{ translateKeyword('first_name') }}"
                                                            name="first_name" value="{{ old('first_name') }}"
                                                            required>


                                                        @if ($errors->has('first_name'))
                                                            <span class="help-block alert-danger p-1">

                                                                <strong>{{ $errors->first('first_name') }}</strong>

                                                            </span>
                                                        @endif

                                                    </div>

                                                    <div class="col-md-6 col-sm-6">

                                                        <span class="fas fa-user" style="margin-left: 10px;"></span>

                                                        <input type="text" placeholder="{{ translateKeyword('last_name') }}"
                                                            name="last_name" value="{{ old('last_name') }}" required>


                                                        @if ($errors->has('last_name'))
                                                            <span class="help-block alert-danger p-1">

                                                                <strong>{{ $errors->first('last_name') }}</strong>

                                                            </span>
                                                        @endif

                                                    </div>
                                                    @if (Setting::get('partner_company_info') == 1)

                                                        <div class="col-md-12 col-sm-12">

                                                            <span class="fas fa-envelope"
                                                                style="margin-left: 10px;"></span>

                                                            <input type="text" name="company_name"
                                                                placeholder="{{ translateKeyword('company_name') }}"
                                                                value="{{ old('company_name') }}" required>


                                                            @if ($errors->has('company_name'))
                                                                <span class="help-block alert-danger p-1">

                                                                    <strong>{{ $errors->first('company_name') }}</strong>

                                                                </span>
                                                            @endif

                                                        </div>
                                                        <div class="col-md-12 col-sm-12">

                                                            <span class="fas fa-envelope"
                                                                style="margin-left: 10px;"></span>

                                                            <input type="text" name="{{ translateKeyword('company_address') }}"
                                                                placeholder="Company Address"
                                                                value="{{ old('company_address') }}" required>


                                                            @if ($errors->has('company_address'))
                                                                <span class="help-block alert-danger p-1">

                                                                    <strong>{{ $errors->first('company_address') }}</strong>

                                                                </span>
                                                            @endif

                                                        </div>
                                                        <div class="col-md-12 col-sm-12">

                                                            <span class="fas fa-envelope"
                                                                style="margin-left: 10px;"></span>

                                                            <input type="text" name="company_vat"
                                                                placeholder="{{ translateKeyword('company_vat') }}"
                                                                value="{{ old('company_vat') }}" required>


                                                            @if ($errors->has('company_vat'))
                                                                <span class="help-block alert-danger p-1">

                                                                    <strong>{{ $errors->first('company_vat') }}</strong>

                                                                </span>
                                                            @endif

                                                        </div>
                                                    @endif

                                                    @if (Setting::get('email_field', 1))
                                                        <div class="col-md-12 col-sm-12">

                                                            <span class="fas fa-envelope"
                                                                style="margin-left: 10px;"></span>

                                                            <input type="email" name="email"
                                                                placeholder="{{ translateKeyword('email') }}"
                                                                value="{{ old('email') }}" required>


                                                            @if ($errors->has('email'))
                                                                <span class="help-block alert-danger p-1">

                                                                    <strong>{{ $errors->first('email') }}</strong>

                                                                </span>
                                                            @endif

                                                        </div>
                                                    @endif
                                                    @if (Setting::get('driver_referral', 1))
                                                        <div class="col-md-12 col-sm-12">

                                                            <span class="fas fa-envelope"
                                                                style="margin-left: 10px;"></span>

                                                            <input type="text" name="referral_code"
                                                                placeholder="{{ translateKeyword('referral_code') }}"
                                                                value="{{ old('referral_code') }}" required>


                                                            @if ($errors->has('referral_code'))
                                                                <span class="help-block alert-danger p-1">

                                                                    <strong>{{ $errors->first('referral_code') }}</strong>

                                                                </span>
                                                            @endif

                                                        </div>
                                                    @endif


                                                    <div class="col-md-12 col-sm-12">

                                                        <span class="fas fa-lock" style="margin-left: 10px;"></span>
                                                        <div id="show_hide_password1">
                                                            <input type="password" name="password" id="password1"
                                                                placeholder="{{ translateKeyword('password') }}">
                                                            <div class="input-group-addon-password1">
                                                                <a href="javascript:"><i class="fa fa-eye-slash"
                                                                        aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        {{-- <input type="password"  name="password" placeholder="Password" required> --}}



                                                        @if ($errors->has('password'))
                                                            <span class="help-block alert-danger p-1">

                                                                <strong>{{ $errors->first('password') }}</strong>

                                                            </span>
                                                        @endif

                                                    </div>

                                                    <div class="col-md-12 col-sm-12">

                                                        <span class="fas fa-lock" style="margin-left: 10px;"></span>
                                                        <div id="show_hide_password2">
                                                            <input type="password" name="password_confirmation"
                                                                id="password2" placeholder="{{ translateKeyword('retype_password') }}">
                                                            <div class="input-group-addon-password2">
                                                                <a href="javascript:"><i class="fa fa-eye-slash"
                                                                        aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        {{-- <input type="password" placeholder="Re-type Password"  name="password_confirmation" required> --}}



                                                        @if ($errors->has('password_confirmation'))
                                                            <span class="help-block alert-danger p-1">

                                                                <strong>{{ $errors->first('password_confirmation') }}</strong>

                                                            </span>
                                                        @endif

                                                    </div>
                                                    @if (Setting::get('address_driver', 0) == 1)
                                                        <div class="col-md-12 col-sm-12" style="margin-top: 15px;">
                                                            <input  type="text" value="{{ old('address') }}" name="address"
                                                                    required id="address" placeholder="Address">
                                                        </div>
                                                    @endif
                                                    @if (Setting::get('dob_driver', 0) == 1)
                                                        <div class="col-md-12 col-sm-12" style="margin-top: 15px;">
                                                            <input  type="date" value="{{ old('dob') }}" name="dob" class="form-control"
                                                                    required id="dob" placeholder="DOB">
                                                        </div>
                                                    @endif
                                                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                                                        <div class="col-md-12 col-sm-12" style="margin-top: 15px;">
                                                            <select name="zone_id" >
                                                                <option value="0" selected>No Zone</option>
                                                                @foreach ($zones as $zone)
                                                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                    @if (Setting::get('gender', 1))
                                                        <div class="col-md-12 col-sm-12">

                                                            <label>
                                                                <strong>Gender</strong>
                                                            </label><br />
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender"
                                                                    value="male" checked>{{ translateKeyword('male') }}
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender" value="female"
                                                                    >{{ translateKeyword('female') }}                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender"
                                                                    value="other">{{ translateKeyword('other') }}
                                                            </label>

                                                            <span class="help-block alert-danger p-1"
                                                                id="gender-error"
                                                                style="display:none; color:rgb(206, 67, 67);">

                                                                <strong>{{ translateKeyword('note_1') }}</strong>

                                                            </span>
                                                            @if ($errors->has('gender'))
                                                                <span class="help-block alert-danger p-1">

                                                                    <strong>{{ $errors->first('gender') }}</strong>

                                                                </span>
                                                            @endif

                                                        </div>
                                                    @endif
                                                    @if (Setting::get('gender_pref_enabled') == 1)
                                                        <div class="col-md-12 col-sm-12">

                                                            <label>
                                                                <strong>{{ translateKeyword('gender_preference') }}</strong>
                                                            </label><br />
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender_pref"
                                                                    value="male" checked>{{ translateKeyword('male') }}
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender_pref"
                                                                    value="female">{{ translateKeyword('female') }}
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="gender_pref"
                                                                    value="both">{{ translateKeyword('both') }}
                                                            </label>
                                                            @if ($errors->has('gender_pref'))
                                                                <span class="help-block alert-danger p-1">

                                                                    <strong>{{ $errors->first('gender_pref') }}</strong>

                                                                </span>
                                                            @endif

                                                        </div>
                                                    @else
                                                        <input type="hidden" name="gender_pref" value="">
                                                    @endif
                                                    <div class="col-md-12 col-sm-12" style="margin-top: 15px;">

                                                        <select  name="service_type[]"
                                                            id="service_type" required @if (Setting::get('multi_service_module', 0) == 1)
                                                                multiple style="height: 100px"
                                                            @endif>

                                                            <option value="">Select Service</option>

                                                            @foreach (get_all_service_types() as $type)
                                                                <option value="{{ $type->id }}">
                                                                    {{ $type->name }}</option>
                                                            @endforeach
                                                            
                                                        </select>
                                                        <span class="help-block alert-warning p-1">

                                                            <strong>*Press & hold ctrl to select multiple services</strong>

                                                            </span>

                                                        @if ($errors->has('service_type'))
                                                            <span class="help-block alert-danger p-1">

                                                                <strong>{{ $errors->first('service_type') }}</strong>

                                                            </span>
                                                        @endif

                                                    </div>

                                                    @if (Setting::get('tax_tps_info_field', 0) == 1)
                                                        <div class="col-md-12 col-sm-12" style="margin-top: 15px;">

                                                            <input id="tax_tps_info" type="text" name="tax_tps_info"
                                                                value="{{ old('tax_tps_info') }}"
                                                                placeholder="{{ translateKeyword('tax_tps_info_field') }}" required>

                                                            @if ($errors->has('tax_tps_info'))
                                                                <span class="help-block alert-danger p-1">

                                                                    <strong>{{ $errors->first('tax_tps_info') }}</strong>

                                                                </span>
                                                            @endif

                                                        </div>
                                                    @endif

                                                    @if (Setting::get('tax_tvq_info_field', 0) == 1)
                                                        <div class="col-md-12 col-sm-12" style="margin-top: 15px;">

                                                            <input id="tax_tvq_info" type="text" name="tax_tvq_info"
                                                                value="{{ old('tax_tvq_info') }}"
                                                                placeholder="{{ translateKeyword('tax_tvq_info_field') }}" required>

                                                            @if ($errors->has('tax_tvq_info'))
                                                                <span class="help-block alert-danger p-1">
                                                                    <strong>{{ $errors->first('tax_tvq_info') }}</strong>
                                                                </span>
                                                            @endif

                                                        </div>
                                                    @endif
                                                    
                                                    
                                                    <div class="col-md-12 col-sm-12" style="margin-top: 15px;">

                                                        <input id="service-model" type="text" name="service_model"
                                                            value="{{ old('service_model') }}"
                                                            placeholder="{{ translateKeyword('car_model') }}" required>

                                                        @if ($errors->has('service_model'))
                                                            <span class="help-block alert-danger p-1">

                                                                <strong>{{ $errors->first('service_model') }}</strong>

                                                            </span>
                                                        @endif

                                                    </div>


                                                    <div class="col-md-12 col-sm-12">

                                                        <input id="service-number" type="text"
                                                            name="service_number" value="{{ old('service_number') }}"
                                                            placeholder="{{ translateKeyword('car_number') }}" required>

                                                        @if ($errors->has('service_number'))
                                                            <span class="help-block alert-danger p-1">

                                                                <strong>{{ $errors->first('service_number') }}</strong>

                                                            </span>
                                                        @endif

                                                    </div>


                                                    <label for="terms" style="margin-left: 20px;">

                                                        <input type="checkbox" name="terms" id="terms"
                                                            required>

                                                            {{ translateKeyword('i_accept_terms_conditions') }}

                                                    </label>

                                                </div>

                                            </div>

                                        </div>

                                        <button type="submit" class="reg-btn">{{ translateKeyword('signup') }} <i
                                                class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

                                        <!-- <button type="hidden" class="facebook-btn">Login with Facebook <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->

                                        <!-- <button type="hidden" class="google-btn">Login with Google <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button> -->

                                    </form>

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

                            <!--Register Tabs Content End-->

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

                            <h3>{{ translateKeyword('about') }} {{ Setting::get('site_title', '') }}</h3>

                            <p>{{ Setting::get('f_text27', '') }}</p>

                            <ul class="fsocial-links">

                                @if (Setting::get('f_f_link'))
                                    <li><a target="_blank" href="{{ Setting::get('f_f_link', '') }}"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                @endif

                                @if (Setting::get('f_t_link'))
                                    <li><a target="_blank" href="{{ Setting::get('f_t_link', '') }}"><i
                                                class="fab fa-twitter"></i></a></li>
                                @endif

                                @if (Setting::get('f_l_link'))
                                    <li><a target="_blank" href="{{ Setting::get('f_l_link', '') }}"><i
                                                class="fab fa-linkedin-in"></i></a></li>
                                @endif

                                @if (Setting::get('f_i_link'))
                                    <li><a target="_blank" href="{{ Setting::get('f_i_link', '') }}"><i
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

                                @if (Setting::get('contact_address'))
                                    <li>

                                        <i class="fas fa-home" aria-hidden="true"></i>
                                        {{ Setting::get('contact_address', '') }}

                                    </li>
                                @endif
                                @if (Setting::get('contact_email'))
                                    <li>

                                        <i class="far fa-envelope-open"></i>

                                        <a href="mailto:{{ Setting::get('contact_email', '') }}">

                                            {{ Setting::get('contact_email', '') }}</a>

                                    </li>
                                @endif
                                @if (Setting::get('contact_number_show', 0) == 1 && Setting::get('contact_number'))
                                    <li>

                                        <i class="fas fa-phone-square"></i>

                                        {{ str_replace(' ', '', Setting::get('contact_number', '')) }}

                                    </li>
                                @endif
                                @if (Setting::get('site_link'))
                                    <li>

                                        <i class="fas fa-globe-asia"></i>

                                        <a
                                            href="{{ Setting::get('site_link', '') }}">{{ Setting::get('site_link', '') }}</a>

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

                        <p>{{ Setting::get('site_copyright', '') }}</p>

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
        $('input[type=radio][name=gender]').click(function() {
            if (this.value == 'male') {
                $('#gender-error').show();
                // $('input[type=radio][name=gender][value="female"]').prop('checked', true);
            } else {
                $('#gender-error').hide();
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#show_hide_password a").on('click', function(event) {
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

            $("#show_hide_password1 a").on('click', function(event) {
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

            $("#show_hide_password2 a").on('click', function(event) {
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
