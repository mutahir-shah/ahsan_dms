@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Apps Settings ')

@section('content')
    <style>
        .panel {
            height: fit-content;
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
    </style>



    <div class="content-wrapper">
        <div class="container-fluid">
            @include('common.notify')
            <form class="form-horizontal" action="{{ route('admin.settings.appsetting.store') }}" method="POST"
                enctype="multipart/form-data" role="form">
                {{ csrf_field() }}


                <div class="panel-group row p-2" id="accordion" role="tablist" aria-multiselectable="true">


                    <div class="col-6">
                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading51">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse51" aria-expanded="false" aria-controls="collapse51">
                                        {{ translateKeyword('auth-controls-section') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse51" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading51">
                                <div class="panel-body row">
                                    <br />

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('disable-driver-login') }}

                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_login_disable') == 1) checked @endif
                                                name="driver_login_disable" id="driver_login_disable" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('disable-driver-signUp') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_signup_disable') == 1) checked @endif
                                                name="driver_signup_disable" id="driver_signup_disable" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-whatsApp-signUp') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_whatsapp_button') == 1) checked @endif
                                                name="driver_whatsapp_button" id="driver_whatsapp_button" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('disable-user-login') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('user_login_disable') == 1) checked @endif
                                                name="user_login_disable" id="user_login_disable" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('disable-user-signup') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('user_signup_disable') == 1) checked @endif
                                                name="user_signup_disable" id="user_signup_disable" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        {{ translateKeyword('chat') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingThree">
                                <div class="panel-body row">
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('facebook-chat') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('fb_chat') == 1) checked @endif name="fb_chat"
                                                id="fb_chat" onchange="fb_chat_select()" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group row" id="fb_chat_fields"
                                        @if (Setting::get('fb_chat') == 0) style="display:none;" @endif>
                                        <label for="fb_chat_page_id"
                                            class="col-xs-2 col-form-label">{{ translateKeyword('facebook-page-id') }}</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('fb_chat_page_id', '') }}" name="fb_chat_page_id"
                                                id="fb_chat_page_id" placeholder="Facebook Page ID">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseOneNew" aria-expanded="false" aria-controls="collapseOneNew">
                                        {{ translateKeyword('manage-cards') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOneNew" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingOne">
                                <div class="panel-body row">
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="manage_card_driver" class="col-form-label">
                                                {{ translateKeyword('manage-card-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('manage_card_driver') == 1) checked @endif
                                                name="manage_card_driver" id="manage_card_driver" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-7 col-form-label">
                                            <label for="manage_card_passenger" class="col-form-label">
                                                {{ translateKeyword('manage-card-passenger') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-5">
                                            <input @if (Setting::get('manage_card_passenger') == 1) checked @endif
                                                name="manage_card_passenger" id="manage_card_passenger" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading77">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse77" aria-expanded="false" aria-controls="collapse77">
                                        {{ translateKeyword('faqs') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse77" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading7">
                                <div class="panel-body row">

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('rider-FAQs') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('rider_faq') == 1) checked @endif name="rider_faq"
                                                id="rider_faq" onchange="" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-FAQs') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_faq') == 1) checked @endif name="driver_faq"
                                                id="driver_faq" onchange="" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="headingFive">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        {{ translateKeyword('general-settings') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingFive">
                                <div class="panel-body row">
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('app-maintenance') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('appmaintain') == 1) checked @endif name="appmaintain"
                                                id="appmaintain" onchange="appmaintainselect()" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('app-auth-preset') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('app_auth_preset') == 1) checked @endif
                                                name="app_auth_preset" id="app_auth_preset" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div id="appmaintain_div" class="col-12 mb-3"
                                        @if (Setting::get('appmaintain') == 0) style="display: none;" @endif>
                                        <div class="form-group col-6">
                                            <label for=""
                                                class="col-xs-12 col-form-label">{{ translateKeyword('add-maintinance-note') }}</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text"
                                                    value="{{ Setting::get('app_maintenance', '') }}"
                                                    name="app_maintenance" id="app_maintenance"
                                                    placeholder="Enter App Maintinance note " value="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('add-destination-later') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('add_destination_later') == 1) checked @endif
                                                name="add_destination_later" id="add_destination_later" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('address-user') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('address_user') == 1) checked @endif name="address_user"
                                                id="address_user" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('address-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('address_driver') == 1) checked @endif name="address_driver"
                                                id="address_driver" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="booking_pre_payment" class="col-form-label">
                                                {{ translateKeyword('booking-pre-payment-from-card') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('booking_pre_payment') == 1) checked @endif
                                                name="booking_pre_payment" id="booking_pre_payment" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>



                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="" class="col-form-label">
                                                {{ translateKeyword('booking-method-only') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('booking_prepayment_method') == 1) checked @endif
                                                name="booking_prepayment_method" id="booking_prepayment_method"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('booking-service-fee') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('booking_fee') == 1) checked @endif name="booking_fee"
                                                id="booking_fee" onchange="bookingfeeselect()" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    <div id="booking_fee_div" class="col-12"
                                        @if (Setting::get('booking_fee') == 0) style="display: none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="booking_fee_category"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('booking-fee-category') }}</label>
                                                <div class="col-xs-12">
                                                    <select name="booking_fee_category" class="form-control" required>
                                                        <option @if (Setting::get('booking_fee_category', 'global') == 'global') selected @endif
                                                            value="global"> {{ translateKeyword('global') }}
                                                        </option>
                                                        <option @if (Setting::get('booking_fee_category', 'global') == 'service') selected @endif
                                                            value="service"> {{ translateKeyword('service-wise') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group row">
                                                    <label for="booking_fee_type" class="col-xs-2 col-form-label">Commission
                                                        Type</label>
                                                    <div class="col-xs-10">
                                                        <select name="booking_fee_type" class="form-control">
                                                            <option value="fixed"> Fixed
                                                            </option>
                                                            <option value="percentage"> Percentage
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div> --}}
                                            <div class="form-group col-6">
                                                <label for="" class="col-xs-12 col-form-label">
                                                    {{ translateKeyword('booking-fee') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('booking_fee_amount', '') }}"
                                                        name="booking_fee_amount" id="booking_fee_amount"
                                                        placeholder=" Fee Amount" value="0">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('block-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('block_driver') == 1) checked @endif name="block_driver"
                                                id="block_driver" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('block-user') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('block_user') == 1) checked @endif name="block_user"
                                                id="block_user" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('broadcast-jobs-to-all-providers--simultaneously') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('broadcast_request_all') == 1) checked @endif
                                                name="broadcast_request_all" id="broadcast_request_all" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('cancel-ride-from-passenger') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cancel_ride_passenger') == 1) checked @endif
                                                name="cancel_ride_passenger" id="cancel_ride_passenger" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('code-based-job-request-to-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('code_base_job_req') == 1) checked @endif
                                                name="code_base_job_req" id="code_base_job_req" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-code-signup') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_code_signup') == 1) checked @endif
                                                name="driver_code_signup" id="driver_code_signup" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('call-option-on-ride-start') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('call_option_ride_start') == 1) checked @endif
                                                name="call_option_ride_start" id="call_option_ride_start" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('chat-option-on-ride-start') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('chat_option_ride_start') == 1) checked @endif
                                                name="chat_option_ride_start" id="chat_option_ride_start" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('customer-vehicle-info') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('customer_vehicle_info') == 1) checked @endif
                                                name="customer_vehicle_info" id="customer_vehicle_info" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('customer-pick-up-location-visibility-to-provider') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('pickup_location') == 1) checked @endif
                                                name="pickup_location" id="pickup_location" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('customer-drop-off-location-visibility-to-provider') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('dropoff_location') == 1) checked @endif
                                                name="dropoff_location" id="dropoff_location" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('cancellation-jobs-blockage') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cancellation_jobs_blockage') == 1) checked @endif
                                                name="cancellation_jobs_blockage" id="cancellation_jobs_blockage"
                                                onchange="cancellationjobsblockage()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div id="cancellation_jobs_blockage_div" class="col-12"
                                        @if (Setting::get('cancellation_jobs_blockage') == 0) style="display: none;" @endif>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('cancellation-jobs-limit') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('cancellation_jobs_limit', '') }}"
                                                        name="cancellation_jobs_limit" id="cancellation_jobs_limit"
                                                        placeholder="{{ translateKeyword('cancellation-jobs-limit') }}"
                                                        value="1" min="1">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('cancellation-jobs-days') }}</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('cancellation_jobs_days', '') }}"
                                                        name="cancellation_jobs_days" id="cancellation_jobs_days"
                                                        placeholder="{{ translateKeyword('cancellation-jobs-days') }}"
                                                        value="1" min="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="map_key"
                                            class="col-xs-5 col-form-label">{{ translateKeyword('country-code') }}</label>
                                        <div class="col-xs-7">
                                            <select class="form-control" id="country_code" name="country_code">
                                                <option @if (Setting::get('country_code') === '') selected @endif value="">
                                                    Worldwide
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AF') selected @endif value="AF">
                                                    Afghanistan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AX') selected @endif value="AX">
                                                    Aland Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AL') selected @endif value="AL">
                                                    Albania
                                                </option>
                                                <option @if (Setting::get('country_code') === 'DZ') selected @endif value="DZ">
                                                    Algeria
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AS') selected @endif value="AS">
                                                    American Samoa
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AD') selected @endif value="AD">
                                                    Andorra
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AO') selected @endif value="AO">
                                                    Angola
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AI') selected @endif value="AI">
                                                    Anguilla
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AQ') selected @endif value="AQ">
                                                    Antarctica
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AG') selected @endif value="AG">
                                                    Antigua and
                                                    Barbuda
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AR') selected @endif value="AR">
                                                    Argentina
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AM') selected @endif value="AM">
                                                    Armenia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AW') selected @endif value="AW">
                                                    Aruba
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AU') selected @endif value="AU">
                                                    Australia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AT') selected @endif value="AT">
                                                    Austria
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AZ') selected @endif value="AZ">
                                                    Azerbaijan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BS') selected @endif value="BS">
                                                    Bahamas
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BH') selected @endif value="BH">
                                                    Bahrain
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BD') selected @endif value="BD">
                                                    Bangladesh
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BB') selected @endif value="BB">
                                                    Barbados
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BY') selected @endif value="BY">
                                                    Belarus
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BE') selected @endif value="BE">
                                                    Belgium
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BZ') selected @endif value="BZ">
                                                    Belize
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BJ') selected @endif value="BJ">
                                                    Benin
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BM') selected @endif value="BM">
                                                    Bermuda
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BT') selected @endif value="BT">
                                                    Bhutan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BO') selected @endif value="BO">
                                                    Bolivia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BQ') selected @endif value="BQ">
                                                    Bonaire, Sint
                                                    Eustatius and Saba
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BA') selected @endif value="BA">
                                                    Bosnia and
                                                    Herzegovina
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BW') selected @endif value="BW">
                                                    Botswana
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BV') selected @endif value="BV">
                                                    Bouvet Island
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BR') selected @endif value="BR">
                                                    Brazil
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IO') selected @endif value="IO">
                                                    British Indian
                                                    Ocean Territory
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BN') selected @endif value="BN">
                                                    Brunei
                                                    Darussalam
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BG') selected @endif value="BG">
                                                    Bulgaria
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BF') selected @endif value="BF">
                                                    Burkina Faso
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BI') selected @endif value="BI">
                                                    Burundi
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KH') selected @endif value="KH">
                                                    Cambodia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CM') selected @endif value="CM">
                                                    Cameroon
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CA') selected @endif value="CA">
                                                    Canada
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CV') selected @endif value="CV">
                                                    Cape Verde
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KY') selected @endif value="KY">
                                                    Cayman Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CF') selected @endif value="CF">
                                                    Central African
                                                    Republic
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TD') selected @endif value="TD">
                                                    Chad
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CL') selected @endif value="CL">
                                                    Chile
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CN') selected @endif value="CN">
                                                    China
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CX') selected @endif value="CX">
                                                    Christmas Island
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CC') selected @endif value="CC">
                                                    Cocos (Keeling)
                                                    Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CO') selected @endif value="CO">
                                                    Colombia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KM') selected @endif value="KM">
                                                    Comoros
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CG') selected @endif value="CG">
                                                    Congo
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CD') selected @endif value="CD">
                                                    Congo,
                                                    Democratic Republic of the Congo
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CK') selected @endif value="CK">
                                                    Cook Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CR') selected @endif value="CR">
                                                    Costa Rica
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CI') selected @endif value="CI">
                                                    Cote D'Ivoire
                                                </option>
                                                <option @if (Setting::get('country_code') === 'HR') selected @endif value="HR">
                                                    Croatia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CU') selected @endif value="CU">
                                                    Cuba
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CW') selected @endif value="CW">
                                                    Curacao
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CY') selected @endif value="CY">
                                                    Cyprus
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CZ') selected @endif value="CZ">
                                                    Czech Republic
                                                </option>
                                                <option @if (Setting::get('country_code') === 'DK') selected @endif value="DK">
                                                    Denmark
                                                </option>
                                                <option @if (Setting::get('country_code') === 'DJ') selected @endif value="DJ">
                                                    Djibouti
                                                </option>
                                                <option @if (Setting::get('country_code') === 'DM') selected @endif value="DM">
                                                    Dominica
                                                </option>
                                                <option @if (Setting::get('country_code') === 'DO') selected @endif
                                                    value="DO">
                                                    Dominican
                                                    Republic
                                                </option>
                                                <option @if (Setting::get('country_code') === 'EC') selected @endif
                                                    value="EC">
                                                    Ecuador
                                                </option>
                                                <option @if (Setting::get('country_code') === 'EG') selected @endif
                                                    value="EG">
                                                    Egypt
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SV') selected @endif
                                                    value="SV">
                                                    El Salvador
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GQ') selected @endif
                                                    value="GQ">
                                                    Equatorial
                                                    Guinea
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ER') selected @endif
                                                    value="ER">
                                                    Eritrea
                                                </option>
                                                <option @if (Setting::get('country_code') === 'EE') selected @endif
                                                    value="EE">
                                                    Estonia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ET') selected @endif
                                                    value="ET">
                                                    Ethiopia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'FK') selected @endif
                                                    value="FK">
                                                    Falkland Islands
                                                    (Malvinas)
                                                </option>
                                                <option @if (Setting::get('country_code') === 'FO') selected @endif
                                                    value="FO">
                                                    Faroe Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'FJ') selected @endif
                                                    value="FJ">
                                                    Fiji
                                                </option>
                                                <option @if (Setting::get('country_code') === 'FI') selected @endif
                                                    value="FI">
                                                    Finland
                                                </option>
                                                <option @if (Setting::get('country_code') === 'FR') selected @endif
                                                    value="FR">
                                                    France
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GF') selected @endif
                                                    value="GF">
                                                    French Guiana
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PF') selected @endif
                                                    value="PF">
                                                    French Polynesia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TF') selected @endif
                                                    value="TF">
                                                    French Southern
                                                    Territories
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GA') selected @endif
                                                    value="GA">
                                                    Gabon
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GM') selected @endif
                                                    value="GM">
                                                    Gambia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GE') selected @endif
                                                    value="GE">
                                                    Georgia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'DE') selected @endif
                                                    value="DE">Germany
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GH') selected @endif
                                                    value="GH">Ghana
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GI') selected @endif
                                                    value="GI">Gibraltar
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GR') selected @endif
                                                    value="GR">Greece
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GL') selected @endif
                                                    value="GL">Greenland
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GD') selected @endif
                                                    value="GD">Grenada
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GP') selected @endif
                                                    value="GP">Guadeloupe
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GU') selected @endif
                                                    value="GU">Guam
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GT') selected @endif
                                                    value="GT">Guatemala
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GG') selected @endif
                                                    value="GG">Guernsey
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GN') selected @endif
                                                    value="GN">Guinea
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GW') selected @endif
                                                    value="GW">Guinea-Bissau
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GY') selected @endif
                                                    value="GY">Guyana
                                                </option>
                                                <option @if (Setting::get('country_code') === 'HT') selected @endif
                                                    value="HT">Haiti
                                                </option>
                                                <option @if (Setting::get('country_code') === 'HM') selected @endif
                                                    value="HM">Heard Island
                                                    and Mcdonald Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'VA') selected @endif
                                                    value="VA">Holy See
                                                    (Vatican City State)
                                                </option>
                                                <option @if (Setting::get('country_code') === 'HN') selected @endif
                                                    value="HN">Honduras
                                                </option>
                                                <option @if (Setting::get('country_code') === 'HK') selected @endif
                                                    value="HK">Hong Kong
                                                </option>
                                                <option @if (Setting::get('country_code') === 'HU') selected @endif
                                                    value="HU">Hungary
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IS') selected @endif
                                                    value="IS">Iceland
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IN') selected @endif
                                                    value="IN">India
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ID') selected @endif
                                                    value="ID">Indonesia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IR') selected @endif
                                                    value="IR">Iran, Islamic
                                                    Republic of
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IQ') selected @endif
                                                    value="IQ">Iraq
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IE') selected @endif
                                                    value="IE">Ireland
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IM') selected @endif
                                                    value="IM">Isle of Man
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IL') selected @endif
                                                    value="IL">Israel
                                                </option>
                                                <option @if (Setting::get('country_code') === 'IT') selected @endif
                                                    value="IT">Italy
                                                </option>
                                                <option @if (Setting::get('country_code') === 'JM') selected @endif
                                                    value="JM">Jamaica
                                                </option>
                                                <option @if (Setting::get('country_code') === 'JP') selected @endif
                                                    value="JP">Japan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'JE') selected @endif
                                                    value="JE">Jersey
                                                </option>
                                                <option @if (Setting::get('country_code') === 'JO') selected @endif
                                                    value="JO">Jordan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KZ') selected @endif
                                                    value="KZ">Kazakhstan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KE') selected @endif
                                                    value="KE">Kenya
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KI') selected @endif
                                                    value="KI">Kiribati
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KP') selected @endif
                                                    value="KP">Korea,
                                                    Democratic People's Republic of
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KR') selected @endif
                                                    value="KR">Korea,
                                                    Republic of
                                                </option>
                                                <option @if (Setting::get('country_code') === 'XK') selected @endif
                                                    value="XK">Kosovo
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KW') selected @endif
                                                    value="KW">Kuwait
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KG') selected @endif
                                                    value="KG">Kyrgyzstan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LA') selected @endif
                                                    value="LA">Lao People's
                                                    Democratic Republic
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LV') selected @endif
                                                    value="LV">Latvia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LB') selected @endif
                                                    value="LB">Lebanon
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LS') selected @endif
                                                    value="LS">Lesotho
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LR') selected @endif
                                                    value="LR">Liberia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LY') selected @endif
                                                    value="LY">Libyan Arab
                                                    Jamahiriya
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LI') selected @endif
                                                    value="LI">Liechtenstein
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LT') selected @endif
                                                    value="LT">Lithuania
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LU') selected @endif
                                                    value="LU">Luxembourg
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MO') selected @endif
                                                    value="MO">Macao
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MK') selected @endif
                                                    value="MK">Macedonia, the
                                                    Former Yugoslav Republic of
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MG') selected @endif
                                                    value="MG">Madagascar
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MW') selected @endif
                                                    value="MW">Malawi
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MY') selected @endif
                                                    value="MY">Malaysia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MV') selected @endif
                                                    value="MV">Maldives
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ML') selected @endif
                                                    value="ML">Mali
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MT') selected @endif
                                                    value="MT">Malta
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MH') selected @endif
                                                    value="MH">Marshall
                                                    Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MQ') selected @endif
                                                    value="MQ">Martinique
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MR') selected @endif
                                                    value="MR">Mauritania
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MU') selected @endif
                                                    value="MU">Mauritius
                                                </option>
                                                <option @if (Setting::get('country_code') === 'YT') selected @endif
                                                    value="YT">Mayotte
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MX') selected @endif
                                                    value="MX">Mexico
                                                </option>
                                                <option @if (Setting::get('country_code') === 'FM') selected @endif
                                                    value="FM">Micronesia,
                                                    Federated States of
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MD') selected @endif
                                                    value="MD">Moldova,
                                                    Republic of
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MC') selected @endif
                                                    value="MC">Monaco
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MN') selected @endif
                                                    value="MN">Mongolia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ME') selected @endif
                                                    value="ME">Montenegro
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MS') selected @endif
                                                    value="MS">Montserrat
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MA') selected @endif
                                                    value="MA">Morocco
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MZ') selected @endif
                                                    value="MZ">Mozambique
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MM') selected @endif
                                                    value="MM">Myanmar
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NA') selected @endif
                                                    value="NA">Namibia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NR') selected @endif
                                                    value="NR">Nauru
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NP') selected @endif
                                                    value="NP">Nepal
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NL') selected @endif
                                                    value="NL">Netherlands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AN') selected @endif
                                                    value="AN">Netherlands
                                                    Antilles
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NC') selected @endif
                                                    value="NC">New Caledonia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NZ') selected @endif
                                                    value="NZ">New Zealand
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NI') selected @endif
                                                    value="NI">Nicaragua
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NE') selected @endif
                                                    value="NE">Niger
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NG') selected @endif
                                                    value="NG">Nigeria
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NU') selected @endif
                                                    value="NU">Niue
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NF') selected @endif
                                                    value="NF">Norfolk Island
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MP') selected @endif
                                                    value="MP">Northern
                                                    Mariana Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'NO') selected @endif
                                                    value="NO">Norway
                                                </option>
                                                <option @if (Setting::get('country_code') === 'OM') selected @endif
                                                    value="OM">Oman
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PK') selected @endif
                                                    value="PK">Pakistan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PW') selected @endif
                                                    value="PW">Palau
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PS') selected @endif
                                                    value="PS">Palestinian
                                                    Territory, Occupied
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PA') selected @endif
                                                    value="PA">Panama
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PG') selected @endif
                                                    value="PG">Papua New
                                                    Guinea
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PY') selected @endif
                                                    value="PY">Paraguay
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PE') selected @endif
                                                    value="PE">Peru
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PH') selected @endif
                                                    value="PH">Philippines
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PN') selected @endif
                                                    value="PN">Pitcairn
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PL') selected @endif
                                                    value="PL">Poland
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PT') selected @endif
                                                    value="PT">Portugal
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PR') selected @endif
                                                    value="PR">Puerto Rico
                                                </option>
                                                <option @if (Setting::get('country_code') === 'QA') selected @endif
                                                    value="QA">Qatar
                                                </option>
                                                <option @if (Setting::get('country_code') === 'RE') selected @endif
                                                    value="RE">Reunion
                                                </option>
                                                <option @if (Setting::get('country_code') === 'RO') selected @endif
                                                    value="RO">Romania
                                                </option>
                                                <option @if (Setting::get('country_code') === 'RU') selected @endif
                                                    value="RU">Russian
                                                    Federation
                                                </option>
                                                <option @if (Setting::get('country_code') === 'RW') selected @endif
                                                    value="RW">Rwanda
                                                </option>
                                                <option @if (Setting::get('country_code') === 'BL') selected @endif
                                                    value="BL">Saint
                                                    Barthelemy
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SH') selected @endif
                                                    value="SH">Saint Helena
                                                </option>
                                                <option @if (Setting::get('country_code') === 'KN') selected @endif
                                                    value="KN">Saint Kitts
                                                    and Nevis
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LC') selected @endif
                                                    value="LC">Saint Lucia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'MF') selected @endif
                                                    value="MF">Saint Martin
                                                </option>
                                                <option @if (Setting::get('country_code') === 'PM') selected @endif
                                                    value="PM">Saint Pierre
                                                    and Miquelon
                                                </option>
                                                <option @if (Setting::get('country_code') === 'VC') selected @endif
                                                    value="VC">Saint Vincent
                                                    and the Grenadines
                                                </option>
                                                <option @if (Setting::get('country_code') === 'WS') selected @endif
                                                    value="WS">Samoa
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SM') selected @endif
                                                    value="SM">San Marino
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ST') selected @endif
                                                    value="ST">Sao Tome and
                                                    Principe
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SA') selected @endif
                                                    value="SA">Saudi Arabia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SN') selected @endif
                                                    value="SN">Senegal
                                                </option>
                                                <option @if (Setting::get('country_code') === 'RS') selected @endif
                                                    value="RS">Serbia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CS') selected @endif
                                                    value="CS">Serbia and
                                                    Montenegro
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SC') selected @endif
                                                    value="SC">Seychelles
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SL') selected @endif
                                                    value="SL">Sierra Leone
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SG') selected @endif
                                                    value="SG">Singapore
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SX') selected @endif
                                                    value="SX">Sint Maarten
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SK') selected @endif
                                                    value="SK">Slovakia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SI') selected @endif
                                                    value="SI">Slovenia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SB') selected @endif
                                                    value="SB">Solomon
                                                    Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SO') selected @endif
                                                    value="SO">Somalia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ZA') selected @endif
                                                    value="ZA">South Africa
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GS') selected @endif
                                                    value="GS">South Georgia
                                                    and the South Sandwich Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SS') selected @endif
                                                    value="SS">South Sudan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ES') selected @endif
                                                    value="ES">Spain
                                                </option>
                                                <option @if (Setting::get('country_code') === 'LK') selected @endif
                                                    value="LK">Sri Lanka
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SD') selected @endif
                                                    value="SD">Sudan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SR') selected @endif
                                                    value="SR">Suriname
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SJ') selected @endif
                                                    value="SJ">Svalbard and
                                                    Jan Mayen
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SZ') selected @endif
                                                    value="SZ">Swaziland
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SE') selected @endif
                                                    value="SE">Sweden
                                                </option>
                                                <option @if (Setting::get('country_code') === 'CH') selected @endif
                                                    value="CH">Switzerland
                                                </option>
                                                <option @if (Setting::get('country_code') === 'SY') selected @endif
                                                    value="SY">Syrian Arab
                                                    Republic
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TW') selected @endif
                                                    value="TW">Taiwan,
                                                    Province of China
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TJ') selected @endif
                                                    value="TJ">Tajikistan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TZ') selected @endif
                                                    value="TZ">Tanzania,
                                                    United Republic of
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TH') selected @endif
                                                    value="TH">Thailand
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TL') selected @endif
                                                    value="TL">Timor-Leste
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TG') selected @endif
                                                    value="TG">Togo
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TK') selected @endif
                                                    value="TK">Tokelau
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TO') selected @endif
                                                    value="TO">Tonga
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TT') selected @endif
                                                    value="TT">Trinidad and
                                                    Tobago
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TN') selected @endif
                                                    value="TN">Tunisia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TR') selected @endif
                                                    value="TR">Turkey
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TM') selected @endif
                                                    value="TM">Turkmenistan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TC') selected @endif
                                                    value="TC">Turks and
                                                    Caicos Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'TV') selected @endif
                                                    value="TV">Tuvalu
                                                </option>
                                                <option @if (Setting::get('country_code') === 'UG') selected @endif
                                                    value="UG">Uganda
                                                </option>
                                                <option @if (Setting::get('country_code') === 'UA') selected @endif
                                                    value="UA">Ukraine
                                                </option>
                                                <option @if (Setting::get('country_code') === 'AE') selected @endif
                                                    value="AE">United Arab
                                                    Emirates
                                                </option>
                                                <option @if (Setting::get('country_code') === 'GB') selected @endif
                                                    value="GB">United Kingdom
                                                </option>
                                                <option @if (Setting::get('country_code') === 'US') selected @endif
                                                    value="US">United States
                                                </option>
                                                <option @if (Setting::get('country_code') === 'UM') selected @endif
                                                    value="UM">United States
                                                    Minor Outlying Islands
                                                </option>
                                                <option @if (Setting::get('country_code') === 'UY') selected @endif
                                                    value="UY">Uruguay
                                                </option>
                                                <option @if (Setting::get('country_code') === 'UZ') selected @endif
                                                    value="UZ">Uzbekistan
                                                </option>
                                                <option @if (Setting::get('country_code') === 'VU') selected @endif
                                                    value="VU">Vanuatu
                                                </option>
                                                <option @if (Setting::get('country_code') === 'VE') selected @endif
                                                    value="VE">Venezuela
                                                </option>
                                                <option @if (Setting::get('country_code') === 'VN') selected @endif
                                                    value="VN">Viet Nam
                                                </option>
                                                <option @if (Setting::get('country_code') === 'VG') selected @endif
                                                    value="VG">Virgin
                                                    Islands, British
                                                </option>
                                                <option @if (Setting::get('country_code') === 'VI') selected @endif
                                                    value="VI">Virgin
                                                    Islands, U.s.
                                                </option>
                                                <option @if (Setting::get('country_code') === 'WF') selected @endif
                                                    value="WF">Wallis and
                                                    Futuna
                                                </option>
                                                <option @if (Setting::get('country_code') === 'EH') selected @endif
                                                    value="EH">Western Sahara
                                                </option>
                                                <option @if (Setting::get('country_code') === 'YE') selected @endif
                                                    value="YE">Yemen
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ZM') selected @endif
                                                    value="ZM">Zambia
                                                </option>
                                                <option @if (Setting::get('country_code') === 'ZW') selected @endif
                                                    value="ZW">Zimbabwe
                                                </option>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('dont-disturb-user') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('dont_disturb_user') == 1) checked @endif
                                                name="dont_disturb_user" id="dont_disturb_user" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>



                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-ban-on-ride-cancellation') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_ban_ride_cancellation') == 1) checked @endif
                                                name="driver_ban_ride_cancellation" id="driver_ban_ride_cancellation"
                                                onchange="driverbanridecancellation()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('round-value-nearest-ten') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('round_value_nearest_ten') == 1) checked @endif
                                                name="round_value_nearest_ten" id="round_value_nearest_ten"
                                                onchange="driverbanridecancellation()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div id="driver_ban_ride_cancellation_div" class="col-12"
                                        @if (Setting::get('driver_ban_ride_cancellation') == 0) style="display: none;" @endif>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('cancelled-number-of-rides') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('cancelled_number_of_rides', '') }}"
                                                        name="cancelled_number_of_rides" id="cancelled_number_of_rides"
                                                        placeholder="{{ translateKeyword('cancelled-number-of-rides') }}"
                                                        value="1" min="1">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('ban-for-number-of-days') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('ban_number_of_days', '') }}"
                                                        name="ban_number_of_days" id="ban_number_of_days"
                                                        placeholder="{{ translateKeyword('ban-for-number-of-days') }}"
                                                        value="1" min="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('delivery-note/special-note') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('delivery_note') == 1) checked @endif
                                                name="delivery_note" id="delivery_note" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-earning') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_earning') == 1) checked @endif
                                                name="driver_earning" id="driver_earning" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-summary') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_summary') == 1) checked @endif
                                                name="driver_summary" id="driver_summary" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('provider_documents') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_document') == 1) checked @endif
                                                name="driver_document" id="driver_document" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('date-of-birth-user') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('dob_user') == 1) checked @endif name="dob_user"
                                                id="dob_user" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('date of-birth-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('dob_driver') == 1) checked @endif name="dob_driver"
                                                id="dob_driver" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    @if (Setting::get('CARD', 0) == 0)
                                        <div class="form-group col-6">
                                            <div class="col-xs-6 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    {{ translateKeyword('email-field') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input @if (Setting::get('email_field') == 1) checked @endif
                                                    name="email_field" id="email_field" type="checkbox"
                                                    class="js-switch" data-color="#43b968">
                                            </div>

                                        </div>
                                    @endif
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('fleet-manager-address-and-nif') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('fleet_manager_address_nif') == 1) checked @endif
                                                name="fleet_manager_address_nif" id="fleet_manager_address_nif"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('favourite-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('favourite_driver') == 1) checked @endif
                                                name="favourite_driver" id="favourite_driver" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('free-ride') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('free_ride') == 1) checked @endif name="free_ride"
                                                id="free_ride" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="gender" class="col-form-label">
                                                {{ translateKeyword('gender') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('gender') == 1) checked @endif name="gender"
                                                id="gender" type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('gender-preference') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('gender_pref_enabled') == 1) checked @endif
                                                name="gender_pref_enabled" id="gender_pref_enabled" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('gender-preference-at-run-time') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('gender_pref_run_time') == 1) checked @endif
                                                name="gender_pref_run_time" id="gender_pref_run_time" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('gif-splash-ios') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('gif_splash_ios') == 1) checked @endif
                                                name="gif_splash_ios" id="gif_splash_ios" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('invoice') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('invoice') == 1) checked @endif name="invoice"
                                                id="invoice" onchange="invoiceselect()" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    <div id="invoice_div" class="col-12 mb-3"
                                        @if (Setting::get('invoice') == 0) style="display: none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="language_invoice"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('invoice-language') }}</label>
                                                <div class="col-xs-12">
                                                    <select class="form-control" id="language_invoice"
                                                        name="language_invoice">
                                                        {{-- Setting::get('language_invoice') --}}
                                                        @foreach ($languages as $item)
                                                            <option value="{{ $item->name }}" @selected(Setting::get('language_invoice') == $item->name)>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('job-cancellation-deduction') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cancellation_deduction') == 1) checked @endif
                                                name="cancellation_deduction" id="cancellation_deduction"
                                                onchange="cancellationselect()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="col-6"></div>

                                    <div id="cancellation_deduction_div" class="col-12"
                                        @if (Setting::get('cancellation_deduction') == 0) style="display: none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('cancellation-amount') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('cancellation_amount', '') }}"
                                                        name="cancellation_amount" id="cancellation_amount"
                                                        placeholder="{{ translateKeyword('cancellation-amount') }}"
                                                        value="0">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('cancellation-time(in-minutes)') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('cancellation_time', '') }}"
                                                        name="cancellation_time" id="cancellation_time"
                                                        placeholder="{{ translateKeyword('cancellation-time(in-minutes)') }}"
                                                        value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('job-otp') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('ride_otp') == 1) checked @endif name="ride_otp"
                                                id="ride_otp" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="booking_amount_visibility" class="col-form-label">
                                                {{ translateKeyword('job-booking-amount-visibility-to-provider') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('booking_amount_visibility') == 1) checked @endif
                                                name="booking_amount_visibility" id="booking_amount_visibility"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('manage-account') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('manage_account') == 1) checked @endif
                                                name="manage_account" id="manage_account" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('multi-stops') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('multi_stops') == 1) checked @endif name="multi_stops"
                                                id="multi_stops" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('map-pin-location') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('pin_loc_map') == 1) checked @endif name="pin_loc_map"
                                                id="pin_loc_map" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('onlypickup') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('only_pickup') == 1) checked @endif name="only_pickup"
                                                id="only_pickup" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>






                                    <div class="form-group col-6">
                                        <label for="provider_select_timeout"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('provider-job-accept-timeout') }}
                                        </label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="number"
                                                value="{{ Setting::get('provider_select_timeout', '60') }}"
                                                name="provider_select_timeout" required id="provider_select_timeout"
                                                placeholder="Provider Timout">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="provider_search_radius"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('provider-search-radius') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('provider_search_radius', '5') }}"
                                                name="provider_search_radius" required id="provider_search_radius"
                                                placeholder="{{ translateKeyword('provider-search-radius') }}">
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('provider-at-disposal') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_at_disposal') == 1) checked @endif
                                                name="driver_at_disposal" id="driver_at_disposal"
                                                onchange="driveratdisposalselect()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="col-6"></div>


                                    <div id="driver_at_disposal_div" class="col-12 mb-3"
                                        @if (Setting::get('driver_at_disposal') == 0) style="display: none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('enter_phone_number') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('driver_disposal_phone', '') }}"
                                                        name="driver_disposal_phone" id="driver_disposal_phone"
                                                        placeholder="{{ translateKeyword('enter_phone_number') }}"
                                                        value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('promocodes') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('promocode') == 1) checked @endif name="promocode"
                                                id="promocode" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('partner-company-info') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('partner_company_info') == 1) checked @endif
                                                name="partner_company_info" id="partner_company_info" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('provider-single-login') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('provider_single_login') == 1) checked @endif
                                                name="provider_single_login" id="provider_single_login"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('provider-acc-blockage-on-docs(Non-availbility-after-bookings)') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_acc_blockage_doc') == 1) checked @endif
                                                name="driver_acc_blockage_doc" id="driver_acc_blockage_doc"
                                                onchange="driveraccblockageselect()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>


                                    <div id="driver_acc_blockage_doc_div" class="col-12"
                                        @if (Setting::get('driver_acc_blockage_doc') == 0) style="display: none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('enter-number-of-bookings') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('driver_acc_blockage_doc_value', '') }}"
                                                        name="driver_acc_blockage_doc_value"
                                                        id="driver_acc_blockage_doc_value"
                                                        placeholder="{{ translateKeyword('enter-number-of-bookings') }}"
                                                        value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('pre-booking-hourly-hold') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('pre_booking_hourly_hold') == 1) checked @endif
                                                name="pre_booking_hourly_hold" id="pre_booking_hourly_hold"
                                                onchange="prebookinghourly()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="col-4"></div>


                                    <div id="pre_booking_hourly_hold_div" class="col-12"
                                        @if (Setting::get('pre_booking_hourly_hold') == 0) style="display: none;" @endif>

                                       <div class="row">
                                        <div class="form-group col-6">
                                            <label for=""
                                                class="col-xs-12 col-form-label">{{ translateKeyword('first-hold-time-(hrs)') }}</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="number"
                                                    value="{{ Setting::get('first_hold_time', '') }}"
                                                    name="first_hold_time" id="first_hold_time"
                                                    placeholder="{{ translateKeyword('first-hold-time-(hrs)') }}"
                                                    value="1" min="1">
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for=""
                                                class="col-xs-12 col-form-label">{{ translateKeyword('second-hold-time-(hrs)') }}</label>
                                            <div class="col-xs-12">
                                                <input class="form-control" type="number"
                                                    value="{{ Setting::get('second_hold_time', '') }}"
                                                    name="second_hold_time" id="second_hold_time"
                                                    placeholder="{{ translateKeyword('second-hold-time-(hrs)') }}"
                                                    value="1" min="1">
                                            </div>
                                        </div>
                                       </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('provider-pick-up-location-radius') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('pickup_location_radius') == 1) checked @endif
                                                name="pickup_location_radius" id="pickup_location_radius"
                                                onchange="pickupradiusselect()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="col-6"></div>


                                    <div id="pickup_location_radius_div" class="col-12 mb-3"
                                        @if (Setting::get('pickup_location_radius') == 0) style="display: none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('enter-radius') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('pickup_location_radius_value', '') }}"
                                                        name="pickup_location_radius_value"
                                                        id="pickup_location_radius_value"
                                                        placeholder="{{ translateKeyword('enter-radius') }}"
                                                        value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('reward-points-for-customers') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('reward_point_customer') == 1) checked @endif
                                                name="reward_point_customer" id="reward_point_customer"
                                                onchange="rewardpointselect()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="col-6"></div>


                                    <div id="reward_point_customer_div" class="col-12 mb-3"
                                        @if (Setting::get('reward_point_customer') == 0) style="display: none;" @endif>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('reward-percentage') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('reward_percentage', '') }}"
                                                        name="reward_percentage" id="reward_percentage"
                                                        placeholder="{{ translateKeyword('reward-percentage') }}"
                                                        value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('apply-return-trip-pricing') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('return_trip') == 1) checked @endif name="return_trip"
                                                id="return_trip" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="service_time_duration" class="col-form-label">
                                                {{ translateKeyword('service-time-duration') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('service_time_duration') == 1) checked @endif
                                                name="service_time_duration" id="service_time_duration"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('report-images-customer') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('report_images_customer') == 1) checked @endif
                                                name="report_images_customer" id="report_images_customer"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('report-images-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('report_images_driver') == 1) checked @endif
                                                name="report_images_driver" id="report_images_driver" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('round-value-ceiling-floor') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('round_value_ceiling_floor') == 1) checked @endif
                                                name="round_value_ceiling_floor" id="round_value_ceiling_floor"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>



                                    {{-- smtp mailing Switch --}}

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('SMTP-mail') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('smtp_mail') == 1) checked @endif name="smtp_mail"
                                                id="smtp_mail" onchange="smtpmailselect()" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('show-driver-earning-only-on-job-request') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_earning_job_request') == 1) checked @endif
                                                name="driver_earning_job_request" id="driver_earning_job_request"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('show-pending-schedule-jobs-passenger') }}

                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('show_pending_schedule_jobs_passenger') == 1) checked @endif
                                                name="show_pending_schedule_jobs_passenger"
                                                id="show_pending_schedule_jobs_passenger" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('show-pending-schedule-jobs-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('show_pending_schedule_jobs_driver') == 1) checked @endif
                                                name="show_pending_schedule_jobs_driver"
                                                id="show_pending_schedule_jobs_driver" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('show-driver-amount-in-flow') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('show_driver_amount_flow') == 1) checked @endif
                                                name="show_driver_amount_flow" id="show_driver_amount_flow"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('schedule-booking') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('schedule_booking') == 1) checked @endif
                                                name="schedule_booking" id="schedule_booking" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('tool-tax') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('tool_tax') == 1) checked @endif name="tool_tax"
                                                id="tool_tax" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('tip-collection') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('tip_collect') == 1) checked @endif name="tip_collect"
                                                id="tip_collect" onchange="tipselect()" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>


                                    <div id="tip_collect_div" class="col-12 mb-3"
                                        @if (Setting::get('tip_collect') == 0) style="display: none;" @endif>

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('tip-suggestion') }}
                                                    1</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('tip_suggestion1', '') }}"
                                                        name="tip_suggestion1" id="tip_suggestion1"
                                                        placeholder="{{ translateKeyword('tip-suggestion') }} 1"
                                                        value="0" min="0">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('tip-suggestion') }}
                                                    2</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('tip_suggestion2', '') }}"
                                                        name="tip_suggestion2" id="tip_suggestion2"
                                                        placeholder="{{ translateKeyword('tip-suggestion') }} 2"
                                                        value="0" min="0">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('tip-suggestion') }}
                                                    3</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('tip_suggestion3', '') }}"
                                                        name="tip_suggestion3" id="tip_suggestion3"
                                                        placeholder="{{ translateKeyword('tip-suggestion') }} 3"
                                                        value="0" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('veritical-service-listing') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('vertical_service_listing') == 1) checked @endif
                                                name="vertical_service_listing" id="vertical_service_listing"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('wallet') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('wallet') == 1) checked @endif name="wallet"
                                                id="wallet" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('wallet-and-coupons') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('wallet_and_coupon') == 1) checked @endif
                                                name="wallet_and_coupon" id="wallet_and_coupon" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('wallet-amount-sharing') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('wallet_sharing') == 1) checked @endif
                                                name="wallet_sharing" id="wallet_sharing" onchange="tipselect()"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('whole-number-value') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('round_off_value') == 1) checked @endif
                                                name="round_off_value" id="round_off_value" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>







                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('user-referral') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('user_referral') == 1) checked @endif
                                                name="user_referral" id="user_referral" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-referral') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_referral') == 1) checked @endif
                                                name="driver_referral" id="driver_referral" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>



                                    {{-- <div class="form-group row">
                                            <div class="col-xs-2 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    Destination time & distance on Driver
                                                </label>
                                            </div>
                                            <div class="col-xs-10">
                                                <input @if (Setting::get('destination_time_distance_driver') == 1) checked
                                                    @endif name="destination_time_distance_driver"
                                                    id="destination_time_distance_driver" type="checkbox" class="js-switch"
                                                    data-color="#43b968">
                                            </div>
                                        </div> --}}


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-document-delete-on-expiry') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_doc_delete_expiry') == 1) checked @endif
                                                name="driver_doc_delete_expiry" id="driver_doc_delete_expiry"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('user-document-delete-on-expiry') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('user_doc_delete_expiry') == 1) checked @endif
                                                name="user_doc_delete_expiry" id="user_doc_delete_expiry"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for=""
                                            class="col-xs-6 col-form-label">{{ translateKeyword('docs-expiry-days-limit') }}</label>
                                        <div class="col-xs-6">
                                            <input class="form-control" type="number"
                                                value="{{ Setting::get('expiry_days_limit', '') }}"
                                                name="expiry_days_limit" id="expiry_days_limit"
                                                placeholder="{{ translateKeyword('docs-expiry-days-limit') }}"
                                                value="0">
                                        </div>
                                    </div>






                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('customer-review-mandatory') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('customer_review') == 1) checked @endif
                                                name="customer_review" id="customer_review" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('provider-review-mandatory') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_review') == 1) checked @endif
                                                name="driver_review" id="driver_review" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>











                                    {{-- <div class="form-group row">
                                            <div class="col-xs-2 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    Cancellation Charges
                                                </label>
                                            </div>
                                            <div class="col-xs-10">
                                                <input @if (Setting::get('cancellation_charges') == 1) checked @endif
                                                name="cancellation_charges" id="cancellation_charges"
                                                    onchange="cancellationchargesselect()" type="checkbox" class="js-switch"
                                                    data-color="#43b968">
                                            </div>
                                        </div>
    
    
                                        <div id="cancellation_charges_div"
                                            @if (Setting::get('cancellation_charges') == 0) style="display: none;" @endif>
                                            <div class="form-group row">
                                                <label for="" class="col-xs-2 col-form-label">Cancellation Time</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('cancellation_times', '') }}"
                                                        name="cancellation_times" id="cancellation_times"
                                                        placeholder="Enter Cancellation Time" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-xs-2 col-form-label">Cancellation Charges</label>
                                                <div class="col-xs-10">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('cancellation_charge', '') }}"
                                                        name="cancellation_charge" id="cancellation_charge"
                                                        placeholder="Enter Cancellation Charges" value="0">
                                                </div>
                                            </div>
                                        </div> --}}









                                    <div id="smtp_mail_div" class="row"
                                        @if (Setting::get('smtp_mail') == 0) style="display: none;" @endif>
                                        <div class="form-group col-6">
                                            <div class="col-xs-6 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    {{ translateKeyword('booking-email') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input @if (Setting::get('booking_email') == 1) checked @endif
                                                    name="booking_email" id="booking_email" type="checkbox"
                                                    class="js-switch" data-color="#43b968">
                                            </div>
                                        </div>


                                        <div class="form-group col-6">
                                            <div class="col-xs-6 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    {{ translateKeyword('Contact_Email') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input @if (Setting::get('contact_email') == 1) checked @endif
                                                    name="contact_email" id="contact_email" type="checkbox"
                                                    class="js-switch" data-color="#43b968">
                                            </div>
                                        </div>

                                    </div>









                                    {{-- <div class="form-group row">
                                            <div class="col-xs-2 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    App Maintenance
                                                </label>
                                            </div>
                                            <div class="col-xs-10">
                                                <input @if (Setting::get('appmaintain') == 1) checked @endif name="appmaintain"
                                                    id="appmaintain_check" onchange="appmaintainselect()" type="checkbox"
                                                    class="js-switch" data-color="#43b968">
                                            </div>
                                        </div> --}}



                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="customer_pic" class="col-form-label">
                                                {{ translateKeyword('customer-pic-mandatory') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('customer_pic_mandatory') == 1) checked @endif
                                                name="customer_pic_mandatory" id="customer_pic_mandatory"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="driver_pic" class="col-form-label">
                                                {{ translateKeyword('provider-pic-mandatory') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_pic_mandatory') == 1) checked @endif
                                                name="driver_pic_mandatory" id="driver_pic_mandatory" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="driver_pic" class="col-form-label">
                                                {{ translateKeyword('passenger-profile-image-camera-only') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('passenger_image_camera') == 1) checked @endif
                                                name="passenger_image_camera" id="passenger_image_camera"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="driver_pic" class="col-form-label">
                                                {{ translateKeyword('driver-profile-image-camera-only') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_image_camera') == 1) checked @endif
                                                name="driver_image_camera" id="driver_image_camera" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('user-app-job-rating-enable') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('user_app_rating') == 1) checked @endif
                                                name="user_app_rating" id="user_app_rating" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-app-job-rating-enable') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_app_rating') == 1) checked @endif
                                                name="driver_app_rating" id="driver_app_rating" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('customer-app-link-on-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('customer_app_link_driver') == 1) checked @endif
                                                name="customer_app_link_driver" id="customer_app_link_driver"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('river-app-link-on-customer') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_app_link_customer') == 1) checked @endif
                                                name="driver_app_link_customer" id="driver_app_link_customer"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>







                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        {{ translateKeyword('support') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingTwo">
                                <div class="panel-body row">
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('whatsApp-support') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('whatsapp_support') == 1) checked @endif
                                                name="whatsapp_support" id="whatsapp_support"
                                                onchange="whatsapp_support_select()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6" id="whatsapp_support_fields"
                                        @if (Setting::get('whatsapp_support') == 0) style="display:none;" @endif>
                                        <label for="whatsapp_number"
                                            class="col-xs-6 col-form-label">{{ translateKeyword('whatsapp-mobile-number') }}</label>
                                        <div class="col-xs-6">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('whatsapp_number', '') }}"
                                                name="whatsapp_number" id="contact_number"
                                                placeholder="{{ translateKeyword('whatsapp-mobile-number') }}">
                                        </div>
                                    </div>
                                    <div class="col-12"></div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('SOS-support') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('sos_support') == 1) checked @endif name="sos_support"
                                                id="sos_support" onchange="sos_support_select()" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6" id="sos_support_fields"
                                        @if (Setting::get('sos_support') == 0) style="display:none;" @endif>
                                        <label for="sos_number"
                                            class="col-xs-6 col-form-label">{{ translateKeyword('SOS-number') }}
                                        </label>
                                        <div class="col-xs-6">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('sos_number', '911') }}" name="sos_number"
                                                id="sos_number" placeholder="{{ translateKeyword('SOS-number') }}">
                                        </div>
                                    </div>
                                    <div class="col-12"></div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('customer-support') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('customer_support') == 1) checked @endif
                                                name="customer_support" id="customer_support"
                                                onchange="customer_support_select()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6" id="customer_support_fields"
                                        @if (Setting::get('customer_support') == 0) style="display:none;" @endif>
                                        <label for="customer_support_number"
                                            class="col-xs-6 col-form-label">{{ translateKeyword('customer-support-number') }}
                                        </label>
                                        <div class="col-xs-6">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('customer_support_number', '') }}"
                                                name="customer_support_number" id="mobile" minlength="10"
                                                maxlength="15"
                                                placeholder="{{ translateKeyword('customer-support-number') }}">
                                        </div>
                                    </div>
                                    <div class="col-12"></div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('email-support') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('email_support') == 1) checked @endif
                                                name="email_support" id="email_support"
                                                onchange="email_support_select()" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6" id="email_support_fields"
                                        @if (Setting::get('email_support') == 0) style="display:none;" @endif>
                                        <label for="email_address_support"
                                            class="col-xs-6 col-form-label">{{ translateKeyword('email') }}
                                        </label>
                                        <div class="col-xs-6">
                                            <input class="form-control" type="email"
                                                value="{{ Setting::get('email_address_support', '') }}"
                                                name="email_address_support" id="email_address_support"
                                                placeholder="{{ translateKeyword('email-support') }}">
                                        </div>
                                    </div>
                                    <div class="col-12"></div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('tawk-support') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('tawk_support') == 1) checked @endif
                                                name="tawk_support" id="tawk_support" onchange="tawk_support_select()"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="col-12" id="tawk_support_fields"
                                        @if (Setting::get('tawk_support') == 0) style="display:none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="tawk_live"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('tawk-live-support-key') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('tawk_live', '') }}" name="tawk_live"
                                                        id="tawk_live"
                                                        placeholder="{{ translateKeyword('tawk-live-support-key') }}">
                                                </div>
                                            </div>
    
                                            <div class="form-group col-6">
                                                <label for="widget_id"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('widget_id') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('widget_id', '') }}" name="widget_id"
                                                        id="widget_id" placeholder="{{ translateKeyword('widget_id') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading101">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapse101" aria-expanded="false"
                                        aria-controls="collapse101">
                                        {{ translateKeyword('distance-calculation-system') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse101" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading101">
                                <div class="panel-body row">
                                    <br />

                                    <div class="form-group col-6">
                                        <label for="distance_system_calculation"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('distance-calculation-system') }}</label>
                                        <div class="col-xs-12">
                                            <select name="distance_system_calculation" class="form-control" required>
                                                <option @if (Setting::get('distance_system_calculation', 'local') == 'local') selected @endif
                                                    value="local"> {{ translateKeyword('system-calculation') }}
                                                </option>
                                                <option @if (Setting::get('distance_system_calculation', 'local') == 'google') selected @endif
                                                    value="google"> {{ translateKeyword('google-calculation') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="distance_system"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('distance-system') }}</label>
                                        <div class="col-xs-12">
                                            <select class="form-control" id="distance_system" name="distance_system">
                                                <option @if (Setting::get('distance_system') === 'metric') selected @endif
                                                    value="metric">
                                                    Metric - (KM)
                                                </option>
                                                <option @if (Setting::get('distance_system') === 'imperial') selected @endif
                                                    value="imperial">
                                                    Imperial - (Miles)
                                                </option>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('arrival-distance-and-time-show-user') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('arrival_time_switch') == 1) checked @endif
                                                name="arrival_time_switch" id="arrival_time_switch" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('total-distance-and-time-show-provider') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('drop_time_switch') == 1) checked @endif
                                                name="drop_time_switch" id="drop_time_switch" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('pickup-distance-and-time-show-provider') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('pickup_time_switch') == 1) checked @endif
                                                name="pickup_time_switch" id="pickup_time_switch" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        {{ translateKeyword('verification') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingFour">
                                <div class="panel-body row">
                                    <div class="form-group col-6">
                                        <label for="tawk_live"
                                            class="col-xs-6 col-form-label">{{ translateKeyword('firebase-verification-in-app') }}</label>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('verification') == 1) checked @endif
                                                name="verification" id="verification" type="checkbox"
                                                class="js-switch" onchange="firebaseverificationselect()"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="tawk_live"
                                            class="col-xs-6 col-form-label">{{ translateKeyword('twilio-verification-in-app') }}</label>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('twilio_verification') == 1) checked @endif
                                                name="twilio_verification" id="twilio_verification" type="checkbox"
                                                class="js-switch" onchange="twilioverificationselect()"
                                                data-color="#43b968">
                                        </div>
                                    </div>
                                    <div id="twilio_verification_fields" class="col-12"
                                        @if (Setting::get('twilio_verification') == 0) style="display: none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="twilio_sid"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('twilio-SID') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('twilio_sid', '') }}" name="twilio_sid"
                                                        id="twilio_sid"
                                                        placeholder="{{ translateKeyword('twilio-SID') }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="twilio_token"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('twilio-token') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('twilio_token', '') }}" name="twilio_token"
                                                        id="twilio_token"
                                                        placeholder="{{ translateKeyword('twilio-token') }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="twilio_from"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('twilio-from-number') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('twilio_from', '') }}" name="twilio_from"
                                                        id="twilio_from"
                                                        placeholder="{{ translateKeyword('twilio-from-number') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading50">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapse50" aria-expanded="false"
                                        aria-controls="collapse50">
                                        {{ translateKeyword('bank-information') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse50" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading50">
                                <div class="panel-body row">
                                    <br />

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('customer-bankinfo') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('customer_bank_info') == 1) checked @endif
                                                name="customer_bank_info" id="customer_bank_info" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading97">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapse97" aria-expanded="false"
                                        aria-controls="collapse97">
                                        {{ translateKeyword('donation-suggesstion') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse97" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading97">
                                <div class="panel-body row">

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('donate-us') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('donate_us') == 1) checked @endif name="donate_us"
                                                id="donate_us" onchange="donateselect()" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div id="donate_us_div" class="col-12"
                                        @if (Setting::get('donate_us') == 0) style="display: none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('donatation-suggesstion') }}
                                                    1</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('donation_suggestion1', '') }}"
                                                        name="donation_suggestion1" id="donation_suggestion1"
                                                        placeholder="{{ translateKeyword('donatation-suggesstion') }} 1"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('donatation-suggesstion') }}
                                                    2</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('donation_suggestion2', '') }}"
                                                        name="donation_suggestion2" id="donation_suggestion2"
                                                        placeholder="{{ translateKeyword('donatation-suggesstion') }} 2"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for=""
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('donatation-suggesstion') }}
                                                    3</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="text"
                                                        value="{{ Setting::get('donation_suggestion3', '') }}"
                                                        name="donation_suggestion3" id="donation_suggestion3"
                                                        placeholder="{{ translateKeyword('donatation-suggesstion') }} 3"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        {{ translateKeyword('fcm-keys') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingOne">
                                <div class="panel-body row">
                                    <div class="form-group col-6">
                                        <label for="android_user_fcm_key"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('user-app-fcm-key') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('android_user_fcm_key', '') }}"
                                                name="android_user_fcm_key" required id="android_user_fcm_key"
                                                placeholder="{{ translateKeyword('user-app-fcm-key') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="android_user_driver_key"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('provider-app-fcm-key') }}</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('android_user_driver_key', '') }}"
                                                name="android_user_driver_key" required id="android_user_driver_key"
                                                placeholder="{{ translateKeyword('provider-app-fcm-key') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="headingFives">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseFives" aria-expanded="false"
                                        aria-controls="collapseFives">
                                        {{ translateKeyword('multi-device-login') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFives" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingFives">
                                <div class="panel-body row">

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="multi_device_login_driver" class="col-form-label">
                                                {{ translateKeyword('allow-multi-device-login-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('multi_device_login_driver') == 1) checked @endif
                                                name="multi_device_login_driver" id="multi_device_login_driver"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="multi_device_login_passenger" class="col-form-label">
                                                {{ translateKeyword('allow-multi-device-login-passenger') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('multi_device_login_passenger') == 1) checked @endif
                                                name="multi_device_login_passenger" id="multi_device_login_passenger"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading9">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapse9" aria-expanded="false"
                                        aria-controls="collapse9">
                                        {{ translateKeyword('modules') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse9" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading9">
                                <div class="panel-body row">

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('how-rate-card-pricing-structure') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('show_rate_card_pricing_struct') == 1) checked @endif
                                                name="show_rate_card_pricing_struct" id="show_rate_card_pricing_struct"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('bypass-invoice') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('bypass_invoice') == 1) checked @endif
                                                name="bypass_invoice" id="bypass_invoice" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('bid-jobs') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('bid_job') == 1) checked @endif name="bid_job"
                                                id="bid_job" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('custom-amount-by-driver') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('custom_amount_driver') == 1) checked @endif
                                                name="custom_amount_driver" id="custom_amount_driver" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-cancellation-block') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_cancellation_block') == 1) checked @endif
                                                name="driver_cancellation_block" id="driver_cancellation_block"
                                                type="checkbox" class="js-switch" data-color="#43b968"
                                                onchange="driver_cancellation_block_select()">
                                        </div>
                                    </div>
                                    <div class="col-6"></div>
                                    <div id="driver_cancellation_block_fields" class="col-12"
                                        @if (Setting::get('driver_cancellation_block') == 0) style="display:none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="max_allowed_cancellation" class="col-xs-12 col-form-label">
                                                    {{ translateKeyword('max-allowed-cancellations') }}
                                                </label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('max_allowed_cancellation', '3') }}"
                                                        name="max_allowed_cancellation" required
                                                        id="max_allowed_cancellation"
                                                        placeholder="{{ translateKeyword('max-allowed-cancellations') }}.">
                                                </div>
                                            </div>
    
                                            <div class="form-group col-6">
                                                <label for="allowed_cancellation_unit" class="col-xs-12 col-form-label">
                                                    {{ translateKeyword('allowed-cancellation-unit') }}
                                                </label>
                                                <div class="col-xs-12">
                                                    <select name="allowed_cancellation_unit" class="form-control" required>
                                                        <option @if (Setting::get('allowed_cancellation_unit', 'day') == 'day') selected @endif
                                                            value="day"> Day(s)
                                                        </option>
                                                        <option @if (Setting::get('allowed_cancellation_unit', 'day') == 'hour') selected @endif
                                                            value="hour"> Hour(s)
                                                        </option>
                                                        <option @if (Setting::get('allowed_cancellation_unit', 'day') == 'min') selected @endif
                                                            value="min"> Min(s)
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="form-group col-6">
                                                <label for="allowed_cancellation_unit_value"
                                                    class="col-xs-12 col-form-label">
                                                    {{ translateKeyword('allowed-cancellation-unit-value') }}
                                                </label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('allowed_cancellation_unit_value', '1') }}"
                                                        name="allowed_cancellation_unit_value" required
                                                        id="allowed_cancellation_unit_value"
                                                        placeholder="Max Allowed Cancellations.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('force-scheduling-job') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('force_schedule_job') == 1) checked @endif
                                                name="force_schedule_job" id="force_schedule_job" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('instant-booking') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('instant_booking') == 1) checked @endif
                                                name="instant_booking" id="instant_booking" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('meter-pricing-clone-with-service') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('service_metering') == 1) checked @endif
                                                name="service_metering" id="service_metering" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('multi-vehicles-module') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('multi_vehicle_module') == 1) checked @endif
                                                name="multi_vehicle_module" id="multi_vehicle_module" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('multi-services') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('multi_service_module') == 1) checked @endif
                                                name="multi_service_module" id="multi_service_module" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('multi-job-website') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('multi_job_website') == 1) checked @endif
                                                name="multi_job_website" id="multi_job_website" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('price-negotiation-module') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('negotiation_module') == 1) checked @endif
                                                name="negotiation_module" id="negotiation_module" type="checkbox"
                                                class="js-switch" data-color="#43b968"
                                                onchange="negotiation_select()">
                                        </div>
                                    </div>
                                    <div class="col-6"></div>
                                    <div id="negotiation_fields" class="col-12"
                                        @if (Setting::get('negotiation_module') == 0) style="display:none;" @endif>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="negotiation_type"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('negotiation-type') }}</label>
                                                <div class="col-xs-12">
                                                    <select name="negotiation_type" class="form-control" required>
                                                        <option @if (Setting::get('negotiation_type', 'percentage') == 'fixed') selected @endif
                                                            value="fixed"> {{ translateKeyword('fixed') }}
                                                        </option>
                                                        <option @if (Setting::get('negotiation_type', 'percentage') == 'percentage') selected @endif
                                                            value="percentage"> {{ translateKeyword('percentage') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="negotiation_min_threshold"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('negotiation-minimum-threshold') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('negotiation_min_threshold', '0') }}"
                                                        id="negotiation_min_threshold" name="negotiation_min_threshold"
                                                        min="0" max="100"
                                                        placeholder="{{ translateKeyword('negotiation-minimum-threshold') }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="negotiation_max_threshold"
                                                    class="col-xs-12 col-form-label">{{ translateKeyword('negotiation-maximum-threshold') }}</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="number"
                                                        value="{{ Setting::get('negotiation_max_threshold', '0') }}"
                                                        id="negotiation_max_threshold" name="negotiation_max_threshold"
                                                        min="0" max="100"
                                                        placeholder="{{ translateKeyword('negotiation-maximum-threshold') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('subscription-module-stripe') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('subscription_module') == 1) checked @endif
                                                name="subscription_module" id="subscription_module" type="checkbox"
                                                class="js-switch" data-color="#43b968"
                                                onchange="subscription_block_select()">
                                        </div>
                                    </div>

                                    <div class="col-6"></div>

                                    <div id="subscription_block_fields" class="row"
                                        @if (Setting::get('subscription_module') == 0) style="display:none;" @endif>
                                        <div class="form-group col-6">
                                            <div class="col-xs-6 col-form-label">
                                                <label for="UPI_key" class="col-form-label">
                                                    {{ translateKeyword('subscription-module-trial-stripe') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input @if (Setting::get('subscription_module_stripe_trial') == 1) checked @endif
                                                    name="subscription_module_stripe_trial"
                                                    id="subscription_module_stripe_trial" type="checkbox"
                                                    class="js-switch" data-color="#43b968"
                                                    onchange="subscription_trial_block_select()">
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <div class="col-xs-6 col-form-label">
                                                <label for="driver_subscription_module" class="col-form-label">
                                                    {{ translateKeyword('driver-subscription-module') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input @if (Setting::get('driver_subscription_module') == 1) checked @endif
                                                    name="driver_subscription_module" id="driver_subscription_module"
                                                    type="checkbox" class="js-switch" data-color="#43b968"
                                                    onchange="driver_subscription_select()">
                                            </div>
                                        </div>

                                        <div class="form-group col-6" id="driver_trial_period_field"
                                            @if (Setting::get('subscription_module_stripe_trial') == 1) style="display:none;" @endif>
                                            <div class="col-xs-6 col-form-label">
                                                <label for="driver_trial_period" class="col-form-label">
                                                    {{ translateKeyword('trial-period') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input class="form-control" type="number"
                                                    value="{{ Setting::get('driver_trial_period', '0') }}"
                                                    id="driver_trial_period" name="driver_trial_period" min="0"
                                                    max="100"
                                                    placeholder="{{ translateKeyword('trial-period') }}">
                                            </div>
                                        </div>

                                        <div class="form-group col-6">
                                            <div class="col-xs-6 col-form-label">
                                                <label for="rider_subscription_module" class="col-form-label">
                                                    {{ translateKeyword('rider-subscription-module') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input @if (Setting::get('rider_subscription_module') == 1) checked @endif
                                                    name="rider_subscription_module" id="rider_subscription_module"
                                                    type="checkbox" class="js-switch" data-color="#43b968"
                                                    onchange="rider_subscription_select()">
                                            </div>
                                        </div>

                                        <div class="form-group col-6" id="rider_trial_period_field"
                                            @if (Setting::get('subscription_module_stripe_trial') == 1) style="display:none;" @endif>
                                            <div class="col-xs-6 col-form-label">
                                                <label for="rider_trial_period" class="col-form-label">
                                                    {{ translateKeyword('trial-period') }}
                                                </label>
                                            </div>
                                            <div class="col-xs-6">
                                                <input class="form-control" type="number"
                                                    value="{{ Setting::get('rider_trial_period', '0') }}"
                                                    id="rider_trial_period" name="rider_trial_period" min="0"
                                                    max="100"
                                                    placeholder="{{ translateKeyword('trial-period') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('user-verification') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('user_verification') == 1) checked @endif
                                                name="user_verification" id="user_verification" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('driver-verification') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('driver_verification') == 1) checked @endif
                                                name="driver_verification" id="driver_verification" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('vehicle-weightage(kgs)') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('vehicle_weightage') == 1) checked @endif
                                                name="vehicle_weightage" id="vehicle_weightage" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('zone-inbound-force') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('zone_inbound_force') == 1) checked @endif
                                                name="zone_inbound_force" id="zone_inbound_force" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>



                                    {{-- <div class="form-group row">
                                                <div class="col-xs-2 col-form-label">
                                                    <label for="UPI_key" class="col-form-label">
                                                        Service Operation Inbound(Zones)
                                                    </label>
                                                </div>
                                                <div class="col-xs-10">
                                                    <input @if (Setting::get('service_operation_inbound') == 1) checked @endif name="service_operation_inbound"
                                                        id="service_operation_inbound" type="checkbox" class="js-switch"
                                                        data-color="#43b968">
                                                </div>
                                            </div> --}}

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('zones-module') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('zone_module') == 1) checked @endif name="zone_module"
                                                id="zone_module" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('zone(s)-meter-pricing') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('zone_metering') == 1) checked @endif
                                                name="zone_metering" id="zone_metering" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('zones-restrict-module') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('zone_restrict_module') == 1) checked @endif
                                                name="zone_restrict_module" id="zone_restrict_module" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>




                                    {{-- gender pref --}}
                                    {{-- <div class="form-group row">
                                                <div class="col-xs-2 col-form-label">
                                                    <label for="UPI_key" class="col-form-label">
                                                        Gender preference
                                                    </label>
                                                </div>
                                                <div class="col-xs-10">
                                                    <input @if (Setting::get('gender_pref_enabled') == 1) checked @endif
                                                        name="gender_pref_enabled" id="gender_pref_enabled" type="checkbox"
                                                        class="js-switch" data-color="#43b968">
                                                </div>
    
                                            </div> --}}



                                </div>

                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading1011">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapse1011" aria-expanded="false"
                                        aria-controls="collapse1011">
                                        {{ translateKeyword('tax-info') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1011" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading1011">
                                <div class="panel-body row">
                                    <br />

                                    <div class="form-group col-6">
                                        <div class="col-xs-6">
                                            <label for="government-charges" class="col-form-label">
                                                {{ translateKeyword('tax_tps_info_field') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('tax_tps_info_field') == 1) checked @endif
                                                name="tax_tps_info_field" id="tax_tps_info_field" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6">
                                            <label for="government-charges" class="col-form-label">
                                                {{ translateKeyword('tax_tvq_info_field') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('tax_tvq_info_field') == 1) checked @endif
                                                name="tax_tvq_info_field" id="tax_tvq_info_field" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="heading10">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapse10" aria-expanded="false"
                                        aria-controls="collapse10">
                                        {{ translateKeyword('service-categories') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse10" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading10">
                                <div class="panel-body row">
                                    <br />

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('Economy') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_ecomony') == 1) checked @endif
                                                name="cat_app_ecomony" id="cat_app_ecomony_check" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('Luxury') }}
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_lux') == 1) checked @endif name="cat_app_lux"
                                                id="cat_app_lux" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('truck') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_ext') == 1) checked @endif name="cat_app_ext"
                                                id="cat_app_ext" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>


                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('OutStation') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_out') == 1) checked @endif name="cat_app_out"
                                                id="cat_app_out" type="checkbox" class="js-switch"
                                                data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('roadside-assistance') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_road_assist') == 1) checked @endif
                                                name="cat_app_road_assist" id="cat_app_road_assist" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('dream-driver') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_dream_driver') == 1) checked @endif
                                                name="cat_app_dream_driver" id="cat_app_dream_driver" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('rental') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_rental') == 1) checked @endif
                                                name="cat_app_rental" id="cat_app_rental" type="checkbox"
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
                                            <input @if (Setting::get('cat_app_personal_care') == 1) checked @endif
                                                name="cat_app_personal_care" id="cat_app_personal_care"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('medical-and-health-services') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_medical_health') == 1) checked @endif
                                                name="cat_app_medical_health" id="cat_app_medical_health"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('education-and-training') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_education_training') == 1) checked @endif
                                                name="cat_app_education_training" id="cat_app_education_training"
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
                                            <input @if (Setting::get('cat_app_consulting') == 1) checked @endif
                                                name="cat_app_consulting" id="cat_app_consulting" type="checkbox"
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
                                            <input @if (Setting::get('cat_app_cleaning_services') == 1) checked @endif
                                                name="cat_app_cleaning_services" id="cat_app_cleaning_services"
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
                                            <input @if (Setting::get('cat_app_maintenance') == 1) checked @endif
                                                name="cat_app_maintenance" id="cat_app_maintenance" type="checkbox"
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
                                            <input @if (Setting::get('cat_app_construction') == 1) checked @endif
                                                name="cat_app_construction" id="cat_app_construction" type="checkbox"
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
                                            <input @if (Setting::get('cat_app_security') == 1) checked @endif
                                                name="cat_app_security" id="cat_app_security" type="checkbox"
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
                                            <input @if (Setting::get('cat_app_landscaping') == 1) checked @endif
                                                name="cat_app_landscaping" id="cat_app_landscaping" type="checkbox"
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
                                            <input @if (Setting::get('cat_app_garden') == 1) checked @endif
                                                name="cat_app_garden" id="cat_app_garden" type="checkbox"
                                                class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>

                                    <div class="form-group col-6">
                                        <div class="col-xs-6 col-form-label">
                                            <label for="UPI_key" class="col-form-label">
                                                {{ translateKeyword('outdoor-constructions') }}
                                            </label>
                                        </div>

                                        <div class="col-xs-6">
                                            <input @if (Setting::get('cat_app_outdoor_construction') == 1) checked @endif
                                                name="cat_app_outdoor_construction" id="cat_app_outdoor_construction"
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
                                            <input @if (Setting::get('cat_app_exterior_design') == 1) checked @endif
                                                name="cat_app_exterior_design" id="cat_app_exterior_design"
                                                type="checkbox" class="js-switch" data-color="#43b968">
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                            <div class="panel-heading" role="tab" id="headingSix">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        {{ translateKeyword('wallet-suggestion') }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingSix">
                                <div class="panel-body row">
                                    <div class="form-group col-6">
                                        <label for=""
                                            class="col-xs-12 col-form-label">{{ translateKeyword('wallet-suggestion') }}
                                            1</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('wallet_suggestion1', '') }}"
                                                name="wallet_suggestion1" id="wallet_suggestion1"
                                                placeholder="{{ translateKeyword('wallet-suggestion') }} 1"
                                                value="0" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for=""
                                            class="col-xs-12 col-form-label">{{ translateKeyword('wallet-suggestion') }}
                                            2</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('wallet_suggestion2', '') }}"
                                                name="wallet_suggestion2" id="wallet_suggestion2"
                                                placeholder="{{ translateKeyword('wallet-suggestion') }} 2"
                                                value="0" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for=""
                                            class="col-xs-12 col-form-label">{{ translateKeyword('wallet-suggestion') }}
                                            3</label>
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('wallet_suggestion3', '') }}"
                                                name="wallet_suggestion3" id="wallet_suggestion3"
                                                placeholder="{{ translateKeyword('wallet-suggestion') }} 3"
                                                value="0" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Onboarding User --}}
                    {{-- <div class="panel panel-default box box-block bg-white col-6">
                            <div class="panel-heading" role="tab" id="heading8">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                    href="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                        {{ translateKeyword('onboarding-user-title-description-and-images')}}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse8" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="heading8">
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-title')}} 1</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_title1', '') }}"
                                                name="onboarding_user_title1" id="onboarding_user_title1"
                                                placeholder="{{ translateKeyword('onboarding-user-title')}} 1">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-description')}}
                                            1</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_description1', '') }}"
                                                name="onboarding_user_description1" id="onboarding_user_description1"
                                                placeholder="{{ translateKeyword('onboarding-user-description')}} 1">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="onboarding_user_image1" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-image')}} 1
                                        </label>
                                        <div class="col-xs-10">
                                            @if (Setting::get('onboarding_user_image1') != '')
                                                <img style="height: 90px; margin-bottom: 15px;"
                                                    src="{{ Setting::get('onboarding_user_image1') }}">
                                            @endif
                                            <input type="file" accept="image/*" name="onboarding_user_image1"
                                                class="dropify form-control-file" id="onboarding_user_image1"
                                                aria-describedby="fileHelp">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-title')}} 2</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_title2', '') }}"
                                                name="onboarding_user_title2" id="onboarding_user_title2"
                                                placeholder="{{ translateKeyword('onboarding-user-title')}} 2">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-description')}}
                                            2</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_description2', '') }}"
                                                name="onboarding_user_description2" id="onboarding_user_description2"
                                                placeholder="{{ translateKeyword('onboarding-user-description')}} 2">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="onboarding_user_image2" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-image')}} 2
                                        </label>
                                        <div class="col-xs-10">
                                            @if (Setting::get('onboarding_user_image2') != '')
                                                <img style="height: 90px; margin-bottom: 15px;"
                                                    src="{{ Setting::get('onboarding_user_image2') }}">
                                            @endif
                                            <input type="file" accept="image/*" name="onboarding_user_image2"
                                                class="dropify form-control-file" id="onboarding_user_image2"
                                                aria-describedby="fileHelp">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-title')}} 3</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_title3', '') }}"
                                                name="onboarding_user_title3" id="onboarding_user_title3"
                                                placeholder="{{ translateKeyword('onboarding-user-title')}} 3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-description')}}
                                            3</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_description3', '') }}"
                                                name="onboarding_user_description3" id="onboarding_user_description3"
                                                placeholder="{{ translateKeyword('onboarding-user-description')}} 3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="onboarding_user_image3" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-image')}} 3
                                        </label>
                                        <div class="col-xs-10">
                                            @if (Setting::get('onboarding_user_image3') != '')
                                                <img style="height: 90px; margin-bottom: 15px;"
                                                    src="{{ Setting::get('onboarding_user_image3') }}">
                                            @endif
                                            <input type="file" accept="image/*" name="onboarding_user_image3"
                                                class="dropify form-control-file" id="onboarding_user_image3"
                                                aria-describedby="fileHelp">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-title')}} 4</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_title4', '') }}"
                                                name="onboarding_user_title4" id="onboarding_user_title4"
                                                placeholder="{{ translateKeyword('onboarding-user-title')}} 4">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-description')}}
                                            4</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_description4', '') }}"
                                                name="onboarding_user_description4" id="onboarding_user_description4"
                                                placeholder="{{ translateKeyword('onboarding-user-description')}} 4">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="onboarding_user_image4" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-image')}} 4
                                        </label>
                                        <div class="col-xs-10">
                                            @if (Setting::get('onboarding_user_image4') != '')
                                                <img style="height: 90px; margin-bottom: 15px;"
                                                    src="{{ Setting::get('onboarding_user_image4') }}">
                                            @endif
                                            <input type="file" accept="image/*" name="onboarding_user_image4"
                                                class="dropify form-control-file" id="onboarding_user_image4"
                                                aria-describedby="fileHelp">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-title')}} 5</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_title5', '') }}"
                                                name="onboarding_user_title5" id="onboarding_user_title5"
                                                placeholder="{{ translateKeyword('onboarding-user-title')}} 5">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-description')}}
                                            5</label>
                                        <div class="col-xs-10">
                                            <input class="form-control" type="text"
                                                value="{{ Setting::get('onboarding_user_description5', '') }}"
                                                name="onboarding_user_description5" id="onboarding_user_description5"
                                                placeholder="{{ translateKeyword('onboarding-user-description')}} 5">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="onboarding_user_image5" class="col-xs-2 col-form-label">{{ translateKeyword('onboarding-user-image')}} 5
                                        </label>
                                        <div class="col-xs-10">
                                            @if (Setting::get('onboarding_user_image5') != '')
                                                <img style="height: 90px; margin-bottom: 15px;"
                                                    src="{{ Setting::get('onboarding_user_image5') }}">
                                            @endif
                                            <input type="file" accept="image/*" name="onboarding_user_image5"
                                                class="dropify form-control-file" id="onboarding_user_image5"
                                                aria-describedby="fileHelp">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div> --}}

                    {{-- Customer Bank accountinfo --}}

                    <div class="col-12">
                        @if ($edit_permission == 1)
                            <div class="panel panel-default box box-block bg-white col-12 border-radius-10">
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary">{{ translateKeyword('update-apps-settings') }}</button>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function firebaseverificationselect() {
            if ($('#verification').is(":checked")) {
                if ($('#twilio_verification').is(":checked")) {
                    $('#twilio_verification').click();
                }
            }
        }

        // function setDonationField(amount) {
        //     $('#donation').val(amount);
        // }

        function twilioverificationselect() {
            if ($('#twilio_verification').is(":checked")) {
                if ($('#verification').is(":checked")) {
                    $('#verification').click();
                }
                $("#twilio_verification_fields").fadeIn(700);
            } else {
                $("#twilio_verification_fields").fadeOut(700);
            }

        }

        function appmaintainselect() {
            if ($('#appmaintain_check').is(":checked")) {
                $("#appmaintain_field").fadeIn(700);
            } else {
                $("#appmaintain_field").fadeOut(700);
            }
        }

        function tipselect() {
            if ($('#tip_collect').is(":checked")) {
                $("#tip_collect_div").fadeIn(700);
            } else {
                $("#tip_collect_div").fadeOut(700);
            }
        }

        function prebookinghourly() {
            if ($('#pre_booking_hourly_hold').is(":checked")) {
                $("#pre_booking_hourly_hold_div").fadeIn(700);
            } else {
                $("#pre_booking_hourly_hold_div").fadeOut(700);
            }
        }

        function driverbanridecancellation() {
            if ($('#driver_ban_ride_cancellation').is(":checked")) {
                $("#driver_ban_ride_cancellation_div").fadeIn(700);
            } else {
                $("#driver_ban_ride_cancellation_div").fadeOut(700);
            }
        }

        function cancellationjobsblockage() {
            if ($('#cancellation_jobs_blockage').is(":checked")) {
                $("#cancellation_jobs_blockage_div").fadeIn(700);
            } else {
                $("#cancellation_jobs_blockage_div").fadeOut(700);
            }
        }

        function cancellationselect() {
            if ($('#cancellation_deduction').is(":checked")) {
                $("#cancellation_deduction_div").fadeIn(700);
            } else {
                $("#cancellation_deduction_div").fadeOut(700);
            }
        }

        function smtpmailselect() {
            if ($('#smtp_mail').is(":checked")) {
                $("#smtp_mail_div").fadeIn(700);
            } else {
                $("#smtp_mail_div").fadeOut(700);
            }
        }

        function bookingfeeselect() {
            if ($('#booking_fee').is(":checked")) {
                $("#booking_fee_div").fadeIn(700);
            } else {
                $("#booking_fee_div").fadeOut(700);
            }
        }

        function pickupradiusselect() {
            if ($('#pickup_location_radius').is(":checked")) {
                $("#pickup_location_radius_div").fadeIn(700);
            } else {
                $("#pickup_location_radius_div").fadeOut(700);
            }
        }

        function appmaintainselect() {
            if ($('#appmaintain').is(":checked")) {
                $("#appmaintain_div").fadeIn(700);
            } else {
                $("#appmaintain_div").fadeOut(700);
            }
        }

        function invoiceselect() {
            if ($('#invoice').is(":checked")) {
                $("#invoice_div").fadeIn(700);
            } else {
                $("#invoice_div").fadeOut(700);
            }
        }

        function driveraccblockageselect() {
            if ($('#driver_acc_blockage_doc').is(":checked")) {
                $("#driver_acc_blockage_doc_div").fadeIn(700);
            } else {
                $("#driver_acc_blockage_doc_div").fadeOut(700);
            }
        }

        function cancellationchargesselect() {
            if ($('#cancellation_charges').is(":checked")) {
                $("#cancellation_charges_div").fadeIn(700);
            } else {
                $("#cancellation_charges_div").fadeOut(700);
            }
        }

        function rewardpointselect() {
            if ($('#reward_point_customer').is(":checked")) {
                $("#reward_point_customer_div").fadeIn(700);
            } else {
                $("#reward_point_customer_div").fadeOut(700);
            }
        }


        function driveratdisposalselect() {
            if ($('#driver_at_disposal').is(":checked")) {
                $("#driver_at_disposal_div").fadeIn(700);
            } else {
                $("#driver_at_disposal_div").fadeOut(700);
            }
        }


        function cancelselect() {
            if ($('#cancel_reason').is(":checked")) {
                $("#cancel_reason_div").fadeIn(700);
            } else {
                $("#cancel_reason_div").fadeOut(700);
            }
        }

        function donateselect() {
            if ($('#donate_us').is(":checked")) {
                $("#donate_us_div").fadeIn(700);
            } else {
                $("#donate_us_div").fadeOut(700);
            }
        }


        function whatsapp_support_select() {
            if ($('#whatsapp_support').is(":checked")) {
                $("#whatsapp_support_fields").fadeIn(700);
            } else {
                $("#whatsapp_support_fields").fadeOut(700);
            }
        }


        function sos_support_select() {
            if ($('#sos_support').is(":checked")) {
                $("#sos_support_fields").fadeIn(700);
            } else {
                $("#sos_support_fields").fadeOut(700);
            }
        }

        function customer_support_select() {
            if ($('#customer_support').is(":checked")) {
                $("#customer_support_fields").fadeIn(700);
            } else {
                $("#customer_support_fields").fadeOut(700);
            }
        }

        function email_support_select() {
            if ($('#email_support').is(":checked")) {
                $("#email_support_fields").fadeIn(700);
            } else {
                $("#email_support_fields").fadeOut(700);
            }
        }

        function tawk_support_select() {
            if ($('#tawk_support').is(":checked")) {
                $("#tawk_support_fields").fadeIn(700);
            } else {
                $("#tawk_support_fields").fadeOut(700);
            }
        }

        function fb_chat() {
            if ($('#fb_chat').is(":checked")) {
                $("#fb_chat_fields").fadeIn(700);
            } else {
                $("#fb_chat_fields").fadeOut(700);
            }
        }

        function negotiation_select() {
            if ($('#negotiation_module').is(":checked")) {
                $("#negotiation_fields").fadeIn(700);
            } else {
                $("#negotiation_fields").fadeOut(700);
            }
        }

        function driver_cancellation_block_select() {
            if ($('#driver_cancellation_block').is(":checked")) {
                $("#driver_cancellation_block_fields").fadeIn(700);
            } else {
                $("#driver_cancellation_block_fields").fadeOut(700);
            }
        }

        function subscription_block_select() {
            if ($('#subscription_module').is(":checked")) {
                $("#subscription_block_fields").fadeIn(700);
            } else {
                $("#subscription_block_fields").fadeOut(700);
                $('#subscription_module_stripe_trial').prop('checked', false);
                $('#rider_subscription_module').prop('checked', false);
                $('#driver_subscription_module').prop('checked', false);
            }
        }


        function subscription_trial_block_select() {
            if (!$('#subscription_module_stripe_trial').is(":checked")) {
                if ($('#rider_subscription_module').is(":checked")) {
                    $("#rider_trial_period_field").fadeIn(700);
                } else {
                    $("#rider_trial_period_field").fadeOut(700);
                }
                if ($('#driver_subscription_module').is(":checked")) {
                    $("#driver_trial_period_field").fadeIn(700);
                } else {
                    $("#driver_trial_period_field").fadeOut(700);
                }
            } else {
                $("#rider_trial_period_field").fadeOut(700);
                $("#driver_trial_period_field").fadeOut(700);
            }
        }

        function rider_subscription_select() {
            if (!$('#rider_subscription_module').is(":checked")) {
                $("#rider_trial_period_field").fadeOut(700);
            } else if ($('#rider_subscription_module').is(":checked") && !$('#subscription_module_stripe_trial').is(
                    ":checked")) {
                $("#rider_trial_period_field").fadeIn(700);
            }
        }

        function driver_subscription_select() {
            if (!$('#driver_subscription_module').is(":checked")) {
                $("#driver_trial_period_field").fadeOut(700);
            } else if ($('#driver_subscription_module').is(":checked") && !$('#subscription_module_stripe_trial').is(
                    ":checked")) {
                $("#driver_trial_period_field").fadeIn(700);
            }
        }
    </script>
@endsection
