<head>
    @section('title', 'Delivery/Transport Hub')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - @yield('title', 'Delivery/Transport Hub')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
          media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('mainindex/css/style.css') }}">
    <style>
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
    <style>
        body > .skiptranslate {
            display: none;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row mh-100vh">
        <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0"
             id="login-block">
            <div class="m-auto w-lg-75 w-xl-50">
                <h2>
                    <div id="google_translate_element"
                         style="padding-right: 10px; padding-left:20px; margin-left: 10%; float: right;"></div>
                </h2>
                <h2>
                    <a href="/" class="logo"><img style="height: 80px" src="{{ Setting::get('site_logo', '') }}" alt="site_logo"></a>
                </h2>
                <h2 class="text-dark font-weight-light mb-5"><i class="fa fa-lock"></i> {{ translateKeyword('register') }}</h2>
                <form method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
                    <div class="form-group mb-1">
                        <label class="text-secondary">{{ translateKeyword('first_name') }}</label>
                        <input class="form-control mb-2" type="text" name="first_name" value="{{ old('first_name') }}"
                               required>
                        @if ($errors->has('first_name'))
                            <span class="alert-danger p-1">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group mb-1">
                        <label class="text-secondary">{{ translateKeyword('last_name') }}</label>
                        <input class="form-control mb-2" type="text" name="last_name" value="{{ old('last_name') }}"
                               required>
                        @if ($errors->has('last_name'))
                            <span class="alert-danger p-1">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group mb-1">

                        <label>
                            <strong>Gender</strong>
                        </label><br/>
                        <label class="radio-inline">
                            <input type="radio" name="gender" value="male" checked>&nbsp; {{ translateKeyword('male') }}
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gender" value="female" >&nbsp; {{ translateKeyword('female') }}
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gender" value="other">&nbsp; {{ translateKeyword('other') }}
                        </label>
                        <br/>
                        <span class="alert-danger p-1" id="gender-error" style="display: none;">
                                <strong>{{ translateKeyword('note_1') }}</strong>
                            </span>
                        @if ($errors->has('gender'))
                            <span class="alert-danger p-1">

                                    <strong>{{ $errors->first('gender') }}</strong>

                                </span>
                        @endif

                    </div>
                    @if(Setting::get('gender_pref_enabled') == 1)
                        <div class="form-group mb-1">

                            <label>
                                <strong>Gender Preference</strong>
                            </label><br/>
                            
                            <label class="radio-inline">
                                <input type="radio" name="gender_pref" value="male" checked>{{ translateKeyword('male') }}
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender_pref" value="female">{{ translateKeyword('female') }}
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender_pref" value="both">{{ translateKeyword('both') }}
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
                    <div class="form-group mb-1">
                        <label class="text-secondary">{{ translateKeyword('phone_number') }}</label><br/>
                        <input class="form-control mb-2" type="text" id="mobile" minlength="10" maxlength="15"
                               name="phone_number" value="{{ old('phone_number') }}" required
                               placeholder="+46">
                        @if ($errors->has('phone_number'))
                            <span class="alert-danger p-1">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                        @endif
                    </div>
                    @if (Setting::get('address_user', 0) == 1)
                        <div class="form-group mb-1">
                            <label for="address" class="col-xs-12 col-form-label">Address</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="text" value="{{ old('address') }}" name="address"
                                    required id="address" placeholder="Address">
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('dob_user', 0) == 1)
                        <div class="form-group mb-1">
                            <label for="dob" class="col-xs-12 col-form-label">Date of birth</label>
                            <div class="col-xs-10">
                                <input class="form-control" type="date" value="{{ old('dob') }}" name="dob"
                                    required id="dob" placeholder="DOB">
                            </div>
                        </div>
                    @endif
                    @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
                        <div class="form-group mb-1">
                            <label for="mobile" class="col-xs-12 col-form-label">Zone</label>
                            <div class="col-xs-10">
                                <select name="zone_id" class="form-control">
                                    <option value="0" selected>No Zone</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="form-group mb-1">
                        <label class="text-secondary">{{ translateKeyword('email') }}</label>
                        <input class="form-control mb-2" name="email" value="{{ old('email') }}" required
                               type="email"
                               inputmode="email">
                        @if ($errors->has('email'))
                            <span class="alert-danger p-1">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>
                    @if (Setting::get('user_referral') == 1)
                        <div class="form-group mb-1">
                            <label class="text-secondary">{{ translateKeyword('referral_code') }}</label>
                            <input class="form-control mb-2" type="text" name="referral_code" value="{{ old('referral_code') }}"
                                inputmode="referral_code">
                            @if ($errors->has('referral_code'))
                                <span class="alert-danger p-1">
                                        <strong>{{ $errors->first('referral_code') }}</strong>
                                    </span>
                            @endif
                        </div>
                    @endif
                    <div class="form-group mb-1">
                        <label class="text-secondary">{{ translateKeyword('password') }}</label>
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control mb-2" type="password" name="password"
                                   value="{{ old('password') }}" id="password"
                                   placeholder="{{ translateKeyword('password') }}">
                            <div class="input-group-addon">
                                <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        {{-- <input class="form-control mb-2" type="password" name="password" required> --}}
                        @if ($errors->has('password'))
                            <span class="alert-danger p-1">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group mb-1">
                        <label class="text-secondary">{{ translateKeyword('confirm_password') }}</label>
                        <div class="input-group" id="show_hide_password_confirmation">
                            <input class="form-control mb-2" type="password" name="password_confirmation"
                                   value="{{ old('password_confirmation') }}"
                                   id="password_confirmation" placeholder="{{ translateKeyword('confirm_password') }}">
                            <div class="input-group-addon">
                                <a href="javascript:"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        {{-- <input class="form-control mb-2" type="password" name="password_confirmation" required> --}}
                        @if ($errors->has('password_confirmation'))
                            <span class="alert-danger p-1">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                        @endif
                    </div>
                    <button class="btn btn-dark  mt-2" type="submit">{{ translateKeyword('register_now') }}</button>
                </form>
                <p class="mt-3 mb-0"><a class="text-dark small" href="{{ url('/login') }}">{{ translateKeyword('already_have_an_account') }}
                   ? {{ translateKeyword('login_now') }}</a></p>
                <p class="mt-3 mb-0 "><a class="text-dark small" href="{{ url('/') }}">{{ translateKeyword('back_to') }} <b><u>{{ translateKeyword('home_page') }}</u></b></a></p>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-end" id="bg-block"
             style="background-image:url({{ Setting::get('website_register') }});background-size:cover;background-position:center center;">
            <p class="ml-auto small text-dark mb-2">
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<!-- Country picker with phone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="{{ asset('asset/js/custom-phone-input.js') }}"></script>
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

        $("#show_hide_password_confirmation a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password_confirmation input').attr("type") == "text") {
                $('#show_hide_password_confirmation input').attr('type', 'password');
                $('#show_hide_password_confirmation i').addClass("fa-eye-slash");
                $('#show_hide_password_confirmation i').removeClass("fa-eye");
            } else if ($('#show_hide_password_confirmation input').attr("type") == "password") {
                $('#show_hide_password_confirmation input').attr('type', 'text');
                $('#show_hide_password_confirmation i').removeClass("fa-eye-slash");
                $('#show_hide_password_confirmation i').addClass("fa-eye");
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
<!-- Js Files End -->
<script type="text/javascript">
    $('input[type=radio][name=gender]').click(function () {
        if (this.value == 'female') {
            $('#gender-error').show();
            // $('input[type=radio][name=gender][value="female"]').prop('checked', true);
        } else {
            $('#gender-error').hide();
        }
    });
</script>
</body>
