@extends('themes.conexi.layouts.app')
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
    media="screen"> 
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

    .radio-fields input {
        width: auto;
    }

    .book-ride-two .booking-form-two ul.radio-fields {
        margin: 0;
        padding: 0;
        list-style: none;
        margin-left: -15px;
        margin-right: -15px;
    }

    .book-ride-two .booking-form-two ul.radio-fields li {
        float: left;
        width: 106px;
        padding-left: 15px;
        padding-right: 15px;
        margin-bottom: 15px;
    }

    .book-ride-two .booking-form-two [type="radio"]:checked {
        position: absolute;
        left: -9999px;
    }

    .book-ride-two .booking-form-two input {
        border: none;
        outline: none;
        background-color: #F3F3F3;
        height: 67px;
        border-radius: 33.5px;
        padding-left: 40px;
        color: #717171;
        font-size: 14px;
        font-weight: 600;
    }

    .book-ride-two .booking-form-two ul.radio-fields {
        width: 100% !important;
    }
</style>
@endpush
@section('content')
<section class="inner-banner">
</section><!-- /.inner-banner -->
<section class="contact-form-style-one book-ride-two">
    <div class="container">

        <form method="POST" action="{{ url('/register') }}" class="booking-form-two ">
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
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <ul class="radio-fields clearfix">
                        <li>
                            <input type="radio" name="gender" value="male" checked>
                            <label for="test1">{{ translateKeyword('male') }}</label>
                        </li>
                        <li>
                            <input type="radio" name="gender" value="female">
                            <label for="test2">{{ translateKeyword('female') }}</label>
                        </li>
                        <li>
                            <input type="radio" name="gender" value="other">
                            <label for="test3">{{ translateKeyword('other') }}</label>
                        </li>

                    </ul>
                    <span class="alert-danger p-1" id="gender-error" style="display: none;">
                        <strong>{{ translateKeyword('note_1') }}</strong>
                    </span>
                    @if ($errors->has('gender'))
                    <span class="alert-danger p-1">

                        <strong>{{ $errors->first('gender') }}</strong>

                    </span>
                    @endif
                </div><!-- /.col-lg-6 -->
            </div>
            @if(Setting::get('gender_pref_enabled') == 1)
            <div class="form-group mb-1">

                <label>
                    <strong>Gender Preference</strong>
                </label><br />

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
                <label class="text-secondary">{{ translateKeyword('phone_number') }}</label><br />
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


                <div class="input-holder" id="show_hide_password">
                    <input type="password" name="password" id="password" placeholder="{{ translateKeyword('password') }}"
                        value="{{ old('password') }}"><a href="javascript:">
                        <i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>

                @if ($errors->has('password'))
                <span class="alert-danger p-1">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group mb-1">
                <label class="text-secondary">{{ translateKeyword('confirm_password') }}</label>
                <div class="input-holder" id="show_hide_password_confirmation">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ translateKeyword('password_confirmation') }}"
                        value="{{ old('password_confirmation') }}"><a href="javascript:">
                        <i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>


                @if ($errors->has('password_confirmation'))
                <span class="alert-danger p-1">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
            <button class="btn btn-dark  mt-2" type="submit">{{ translateKeyword('register_now') }}</button>
        </form>
    </div><!-- /.container -->
</section>
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

        $("#show_hide_password_confirmation a").on('click', function(event) {
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

<!-- Js Files End -->
<script type="text/javascript">
    $('input[type=radio][name=gender]').click(function() {
        if (this.value == 'female') {
            $('#gender-error').show();
            // $('input[type=radio][name=gender][value="female"]').prop('checked', true);
        } else {
            $('#gender-error').hide();
        }
    });
</script>
@endpush