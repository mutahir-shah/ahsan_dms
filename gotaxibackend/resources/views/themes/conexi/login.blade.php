@extends('themes.conexi.layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet" media="screen">
<style>
    div.logo-block a img {
        width: 100px;
    }

    .inner-banner {
        background-image:url("{{ Setting::get('website_login') }}") !important;
    }

    .input-checker {
        list-style-type: none;
    }

    ul {
        list-style-type: none;
    }

    .contact-form-style-one {
        padding-top: 15px !important;
    }

    .intl-tel-input {
        z-index: 15;
        width: 100%;
        margin-bottom: 10px;
    }

    .taxi-style-one .tab-title {
        margin-bottom: 0px !important;
    }
</style>
@endpush

@section('content')
<section class="inner-banner"></section><!-- /.inner-banner -->
<section class="contact-form-style-one taxi-style-one">
    <div class="container">
        <div class="col-sm-9">
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
            <ul class="nav nav-tabs tab-title" id="myTab" role="tablist">
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
                                {{ $errors->first('email') }}
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
                            <div class="input-holder" id="show_hide_password">
                                <input type="password" name="password" id="password" placeholder="{{ translateKeyword('password') }}"><a href="javascript:">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                            @endif
                            @if ($errors->has('password'))
                            <span class="alert-danger p-1">
                                {{ $errors->first('password') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <div class="input-holder text-center">
                                <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                <button class="theme-btn btn-style-two" type="submit" data-loading-text="Please wait..."><span>{{ translateKeyword('login') }}</span></button>
                            </div><!-- /.input-holder -->
                        </div><!-- /.col-lg-6 -->
                    </form>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group mb-1 mt-2">
                            <label class="text-secondary ">{{ translateKeyword('phone') }}</label>
                            @if(Setting::get('show_preset_credentials') == 1)
                            <div class="form-group mb-1">
                                <input class="form-control mb-2" type="text" id="mobile" minlength="10" maxlength="15" name="mobile" required placeholder="+92" value="+921231231234">
                            </div>
                            @else
                            <div class="form-group mb-1">
                                <input class="form-control mb-2" type="text" id="mobile" minlength="10"
                                    maxlength="15" name="mobile" value="{{ old('mobile') }}" required placeholder="+92">
                            </div>
                            @endif

                            @if ($errors->has('mobile'))
                            <span class="alert-danger p-1">
                                {{ $errors->first('mobile') }}
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
                            <div class="input-holder" id="show_hide_password">
                                <input type="password" name="password" id="password" placeholder="{{ translateKeyword('password') }}"><a href="javascript:">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>

                            @endif
                            @if ($errors->has('password'))
                            <span class="alert-danger p-1">
                                {{ $errors->first('password') }}
                            </span>
                            @endif
                        </div>

                        <div class="col-lg-12">
                            <div class="input-holder text-center">
                                <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                <button class="theme-btn btn-style-two" type="submit" data-loading-text="Please wait..."><span>{{ translateKeyword('login') }}</span></button>
                            </div><!-- /.input-holder -->
                        </div><!-- /.col-lg-6 -->
                    </form>
                </div>
                @if (Setting::get('login_phone_hidden') == 1)
                <ul class="special-checkbox">
                    <li> <a class="text-dark small " href="{{ url('/register') }}">{{ translateKeyword('dont_have_anyaccount_register_now') }}</a>
                    </li>
                    <li> <a class="text-dark small " href="{{ url('/password/reset') }}">{{ translateKeyword('forget_password') }}?</a></li>
                    <li> <a class="text-dark small" href="{{ url('/') }}">{{ translateKeyword('back_to') }} <b><u>{{ translateKeyword('home_page') }}</u></b></a></li>
                </ul>
                @endif

            </div>

        </div><!-- /.container -->
</section>
</div>
@endsection
@push('scripts')
<!-- Country picker with phone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="{{ asset('asset/js/custom-phone-input.js') }}"></script>
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
    });
</script>
@endpush