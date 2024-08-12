<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="title" content="{{ getWebContent()->meta_title ?? '' }}"/>
    <meta name="keywords" content="{{ getWebContent()->meta_keyword ?? '' }}"/>
    <meta name="description"
          content="{{ getWebContent()->meta_description ?? '' }}"/>
    <link rel="canonical" href="{{ url()->current() }}"/>

    <title>{{ getWebContent()->site_title ?? '' }} - {{ getWebContent()->site_sub_title ?? 'Delivery/Transport Hub' }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ Setting::get('site_icon') }}"/>

    <link rel="stylesheet" href="{{ asset('mainindex/vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/bootstrap-datepicker/jquery.mobile.datepicker.css') }}">
    <link rel="stylesheet"
          href="{{ asset('mainindex/vendors/bootstrap-datepicker/jquery.mobile.datepicker.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/elagent-icon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/themfiy/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/simple-line-icon/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/animation/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/calender/dcalendar.picker.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/vendors/magnify-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
          media="screen">
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
            rel="stylesheet"
            type="text/css"
    />
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css"
            rel="stylesheet"
            type="text/css"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('mainindex/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mainindex/css/responsive.css') }}">
    @yield('styles')
    <style>
         :root {
            --color-primary: {{ getColor() ? getColor() : '#EC4949'}};
        }
        /* .skiptranslate {
            display: none !important;
        } */

        body {
            top: 0px !important;
        }

        .goog-logo-link {
            display: none !important;
        }

        .nav-tabs {
            margin-bottom: 15px;
        }

        .sign-with {
            margin-top: 25px;
            padding: 20px;
        }

        div#OR {
            height: 30px;
            width: 30px;
            border: 1px solid #C2C2C2;
            border-radius: 50%;
            font-weight: bold;
            line-height: 28px;
            text-align: center;
            font-size: 12px;
            float: right;
            position: absolute;
            right: -16px;
            top: 40%;
            z-index: 1;
            background: #DFDFDF;
        }

        .modal {
            text-align: center;
        }

        @media screen and (min-width: 768px) {
            .modal:before {
                display: inline-block;
                vertical-align: middle;
                content: " ";
                height: 100%;
            }
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }

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

        .pac-container {
            z-index: 10000 !important;
        }
    </style>
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KTKB3RD" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

@include('layout.header')

<div class="page-content dashboard-page">

    @yield('content')
    {{-- <div class="container">
        <div class="modal fade" id="myModal" class="modal" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" style="width: auto;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            {{ trans('frontend.f_42') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#Login"
                                            data-toggle="tab">{{ trans('frontend.f_43') }}</a>
                                    </li>
                                    <li><a href="#Registration" data-toggle="tab">{{ trans('frontend.f_44') }}</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="Login">

                                        <form role="form" class="form-horizontal" method="POST"
                                            action="{{ url('/login') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Email</label>
                                                <div class="col-sm-10">
                                                    <input id="email" class="form-control" type="email"
                                                        name="email" value="{{ old('email') }}"
                                                        placeholder="Email" required>
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-sm-2 control-label">
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input id="password" class="form-control" type="password"
                                                        name="password" placeholder="Password" required>
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        {{ trans('frontend.f_43') }}</button>
                                                    <!-- <a href="javascript:;">Forgot your password?</a> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="Registration">
                                        <form role="form" class="form-horizontal" method="POST"
                                            action="{{ url('/register') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="first_name" class="col-sm-3 control-label">
                                                    First Name</label>
                                                <div class="col-sm-9">
                                                    <input id="email" class="form-control" type="first_name"
                                                        name="first_name" value="{{ old('first_name') }}"
                                                        placeholder="First Name" required>
                                                    @if ($errors->has('first_name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('first_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name" class="col-sm-3 control-label">
                                                    Last Name</label>
                                                <div class="col-sm-9">
                                                    <input id="last_name" class="form-control" type="last_name"
                                                        name="last_name" value="{{ old('last_name') }}"
                                                        placeholder="Last Name" required>
                                                    @if ($errors->has('last_name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('last_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <select class="form-control" name="country_code"
                                                        id="country_code">
                                                        <option data-countryCode="IN" value="91">India ( 91)
                                                        </option>
                                                        <option data-countryCode="DZ" value="213">Algeria (
                                                            213)
                                                        </option>
                                                        <option data-countryCode="AD" value="376">Andorra (
                                                            376)
                                                        </option>
                                                        <option data-countryCode="AO" value="244">Angola ( 244)
                                                        </option>
                                                        <option data-countryCode="AI" value="1264">Anguilla (
                                                            1264)
                                                        </option>
                                                        <option data-countryCode="AG" value="1268">Antigua &amp;
                                                            Barbuda
                                                            ( 1268)
                                                        </option>
                                                        <option data-countryCode="AR" value="54">Argentina (
                                                            54)
                                                        </option>
                                                        <option data-countryCode="AM" value="374">Armenia (
                                                            374)
                                                        </option>
                                                        <option data-countryCode="AW" value="297">Aruba ( 297)
                                                        </option>
                                                        <option data-countryCode="AU" value="61">Australia (
                                                            61)
                                                        </option>
                                                        <option data-countryCode="AT" value="43">Austria ( 43)
                                                        </option>
                                                        <option data-countryCode="AZ" value="994">Azerbaijan (
                                                            994)
                                                        </option>
                                                        <option data-countryCode="BS" value="1242">Bahamas (
                                                            1242)
                                                        </option>
                                                        <option data-countryCode="BH" value="973">Bahrain (
                                                            973)
                                                        </option>
                                                        <option data-countryCode="BD" value="880">Bangladesh (
                                                            880)
                                                        </option>
                                                        <option data-countryCode="BB" value="1246">Barbados (
                                                            1246)
                                                        </option>
                                                        <option data-countryCode="BY" value="375">Belarus (
                                                            375)
                                                        </option>
                                                        <option data-countryCode="BE" value="32">Belgium ( 32)
                                                        </option>
                                                        <option data-countryCode="BZ" value="501">Belize ( 501)
                                                        </option>
                                                        <option data-countryCode="BJ" value="229">Benin ( 229)
                                                        </option>
                                                        <option data-countryCode="BM" value="1441">Bermuda (
                                                            1441)
                                                        </option>
                                                        <option data-countryCode="BT" value="975">Bhutan ( 975)
                                                        </option>
                                                        <option data-countryCode="BO" value="591">Bolivia (
                                                            591)
                                                        </option>
                                                        <option data-countryCode="BA" value="387">Bosnia
                                                            Herzegovina (
                                                            387)
                                                        </option>
                                                        <option data-countryCode="BW" value="267">Botswana (
                                                            267)
                                                        </option>
                                                        <option data-countryCode="BR" value="55">Brazil ( 55)
                                                        </option>
                                                        <option data-countryCode="BN" value="673">Brunei ( 673)
                                                        </option>
                                                        <option data-countryCode="BG" value="359">Bulgaria (
                                                            359)
                                                        </option>
                                                        <option data-countryCode="BF" value="226">Burkina Faso
                                                            ( 226)
                                                        </option>
                                                        <option data-countryCode="BI" value="257">Burundi (
                                                            257)
                                                        </option>
                                                        <option data-countryCode="KH" value="855">Cambodia (
                                                            855)
                                                        </option>
                                                        <option data-countryCode="CM" value="237">Cameroon (
                                                            237)
                                                        </option>
                                                        <option data-countryCode="CA" value="1">Canada ( 1)
                                                        </option>
                                                        <option data-countryCode="CV" value="238">Cape Verde
                                                            Islands (
                                                            238)
                                                        </option>
                                                        <option data-countryCode="KY" value="1345">Cayman
                                                            Islands (
                                                            1345)
                                                        </option>
                                                        <option data-countryCode="CF" value="236">Central
                                                            African
                                                            Republic ( 236)
                                                        </option>
                                                        <option data-countryCode="CL" value="56">Chile ( 56)
                                                        </option>
                                                        <option data-countryCode="CN" value="86">China ( 86)
                                                        </option>
                                                        <option data-countryCode="CO" value="57">Colombia (
                                                            57)</option>
                                                        <option data-countryCode="KM" value="269">Comoros (
                                                            269)
                                                        </option>
                                                        <option data-countryCode="CG" value="242">Congo ( 242)
                                                        </option>
                                                        <option data-countryCode="CK" value="682">Cook Islands
                                                            ( 682)
                                                        </option>
                                                        <option data-countryCode="CR" value="506">Costa Rica (
                                                            506)
                                                        </option>
                                                        <option data-countryCode="HR" value="385">Croatia (
                                                            385)
                                                        </option>
                                                        <option data-countryCode="CU" value="53">Cuba ( 53)
                                                        </option>
                                                        <option data-countryCode="CY" value="90392">Cyprus North
                                                            (
                                                            90392)
                                                        </option>
                                                        <option data-countryCode="CY" value="357">Cyprus South
                                                            ( 357)
                                                        </option>
                                                        <option data-countryCode="CZ" value="42">Czech
                                                            Republic ( 42)
                                                        </option>
                                                        <option data-countryCode="DK" value="45">Denmark ( 45)
                                                        </option>
                                                        <option data-countryCode="DJ" value="253">Djibouti (
                                                            253)
                                                        </option>
                                                        <option data-countryCode="DM" value="1809">Dominica (
                                                            1809)
                                                        </option>
                                                        <option data-countryCode="DO" value="1809">Dominican
                                                            Republic (
                                                            1809)
                                                        </option>
                                                        <option data-countryCode="EC" value="593">Ecuador (
                                                            593)
                                                        </option>
                                                        <option data-countryCode="EG" value="20">Egypt ( 20)
                                                        </option>
                                                        <option data-countryCode="SV" value="503">El Salvador (
                                                            503)
                                                        </option>
                                                        <option data-countryCode="GQ" value="240">Equatorial
                                                            Guinea (
                                                            240)
                                                        </option>
                                                        <option data-countryCode="ER" value="291">Eritrea (
                                                            291)
                                                        </option>
                                                        <option data-countryCode="EE" value="372">Estonia (
                                                            372)
                                                        </option>
                                                        <option data-countryCode="ET" value="251">Ethiopia (
                                                            251)
                                                        </option>
                                                        <option data-countryCode="FK" value="500">Falkland
                                                            Islands (
                                                            500)
                                                        </option>
                                                        <option data-countryCode="FO" value="298">Faroe Islands
                                                            ( 298)
                                                        </option>
                                                        <option data-countryCode="FJ" value="679">Fiji ( 679)
                                                        </option>
                                                        <option data-countryCode="FI" value="358">Finland (
                                                            358)
                                                        </option>
                                                        <option data-countryCode="FR" value="33">France ( 33)
                                                        </option>
                                                        <option data-countryCode="GF" value="594">French Guiana
                                                            ( 594)
                                                        </option>
                                                        <option data-countryCode="PF" value="689">French
                                                            Polynesia (
                                                            689)
                                                        </option>
                                                        <option data-countryCode="GA" value="241">Gabon ( 241)
                                                        </option>
                                                        <option data-countryCode="GM" value="220">Gambia ( 220)
                                                        </option>
                                                        <option data-countryCode="GE" value="7880">Georgia (
                                                            7880)
                                                        </option>
                                                        <option data-countryCode="DE" value="49">Germany ( 49)
                                                        </option>
                                                        <option data-countryCode="GH" value="233">Ghana ( 233)
                                                        </option>
                                                        <option data-countryCode="GI" value="350">Gibraltar (
                                                            350)
                                                        </option>
                                                        <option data-countryCode="GR" value="30">Greece ( 30)
                                                        </option>
                                                        <option data-countryCode="GL" value="299">Greenland (
                                                            299)
                                                        </option>
                                                        <option data-countryCode="GD" value="1473">Grenada (
                                                            1473)
                                                        </option>
                                                        <option data-countryCode="GP" value="590">Guadeloupe (
                                                            590)
                                                        </option>
                                                        <option data-countryCode="GU" value="671">Guam ( 671)
                                                        </option>
                                                        <option data-countryCode="GT" value="502">Guatemala (
                                                            502)
                                                        </option>
                                                        <option data-countryCode="GN" value="224">Guinea ( 224)
                                                        </option>
                                                        <option data-countryCode="GW" value="245">Guinea -
                                                            Bissau (
                                                            245)
                                                        </option>
                                                        <option data-countryCode="GY" value="592">Guyana ( 592)
                                                        </option>
                                                        <option data-countryCode="HT" value="509">Haiti ( 509)
                                                        </option>
                                                        <option data-countryCode="HN" value="504">Honduras (
                                                            504)
                                                        </option>
                                                        <option data-countryCode="HK" value="852">Hong Kong (
                                                            852)
                                                        </option>
                                                        <option data-countryCode="HU" value="36">Hungary ( 36)
                                                        </option>
                                                        <option data-countryCode="IS" value="354">Iceland (
                                                            354)
                                                        </option>
                                                        <option data-countryCode="ID" value="62">Indonesia (
                                                            62)
                                                        </option>
                                                        <option data-countryCode="IR" value="98">Iran ( 98)
                                                        </option>
                                                        <option data-countryCode="IQ" value="964">Iraq ( 964)
                                                        </option>
                                                        <option data-countryCode="IE" value="353">Ireland (
                                                            353)
                                                        </option>
                                                        <option data-countryCode="IL" value="972">Israel ( 972)
                                                        </option>
                                                        <option data-countryCode="IT" value="39">Italy ( 39)
                                                        </option>
                                                        <option data-countryCode="JM" value="1876">Jamaica (
                                                            1876)
                                                        </option>
                                                        <option data-countryCode="JP" value="81">Japan ( 81)
                                                        </option>
                                                        <option data-countryCode="JO" value="962">Jordan ( 962)
                                                        </option>
                                                        <option data-countryCode="KZ" value="7">Kazakhstan (
                                                            7)</option>
                                                        <option data-countryCode="KE" value="254">Kenya ( 254)
                                                        </option>
                                                        <option data-countryCode="KI" value="686">Kiribati (
                                                            686)
                                                        </option>
                                                        <option data-countryCode="KP" value="850">Korea North (
                                                            850)
                                                        </option>
                                                        <option data-countryCode="KR" value="82">Korea South (
                                                            82)
                                                        </option>
                                                        <option data-countryCode="KW" value="965">Kuwait ( 965)
                                                        </option>
                                                        <option data-countryCode="KG" value="996">Kyrgyzstan (
                                                            996)
                                                        </option>
                                                        <option data-countryCode="LA" value="856">Laos ( 856)
                                                        </option>
                                                        <option data-countryCode="LV" value="371">Latvia ( 371)
                                                        </option>
                                                        <option data-countryCode="LB" value="961">Lebanon (
                                                            961)
                                                        </option>
                                                        <option data-countryCode="LS" value="266">Lesotho (
                                                            266)
                                                        </option>
                                                        <option data-countryCode="LR" value="231">Liberia (
                                                            231)
                                                        </option>
                                                        <option data-countryCode="LY" value="218">Libya ( 218)
                                                        </option>
                                                        <option data-countryCode="LI" value="417">Liechtenstein
                                                            ( 417)
                                                        </option>
                                                        <option data-countryCode="LT" value="370">Lithuania (
                                                            370)
                                                        </option>
                                                        <option data-countryCode="LU" value="352">Luxembourg (
                                                            352)
                                                        </option>
                                                        <option data-countryCode="MO" value="853">Macao ( 853)
                                                        </option>
                                                        <option data-countryCode="MK" value="389">Macedonia (
                                                            389)
                                                        </option>
                                                        <option data-countryCode="MG" value="261">Madagascar (
                                                            261)
                                                        </option>
                                                        <option data-countryCode="MW" value="265">Malawi ( 265)
                                                        </option>
                                                        <option data-countryCode="MY" value="60">Malaysia (
                                                            60)</option>
                                                        <option data-countryCode="MV" value="960">Maldives (
                                                            960)
                                                        </option>
                                                        <option data-countryCode="ML" value="223">Mali ( 223)
                                                        </option>
                                                        <option data-countryCode="MT" value="356">Malta ( 356)
                                                        </option>
                                                        <option data-countryCode="MH" value="692">Marshall
                                                            Islands (
                                                            692)
                                                        </option>
                                                        <option data-countryCode="MQ" value="596">Martinique (
                                                            596)
                                                        </option>
                                                        <option data-countryCode="MR" value="222">Mauritania (
                                                            222)
                                                        </option>
                                                        <option data-countryCode="YT" value="269">Mayotte (
                                                            269)
                                                        </option>
                                                        <option data-countryCode="MX" value="52">Mexico ( 52)
                                                        </option>
                                                        <option data-countryCode="FM" value="691">Micronesia (
                                                            691)
                                                        </option>
                                                        <option data-countryCode="MD" value="373">Moldova (
                                                            373)
                                                        </option>
                                                        <option data-countryCode="MC" value="377">Monaco ( 377)
                                                        </option>
                                                        <option data-countryCode="MN" value="976">Mongolia (
                                                            976)
                                                        </option>
                                                        <option data-countryCode="MS" value="1664">Montserrat (
                                                            1664)
                                                        </option>
                                                        <option data-countryCode="MA" value="212">Morocco (
                                                            212)
                                                        </option>
                                                        <option data-countryCode="MZ" value="258">Mozambique (
                                                            258)
                                                        </option>
                                                        <option data-countryCode="MN" value="95">Myanmar ( 95)
                                                        </option>
                                                        <option data-countryCode="NA" value="264">Namibia (
                                                            264)
                                                        </option>
                                                        <option data-countryCode="NR" value="674">Nauru ( 674)
                                                        </option>
                                                        <option data-countryCode="NP" value="977">Nepal ( 977)
                                                        </option>
                                                        <option data-countryCode="NL" value="31">Netherlands (
                                                            31)
                                                        </option>
                                                        <option data-countryCode="NC" value="687">New Caledonia
                                                            ( 687)
                                                        </option>
                                                        <option data-countryCode="NZ" value="64">New Zealand (
                                                            64)
                                                        </option>
                                                        <option data-countryCode="NI" value="505">Nicaragua (
                                                            505)
                                                        </option>
                                                        <option data-countryCode="NE" value="227">Niger ( 227)
                                                        </option>
                                                        <option data-countryCode="NG" value="234">Nigeria (
                                                            234)
                                                        </option>
                                                        <option data-countryCode="NU" value="683">Niue ( 683)
                                                        </option>
                                                        <option data-countryCode="NF" value="672">Norfolk
                                                            Islands (
                                                            672)
                                                        </option>
                                                        <option data-countryCode="NP" value="670">Northern
                                                            Marianas (
                                                            670)
                                                        </option>
                                                        <option data-countryCode="NO" value="47">Norway ( 47)
                                                        </option>
                                                        <option data-countryCode="OM" value="968">Oman ( 968)
                                                        </option>
                                                        <option data-countryCode="PW" value="680">Palau ( 680)
                                                        </option>
                                                        <option data-countryCode="PA" value="507">Panama ( 507)
                                                        </option>
                                                        <option data-countryCode="PG" value="675">Papua New
                                                            Guinea (
                                                            675)
                                                        </option>
                                                        <option data-countryCode="PY" value="595">Paraguay (
                                                            595)
                                                        </option>
                                                        <option data-countryCode="PE" value="51">Peru ( 51)
                                                        </option>
                                                        <option data-countryCode="PH" value="63">Philippines (
                                                            63)
                                                        </option>
                                                        <option data-countryCode="PL" value="48">Poland ( 48)
                                                        </option>
                                                        <option data-countryCode="PT" value="351">Portugal (
                                                            351)
                                                        </option>
                                                        <option data-countryCode="PR" value="1787">Puerto Rico (
                                                            1787)
                                                        </option>
                                                        <option data-countryCode="QA" value="974">Qatar ( 974)
                                                        </option>
                                                        <option data-countryCode="RE" value="262">Reunion (
                                                            262)
                                                        </option>
                                                        <option data-countryCode="RO" value="40">Romania ( 40)
                                                        </option>
                                                        <option data-countryCode="RU" value="7">Russia ( 7)
                                                        </option>
                                                        <option data-countryCode="RW" value="250">Rwanda ( 250)
                                                        </option>
                                                        <option data-countryCode="SM" value="378">San Marino (
                                                            378)
                                                        </option>
                                                        <option data-countryCode="ST" value="239">Sao Tome
                                                            &amp;
                                                            Principe ( 239)
                                                        </option>
                                                        <option data-countryCode="SA" value="966">Saudi Arabia
                                                            ( 966)
                                                        </option>
                                                        <option data-countryCode="SN" value="221">Senegal (
                                                            221)
                                                        </option>
                                                        <option data-countryCode="CS" value="381">Serbia ( 381)
                                                        </option>
                                                        <option data-countryCode="SC" value="248">Seychelles (
                                                            248)
                                                        </option>
                                                        <option data-countryCode="SL" value="232">Sierra Leone
                                                            ( 232)
                                                        </option>
                                                        <option data-countryCode="SG" value="65">Singapore (
                                                            65)
                                                        </option>
                                                        <option data-countryCode="SK" value="421">Slovak
                                                            Republic (
                                                            421)
                                                        </option>
                                                        <option data-countryCode="SI" value="386">Slovenia (
                                                            386)
                                                        </option>
                                                        <option data-countryCode="SB" value="677">Solomon
                                                            Islands (
                                                            677)
                                                        </option>
                                                        <option data-countryCode="SO" value="252">Somalia (
                                                            252)
                                                        </option>
                                                        <option data-countryCode="ZA" value="27">South Africa
                                                            ( 27)
                                                        </option>
                                                        <option data-countryCode="ES" value="34">Spain ( 34)
                                                        </option>
                                                        <option data-countryCode="LK" value="94">Sri Lanka (
                                                            94)
                                                        </option>
                                                        <option data-countryCode="SH" value="290">St. Helena (
                                                            290)
                                                        </option>
                                                        <option data-countryCode="KN" value="1869">St. Kitts (
                                                            1869)
                                                        </option>
                                                        <option data-countryCode="SC" value="1758">St. Lucia (
                                                            1758)
                                                        </option>
                                                        <option data-countryCode="SD" value="249">Sudan ( 249)
                                                        </option>
                                                        <option data-countryCode="SR" value="597">Suriname (
                                                            597)
                                                        </option>
                                                        <option data-countryCode="SZ" value="268">Swaziland (
                                                            268)
                                                        </option>
                                                        <option data-countryCode="SE" value="46">Sweden ( 46)
                                                        </option>
                                                        <option data-countryCode="CH" value="41">Switzerland (
                                                            41)
                                                        </option>
                                                        <option data-countryCode="SI" value="963">Syria ( 963)
                                                        </option>
                                                        <option data-countryCode="TW" value="886">Taiwan ( 886)
                                                        </option>
                                                        <option data-countryCode="TJ" value="7">Tajikstan (
                                                            7)</option>
                                                        <option data-countryCode="TH" value="66">Thailand (
                                                            66)</option>
                                                        <option data-countryCode="TG" value="228">Togo ( 228)
                                                        </option>
                                                        <option data-countryCode="TO" value="676">Tonga ( 676)
                                                        </option>
                                                        <option data-countryCode="TT" value="1868">Trinidad
                                                            &amp; Tobago
                                                            ( 1868)
                                                        </option>
                                                        <option data-countryCode="TN" value="216">Tunisia (
                                                            216)
                                                        </option>
                                                        <option data-countryCode="TR" value="90">Turkey ( 90)
                                                        </option>
                                                        <option data-countryCode="TM" value="7">Turkmenistan
                                                            ( 7)
                                                        </option>
                                                        <option data-countryCode="TM" value="993">Turkmenistan
                                                            ( 993)
                                                        </option>
                                                        <option data-countryCode="TC" value="1649">Turks &amp;
                                                            Caicos
                                                            Islands ( 1649)
                                                        </option>
                                                        <option data-countryCode="TV" value="688">Tuvalu ( 688)
                                                        </option>
                                                        <option data-countryCode="UG" value="256">Uganda ( 256)
                                                        </option>
                                                        <option data-countryCode="GB" value="44">UK ( 44)
                                                        </option>
                                                        <option data-countryCode="UA" value="380">Ukraine (
                                                            380)
                                                        </option>
                                                        <option data-countryCode="AE" value="971">United Arab
                                                            Emirates (
                                                            971)
                                                        </option>
                                                        <option data-countryCode="UY" value="598">Uruguay (
                                                            598)
                                                        </option>
                                                        <option data-countryCode="US" value="1">USA ( 1)
                                                        </option>
                                                        <option data-countryCode="UZ" value="7">Uzbekistan (
                                                            7)</option>
                                                        <option data-countryCode="VU" value="678">Vanuatu (
                                                            678)
                                                        </option>
                                                        <option data-countryCode="VA" value="379">Vatican City
                                                            ( 379)
                                                        </option>
                                                        <option data-countryCode="VE" value="58">Venezuela (
                                                            58)
                                                        </option>
                                                        <option data-countryCode="VN" value="84">Vietnam ( 84)
                                                        </option>
                                                        <option data-countryCode="VG" value="84">Virgin
                                                            Islands -
                                                            British ( 1284)
                                                        </option>
                                                        <option data-countryCode="VI" value="84">Virgin
                                                            Islands - US (
                                                            1340)
                                                        </option>
                                                        <option data-countryCode="WF" value="681">Wallis &amp;
                                                            Futuna (
                                                            681)
                                                        </option>
                                                        <option data-countryCode="YE" value="969">Yemen
                                                            (North)( 969)
                                                        </option>
                                                        <option data-countryCode="YE" value="967">Yemen
                                                            (South)( 967)
                                                        </option>
                                                        <option data-countryCode="ZM" value="260">South Africa
                                                            ( 260)
                                                        </option>
                                                        <option data-countryCode="ZW" value="263">Zimbabwe (
                                                            263)
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input id="phone_number" class="form-control"
                                                        type="phone_number" name="phone_number"
                                                        value="{{ old('phone_number') }}"
                                                        placeholder="Phone Number" required>
                                                    @if ($errors->has('phone_number'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-3 control-label">
                                                    Email ID</label>
                                                <div class="col-sm-9">
                                                    <input id="email" class="form-control" type="email"
                                                        name="email" value="{{ old('email') }}"
                                                        placeholder="Email" required>
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-sm-3 control-label">
                                                    Password</label>
                                                <div class="col-sm-9">
                                                    <input id="password" class="form-control" type="password"
                                                        name="password" placeholder="Password" required>
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation" class="col-sm-3 control-label">
                                                    Re Password</label>
                                                <div class="col-sm-9">
                                                    <input id="password" class="form-control" type="password"
                                                        name="password_confirmation"
                                                        placeholder="Re-Type Password" required>
                                                    @if ($errors->has('password_confirmation'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="terms" class="col-sm-3 control-label">
                                                </label>
                                                <div class="col-sm-9">
                                                    <label for="terms"> <input type="checkbox" name="terms"
                                                            id="terms"><a href="/terms"
                                                            class="href">{{ trans('frontend.f_47') }}</a></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-9">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        {{ trans('frontend.f_45') }}</button>
                                                    <!-- <a href="javascript:;">Forgot your password?</a> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>


@include('layout.footer')
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
<script src="{{ asset('mainindex/js/jquery-3.2.1.min.js') }}"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script> --}}
{{-- <script
  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"
  type="text/javascript"
></script> --}}
<script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        type="text/javascript"
></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
{{-- <script src="{{ asset('mainindex/vendors/bootstrap/js/popper.min.js') }}"></script> --}}
<script src="{{ asset('mainindex/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('mainindex/vendors/slick/slick.min.js') }}"></script>
<script src="{{ asset('mainindex/vendors/calender/dcalendar.picker.js') }}"></script>
<script src="{{ asset('mainindex/vendors/bootstrap-datepicker/datepicker.js') }}"></script>
<script src="{{ asset('mainindex/js/wow.min.js') }}"></script>
<script src="{{ asset('mainindex/vendors/magnify-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('mainindex/js/smoothscroll.js') }}"></script>
<script src="{{ asset('mainindex/js/custom.js') }}"></script>
<!-- Country picker with phone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="{{ asset('asset/js/custom-phone-input.js') }}"></script>
@if (Setting::get('multilanguage_enabled', 0) == 1)
    <script type="text/javascript"
            src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                {
                    pageLanguage: "en",
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                    autoDisplay: false,
                },
                "google_translate_element"
            );
        }

        window.setTimeout(function () {
            var lang = $(".goog-te-menu-value span:first").text();
            $(`#language-selector option[value="${lang}"]`).attr('selected', 'selected');
        }, 3000);

        function translateLanguage(langUrl) {
            window.location.href = langUrl;
        }

        $(function () {
            $(".selectpicker").selectpicker();
        });
    </script>
@endif
@if (count($errors) > 0)
    <script>
        $(document).ready(function () {
            $('#myModal').modal('show');
        });
    </script>
@endif

@yield('scripts')
@if (Setting::get('tawk_support') == 1)
    <!--StartofTawk.toScript-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = "https://embed.tawk.to/{{Setting::get('tawk_live')}}/{{Setting::get('widget_id')}}";
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
@endif

@if (Setting::get('fb_chat') == 1)
    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                xfbml: true,
                version: 'v10.0'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- Your Chat Plugin code -->
    <div class="fb-customerchat" attribution="biz_inbox" page_id="{{ Setting::get('fb_page_id') }}"></div>
@endif
@stack('scripts')
{{-- @include('themes.conexi.layouts.partials.scripts') --}}

</body>

</html>
