@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Payment Settings ')

@section('content')
    <link href="https://bootstrapformhelpers.com/assets/css/bootstrap-formhelpers.min.css" rel="stylesheet" type="text/css" />
    <style>
        .bfh-selectbox {
            width: 100%;
        }


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

        .col-6{
            height: fit-content;
        }
    </style>


    <div class="content-wrapper">
        <div class="container-fluid">
            @include('common.notify')
            <form action="{{ route('admin.settings.payment.store') }}" method="POST">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-12">
                        <div class="card border-radius-10">
                            <ul class="nav nav-tabs" id="serviceTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-modes" data-toggle="tab" href="#content-modes" style="border-top-left-radius: 10px"
                                        role="tab" aria-controls="content-modes" aria-selected="true">
                                        {{ translateKeyword('payment_modes') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-settings" data-toggle="tab" href="#content-settings"
                                        role="tab" aria-controls="content-settings" aria-selected="false">
                                        {{ translateKeyword('payment_settings') }}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="serviceTabsContent">
                                <div class="tab-pane show active" id="content-modes" role="tabpanel"
                                    aria-labelledby="tab-modes">
                                    <div class="box-block row">
                                        {{-- <h5>Payment Modes</h5> --}}

                                        <div class="col-6">
                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="mtn" class="col-form-label">
                                                                Araka
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('araka') == 1) checked @endif
                                                                name="araka" id="araka_check" onchange="arakaselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="araka_field"
                                                        @if (Setting::get('araka') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="araka_email" class="col-xs-4 col-form-label">
                                                                Araka Email</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="email"
                                                                    value="{{ Setting::get('araka_email', '') }}"
                                                                    name="araka_email" id="araka_email"
                                                                    placeholder="Araka Email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="araka_public_key" class="col-xs-4 col-form-label">
                                                                Araka Password</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="password"
                                                                    value="{{ Setting::get('araka_password', '') }}"
                                                                    name="araka_password" id="araka_password"
                                                                    placeholder="Araka Password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="araka_payment_page_id" class="col-xs-4 col-form-label">
                                                                Araka Payment Page ID</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('araka_payment_page_id', '') }}"
                                                                    name="araka_payment_page_id" id="araka_payment_page_id"
                                                                    placeholder="Araka Payment Page ID">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="epayco" class="col-form-label">
                                                                ePayco
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('epayco') == 1) checked @endif
                                                                name="epayco" id="epayco_check" onchange="epaycoselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="epayco_field"
                                                        @if (Setting::get('epayco') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="epayco_public_key" class="col-xs-4 col-form-label">
                                                                ePayco Public key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('epayco_public_key', '') }}"
                                                                    name="epayco_public_key" id="epayco_public_key"
                                                                    placeholder="ePayco Public key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="epayco_private_key" class="col-xs-4 col-form-label">
                                                                ePayco Private Key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('epayco_private_key', '') }}"
                                                                    name="epayco_private_key" id="epayco_priavte_key"
                                                                    placeholder="ePayco Private Key">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="paydunya" class="col-form-label">
                                                                Fathoorah
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('fathoorah') == 1) checked @endif
                                                                name="fathoorah" id="fathoorah_check"
                                                                onchange="fathoorahselect()" type="checkbox"
                                                                class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="fathoorah_field"
                                                        @if (Setting::get('fathoorah') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="paydunya_master_key" class="col-xs-4 col-form-label">
                                                                Fathoorah Api key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('fathoorah_api_key', '') }}"
                                                                    name="fathoorah_api_key" id="fathoorah_api_key"
                                                                    placeholder="Fathoorah Api key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="rave_encryptionKey"
                                                                class="col-xs-4 col-form-label">{{ translateKeyword('Select Country') }}</label>
                                                            <div class="col-xs-8">
                                                                <select class="form-control" id="fathoorah_country"
                                                                    name="fathoorah_country">
    
                                                                    <option value="KUWAIT"
                                                                        @if (Setting::get('fathoorah_country') === 'KUWAIT') selected @endif>
                                                                        @lang('KUWAIT')</option>
    
                                                                    <option value="SAUDI_ARABIA"
                                                                        @if (Setting::get('fathoorah_country') === 'SAUDI_ARABIA') selected @endif>
                                                                        @lang('SAUDI ARABIA')</option>
    
                                                                    <option value="BAHRAIN"
                                                                        @if (Setting::get('fathoorah_country') === 'BAHRAIN') selected @endif>
                                                                        @lang('BAHRAIN')</option>
    
                                                                    <option value="UNITED_ARAB_EMIRATES_UAE"
                                                                        @if (Setting::get('fathoorah_country') === 'UNITED_ARAB_EMIRATES_UAE') selected @endif>
                                                                        @lang('UNITED ARAB EMIRATES - UAE')</option>
    
                                                                    <option value="QATAR"
                                                                        @if (Setting::get('fathoorah_country') === 'QATAR') selected @endif>
                                                                        @lang('QATAR')</option>
    
                                                                    <option value="OMAN"
                                                                        @if (Setting::get('fathoorah_country') === 'OMAN') selected @endif>
                                                                        @lang('OMAN')</option>
                                                                    <option value="JORDAN"
                                                                        @if (Setting::get('fathoorah_country') === 'JORDAN') selected @endif>
                                                                        @lang('JORDAN')</option>
                                                                    <option value="EGYPT"
                                                                        @if (Setting::get('fathoorah_country') === 'EGYPT') selected @endif>
                                                                        @lang('EGYPT')</option>
                                                                </select>
    
    
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="paydunya_public_key" class="col-xs-4 col-form-label">
                                                                fathoorah-mode</label>
                                                            <div class="col-xs-8">
    
                                                                <select class="form-control" id="fathoorah_mode"
                                                                    name="fathoorah_mode">
    
                                                                    <option value="Test"
                                                                        @if (Setting::get('fathoorah_mode') === 'Test') selected @endif>
                                                                        @lang('Test')</option>
    
                                                                    <option value="Live"
                                                                        @if (Setting::get('fathoorah_mode') === 'Live') selected @endif>
                                                                        @lang('Live')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="stripe_secret_key" class="col-form-label">
                                                                FlutterWave Payments
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('rave') == 1) checked @endif
                                                                name="rave" id="rave_check" onchange="raveselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="rave_field"
                                                        @if (Setting::get('rave') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="rave_publicKey" class="col-xs-4 col-form-label">Public
                                                                Key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('rave_publicKey', '') }}"
                                                                    name="rave_publicKey" id="rave_publicKey"
                                                                    placeholder="Public Key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="rave_encryptionKey"
                                                                class="col-xs-4 col-form-label">Encryption
                                                                Key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('rave_encryptionKey', '') }}"
                                                                    name="rave_encryptionKey" id="rave_encryptionKey"
                                                                    placeholder="Encryption Key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="rave_encryptionKey"
                                                                class="col-xs-4 col-form-label">{{ translateKeyword('Select Country') }}</label>
                                                            <div class="col-xs-8">
                                                                <select class="form-control" id="rave_country"
                                                                    name="rave_country">
    
                                                                    <option value="GH"
                                                                        @if (Setting::get('rave_country') === 'GH') selected @endif>
                                                                        @lang('Ghana')</option>
    
                                                                    <option value="KE"
                                                                        @if (Setting::get('rave_country') === 'KE') selected @endif>
                                                                        @lang('Kenya')</option>
    
                                                                    <option value="ZA"
                                                                        @if (Setting::get('rave_country') === 'ZA') selected @endif>
                                                                        @lang('South Africa')</option>
    
                                                                    <option value="TZ"
                                                                        @if (Setting::get('rave_country') === 'TZ') selected @endif>
                                                                        @lang('Tanzania')</option>
    
                                                                    <option value="NG"
                                                                        @if (Setting::get('rave_country') === 'NG') selected @endif>
                                                                        @lang('Nigeria')</option>
    
                                                                    <option value="ZM"
                                                                        @if (Setting::get('rave_country') === 'ZM') selected @endif>
                                                                        @lang('Zambia')</option>
                                                                </select>
    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="ad_mob" class="col-form-label">
                                                                Google AdMob
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('ad_mob') == 1) checked @endif
                                                                name="ad_mob" id="ad_mob" onchange="admobselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    {{-- <div id="admob_field" @if (Setting::get('ad_mob') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="ad_mob" class="col-xs-4 col-form-label">App ID Customer
                                                            </label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('app_id_customer', '') }}" name="app_id_customer" id="app_id_customer"
                                                                    placeholder="Enter App ID Customer">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="ad_mob" class="col-xs-4 col-form-label">Ad Unit ID Customer
                                                            </label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('ad_unit_id_customer', '') }}" name="ad_unit_id_customer" id="ad_unit_id_customer"
                                                                    placeholder="Enter Ad Unit ID Customer">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="ad_mob" class="col-xs-4 col-form-label">App ID Provider
                                                            </label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('app_id_provider', '') }}" name="app_id_provider" id="app_id_provider"
                                                                    placeholder="Enter App ID Provider">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="ad_mob" class="col-xs-4 col-form-label">Ad Unit ID Provider
                                                            </label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('ad_unit_id_provider', '') }}" name="ad_unit_id_provider" id="ad_unit_id_provider"
                                                                    placeholder="Enter Ad Unit ID Provider">
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="mercado_pago" class="col-form-label">
                                                                Mercado Pago
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('mercado') == 1) checked @endif
                                                                name="mercado" id="mercado_check" onchange="mercadoselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="mercado_field"
                                                        @if (Setting::get('mercado') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="mercado_public_key" class="col-xs-4 col-form-label">
                                                                Mercado Public key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('mercado_public_key', '') }}"
                                                                    name="mercado_public_key" id="mercado_public_key"
                                                                    placeholder="Mercado Public key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="mercado_access_token" class="col-xs-4 col-form-label">
                                                                Mercado Access token</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('mercado_access_token', '') }}"
                                                                    name="mercado_access_token" id="mercado_access_token"
                                                                    placeholder="Mercado Access token">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="mtn" class="col-form-label">
                                                                @lang('MTN')
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('mtn') == 1) checked @endif
                                                                name="mtn" id="mtn_check" onchange="mtnselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="mtn_field"
                                                        @if (Setting::get('mtn') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="mtn_user_id" class="col-xs-4 col-form-label">
                                                                MTN User ID</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('mtn_user_id', '') }}"
                                                                    name="mtn_user_id" id="mtn_user_id"
                                                                    placeholder="MTN User ID">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="mtn_user_key" class="col-xs-4 col-form-label">
                                                                MTN User Key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('mtn_user_key', '') }}"
                                                                    name="mtn_user_key" id="mtn_user_key"
                                                                    placeholder="MTN User Key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for=mtn_primary_subscription_key_collection"
                                                                class="col-xs-4 col-form-label">
                                                                {{ translateKeyword('MTN Primary Subscription Key (Collections)') }}</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('mtn_primary_subscription_key_collection', '') }}"
                                                                    name="mtn_primary_subscription_key_collection"
                                                                    id="mtn_primary_subscription_key_collection"
                                                                    placeholder="{{ translateKeyword('MTN Primary Subscription Key (Collections)') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="mtn_secondary_subscription_key_collection"
                                                                class="col-xs-4 col-form-label">
                                                                {{ translateKeyword('MTN Secondary Subscription Key (Collections)') }}</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('mtn_secondary_subscription_key_collection', '') }}"
                                                                    name="mtn_secondary_subscription_key_collection"
                                                                    id="mtn_secondary_subscription_key_collection"
                                                                    placeholder="{{ translateKeyword('MTN Secondary Subscription Key (Collections)') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="mtn_primary_subscription_key_disbursement"
                                                                class="col-xs-4 col-form-label">
                                                                {{ translateKeyword('MTN Primary Subscription Key (Disbursements)') }}</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('mtn_primary_subscription_key_disbursement', '') }}"
                                                                    name="mtn_primary_subscription_key_disbursement"
                                                                    id="mtn_primary_subscription_key_disbursement"
                                                                    placeholder="{{ translateKeyword('MTN Primary Subscription Key (Disbursements)') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="mtn_secondary_subscription_key_disbursement"
                                                                class="col-xs-4 col-form-label">
                                                                {{ translateKeyword('MTN Secondary Subscription Key (Disbursements)') }}</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('mtn_secondary_subscription_key_disbursement', '') }}"
                                                                    name="mtn_secondary_subscription_key_disbursement"
                                                                    id="mtn_secondary_subscription_key_disbursement"
                                                                    placeholder="{{ translateKeyword('MTN Secondary Subscription Key (Disbursements)') }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="mtn_public_key" class="col-xs-4 col-form-label">
                                                                MTN Mode</label>
                                                            <div class="col-xs-8">
                                                                <select class="form-control" id="mtn_mode" name="mtn_mode">
                                                                    <option value="sandbox"
                                                                        @if (Setting::get('mtn_mode') === 'sandbox') selected @endif>
                                                                        @lang('Test')</option>
    
                                                                    <option value="production"
                                                                        @if (Setting::get('mtn_mode') === 'production') selected @endif>
                                                                        @lang('Live')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="UPI_key" class="col-form-label">
                                                                MLajan
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('mlajan') == 1) checked @endif
                                                                name="mlajan" id="mlajan_check" onchange="mlajanselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="mlajan_field"
                                                        @if (Setting::get('mlajan') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="merchant_code"
                                                                class="col-xs-4 col-form-label">MerchantCode</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('merchant_code', '') }}"
                                                                    name="merchant_code" id="merchant_code"
                                                                    placeholder="MerchantCode">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="paydunya" class="col-form-label">
                                                                @lang('Paydunya')
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('paydunya') == 1) checked @endif
                                                                name="paydunya" id="paydunya_check"
                                                                onchange="paydunyaselect()" type="checkbox" class="js-switch"
                                                                data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="paydunya_field"
                                                        @if (Setting::get('paydunya') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="paydunya_master_key" class="col-xs-4 col-form-label">
                                                                Paydunya Master key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('paydunya_master_key', '') }}"
                                                                    name="paydunya_master_key" id="paydunya_master_key"
                                                                    placeholder="Paydunya Master Key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="paydunya_public_key" class="col-xs-4 col-form-label">
                                                                Paydunya Public key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('paydunya_public_key', '') }}"
                                                                    name="paydunya_public_key" id="paydunya_public_key"
                                                                    placeholder="Paydunya Public Key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="paydunya_public_key" class="col-xs-4 col-form-label">
                                                                Paydunya Private key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('paydunya_private_key', '') }}"
                                                                    name="paydunya_private_key" id="paydunya_private_key"
                                                                    placeholder="Paydunya Public Key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="paydunya_token" class="col-xs-4 col-form-label">
                                                                Paydunya Token</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('paydunya_token', '') }}"
                                                                    name="paydunya_token" id="paydunya_token"
                                                                    placeholder="Paydunya Token">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="paydunya_public_key" class="col-xs-4 col-form-label">
                                                                Paydunya Mode</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('paydunya_mode', '') }}"
                                                                    name="paydunya_mode" id="paydunya_mode"
                                                                    placeholder="Paydunya Mode">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="cash-payments" class="col-form-label">
                                                                {{ translateKeyword('cash_payments') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('CASH') == 1) checked @endif
                                                                name="CASH" id="cash-payments" onchange="cardselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="UPI_key" class="col-form-label">
                                                                {{ translateKeyword('PayPal Payments') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('paypal') == 1) checked @endif
                                                                name="paypal" id="paypal_check" onchange="paypalselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="paypal_field"
                                                        @if (Setting::get('paypal') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="paypal_client_id"
                                                                class="col-xs-4 col-form-label">PayPal
                                                                Client
                                                                ID</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('paypal_client_id', '') }}"
                                                                    name="paypal_client_id" id="paypal_client_id"
                                                                    placeholder="PayPal Client Id">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="paymob_key" class="col-form-label">
                                                                PayMob
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('pay_mob') == 1) checked @endif
                                                                name="pay_mob" id="pay_mob" onchange="paymobselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="paymob_field"
                                                        @if (Setting::get('pay_mob') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="paymob_key"
                                                                class="col-xs-4 col-form-label">IframeID</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('iframe_id', '') }}"
                                                                    name="iframe_id" id="iframe_id" placeholder="IframeID">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="paymob_key" class="col-xs-4 col-form-label">Api
                                                                Key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('paymob_api_key', '') }}"
                                                                    name="paymob_api_key" id="paymob_api_key"
                                                                    placeholder="Paymob Api Key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="hash_key" class="col-xs-4 col-form-label">Hash
                                                                Key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('hash_key', '') }}"
                                                                    name="hash_key" id="hash_key" placeholder="Hash Key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="integration_id"
                                                                class="col-xs-4 col-form-label">Integration
                                                                Id</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('integration_id', '') }}"
                                                                    name="integration_id" id="integration_id"
                                                                    placeholder="Integration Id">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="razor_key" class="col-form-label">
                                                                RazorPay Gateway
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('razor') == 1) checked @endif
                                                                name="razor" id="razor_check" onchange="razorselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="razor_field"
                                                        @if (Setting::get('razor') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="razor_key" class="col-xs-4 col-form-label">RazorPay
                                                                Key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('razor_key', '') }}"
                                                                    name="razor_key" id="razor_key"
                                                                    placeholder="RazorPay Key">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="stc_key" class="col-form-label">
                                                                Stc Gateway
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('stc') == 1) checked @endif
                                                                name="stc" id="stc_check" onchange="stcselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="stc_field"
                                                        @if (Setting::get('stc') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="stc_key" class="col-xs-4 col-form-label">Stc
                                                                Key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('stc_key', '') }}" name="stc_key"
                                                                    id="stc_key" placeholder="Stc Key">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="stripe_secret_key" class="col-form-label">
                                                                @lang('Stripe Payments')
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('CARD') == 1) checked @endif
                                                                name="CARD" id="stripe_check" onchange="cardselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="card_field"
                                                        @if (Setting::get('CARD') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="stripe_publishable_key"
                                                                class="col-xs-4 col-form-label">Stripe
                                                                Publishable key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('stripe_publishable_key', '') }}"
                                                                    name="stripe_publishable_key" id="stripe_publishable_key"
                                                                    placeholder="Stripe Publishable key">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="stripe_secret_key"
                                                                class="col-xs-4 col-form-label">Stripe
                                                                Secret
                                                                key</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('stripe_secret_key', '') }}"
                                                                    name="stripe_secret_key" id="stripe_secret_key"
                                                                    placeholder="Stripe Secret key">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card col-12 border-radius-10">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="UPI_key" class="col-form-label">
                                                                {{ translateKeyword('UPI Payments') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('UPI') == 1) checked @endif
                                                                name="UPI" id="upi_check" onchange="upiselect()"
                                                                type="checkbox" class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div id="upi_field"
                                                        @if (Setting::get('UPI') == 0) style="display: none;" @endif>
                                                        <div class="form-group row">
                                                            <label for="UPI_key"
                                                                class="col-xs-4 col-form-label">{{ translateKeyword('UPI Address') }}</label>
                                                            <div class="col-xs-8">
                                                                <input class="form-control" type="text"
                                                                    value="{{ Setting::get('UPI_key', '') }}" name="UPI_key"
                                                                    id="UPI_key"
                                                                    placeholder="{{ translateKeyword('UPI Address') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Surge peak Switch --}}
                                        {{-- <div class="card">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-xs-4">
                                                        <label for="stripe_secret_key" class="col-form-label">
                                                            @lang('Surge Peak Switch')
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input @if (Setting::get('CARD') == 1) checked @endif name="CARD" id="stripe_check"
                                                            onchange="cardselect()" type="checkbox" class="js-switch" data-color="#43b968">
                                                    </div>
                                                </div>
                                                <div id="card_field" @if (Setting::get('CARD') == 0) style="display: none;" @endif>
                                                    <div class="form-group row">
                                                        <label for="stripe_publishable_key" class="col-xs-4 col-form-label">Stripe
                                                            Publishable key</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('stripe_publishable_key', '') }}"
                                                                name="stripe_publishable_key" id="stripe_publishable_key"
                                                                placeholder="Stripe Publishable key">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="stripe_secret_key" class="col-xs-4 col-form-label">Stripe Secret
                                                            key</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('stripe_secret_key', '') }}" name="stripe_secret_key"
                                                                id="stripe_secret_key" placeholder="Stripe Secret key">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- ePayco payment gateway --}}



                                        {{-- //PayU --}}

                                        {{-- <div class="card">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-xs-4">
                                                        <label for="payu_key" class="col-form-label">
                                                            PayU Gateway
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input @if (Setting::get('payu') == 1) checked @endif name="payu"
                                                            id="payu_check" onchange="payuselect()" type="checkbox" class="js-switch"
                                                            data-color="#43b968">
                                                    </div>
                                                </div>
                                                <div id="payu_field" @if (Setting::get('payu') == 0) style="display: none;" @endif>
                                                    <div class="form-group row">
                                                        <label for="payu_key" class="col-xs-4 col-form-label">PayU Key</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('payu_key', '') }}" name="payu_key" id="payu_key"
                                                                placeholder="PayU Key">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- Stc --}}

                                        {{-- PAYU SWITCH --}}

                                        {{-- <div class="card">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-xs-4">
                                                        <label for="PAYU" class="col-form-label">
                                                            PAYU
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input @if (Setting::get('payu_switch') == 1) checked @endif name="payu_switch"
                                                            id="payu_switch_check" onchange="payuswitchselect()" type="checkbox" class="js-switch"
                                                            data-color="#43b968">
                                                    </div>
                                                </div>
                                                <div id="payu_switch_field" @if (Setting::get('payu_switch') == 0) style="display: none;" @endif>
                                                    <div class="form-group row">
                                                        <label for="payu_on_testing" class="col-xs-4 col-form-label">PAYU_ON_TESTING</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('payu_on_testing', '') }}" name="payu_on_testing" id="payu_on_testing"
                                                                placeholder="PAYU_ON_TESTING">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="payu_merchant_id" class="col-xs-4 col-form-label">PAYU_MERCHANT_ID</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('payu_merchant_id', '') }}" name="payu_merchant_id" id="payu_merchant_id"
                                                                placeholder="payu_merchant_id">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="payu_api_login" class="col-xs-4 col-form-label">PAYU_API_LOGIN</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('payu_api_login', '') }}" name="payu_api_login" id="payu_api_login"
                                                                placeholder="PAYU_API_LOGIN">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="payu_api_key" class="col-xs-4 col-form-label">PAYU_API_KEY</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('payu_api_key', '') }}" name="payu_api_key" id="payu_api_key"
                                                                placeholder="PAYU_API_KEY">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="payu_account_id" class="col-xs-4 col-form-label">PAYU_ACCOUNT_ID</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('payu_account_id', '') }}" name="payu_account_id" id="payu_account_id"
                                                                placeholder="PAYU_ACCOUNT_ID">
                                                        </div>
                                                    </div>
        
                                                    <div class="form-group row">
                                                        <label for="rave_encryptionKey" class="col-xs-4 col-form-label">PAYU_Country</label>
                                                        <div class="col-xs-8">
                                                            <select class="form-control" id="payu_country" name="payu_country">
                    
                                                                <option value="AR" @if (Setting::get('payu_country') === 'AR') selected @endif>
                                                                    @lang('AR')</option>
                    
                                                                <option value="BR" @if (Setting::get('payu_country') === 'BR') selected @endif>
                                                                    @lang('BR')</option>
                    
                                                                <option value="CO" @if (Setting::get('payu_country') === 'CO') selected @endif>
                                                                    @lang('CO')</option>
                    
                                                                <option value="CL" @if (Setting::get('payu_country') === 'CL') selected @endif>
                                                                    @lang('CL')</option>
                    
                                                                <option value="MX" @if (Setting::get('payu_country') === 'MX') selected @endif>
                                                                    @lang('MX')</option>
                    
                                                                <option value="PA" @if (Setting::get('payu_country') === 'PA') selected @endif>
                                                                     @lang('PA')</option>
        
                                                                <option value="PE" @if (Setting::get('payu_country') === 'PE') selected @endif>
                                                                     @lang('PE')</option>
        
                                                                <option value="US" @if (Setting::get('payu_country') === 'US') selected @endif>
                                                                     @lang('US')</option>
                                                            </select>
                    
                                                        </div>
                                                    </div>
        
                                                    <div class="form-group row">
                                                        <label for="pse_redirect_url" class="col-xs-4 col-form-label">PSE_REDIRECT_URL</label>
                                                        <div class="col-xs-8">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('pse_redirect_url', '') }}" name="pse_redirect_url" id="pse_redirect_url"
                                                                placeholder="PSE_REDIRECT_URL">
                                                        </div>
                                                    </div>
        
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="tab-pane" id="content-settings" role="tabpanel"
                                    aria-labelledby="tab-settings">
                                    <div class="box-block">
                                        {{-- <h5>Payment Settings</h5> --}}

                                        <div class="card card-block card-inverse card-info border-radius-10">
                                            <div class="card-body row">


                                                <div class="form-group col-4">
                                                    <label for="booking_prefix"
                                                        class="col-xs-12 col-form-label">{{ translateKeyword('booking_id_prefix') }}</label>
                                                    <div class="col-xs-12">
                                                        <input class="form-control" type="text"
                                                            value="{{ Setting::get('booking_prefix', '0') }}"
                                                            id="booking_prefix" name="booking_prefix" min="0"
                                                            max="4"
                                                            placeholder="{{ translateKeyword('booking_id_prefix') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-4">
                                                    <label for="base_price" class="col-xs-12 col-form-label">
                                                        {{ translateKeyword('currency') }} (
                                                        <strong> @lang('currency.' . Setting::get('currency', 'USD')) </strong>)
                                                    </label>
                                                    <div class="col-xs-12">
                                                        {{-- <div class="bfh-selectbox bfh-currencies" name="currency" data-currency="{{ Setting::get('currency', 'USD')  }}" data-flags="true"></div> --}}
                                                        <select class="form-control bfh-currencies" name="currency"
                                                            data-currency="{{ Setting::get('currency', 'USD') }}"></select>
                                                        {{-- <select name="currency" class="form-control" >
                                                            <option @if (Setting::get('currency') == "$") selected @endif value="$">US Dollar
                                                                (USD)
                                                            </option>
                                                            <option @if (Setting::get('currency') == '₹') selected @endif value="₹"> Indian
                                                                Rupee (INR)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'د.ك') selected @endif value="د.ك">
                                                                Kuwaiti Dinar (KWD)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'د.ب') selected @endif value="د.ب">
                                                                Bahraini Dinar (BHD)
                                                            </option>
                                                            <option @if (Setting::get('currency') == '﷼') selected @endif value="﷼">Omani
                                                                Rial (OMR)
                                                            </option>
                                                            <option @if (Setting::get('currency') == '£') selected @endif value="£">British
                                                                Pound (GBP)
                                                            </option>
                                                            <option @if (Setting::get('currency') == '€') selected @endif value="€">Euro
                                                                (EUR)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'CHF') selected @endif value="CHF">Swiss
                                                                Franc (CHF)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'ل.د') selected @endif value="ل.د">
                                                                Libyan Dinar (LYD)
                                                            </option>
                                                            <option @if (Setting::get('currency') == "B$") selected @endif value="B$">
                                                                Bruneian Dollar (BND)
                                                            </option>
                                                            <option @if (Setting::get('currency') == "S$") selected @endif value="S$">
                                                                Singapore Dollar (SGD)
                                                            </option>
                                                            <option @if (Setting::get('currency') == "AU$") selected @endif value="AU$">
                                                                Australian Dollar (AUD)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'KES') selected @endif value="KES">
                                                                Kenya Shilling (KES)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'R') selected @endif value="R">
                                                                SouthAfrica Rand (R)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'Kr.') selected @endif value="Kr.">
                                                                Danish krone (DOK)/Norwegian krone (NOK)
                                                            </option>
                                                            <option @if (Setting::get('currency') == '₪') selected @endif value="₪"> Israeli
                                                                Shekel (₪)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'ZK') selected @endif value="ZK"> Kwacha
                                                                (ZK)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'FCFA') selected @endif value="FCFA">
                                                                West African CFA franc (FCFA)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'SEK') selected @endif value="SEK">
                                                                Swedish krona (SEK)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'CAD') selected @endif value="CAD">
                                                                Canadian Dollar (CAD)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'DJF') selected @endif value="DJF">
                                                                Djiboutian franc (DJF)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'CDF') selected @endif value="CDF">
                                                                Congolese franc (CDF)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'MK') selected @endif value="MK">
                                                                Malawian kwacha (MK)
                                                            </option>
                                                            <option @if (Setting::get('currency') == 'zł') selected @endif value="zł"> Polish
                                                                złoty (zł)
                                                            </option>
                                                        </select> --}}
                                                    </div>
                                                </div>

                                                <div class="col-4"></div>

                                                <div class="form-group col-4">
                                                    <div class="col-xs-6">
                                                        <label for="cash-payments" class="col-form-label">
                                                            {{ translateKeyword('commission-deduction') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <input @if (Setting::get('commission_deduction') == 1) checked @endif
                                                            name="commission_deduction" id="commission_deduction"
                                                            type="checkbox" class="js-switch"
                                                            onchange="commissionselect()" data-color="#43b968">
                                                    </div>
                                                </div>
                                                <div id="commission_fields" class="row"
                                                    @if (Setting::get('commission_deduction') == 0) style="display: none;" @endif>
                                                    <div class="form-group col-4">
                                                        <label for="commission_type"
                                                            class="col-xs-12 col-form-label">{{ translateKeyword('commission-type') }}</label>
                                                        <div class="col-xs-12">
                                                            <select name="commission_type" class="form-control">
                                                                <option @if (Setting::get('commission_type', 'percentage') == 'fixed') selected @endif
                                                                    value="fixed"> {{ translateKeyword('fixed') }}
                                                                </option>
                                                                <option @if (Setting::get('commission_type', 'percentage') == 'percentage') selected @endif
                                                                    value="percentage">
                                                                    {{ translateKeyword('percentage') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label for="commission_percentage"
                                                            class="col-xs-12 col-form-label">{{ translateKeyword('commission-percentage(%)/fixed') }}</label>
                                                        <div class="col-xs-12">
                                                            <input class="form-control" type="text"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                value="{{ Setting::get('commission_percentage', '0') }}"
                                                                id="commission_percentage" name="commission_percentage"
                                                                min="0" max="100"
                                                                placeholder="Commission percentage/fixed" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4"></div>
                                                    <div class="form-group col-4">
                                                        <div class="col-xs-6">
                                                            <label for="cash-payments" class="col-form-label">
                                                                {{ translateKeyword('commission-deduction-from-provider-wallet') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('commission_deduction_wallet_driver') == 1) checked @endif
                                                                name="commission_deduction_wallet_driver"
                                                                id="commission_deduction_wallet_driver" type="checkbox"
                                                                class="js-switch" onchange="commissiondeductionwallet()"
                                                                data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <div class="col-xs-6">
                                                            <label for="cash-payments" class="col-form-label">
                                                                {{ translateKeyword('commission-deduction-on-ti-amount') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('commission_deduction_on_tip') == 1) checked @endif
                                                                name="commission_deduction_on_tip"
                                                                id="commission_deduction_on_tip" type="checkbox"
                                                                class="js-switch" data-color="#43b968">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="cash-payments" class="col-form-label">
                                                                Commission Deduction Blockage Provider's Wallet
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('commission_deduction_wallet_blockage') == 1) checked
                                                                   @endif name="commission_deduction_wallet_blockage"
                                                                   id="commission_deduction_wallet_blockage" type="checkbox"
                                                                   class="js-switch"
                                                                   data-color="#43b968">
                                                        </div>
                                                    </div> --}}

                                                    <div class="form-group col-4">
                                                        <div class="col-xs-6">
                                                            <label for="driver_wallet_threshold" class="col-form-label">
                                                                {{ translateKeyword('commission-deduction-blockage-provider-wallet') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('driver_wallet_threshold') == 1) checked @endif
                                                                name="driver_wallet_threshold"
                                                                id="driver_wallet_threshold" type="checkbox"
                                                                class="js-switch"
                                                                onchange="commissiondeductionblockageproviderwallet()"
                                                                data-color="#43b968">
                                                        </div>
                                                    </div>

                                                    <div id="commission_deduction_provider_wallet" class="col-12"
                                                        @if (Setting::get('driver_wallet_threshold') == 0) style="display: none;" @endif>

                                                        <div class="form-group col-4">
                                                            <label for="provider_wallet_threshold"
                                                                class="col-xs-12 col-form-label">{{ translateKeyword('enter-provider-wallet-threshold') }}</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text"
                                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                    value="{{ Setting::get('provider_wallet_threshold', '') }}"
                                                                    id="provider_wallet_threshold"
                                                                    name="provider_wallet_threshold" min="0"
                                                                    placeholder="{{ translateKeyword('enter-provider-wallet-threshold') }}"
                                                                    required>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group col-4">
                                                        <div class="col-xs-12">
                                                            <label for="commission_deduction_account_driver"
                                                                class="col-form-label">
                                                                {{ translateKeyword('commission-deduction-blockage-provider-managed-account') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <input @if (Setting::get('commission_deduction_account_driver') == 1) checked @endif
                                                                name="commission_deduction_account_driver"
                                                                id="commission_deduction_account_driver" type="checkbox"
                                                                class="js-switch"
                                                                onchange="commissiondeductionblockageprovidermanagedaccount()"
                                                                data-color="#43b968">
                                                        </div>
                                                    </div>

                                                    <div id="commission_deduction_provider_managed_account" class="col-12"
                                                        @if (Setting::get('commission_deduction_account_driver') == 0) style="display: none;" @endif>

                                                        <div class="form-group col-4">
                                                            <label for="provider_wallet_threshold"
                                                                class="col-xs-12 col-form-label">{{ translateKeyword('enter-provider-managed-account-threshold') }}</label>
                                                            <div class="col-xs-12">
                                                                <input class="form-control" type="text"
                                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                    value="{{ Setting::get('driver_account_threshold', '') }}"
                                                                    id="driver_account_threshold"
                                                                    name="driver_account_threshold" min="0"
                                                                    placeholder="{{ translateKeyword('enter-provider-managed-account-threshold') }}">
                                                            </div>
                                                        </div>

                                                    </div>



                                                    {{-- <div class="form-group row">
                                                        <div class="col-xs-4">
                                                            <label for="cash-payments" class="col-form-label">
                                                                Commission Deduction From Fare
                                                            </label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input @if (Setting::get('commission_deduction_account_driver') == 1) checked
                                                                   @endif name="commission_deduction_account_driver"
                                                                   id="commission_deduction_account_driver" type="checkbox"
                                                                   class="js-switch" onchange="commissiondeductionfare()"
                                                                   data-color="#43b968">
                                                        </div>
                                                    </div> --}}
                                                </div>

                                                <div class="form-group col-4">
                                                    <label for="commission_type"
                                                        class="col-xs-12 col-form-label">{{ translateKeyword('commission-and-tax-application') }}</label>
                                                    <div class="col-xs-12">
                                                        <select name="commission_tax_apply" class="form-control">
                                                            <option @if (Setting::get('commission_tax_apply', 'global') == 'global') selected @endif
                                                                value="global"> {{ translateKeyword('global') }}
                                                            </option>
                                                            <option @if (Setting::get('commission_tax_apply', 'global') == 'service') selected @endif
                                                                value="service"> {{ translateKeyword('service-wise') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group col-4">
                                                    <label for="tax_percentage"
                                                        class="col-xs-12 col-form-label">{{ translateKeyword('tax_percentage') }}</label>
                                                    <div class="col-xs-12">
                                                        <input class="form-control" type="text"
                                                            value="{{ Setting::get('tax_percentage', '0') }}"
                                                            id="tax_percentage" name="tax_percentage" min="0"
                                                            max="100"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            placeholder="{{ translateKeyword('tax_percentage') }}">
                                                    </div>
                                                </div>

                                                <div class="col-4"></div>

                                                <div class="form-group col-4">
                                                    <label for="daily_target"
                                                        class="col-xs-12 col-form-label">{{ translateKeyword('daily-rides-target') }}</label>
                                                    <div class="col-xs-12">
                                                        <input class="form-control" type="text"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ Setting::get('daily_target', '0') }}"
                                                            id="daily_target" name="daily_target" min="0"
                                                            placeholder="{{ translateKeyword('daily-rides-target') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group col-4">
                                                    <label for="weekly_target"
                                                        class="col-xs-12 col-form-label">{{ translateKeyword('weekly-rides-target') }}</label>
                                                    <div class="col-xs-12">
                                                        <input class="form-control" type="text"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ Setting::get('weekly_target', '0') }}"
                                                            id="weekly_target" name="weekly_target" min="0"
                                                            placeholder="{{ translateKeyword('weekly-rides-target') }}">
                                                    </div>
                                                </div>

                                                <div class="col-4"></div>




                                                <div class="form-group col-4">
                                                    <div class="col-xs-12">
                                                        <label for="surge-peaks" class="col-form-label">
                                                            {{ translateKeyword('surge-peak-switch') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <input @if (Setting::get('surge_peak_switch') == 1) checked @endif
                                                            name="surge_peak_switch" id="surge_peak_switch"
                                                            type="checkbox" class="js-switch"
                                                            onchange="surgepeakselect()" data-color="#43b968">
                                                    </div>
                                                </div>

                                                <div class="col-4"></div>

                                                <div id="surge_peaks" class="row"
                                                    @if (Setting::get('surge_peak_switch') == 0) style="display: none;" @endif>

                                                    <div class="form-group col-6">
                                                        <label for="surge_trigger"
                                                            class="col-xs-12 col-form-label">{{ translateKeyword('surge_trigger_point') }}</label>
                                                        <div class="col-xs-12">
                                                            <input class="form-control" type="text"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                value="{{ Setting::get('surge_trigger', '') }}"
                                                                id="surge_trigger" name="surge_trigger" min="0"
                                                                placeholder="{{ translateKeyword('surge_trigger_point') }}"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label for="surge_percentage"
                                                            class="col-xs-12 col-form-label">{{ translateKeyword('surge-percentage(%)') }}</label>
                                                        <div class="col-xs-12">
                                                            <input class="form-control" type="text"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                value="{{ Setting::get('surge_percentage', '0') }}"
                                                                id="surge_percentage" name="surge_percentage"
                                                                min="0" max="100"
                                                                placeholder="{{ translateKeyword('surge-percentage(%)') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4"></div>
                                                <div class="form-group col-4">
                                                    <div class="col-xs-12">
                                                        <label for="government-charges" class="col-form-label">
                                                            {{ translateKeyword('government-charges') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <input @if (Setting::get('government_charges') == 1) checked @endif
                                                            name="government_charges" id="government_charges"
                                                            type="checkbox" class="js-switch"
                                                            onchange="governmentcharges()" data-color="#43b968">
                                                    </div>
                                                </div>

                                                <div id="government_charges_div" class="col-4"
                                                    @if (Setting::get('government_charges') == 0) style="display: none;" @endif>




                                                    <div class="form-group col-12">
                                                        <label for="government_charges_value"
                                                            class="col-xs-12 col-form-label">{{ translateKeyword('government-charges-value') }}</label>
                                                        <div class="col-xs-12">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('government_charges_value', '') }}"
                                                                id="government_charges_value"
                                                                name="government_charges_value" min="0"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                max="100"
                                                                placeholder="{{ translateKeyword('government-charges-value') }}"
                                                                required>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="col-4"></div>



                                                <div class="form-group col-4">
                                                    <div class="col-xs-12">
                                                        <label for="bank-charges" class="col-form-label">
                                                            {{ translateKeyword('bank_charges_price') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <input @if (Setting::get('bank_charges') == 1) checked @endif
                                                            name="bank_charges" id="bank_charges" type="checkbox"
                                                            class="js-switch" onchange="bankcharges()"
                                                            data-color="#43b968">
                                                    </div>
                                                </div>

                                                <div id="bank_charges_div" class="row"
                                                    @if (Setting::get('bank_charges') == 0) style="display: none;" @endif>

                                                    <div class="form-group col-6">
                                                        <label for="bank_charges_type"
                                                            class="col-xs-12 col-form-label">{{ translateKeyword('bank-charges-type') }}</label>
                                                        <div class="col-xs-12">
                                                            <select name="bank_charges_type" class="form-control">
                                                                <option @if (Setting::get('bank_charges_type', 'percentage') == 'fixed') selected @endif
                                                                    value="fixed"> {{ translateKeyword('fixed') }}
                                                                </option>
                                                                <option @if (Setting::get('bank_charges_type', 'percentage') == 'percentage') selected @endif
                                                                    value="percentage">
                                                                    {{ translateKeyword('percentage') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>




                                                    <div class="form-group col-6">
                                                        <label for="bank_charges_value"
                                                            class="col-xs-12 col-form-label">{{ translateKeyword('bank-charges-value') }}</label>
                                                        <div class="col-xs-12">
                                                            <input class="form-control" type="text"
                                                                value="{{ Setting::get('bank_charges_value', '0') }}"
                                                                id="bank_charges_value" name="bank_charges_value"
                                                                min="0"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                                max="100"
                                                                placeholder="{{ translateKeyword('bank-charges-value') }}"
                                                                required>
                                                        </div>
                                                    </div>


                                                </div>






                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            @if ($edit_permission == 1)
                                <div class="col-4 mt-2-dis mb-4">
                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{ translateKeyword('update-payment-settings') }}</button>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="col-12">

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://bootstrapformhelpers.com/assets/js/bootstrap.min.js"></script>
    <script src="https://bootstrapformhelpers.com/assets/js/bootstrap-formhelpers.min.js"></script>
    <script type="text/javascript">
        function cardselect() {
            if ($('#stripe_check').is(":checked")) {
                $("#card_field").fadeIn(700);
            } else {
                $("#card_field").fadeOut(700);
            }
        }

        function mercadoselect() {
            if ($('#mercado_check').is(":checked")) {
                $("#mercado_field").fadeIn(700);
            } else {
                $("#mercado_field").fadeOut(700);
            }
        }

        function epaycoselect() {
            if ($('#epayco_check').is(":checked")) {
                $("#epayco_field").fadeIn(700);
            } else {
                $("#epayco_field").fadeOut(700);
            }
        }

        function paydunyaselect() {
            if ($('#paydunya_check').is(":checked")) {
                $("#paydunya_field").fadeIn(700);
            } else {
                $("#paydunya_field").fadeOut(700);
            }
        }

        function mtnselect() {
            if ($('#mtn_check').is(":checked")) {
                $("#mtn_field").fadeIn(700);
            } else {
                $("#mtn_field").fadeOut(700);
            }
        }

        function arakaselect() {
            if ($('#araka_check').is(":checked")) {
                $("#araka_field").fadeIn(700);
            } else {
                $("#araka_field").fadeOut(700);
            }
        }

        function fathoorahselect() {
            if ($('#fathoorah_check').is(":checked")) {
                $("#fathoorah_field").fadeIn(700);
            } else {
                $("#fathoorah_field").fadeOut(700);
            }
        }

        function upiselect() {
            if ($('#upi_check').is(":checked")) {
                $("#upi_field").fadeIn(700);
            } else {
                $("#upi_field").fadeOut(700);
            }
        }

        function razorselect() {
            if ($('#razor_check').is(":checked")) {
                $("#razor_field").fadeIn(700);
            } else {
                $("#razor_field").fadeOut(700);
            }
        }

        function payuselect() {
            if ($('#payu_check').is(":checked")) {
                $("#payu_field").fadeIn(700);
            } else {
                $("#payu_field").fadeOut(700);
            }

        }

        function payuswitchselect() {
            if ($('#payu_switch_check').is(":checked")) {
                $("#payu_switch_field").fadeIn(700);
            } else {
                $("#payu_switch_field").fadeOut(700);
            }

        }

        function stcselect() {
            if ($('#stc_check').is(":checked")) {
                $("#stc_field").fadeIn(700);
            } else {
                $("#stc_field").fadeOut(700);
            }

        }

        function paymobselect() {
            if ($('#pay_mob').is(":checked")) {
                $("#paymob_field").fadeIn(700);
            } else {
                $("#paymob_field").fadeOut(700);
            }

        }

        // function admobselect(){
        //     if ($('#ad_mob').is(":checked")) {
        //         $("#admob_field").fadeIn(700);
        //     } else {
        //         $("#admob_field").fadeOut(700);
        //     }

        // }

        function paypalselect() {
            if ($('#paypal_check').is(":checked")) {
                $("#paypal_field").fadeIn(700);
            } else {
                $("#paypal_field").fadeOut(700);
            }
        }

        function mlajanselect() {
            if ($('#mlajan_check').is(":checked")) {
                $("#mlajan_field").fadeIn(700);
            } else {
                $("#mlajan_field").fadeOut(700);
            }
        }

        function raveselect() {
            if ($('#rave_check').is(":checked")) {
                $("#rave_field").fadeIn(700);
            } else {
                $("#rave_field").fadeOut(700);
            }
        }

        function commissionselect() {
            if ($('#commission_deduction').is(":checked")) {
                $("#commission_fields").fadeIn(700);
                $('#commission_percentage').attr('required', true);
            } else {
                $("#commission_fields").fadeOut(700);
                $('#commission_percentage').removeAttr('required');
            }
        }


        function surgepeakselect() {
            if ($('#surge_peak_switch').is(":checked")) {
                $("#surge_peaks").fadeIn(700);
                $('#surge_trigger').attr('required', true);
                $('#surge_percentage').attr('required', true);
            } else {
                $("#surge_peaks").fadeOut(700);
                $('#surge_trigger').removeAttr('required');
                $('#surge_percentage').removeAttr('required');
            }
        }

        function governmentcharges() {
            if ($('#government_charges').is(":checked")) {
                $("#government_charges_div").fadeIn(700);
                $('#government_charges_value').attr('required', true);
            } else {
                $("#government_charges_div").fadeOut(700);
                $('#government_charges_value').removeAttr('required');
            }
        }

        function bankcharges() {
            if ($('#bank_charges').is(":checked")) {
                $("#bank_charges_div").fadeIn(700);
                $('#bank_charges_value').attr('required', true);
            } else {
                $("#bank_charges_div").fadeOut(700);
                $('#bank_charges_value').removeAttr('required');
            }
        }

        function commissiondeductionblockageproviderwallet() {
            if ($('#driver_wallet_threshold').is(":checked")) {
                $("#commission_deduction_provider_wallet").fadeIn(700);
                $("#provider_wallet_threshold").attr('required', true);
            } else {
                $("#commission_deduction_provider_wallet").fadeOut(700);
                $("#provider_wallet_threshold").removeAttr('required');
            }
        }

        function commissiondeductionblockageprovidermanagedaccount() {
            if ($('#commission_deduction_account_driver').is(":checked")) {
                $("#commission_deduction_provider_managed_account").fadeIn(700);
            } else {
                $("#commission_deduction_provider_managed_account").fadeOut(700);
            }
        }

        function commissiondeductionwallet() {
            if ($('#commission_deduction_account_driver').is(":checked")) {
                $('#commission_deduction_account_driver').click();
            }
            if ($('#commission_deduction_wallet_blockage').is(":checked")) {
                $('#commission_deduction_wallet_blockage').click();
            }
        }

        function commissiondeductionfare() {
            if ($('#commission_deduction_wallet_driver').is(":checked")) {
                $('#commission_deduction_wallet_driver').click();
            }
            if ($('#commission_deduction_wallet_blockage').is(":checked")) {
                $('#commission_deduction_wallet_blockage').click();
            }
        }
    </script>
@endsection
