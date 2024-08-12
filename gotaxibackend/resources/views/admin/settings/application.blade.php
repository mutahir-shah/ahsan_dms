@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Site Settings ')

@section('content')

    <style>
        /* */

        .panel-default>.panel-heading {
            color: #333 !important;
            background-color: #fff;
            border-color: #e4e5e7;
            padding: 0;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .panel-default>.panel-heading a {
            display: block;
            padding: 10px 15px;
            color: #333 !important;
        }

        .panel-default>.panel-heading a:after {
            content: "";
            position: relative;
            top: 1px;
            display: inline-block;
            font-family: 'Glyphicons Halflings';
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            float: right;
            transition: transform .25s linear;
            -webkit-transition: -webkit-transform .25s linear;
        }

        .panel-default>.panel-heading a[aria-expanded="true"] {
            background-color: #eee;
        }

        .panel-default>.panel-heading a[aria-expanded="true"]:after {
            content: "\2212";
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .panel-default>.panel-heading a[aria-expanded="false"]:after {
            content: "\002b";
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        .panel {
            height: fit-content;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-fluid">
            @include('common.notify')

            {{-- <h5>Site Settings</h5> --}}

            <form class="form-horizontal" action="{{ route('admin.settings.store') }}" method="POST"
                enctype="multipart/form-data" role="form">
                {{ csrf_field() }}

                <div class="panel-group row" id="accordion" role="tablist" aria-multiselectable="true">

                    <div class="col-6">
                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading16">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse161" aria-expanded="false" aria-controls="collapse161">
                                        @translateKeyword('timezones')
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse161" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading16">
                                <div class="panel-body row">

                                    <div class="form-group col-6">
                                        <label for="timezone"
                                            class="col-xs-12 col-form-label">@translateKeyword('set_timezone')</label>
                                        <div class="col-xs-12">
                                            <select class="form-control" name="timezone">
                                                @foreach ($timezones as $timezone)
                                                    <option value="{{ $timezone }}"
                                                        @if (getSettings('timezone') == $timezone) selected @endif>
                                                        {{ $timezone }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading19">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse19" aria-expanded="false" aria-controls="collapse19">
                                        {{ translateKeyword('modules') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse19" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading19">
                                <div class="panel-body row">


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                @translateKeyword('all-provider-on-dispatcher')
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('all_provider_dispatcher') == 1) checked @endif
                                                name="all_provider_dispatcher" id="all_provider_dispatcher" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('accountant-panel') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('account_panel') == 1) checked @endif name="account_panel"
                                                id="account_panel" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('about-us-page') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('introduction') == 1) checked @endif name="introduction"
                                                id="introduction" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('booking-form-on-web') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('bookingform_on_web') == 1) checked @endif
                                                name="bookingform_on_web" id="bookingform_on_web" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('blogs-switch') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('blogs_switch') == 1) checked @endif name="blogs_switch"
                                                id="blogs_switch" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('call-us-button-on-header') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('call_us') == 1) checked @endif name="call_us"
                                                id="call_us" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('call-to-action-container') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('cta_container') == 1) checked @endif name="cta_container"
                                                id="cta_container" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('contact-info-container') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('contact_info_container') == 1) checked @endif
                                                name="contact_info_container" id="contact_info_container" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('dispatcher-panel') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('dispatcher_panel') == 1) checked @endif name="dispatcher_panel"
                                                id="dispatcher_panel" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('force-login-page-on-web') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('force_login_page') == 1) checked @endif
                                                name="force_login_page" id="force_login_page" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('fleet-panel') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('vendor_panel') == 1) checked @endif name="vendor_panel"
                                                id="vendor_panel" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('faq-switch') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('faq_switch') == 1) checked @endif name="faq_switch"
                                                id="faq_switch" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('features-section') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('features_section') == 1) checked @endif
                                                name="features_section" id="features_section" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('hide-conexi-code') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('hide_conexi_code') == 1) checked @endif
                                                name="hide_conexi_code" id="hide_conexi_code" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('home-page-button') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('home_button') == 1) checked @endif name="home_button"
                                                id="home_button" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('job-button') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('ride_btn') == 1) checked @endif name="ride_btn"
                                                id="ride_btn" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('login-on-web') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('login_on_web') == 1) checked @endif name="login_on_web"
                                                id="login_on_web" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('login-phone-field-in-login-page') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('login_phone_hidden') == 1) checked @endif
                                                name="login_phone_hidden" id="login_phone_hidden" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('landing-page') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('landing_page') == 1) checked @endif name="landing_page"
                                                id="landing_page" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('multi-language') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('multilanguage_enabled') == 1) checked @endif
                                                name="multilanguage_enabled" id="multilanguage_enabled" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('mockups-section') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('mockup_section') == 1) checked @endif name="mockup_section"
                                                id="mockup_section" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('offers-section') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('offer_section') == 1) checked @endif name="offer_section"
                                                id="offer_section" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('offers-container') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('offer_container') == 1) checked @endif
                                                name="offer_container" id="offer_container" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('provider-on-web') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('driver_on_web') == 1) checked @endif name="driver_on_web"
                                                id="driver_on_web" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('play-bell') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('play_bell') == 1) checked @endif name="play_bell"
                                                id="play_bell" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>




                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('register-on-web') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('register_on_web') == 1) checked @endif
                                                name="register_on_web" id="register_on_web" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('slider-section') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('slider_container') == 1) checked @endif
                                                name="slider_container" id="slider_container" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('services-container') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('services_container') == 1) checked @endif
                                                name="services_container" id="services_container" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('testinomials-switch') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('testinomials_switch') == 1) checked @endif
                                                name="testinomials_switch" id="testinomials_switch" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>












                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('website') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('website_enable') == 1) checked @endif name="website_enable"
                                                id="website_enable" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="admin_login_otp" class="col-form-label">
                                                {{ translateKeyword('admin-login-otp') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('admin_login_otp') == 1) checked @endif
                                                name="admin_login_otp" id="admin_login_otp" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="account_login_otp" class="col-form-label">
                                                {{ translateKeyword('account-login-otp') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('account_login_otp') == 1) checked @endif
                                                name="account_login_otp" id="account_login_otp" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="fleet_login_otp" class="col-form-label">
                                                {{ translateKeyword('fleet-login-otp') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('fleet_login_otp') == 1) checked @endif
                                                name="fleet_login_otp" id="fleet_login_otp" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="dispatcher_login_otp" class="col-form-label">
                                                {{ translateKeyword('dispatcher-login-otp') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('dispatcher_login_otp') == 1) checked @endif
                                                name="dispatcher_login_otp" id="dispatcher_login_otp" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    {{-- <div class="form-group row">
                                        <div class="col-xs-2 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                Gender preference
                                            </label>
                                        </div>
                                        <div class="col-xs-10">
                                            <input @if (getSettings('gender_pref_enabled') == 1) checked @endif
                                                name="gender_pref_enabled" id="gender_pref_enabled" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
    
                                    </div> --}}


                                    @if (config('app.url') == 'https://dev.meemcolart.com' ||
                                            config('app.url') == 'https://meemcolart.com/' ||
                                            config('app.url') == 'https://godrive.meemcolart.com')
                                        <div class="form-group col-6">
                                            <div class="col-xs-6 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    {{ translateKeyword('show-preset-credentials') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input @if (getSettings('show_preset_credentials') == 1) checked @endif
                                                    name="show_preset_credentials" id="show_preset_credentials"
                                                    type="checkbox" class="js-switch" data-color="#43b968">
                                            </div>

                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading21">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse21" aria-expanded="false" aria-controls="collapse21">
                                        {{ translateKeyword('service-categories-for-web') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse21" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading21">
                                <div class="panel-body row">

                                    <br />

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('Luxury') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_lux') == 1) checked @endif name="cat_web_lux"
                                                id="cat_web_lux" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('OutStation') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_out') == 1) checked @endif name="cat_web_out"
                                                id="cat_web_out" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>




                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('road-assitance') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_road_assist') == 1) checked @endif
                                                name="cat_web_road_assist" id="cat_web_road_assist" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('Economy') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_ecomony') == 1) checked @endif
                                                name="cat_web_ecomony" id="cat_web_ecomony" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>




                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('towing-service') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_ext') == 1) checked @endif name="cat_web_ext"
                                                id="cat_web_ext" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('dream-driver') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_dream_driver') == 1) checked @endif
                                                name="cat_web_dream_driver" id="cat_web_dream_driver" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('personal-care') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_personal_care') == 1) checked @endif
                                                name="cat_web_personal_care" id="cat_web_personal_care" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('medical-and-health-services') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_medical_health') == 1) checked @endif
                                                name="cat_web_medical_health" id="cat_web_medical_health" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('education-and-training') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_education_training') == 1) checked @endif
                                                name="cat_web_education_training" id="cat_web_education_training"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('consulting-and-coaching') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_consulting') == 1) checked @endif
                                                name="cat_web_consulting" id="cat_web_consulting" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('cleaning-services') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_cleaning_services') == 1) checked @endif
                                                name="cat_web_cleaning_services" id="cat_web_cleaning_services"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('maintenance-and-repairs') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_maintenance') == 1) checked @endif
                                                name="cat_web_maintenance" id="cat_web_maintenance" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('construction-and-renovations') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_construction') == 1) checked @endif
                                                name="cat_web_construction" id="cat_web_construction" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('security') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_security') == 1) checked @endif
                                                name="cat_web_security" id="cat_web_security" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('landscaping-services') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_landscaping') == 1) checked @endif
                                                name="cat_web_landscaping" id="cat_web_landscaping" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('garden-maintenance') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_garden') == 1) checked @endif name="cat_web_garden"
                                                id="cat_web_garden" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('outdoor-constructions') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_outdoor_construction') == 1) checked @endif
                                                name="cat_web_outdoor_construction" id="cat_web_outdoor_construction"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('exterior-design-services') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (getSettings('cat_web_exterior_design') == 1) checked @endif
                                                name="cat_web_exterior_design" id="cat_web_exterior_design"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading20">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse20" aria-expanded="false" aria-controls="collapse20">
                                        {{ translateKeyword('front-end') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse20" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading20">
                                <div class="panel-body row">

                                    <div class="form-group col-6">
                                        <label for="index paragraph"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('home-page-paragraph') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="@settings('index_paragraph')" name="index_paragraph"
                                                id="index_paragraph" placeholder="Index ">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="km driven" class="col-xs-12 col-form-label">
                                            @if (getSettings('distance_system') === 'metric')
                                                KM
                                            @else
                                                Miles
                                            @endif Driven
                                        </label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ getSettings('km_driven', '') }}" name="km_driven"
                                                id="km_driven"
                                                placeholder=" @if (getSettings('distance_system') === 'metric') KM @else Miles @endif  driven">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="people dropped"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('people-dropped') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ getSettings('people_dropped', '') }}" name="people_dropped"
                                                id="people_dropped"
                                                placeholder="{{ translateKeyword('people-dropped') }} ">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="taxi drivers"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('taxis-and-providers') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ getSettings('taxi_drivers', '') }}" name="taxi_drivers"
                                                id="taxi_drivers"
                                                placeholder="{{ translateKeyword('taxis-and-providers') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="Happy People"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('happy-people') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ getSettings('happy_people', '') }}" name="happy_people"
                                                id="happy_people" placeholder="{{ translateKeyword('happy-people') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="Youtube Link"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('youtube-link') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ getSettings('youtube_link', '') }}" name="youtube_link"
                                                id="youtube_link" placeholder="{{ translateKeyword('youtube-link') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="Contact Email"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('site-copyright') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ getSettings('site_copyright', '') }}" name="site_copyright"
                                                id="site_copyright"
                                                placeholder="{{ translateKeyword('site-copyright') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="Site Copyright Url"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('site-copyright-url') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ getSettings('site_copyright_url', '') }}"
                                                name="site_copyright_url" id="site_copysite_copyright_urlright"
                                                placeholder="{{ translateKeyword('site-copyright-url') }}">
                                        </div>
                                    </div>
                                    {{-- <h5>Email</h5><br /><br /> --}}
                                    <br>
                                    <div class="form-group col-6">
                                        <label for="Contact Email"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('site-email') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ getSettings('site_email', '') }}" name="site_email"
                                                id="site_email" placeholder="{{ translateKeyword('site-email') }}">
                                        </div>
                                    </div>

                                    <input type="hidden" accept="image/*" name="f_img2" id="f_img2"
                                        aria-describedby="fileHelp">
                                    <br />
                                    {{-- <h5>Themes</h5> --}}
                                    <div class="form-group col-6">
                                        <div class="col-xs-12 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('theme') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-12">
                                            <select class="form-control" name="website_theme">
                                                <option value="default"
                                                    @if (getSettings('website_theme') == 'default') selected @endif>
                                                    {{ translateKeyword('default') }}
                                                </option>
                                                <option value="conexi" @if (getSettings('website_theme') == 'conexi') selected @endif>
                                                    Theme
                                                    1(Conexi)
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <input type="hidden" accept="image/*" name="f_img2" id="f_img2"
                                        aria-describedby="fileHelp">
                                    <br />


                                    <div class="form-group col-6">
                                        <div class="col-xs-12 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('website-language-default') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-12">
                                            <select class="form-control" name="website_languages">
                                                <option value="en" @if (getSettings('website_languages') == 'en') selected @endif>
                                                    English
                                                </option>
                                                <option value="es" @if (getSettings('website_languages') == 'es') selected @endif>
                                                    Spanish
                                                </option>
                                                <option value="fr" @if (getSettings('website_languages') == 'fr') selected @endif>
                                                    French
                                                </option>
                                                <option value="pl" @if (getSettings('website_languages') == 'pl') selected @endif>
                                                    Polish
                                                </option>
                                                <option value="fi" @if (getSettings('website_languages') == 'fi') selected @endif>
                                                    Finnish
                                                </option>
                                                <option value="se" @if (getSettings('website_languages') == 'se') selected @endif>
                                                    Swedish
                                                </option>
                                                <option value="ca" @if (getSettings('website_languages') == 'ca') selected @endif>
                                                    Catalan
                                                </option>
                                                <option value="ar" @if (getSettings('website_languages') == 'ar') selected @endif>
                                                    Arabic
                                                </option>
                                                <option value="ro" @if (getSettings('website_languages') == 'ro') selected @endif>
                                                    Romanian
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <input type="hidden" accept="image/*" name="f_img2" id="f_img2"
                                        aria-describedby="fileHelp">
                                    <br />


                                    <div class="form-group col-6">
                                        <div class="col-xs-12 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('color') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-12">
                                            <select class="form-control" name="website_theme_color">
                                                <option value="default"
                                                    @if (getSettings('website_theme_color') == 'default') selected @endif>
                                                    Default
                                                </option>
                                                <option value="blue" @if (getSettings('website_theme_color') == 'blue') selected @endif>
                                                    Blue
                                                </option>
                                                <option value="red" @if (getSettings('website_theme_color') == 'red') selected @endif>
                                                    Red
                                                </option>
                                                <option value="green" @if (getSettings('website_theme_color') == 'green') selected @endif>
                                                    Green
                                                </option>
                                                <option value="orange" @if (getSettings('website_theme_color') == 'orange') selected @endif>
                                                    Orange
                                                </option>
                                                <option value="black" @if (getSettings('website_theme_color') == 'black') selected @endif>
                                                    Black
                                                </option>
                                                <option value="purple" @if (getSettings('website_theme_color') == 'purple') selected @endif>
                                                    Purple
                                                </option>
                                                <option value="gold" @if (getSettings('website_theme_color') == 'gold') selected @endif>
                                                    Gold
                                                </option>
                                                <option value="silver" @if (getSettings('website_theme_color') == 'silver') selected @endif>
                                                    Silver
                                                </option>
                                                <option value="pink" @if (getSettings('website_theme_color') == 'pink') selected @endif>
                                                    Pink
                                                </option>
                                                <option value="turquoise"
                                                    @if (getSettings('website_theme_color') == 'turquoise') selected @endif>
                                                    Turquoise
                                                </option>
                                                <option value="cyan" @if (getSettings('website_theme_color') == 'cyan') selected @endif>
                                                    Cyan
                                                </option>
                                                <option value="limegreen"
                                                    @if (getSettings('website_theme_color') == 'limegreen') selected @endif>
                                                    Lime
                                                    Green
                                                </option>
                                                <option value="violet" @if (getSettings('website_theme_color') == 'violet') selected @endif>
                                                    Violet
                                                </option>
                                                <option value="brown" @if (getSettings('website_theme_color') == 'brown') selected @endif>
                                                    Brown
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading900">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse900" aria-expanded="false" aria-controls="collapse900">
                                        {{ translateKeyword('tax-info') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse900" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading900">
                                <div class="panel-body row">

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="tax_tps_info_field" class="col-form-label">
                                                {{ translateKeyword('tax_tps_info_field') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('tax_tps_info_field') == 1) checked @endif
                                                name="tax_tps_info_field" id="tax_tps_info_field" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="tax_tvq_info_field" class="col-form-label">
                                                {{ translateKeyword('tax_tvq_info_field') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (getSettings('tax_tvq_info_field') == 1) checked @endif
                                                name="tax_tvq_info_field" id="tax_tvq_info_field" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    {{-- <div class="form-group row">
                                        <div class="col-xs-2 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                Gender preference
                                            </label>
                                        </div>
                                        <div class="col-xs-10">
                                            <input @if (getSettings('gender_pref_enabled') == 1) checked @endif
                                                name="gender_pref_enabled" id="gender_pref_enabled" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
    
                                    </div> --}}


                                    @if (config('app.url') == 'https://dev.meemcolart.com' ||
                                            config('app.url') == 'https://meemcolart.com/' ||
                                            config('app.url') == 'https://godrive.meemcolart.com')
                                        <div class="form-group col-6">
                                            <div class="col-xs-6 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    {{ translateKeyword('show-preset-credentials') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input @if (getSettings('show_preset_credentials') == 1) checked @endif
                                                    name="show_preset_credentials" id="show_preset_credentials"
                                                    type="checkbox" class="js-switch" data-color="#43b968">
                                            </div>

                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        @if ($edit_permission == 1)
                            <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary">{{ translateKeyword('update-web-settings') }}</button>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
