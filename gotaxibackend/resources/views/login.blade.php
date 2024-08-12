<head>
    @section('title', 'Delivery/Transport Hub')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - @yield('title')</title>
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
                    <a @if (Setting::get('force_login_page', 0) == 1)
                        href="#"
                    @else
                        href="/"
                    @endif
                     class="logo"><img style="height: 80px" src="{{ Setting::get('site_logo', '') }}"
                        alt="site_logo"></a>
                </h2>
                <h2 class="text-dark font-weight-light mb-5"><i class="fa fa-lock"></i> {{ translateKeyword('signin') }}</h2>
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="p-0 m-0" style="list-style: none;">
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @if (Setting::get('email_field', 0) == 1)
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                           aria-controls="home" aria-selected="true">{{ translateKeyword('email') }}</a>
                    </li>
                    @endif
                    @if (Setting::get('login_phone_hidden', 0) == 1)
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="false">{{ translateKeyword('phone') }}</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show  @if (Setting::get('email_field', 0) == 1) active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group mb-1 mt-2">
                                <label class="text-secondary ">{{ translateKeyword('email') }}</label>
                                @if(Setting::get('show_preset_credentials') == 1)
                                    <input type="email" class="form-control mb-2" name="email" required="true"
                                           id="email" placeholder="{{ translateKeyword('email') }}" value="user@meemcolart.com">
                                @else
                                    <input type="email" class="form-control mb-2" name="email"
                                           value="{{ old('email') }}" required="true"
                                           id="email" placeholder="{{ translateKeyword('email') }}">
                                @endif

                                @if ($errors->has('email'))
                                    <span class="alert-danger p-1">
                               <strong>{{ $errors->first('email') }}</strong>
                               </span>
                                @endif
                            </div>
                            <div class="form-group mb-1 ">
                                <label class="text-secondary ">{{ translateKeyword('password') }}</label>
                                @if(Setting::get('show_preset_credentials') == 1)
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control mb-2" type="password" name="password" id="password"
                                               placeholder="Password" value="Quartz@1234">
                                        <div class="input-group-addon">
                                            <a href="javascript:"><i class="fa fa-eye-slash"
                                                                     aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    {{-- <input type="password" name="password" required="true" class="form-control mb-2" id="password" placeholder="Password" value="Quartz@1234"> --}}
                                @else
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control mb-2" type="password" name="password" id="password"
                                               placeholder="Password">
                                        <div class="input-group-addon">
                                            <a href="javascript:"><i class="fa fa-eye-slash"
                                                                     aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    {{-- <input type="password" name="password" id="show_hide_password" required="true" class="form-control " id="password" placeholder="Password"> --}}
                                @endif
                                @if ($errors->has('password'))
                                    <span class="alert-danger p-1">
                               <strong>{{ $errors->first('password') }}</strong>
                               </span>
                                @endif
                            </div>
                            <button class="btn btn-dark mt-2 " type="submit ">{{ translateKeyword('login') }}</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group mb-1 mt-2">
                                <label class="text-secondary ">{{ translateKeyword('phone') }}</label>
                                @if(Setting::get('show_preset_credentials') == 1)
                                    <div class="form-group mb-1">
                                        <input class="form-control mb-2" type="text" id="mobile" minlength="10"
                                               maxlength="15" name="mobile" required
                                               placeholder="+92" value="+921231231234">
                                    </div>
                                @else
                                    <div class="form-group mb-1">
                                        <input class="form-control mb-2" type="text" id="mobile" minlength="10"
                                               maxlength="15" name="mobile" value="{{ old('mobile') }}" required
                                               placeholder="+92">
                                    </div>
                                @endif

                                @if ($errors->has('mobile'))
                                    <span class="alert-danger p-1">
                                   <strong>{{ $errors->first('mobile') }}</strong>
                                   </span>
                                @endif
                            </div>
                            <div class="form-group mb-1 ">
                                <label class="text-secondary ">{{ translateKeyword('password') }}</label>
                                @if(Setting::get('show_preset_credentials') == 1)
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control mb-2" type="password" name="password" id="password"
                                               placeholder="{{ translateKeyword('password') }}" value="Quartz@1234">
                                        <div class="input-group-addon">
                                            <a href="javascript:"><i class="fa fa-eye-slash"
                                                                     aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    {{-- <input type="password" name="password" required="true" class="form-control mb-2" id="password" placeholder="Password" value="Quartz@1234"> --}}
                                @else
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control mb-2" type="password" name="password" id="password"
                                               placeholder="{{ translateKeyword('password') }}">
                                        <div class="input-group-addon">
                                            <a href="javascript:"><i class="fa fa-eye-slash"
                                                                     aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    {{-- <input type="password" name="password" id="show_hide_password" required="true" class="form-control " id="password" placeholder="Password"> --}}
                                @endif
                                @if ($errors->has('password'))
                                    <span class="alert-danger p-1">
                                   <strong>{{ $errors->first('password') }}</strong>
                                   </span>
                                @endif
                            </div>
                            <button class="btn btn-dark mt-2 " type="submit ">{{ translateKeyword('login') }}</button>
                        </form>
                    </div>
                </div>
                @if (Setting::get('login_phone_hidden') == 1)
                    <p class="mt-3 mb-0 "><a class="text-dark small " href="{{ url('/register') }}">{{ translateKeyword('dont_have_anyaccount_register_now') }}</a><br/>
                        <a class="text-dark small " href="{{ url('/password/reset') }}">{{ translateKeyword('forget_password') }}?</a></p>
                    <p class="mt-3 mb-0 "><a class="text-dark small" href="{{ url('/') }}">{{ translateKeyword('back_to') }} <b><u>{{ translateKeyword('home_page') }}</u></b></a></p>
                @endif
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-end" id="bg-block"
             style="background-image:url({{ Setting::get('website_login') }});background-size:cover;background-position:center center;">
            <p class="ml-auto small text-dark mb-2">
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<!-- Country picker with phone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="{{ asset('asset/js/custom-phone-input.js') }}"></script>
@if(Setting::get('multilanguage_enabled', 0) == 1)
    <script type="text/javascript"
            src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element')
        }
    </script>
@endif
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
    });
</script>

</body>
