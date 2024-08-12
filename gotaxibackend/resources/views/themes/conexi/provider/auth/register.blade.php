@extends('themes.conexi.provider.layouts.app')
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

        <form method="POST" action="{{ url('/provider/register') }}" class="booking-form-two ">
            {{ csrf_field() }}

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
            <div class="row">
                <div class="col-lg-6">
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
                </div>
                <div class="col-lg-6">
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
                </div>

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

            <div class="row">
                <div class="col-lg-6">
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
                </div>

                <div class="col-lg-6">
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
                </div>
            </div>


            @if (Setting::get('address_driver', 0) == 1)
            <div class="col-md-12 col-sm-12" style="margin-top: 15px;">
                <input type="text" value="{{ old('address') }}" name="address"
                    required id="address" placeholder="Address">
            </div>
            @endif
            @if (Setting::get('dob_driver', 0) == 1)
            <div class="col-md-12 col-sm-12" style="margin-top: 15px;">
                <input type="date" value="{{ old('dob') }}" name="dob" class="form-control"
                    required id="dob" placeholder="DOB">
            </div>
            @endif
            @if (Setting::get('zone_restrict_module', 0) == 1 && Setting::get('zone_module', 0) == 1)
            <div class="col-md-12 col-sm-12" style="margin-top: 15px;">
                <select name="zone_id">
                    <option value="0" selected>No Zone</option>
                    @foreach ($zones as $zone)
                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            @if (Setting::get('gender', 1))

            <div class="form-group mb-1"><label class="text-secondary">{{ translateKeyword('gender') }}</label></div>

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

            <div class="form-group mb-1"><label class="text-secondary">{{ translateKeyword('Select Service') }}</label></div>
            <div class="row">
                <div class="col-lg-12">

                    <select name="service_type[]"
                        id="service_type" required @if (Setting::get('multi_service_module', 0)==1)
                        multiple style="height: 100px"
                        @endif>

                        <option value="">Select Service</option>

                        @foreach (get_all_service_types() as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->name }}
                        </option>
                        @endforeach

                    </select>

                    <div class="col-lg-12">
                        <span class="help-block alert-warning p-1">

                            <strong>*Press & hold ctrl to select multiple services</strong>

                        </span>
                    </div>

                    @if ($errors->has('service_type'))
                    <span class="help-block alert-danger p-1">

                        <strong>{{ $errors->first('service_type') }}</strong>

                    </span>
                    @endif

                </div>
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
            <div class="row">
                <div class="col-lg-6">


                    <div class="form-group mb-1">
                        <label class="text-secondary">{{ translateKeyword('car_number') }}</label>
                        <input id="service-number" type="text"
                            name="car_number" value="{{ old('service_number') }}"
                            placeholder="{{ translateKeyword('car_number') }}" required>

                        @if ($errors->has('car_number'))
                        <span class="help-block alert-danger p-1">

                            <strong>{{ $errors->first('car_number') }}</strong>

                        </span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-1">
                        <label class="text-secondary">{{ translateKeyword('car_model') }}</label>
                        <input id="service-model" type="text" name="service_model"
                            value="{{ old('car_model') }}"
                            placeholder="{{ translateKeyword('car_model') }}" required>

                        @if ($errors->has('car_model'))
                        <span class="help-block alert-danger p-1">

                            <strong>{{ $errors->first('car_model') }}</strong>

                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group mb-1">
                <label class="text-secondary"> <input type="checkbox" name="terms" id="terms"
                        required></label> {{ translateKeyword('i_accept_terms_conditions') }}



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