@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Site Settings ')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Dashboard
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Dispatcher
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Eagle Eye
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Push Notification
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Reviews
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Booking Requests
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Contact Enquiries
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Country View
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Users
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Providers
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Dispatcher
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Accountant
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Fleet Group
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Zones
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Statements
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Documents
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Promocodes
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Services
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        History
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Settings
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Extra
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Account
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>
            <div class="form-group row">
                <div class="col-xs-2 col-form-label">
                    <label for="UPI_key" class="col-form-label">
                        Logout
                    </label>
                </div>
                <div class="col-xs-10">
                    <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                           id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                </div>

            </div>

            <div class="box box-block bg-white">
                {{-- <h5>Site Settings</h5> --}}

                {{-- <form class="form-horizontal" action="{{ route('admin.settings.store') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    {{ csrf_field() }} --}}

                {{-- <div class="form-group row">
                    <label for="site_title" class="col-xs-2 col-form-label">Site Title</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('site_title', '') }}"
                            name="site_title" required id="site_title" placeholder="Site Title">
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label for="site_sub_title" class="col-xs-2 col-form-label">Site Sub Title</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('site_sub_title', '') }}"
                            name="site_sub_title" required id="site_sub_title" placeholder="Site Sub Title">
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label for="meta_title" class="col-xs-2 col-form-label">Meta Title</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('meta_title', '') }}"
                            name="meta_title" id="meta_title" placeholder="Meta Title">
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label for="meta_keywords" class="col-xs-2 col-form-label">Meta Keywords</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('meta_keywords', '') }}"
                            name="meta_keywords" id="meta_keywords" placeholder="Meta Keywords">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="meta_description" class="col-xs-2 col-form-label">Meta Description</label>
                    <div class="col-xs-10">
                        <textarea class="form-control"
                            name="meta_description" id="meta_description" placeholder="Meta Description" maxlength="160" >{{ Setting::get('meta_description', '') }}</textarea>
                    </div>
                </div> --}}


                {{-- <div class="form-group row">
                    <label for="site_logo" class="col-xs-2 col-form-label">Site Logo - (Dimension: 80 x 80)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('site_logo') != '')
                            <img style="height: 90px; margin-bottom: 15px;"
                                src="{{ Setting::get('site_logo', asset('logo-black.png')) }}">
                        @endif
                        <input type="file" accept="image/*" name="site_logo" class="dropify form-control-file"
                            id="site_logo" aria-describedby="fileHelp" multiple>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="site_icon" class="col-xs-2 col-form-label">Site Icon</label>
                    <div class="col-xs-10">
                        @if (Setting::get('site_icon') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('site_icon') }}">
                        @endif
                        <input type="file" accept="image/*" name="site_icon" class="dropify form-control-file"
                            id="site_icon" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="booking_form_image" class="col-xs-2 col-form-label">Booking Form Image - (Dimension:
                        500 × 400)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('booking_form_image') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('booking_form_image') }}">
                        @endif
                        <input type="file" accept="image/*" name="booking_form_image" class="dropify form-control-file"
                            id="booking_form_image" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="advantage_image_1" class="col-xs-2 col-form-label">Advantage Area Image 1 - (Dimension:
                        390 × 298)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('advantage_image_1') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('advantage_image_1') }}">
                        @endif
                        <input type="file" accept="image/*" name="advantage_image_1" class="dropify form-control-file"
                            id="advantage_image_1" aria-describedby="fileHelp">
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label for="advantage_image_2" class="col-xs-2 col-form-label">Advantage Area Image 2 - (Dimension:
                        390 × 298)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('advantage_image_2') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('advantage_image_2') }}">
                        @endif
                        <input type="file" accept="image/*" name="advantage_image_2" class="dropify form-control-file"
                            id="advantage_image_2" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="call_us_image" class="col-xs-2 col-form-label">Call Us Image - (Dimension:
                        509 x 339)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('call_us_image') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('call_us_image') }}">
                        @endif
                        <input type="file" accept="image/*" name="call_us_image" class="dropify form-control-file"
                            id="call_us_image" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="site_icon" class="col-xs-2 col-form-label">Site Banner Image - (Dimension:
                        1500x1000)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('f_mainBanner') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('f_mainBanner') }}">
                        @endif
                        <input type="file" accept="image/*" name="f_mainBanner" class="dropify form-control-file"
                            id="f_mainBanner" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="mockup_one" class="col-xs-2 col-form-label">Phone Mockup 1 - (Dimension:
                        346 × 641)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('mockup_one') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('mockup_one') }}">
                        @endif
                        <input type="file" accept="image/*" name="mockup_one" class="dropify form-control-file"
                            id="mockup_one" aria-describedby="fileHelp">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="mockup_two" class="col-xs-2 col-form-label">Phone Mockup 2 - (Dimension:
                        346 × 641)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('mockup_two') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('mockup_two') }}">
                        @endif
                        <input type="file" accept="image/*" name="mockup_two" class="dropify form-control-file"
                            id="mockup_two" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="website_login" class="col-xs-2 col-form-label">Website Login Image - (Dimension:
                        903 × 1368)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('website_login') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('website_login') }}">
                        @endif
                        <input type="file" accept="image/*" name="website_login"
                            class="dropify form-control-file" id="website_login" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="website_register" class="col-xs-2 col-form-label">Website Register Image -
                        (Dimension: 903 × 1368)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('website_register') != '')
                            <img style="height: 90px; margin-bottom: 15px;"
                                src="{{ Setting::get('website_register') }}">
                        @endif
                        <input type="file" accept="image/*" name="website_register"
                            class="dropify form-control-file" id="website_register" aria-describedby="fileHelp">
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label for="slider_image1" class="col-xs-2 col-form-label">Slider Image 1 - (Dimension:
                        1500x1000)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('slider_image1') != '')
                            <img style="height: 90px; margin-bottom: 15px;"
                                src="{{ Setting::get('slider_image1') }}">
                        @endif
                        <input type="file" accept="image/*" name="slider_image1"
                            class="dropify form-control-file" id="slider_image1" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slider_image2" class="col-xs-2 col-form-label">Slider Image 2 - (Dimension:
                        1500x1000)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('slider_image2') != '')
                            <img style="height: 90px; margin-bottom: 15px;"
                                src="{{ Setting::get('slider_image2') }}">
                        @endif
                        <input type="file" accept="image/*" name="slider_image2"
                            class="dropify form-control-file" id="slider_image2" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slider_image3" class="col-xs-2 col-form-label">Slider Image 3 - (Dimension:
                        1500x1000)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('slider_image3') != '')
                            <img style="height: 90px; margin-bottom: 15px;"
                                src="{{ Setting::get('slider_image3') }}">
                        @endif
                        <input type="file" accept="image/*" name="slider_image3"
                            class="dropify form-control-file" id="slider_image3" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slider_image4" class="col-xs-2 col-form-label">Slider Image 4 - (Dimension:
                        1500x1000)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('slider_image4') != '')
                            <img style="height: 90px; margin-bottom: 15px;"
                                src="{{ Setting::get('slider_image4') }}">
                        @endif
                        <input type="file" accept="image/*" name="slider_image4"
                            class="dropify form-control-file" id="slider_image4" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slider_image5" class="col-xs-2 col-form-label">Slider Image 5 - (Dimension:
                        1500x1000)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('slider_image5') != '')
                            <img style="height: 90px; margin-bottom: 15px;"
                                src="{{ Setting::get('slider_image5') }}">
                        @endif
                        <input type="file" accept="image/*" name="slider_image5"
                            class="dropify form-control-file" id="slider_image5" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="admin_panel" class="col-xs-2 col-form-label">Admin Panel Image - (Dimension:
                        1296 × 864)</label>
                    <div class="col-xs-10">
                        @if (Setting::get('admin_panel') != '')
                            <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('admin_panel') }}">
                        @endif
                        <input type="file" accept="image/*" name="admin_panel" class="dropify form-control-file"
                            id="admin_panel" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="button_color_code" class="col-xs-2 col-form-label">Admin Button Color</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="color"
                            value="{{ Setting::get('button_color_code', '') }}" name="button_color_code"
                            id="button_color_code" placeholder="User Appstore link">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-xs-12 col-form-label">Base Location</label><br/>
                    <label for="store_link_android" class="col-xs-2 col-form-label">Latitude</label>
                    <div class="col-xs-4">
                        <input class="form-control" type="text" value="{{ Setting::get('latitude', '') }}"
                            name="latitude" id="latitude" placeholder="Latitude" required>
                    </div>
                    <label for="store_link_android" class="col-xs-2 col-form-label">Longitude</label>
                    <div class="col-xs-4">
                        <input class="form-control" type="text" value="{{ Setting::get('longitude', '') }}"
                            name="longitude" id="longitude" placeholder="Longitude" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="map_contact_page" class="col-xs-2 col-form-label">Map iFrame source - Contact
                        Page</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text"
                            value="{{ Setting::get('map_contact_page', '') }}" name="map_contact_page"
                            id="map_contact_page" placeholder="Map contact page">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="user_store_link_ios" class="col-xs-2 col-form-label">User Appstore Link</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text"
                            value="{{ Setting::get('user_store_link_ios', '') }}" name="user_store_link_ios"
                            id="user_store_link_ios" placeholder="User Appstore link">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="driver_store_link_ios" class="col-xs-2 col-form-label">Provider Appstore Link</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text"
                            value="{{ Setting::get('driver_store_link_ios', '') }}" name="driver_store_link_ios"
                            id="driver_store_link_ios" placeholder="Provider Appstore link">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="provider_select_timeout" class="col-xs-2 col-form-label">Provider Accept
                        Timeout</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="number"
                            value="{{ Setting::get('provider_select_timeout', '60') }}"
                            name="provider_select_timeout" required id="provider_select_timeout"
                            placeholder="Provider Timout">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="provider_search_radius" class="col-xs-2 col-form-label">Provider Search
                        Radius</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="number"
                            value="{{ Setting::get('provider_search_radius', '100') }}" name="provider_search_radius"
                            required id="provider_search_radius" placeholder="Provider Search Radius">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sos_number" class="col-xs-2 col-form-label">SOS Number</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('sos_number', '911') }}"
                            name="sos_number" required id="sos_number" placeholder="SOS Number">
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label for="map_key" class="col-xs-2 col-form-label">Google Map Api Key</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('map_key') }}"
                            name="map_key" id="map_key" placeholder="Site Copyright">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="map_key" class="col-xs-2 col-form-label">Country Code</label>
                    <div class="col-xs-10">
                        <select class="form-control" id="country_code" name="country_code">
                            <option @if (Setting::get('country_code') === '') selected @endif value="">Worldwide
                            </option>
                            <option @if (Setting::get('country_code') === 'AF') selected @endif value="AF">Afghanistan
                            </option>
                            <option @if (Setting::get('country_code') === 'AX') selected @endif value="AX">Aland Islands
                            </option>
                            <option @if (Setting::get('country_code') === 'AL') selected @endif value="AL">Albania</option>
                            <option @if (Setting::get('country_code') === 'DZ') selected @endif value="DZ">Algeria</option>
                            <option @if (Setting::get('country_code') === 'AS') selected @endif value="AS">American Samoa
                            </option>
                            <option @if (Setting::get('country_code') === 'AD') selected @endif value="AD">Andorra</option>
                            <option @if (Setting::get('country_code') === 'AO') selected @endif value="AO">Angola</option>
                            <option @if (Setting::get('country_code') === 'AI') selected @endif value="AI">Anguilla
                            </option>
                            <option @if (Setting::get('country_code') === 'AQ') selected @endif value="AQ">Antarctica
                            </option>
                            <option @if (Setting::get('country_code') === 'AG') selected @endif value="AG">Antigua and
                                Barbuda</option>
                            <option @if (Setting::get('country_code') === 'AR') selected @endif value="AR">Argentina
                            </option>
                            <option @if (Setting::get('country_code') === 'AM') selected @endif value="AM">Armenia</option>
                            <option @if (Setting::get('country_code') === 'AW') selected @endif value="AW">Aruba</option>
                            <option @if (Setting::get('country_code') === 'AU') selected @endif value="AU">Australia
                            </option>
                            <option @if (Setting::get('country_code') === 'AT') selected @endif value="AT">Austria</option>
                            <option @if (Setting::get('country_code') === 'AZ') selected @endif value="AZ">Azerbaijan
                            </option>
                            <option @if (Setting::get('country_code') === 'BS') selected @endif value="BS">Bahamas</option>
                            <option @if (Setting::get('country_code') === 'BH') selected @endif value="BH">Bahrain</option>
                            <option @if (Setting::get('country_code') === 'BD') selected @endif value="BD">Bangladesh
                            </option>
                            <option @if (Setting::get('country_code') === 'BB') selected @endif value="BB">Barbados
                            </option>
                            <option @if (Setting::get('country_code') === 'BY') selected @endif value="BY">Belarus</option>
                            <option @if (Setting::get('country_code') === 'BE') selected @endif value="BE">Belgium</option>
                            <option @if (Setting::get('country_code') === 'BZ') selected @endif value="BZ">Belize</option>
                            <option @if (Setting::get('country_code') === 'BJ') selected @endif value="BJ">Benin</option>
                            <option @if (Setting::get('country_code') === 'BM') selected @endif value="BM">Bermuda</option>
                            <option @if (Setting::get('country_code') === 'BT') selected @endif value="BT">Bhutan</option>
                            <option @if (Setting::get('country_code') === 'BO') selected @endif value="BO">Bolivia</option>
                            <option @if (Setting::get('country_code') === 'BQ') selected @endif value="BQ">Bonaire, Sint
                                Eustatius and Saba</option>
                            <option @if (Setting::get('country_code') === 'BA') selected @endif value="BA">Bosnia and
                                Herzegovina</option>
                            <option @if (Setting::get('country_code') === 'BW') selected @endif value="BW">Botswana
                            </option>
                            <option @if (Setting::get('country_code') === 'BV') selected @endif value="BV">Bouvet Island
                            </option>
                            <option @if (Setting::get('country_code') === 'BR') selected @endif value="BR">Brazil</option>
                            <option @if (Setting::get('country_code') === 'IO') selected @endif value="IO">British Indian
                                Ocean Territory</option>
                            <option @if (Setting::get('country_code') === 'BN') selected @endif value="BN">Brunei
                                Darussalam</option>
                            <option @if (Setting::get('country_code') === 'BG') selected @endif value="BG">Bulgaria
                            </option>
                            <option @if (Setting::get('country_code') === 'BF') selected @endif value="BF">Burkina Faso
                            </option>
                            <option @if (Setting::get('country_code') === 'BI') selected @endif value="BI">Burundi</option>
                            <option @if (Setting::get('country_code') === 'KH') selected @endif value="KH">Cambodia
                            </option>
                            <option @if (Setting::get('country_code') === 'CM') selected @endif value="CM">Cameroon
                            </option>
                            <option @if (Setting::get('country_code') === 'CA') selected @endif value="CA">Canada</option>
                            <option @if (Setting::get('country_code') === 'CV') selected @endif value="CV">Cape Verde
                            </option>
                            <option @if (Setting::get('country_code') === 'KY') selected @endif value="KY">Cayman Islands
                            </option>
                            <option @if (Setting::get('country_code') === 'CF') selected @endif value="CF">Central African
                                Republic</option>
                            <option @if (Setting::get('country_code') === 'TD') selected @endif value="TD">Chad</option>
                            <option @if (Setting::get('country_code') === 'CL') selected @endif value="CL">Chile</option>
                            <option @if (Setting::get('country_code') === 'CN') selected @endif value="CN">China</option>
                            <option @if (Setting::get('country_code') === 'CX') selected @endif value="CX">Christmas Island
                            </option>
                            <option @if (Setting::get('country_code') === 'CC') selected @endif value="CC">Cocos (Keeling)
                                Islands</option>
                            <option @if (Setting::get('country_code') === 'CO') selected @endif value="CO">Colombia
                            </option>
                            <option @if (Setting::get('country_code') === 'KM') selected @endif value="KM">Comoros</option>
                            <option @if (Setting::get('country_code') === 'CG') selected @endif value="CG">Congo</option>
                            <option @if (Setting::get('country_code') === 'CD') selected @endif value="CD">Congo,
                                Democratic Republic of the Congo</option>
                            <option @if (Setting::get('country_code') === 'CK') selected @endif value="CK">Cook Islands
                            </option>
                            <option @if (Setting::get('country_code') === 'CR') selected @endif value="CR">Costa Rica
                            </option>
                            <option @if (Setting::get('country_code') === 'CI') selected @endif value="CI">Cote D'Ivoire
                            </option>
                            <option @if (Setting::get('country_code') === 'HR') selected @endif value="HR">Croatia</option>
                            <option @if (Setting::get('country_code') === 'CU') selected @endif value="CU">Cuba</option>
                            <option @if (Setting::get('country_code') === 'CW') selected @endif value="CW">Curacao</option>
                            <option @if (Setting::get('country_code') === 'CY') selected @endif value="CY">Cyprus</option>
                            <option @if (Setting::get('country_code') === 'CZ') selected @endif value="CZ">Czech Republic
                            </option>
                            <option @if (Setting::get('country_code') === 'DK') selected @endif value="DK">Denmark</option>
                            <option @if (Setting::get('country_code') === 'DJ') selected @endif value="DJ">Djibouti
                            </option>
                            <option @if (Setting::get('country_code') === 'DM') selected @endif value="DM">Dominica
                            </option>
                            <option @if (Setting::get('country_code') === 'DO') selected @endif value="DO">Dominican
                                Republic</option>
                            <option @if (Setting::get('country_code') === 'EC') selected @endif value="EC">Ecuador</option>
                            <option @if (Setting::get('country_code') === 'EG') selected @endif value="EG">Egypt</option>
                            <option @if (Setting::get('country_code') === 'SV') selected @endif value="SV">El Salvador
                            </option>
                            <option @if (Setting::get('country_code') === 'GQ') selected @endif value="GQ">Equatorial
                                Guinea</option>
                            <option @if (Setting::get('country_code') === 'ER') selected @endif value="ER">Eritrea</option>
                            <option @if (Setting::get('country_code') === 'EE') selected @endif value="EE">Estonia</option>
                            <option @if (Setting::get('country_code') === 'ET') selected @endif value="ET">Ethiopia
                            </option>
                            <option @if (Setting::get('country_code') === 'FK') selected @endif value="FK">Falkland Islands
                                (Malvinas)</option>
                            <option @if (Setting::get('country_code') === 'FO') selected @endif value="FO">Faroe Islands
                            </option>
                            <option @if (Setting::get('country_code') === 'FJ') selected @endif value="FJ">Fiji</option>
                            <option @if (Setting::get('country_code') === 'FI') selected @endif value="FI">Finland</option>
                            <option @if (Setting::get('country_code') === 'FR') selected @endif value="FR">France</option>
                            <option @if (Setting::get('country_code') === 'GF') selected @endif value="GF">French Guiana
                            </option>
                            <option @if (Setting::get('country_code') === 'PF') selected @endif value="PF">French Polynesia
                            </option>
                            <option @if (Setting::get('country_code') === 'TF') selected @endif value="TF">French Southern
                                Territories</option>
                            <option @if (Setting::get('country_code') === 'GA') selected @endif value="GA">Gabon</option>
                            <option @if (Setting::get('country_code') === 'GM') selected @endif value="GM">Gambia</option>
                            <option @if (Setting::get('country_code') === 'GE') selected @endif value="GE">Georgia</option>
                            <option @if (Setting::get('country_code') === 'DE') selected @endif value="DE">Germany</option>
                            <option @if (Setting::get('country_code') === 'GH') selected @endif value="GH">Ghana</option>
                            <option @if (Setting::get('country_code') === 'GI') selected @endif value="GI">Gibraltar
                            </option>
                            <option @if (Setting::get('country_code') === 'GR') selected @endif value="GR">Greece</option>
                            <option @if (Setting::get('country_code') === 'GL') selected @endif value="GL">Greenland
                            </option>
                            <option @if (Setting::get('country_code') === 'GD') selected @endif value="GD">Grenada
                            </option>
                            <option @if (Setting::get('country_code') === 'GP') selected @endif value="GP">Guadeloupe
                            </option>
                            <option @if (Setting::get('country_code') === 'GU') selected @endif value="GU">Guam</option>
                            <option @if (Setting::get('country_code') === 'GT') selected @endif value="GT">Guatemala
                            </option>
                            <option @if (Setting::get('country_code') === 'GG') selected @endif value="GG">Guernsey
                            </option>
                            <option @if (Setting::get('country_code') === 'GN') selected @endif value="GN">Guinea</option>
                            <option @if (Setting::get('country_code') === 'GW') selected @endif value="GW">Guinea-Bissau
                            </option>
                            <option @if (Setting::get('country_code') === 'GY') selected @endif value="GY">Guyana</option>
                            <option @if (Setting::get('country_code') === 'HT') selected @endif value="HT">Haiti</option>
                            <option @if (Setting::get('country_code') === 'HM') selected @endif value="HM">Heard Island
                                and Mcdonald Islands</option>
                            <option @if (Setting::get('country_code') === 'VA') selected @endif value="VA">Holy See
                                (Vatican City State)</option>
                            <option @if (Setting::get('country_code') === 'HN') selected @endif value="HN">Honduras
                            </option>
                            <option @if (Setting::get('country_code') === 'HK') selected @endif value="HK">Hong Kong
                            </option>
                            <option @if (Setting::get('country_code') === 'HU') selected @endif value="HU">Hungary
                            </option>
                            <option @if (Setting::get('country_code') === 'IS') selected @endif value="IS">Iceland
                            </option>
                            <option @if (Setting::get('country_code') === 'IN') selected @endif value="IN">India</option>
                            <option @if (Setting::get('country_code') === 'ID') selected @endif value="ID">Indonesia
                            </option>
                            <option @if (Setting::get('country_code') === 'IR') selected @endif value="IR">Iran, Islamic
                                Republic of</option>
                            <option @if (Setting::get('country_code') === 'IQ') selected @endif value="IQ">Iraq</option>
                            <option @if (Setting::get('country_code') === 'IE') selected @endif value="IE">Ireland
                            </option>
                            <option @if (Setting::get('country_code') === 'IM') selected @endif value="IM">Isle of Man
                            </option>
                            <option @if (Setting::get('country_code') === 'IL') selected @endif value="IL">Israel
                            </option>
                            <option @if (Setting::get('country_code') === 'IT') selected @endif value="IT">Italy</option>
                            <option @if (Setting::get('country_code') === 'JM') selected @endif value="JM">Jamaica
                            </option>
                            <option @if (Setting::get('country_code') === 'JP') selected @endif value="JP">Japan</option>
                            <option @if (Setting::get('country_code') === 'JE') selected @endif value="JE">Jersey
                            </option>
                            <option @if (Setting::get('country_code') === 'JO') selected @endif value="JO">Jordan
                            </option>
                            <option @if (Setting::get('country_code') === 'KZ') selected @endif value="KZ">Kazakhstan
                            </option>
                            <option @if (Setting::get('country_code') === 'KE') selected @endif value="KE">Kenya</option>
                            <option @if (Setting::get('country_code') === 'KI') selected @endif value="KI">Kiribati
                            </option>
                            <option @if (Setting::get('country_code') === 'KP') selected @endif value="KP">Korea,
                                Democratic People's Republic of</option>
                            <option @if (Setting::get('country_code') === 'KR') selected @endif value="KR">Korea,
                                Republic of</option>
                            <option @if (Setting::get('country_code') === 'XK') selected @endif value="XK">Kosovo
                            </option>
                            <option @if (Setting::get('country_code') === 'KW') selected @endif value="KW">Kuwait
                            </option>
                            <option @if (Setting::get('country_code') === 'KG') selected @endif value="KG">Kyrgyzstan
                            </option>
                            <option @if (Setting::get('country_code') === 'LA') selected @endif value="LA">Lao People's
                                Democratic Republic</option>
                            <option @if (Setting::get('country_code') === 'LV') selected @endif value="LV">Latvia
                            </option>
                            <option @if (Setting::get('country_code') === 'LB') selected @endif value="LB">Lebanon
                            </option>
                            <option @if (Setting::get('country_code') === 'LS') selected @endif value="LS">Lesotho
                            </option>
                            <option @if (Setting::get('country_code') === 'LR') selected @endif value="LR">Liberia
                            </option>
                            <option @if (Setting::get('country_code') === 'LY') selected @endif value="LY">Libyan Arab
                                Jamahiriya</option>
                            <option @if (Setting::get('country_code') === 'LI') selected @endif value="LI">Liechtenstein
                            </option>
                            <option @if (Setting::get('country_code') === 'LT') selected @endif value="LT">Lithuania
                            </option>
                            <option @if (Setting::get('country_code') === 'LU') selected @endif value="LU">Luxembourg
                            </option>
                            <option @if (Setting::get('country_code') === 'MO') selected @endif value="MO">Macao</option>
                            <option @if (Setting::get('country_code') === 'MK') selected @endif value="MK">Macedonia, the
                                Former Yugoslav Republic of</option>
                            <option @if (Setting::get('country_code') === 'MG') selected @endif value="MG">Madagascar
                            </option>
                            <option @if (Setting::get('country_code') === 'MW') selected @endif value="MW">Malawi
                            </option>
                            <option @if (Setting::get('country_code') === 'MY') selected @endif value="MY">Malaysia
                            </option>
                            <option @if (Setting::get('country_code') === 'MV') selected @endif value="MV">Maldives
                            </option>
                            <option @if (Setting::get('country_code') === 'ML') selected @endif value="ML">Mali</option>
                            <option @if (Setting::get('country_code') === 'MT') selected @endif value="MT">Malta</option>
                            <option @if (Setting::get('country_code') === 'MH') selected @endif value="MH">Marshall
                                Islands</option>
                            <option @if (Setting::get('country_code') === 'MQ') selected @endif value="MQ">Martinique
                            </option>
                            <option @if (Setting::get('country_code') === 'MR') selected @endif value="MR">Mauritania
                            </option>
                            <option @if (Setting::get('country_code') === 'MU') selected @endif value="MU">Mauritius
                            </option>
                            <option @if (Setting::get('country_code') === 'YT') selected @endif value="YT">Mayotte
                            </option>
                            <option @if (Setting::get('country_code') === 'MX') selected @endif value="MX">Mexico
                            </option>
                            <option @if (Setting::get('country_code') === 'FM') selected @endif value="FM">Micronesia,
                                Federated States of</option>
                            <option @if (Setting::get('country_code') === 'MD') selected @endif value="MD">Moldova,
                                Republic of</option>
                            <option @if (Setting::get('country_code') === 'MC') selected @endif value="MC">Monaco
                            </option>
                            <option @if (Setting::get('country_code') === 'MN') selected @endif value="MN">Mongolia
                            </option>
                            <option @if (Setting::get('country_code') === 'ME') selected @endif value="ME">Montenegro
                            </option>
                            <option @if (Setting::get('country_code') === 'MS') selected @endif value="MS">Montserrat
                            </option>
                            <option @if (Setting::get('country_code') === 'MA') selected @endif value="MA">Morocco
                            </option>
                            <option @if (Setting::get('country_code') === 'MZ') selected @endif value="MZ">Mozambique
                            </option>
                            <option @if (Setting::get('country_code') === 'MM') selected @endif value="MM">Myanmar
                            </option>
                            <option @if (Setting::get('country_code') === 'NA') selected @endif value="NA">Namibia
                            </option>
                            <option @if (Setting::get('country_code') === 'NR') selected @endif value="NR">Nauru</option>
                            <option @if (Setting::get('country_code') === 'NP') selected @endif value="NP">Nepal</option>
                            <option @if (Setting::get('country_code') === 'NL') selected @endif value="NL">Netherlands
                            </option>
                            <option @if (Setting::get('country_code') === 'AN') selected @endif value="AN">Netherlands
                                Antilles</option>
                            <option @if (Setting::get('country_code') === 'NC') selected @endif value="NC">New Caledonia
                            </option>
                            <option @if (Setting::get('country_code') === 'NZ') selected @endif value="NZ">New Zealand
                            </option>
                            <option @if (Setting::get('country_code') === 'NI') selected @endif value="NI">Nicaragua
                            </option>
                            <option @if (Setting::get('country_code') === 'NE') selected @endif value="NE">Niger</option>
                            <option @if (Setting::get('country_code') === 'NG') selected @endif value="NG">Nigeria
                            </option>
                            <option @if (Setting::get('country_code') === 'NU') selected @endif value="NU">Niue</option>
                            <option @if (Setting::get('country_code') === 'NF') selected @endif value="NF">Norfolk Island
                            </option>
                            <option @if (Setting::get('country_code') === 'MP') selected @endif value="MP">Northern
                                Mariana Islands</option>
                            <option @if (Setting::get('country_code') === 'NO') selected @endif value="NO">Norway
                            </option>
                            <option @if (Setting::get('country_code') === 'OM') selected @endif value="OM">Oman</option>
                            <option @if (Setting::get('country_code') === 'PK') selected @endif value="PK">Pakistan
                            </option>
                            <option @if (Setting::get('country_code') === 'PW') selected @endif value="PW">Palau</option>
                            <option @if (Setting::get('country_code') === 'PS') selected @endif value="PS">Palestinian
                                Territory, Occupied</option>
                            <option @if (Setting::get('country_code') === 'PA') selected @endif value="PA">Panama
                            </option>
                            <option @if (Setting::get('country_code') === 'PG') selected @endif value="PG">Papua New
                                Guinea</option>
                            <option @if (Setting::get('country_code') === 'PY') selected @endif value="PY">Paraguay
                            </option>
                            <option @if (Setting::get('country_code') === 'PE') selected @endif value="PE">Peru</option>
                            <option @if (Setting::get('country_code') === 'PH') selected @endif value="PH">Philippines
                            </option>
                            <option @if (Setting::get('country_code') === 'PN') selected @endif value="PN">Pitcairn
                            </option>
                            <option @if (Setting::get('country_code') === 'PL') selected @endif value="PL">Poland
                            </option>
                            <option @if (Setting::get('country_code') === 'PT') selected @endif value="PT">Portugal
                            </option>
                            <option @if (Setting::get('country_code') === 'PR') selected @endif value="PR">Puerto Rico
                            </option>
                            <option @if (Setting::get('country_code') === 'QA') selected @endif value="QA">Qatar</option>
                            <option @if (Setting::get('country_code') === 'RE') selected @endif value="RE">Reunion
                            </option>
                            <option @if (Setting::get('country_code') === 'RO') selected @endif value="RO">Romania
                            </option>
                            <option @if (Setting::get('country_code') === 'RU') selected @endif value="RU">Russian
                                Federation</option>
                            <option @if (Setting::get('country_code') === 'RW') selected @endif value="RW">Rwanda
                            </option>
                            <option @if (Setting::get('country_code') === 'BL') selected @endif value="BL">Saint
                                Barthelemy</option>
                            <option @if (Setting::get('country_code') === 'SH') selected @endif value="SH">Saint Helena
                            </option>
                            <option @if (Setting::get('country_code') === 'KN') selected @endif value="KN">Saint Kitts
                                and Nevis</option>
                            <option @if (Setting::get('country_code') === 'LC') selected @endif value="LC">Saint Lucia
                            </option>
                            <option @if (Setting::get('country_code') === 'MF') selected @endif value="MF">Saint Martin
                            </option>
                            <option @if (Setting::get('country_code') === 'PM') selected @endif value="PM">Saint Pierre
                                and Miquelon</option>
                            <option @if (Setting::get('country_code') === 'VC') selected @endif value="VC">Saint Vincent
                                and the Grenadines</option>
                            <option @if (Setting::get('country_code') === 'WS') selected @endif value="WS">Samoa</option>
                            <option @if (Setting::get('country_code') === 'SM') selected @endif value="SM">San Marino
                            </option>
                            <option @if (Setting::get('country_code') === 'ST') selected @endif value="ST">Sao Tome and
                                Principe</option>
                            <option @if (Setting::get('country_code') === 'SA') selected @endif value="SA">Saudi Arabia
                            </option>
                            <option @if (Setting::get('country_code') === 'SN') selected @endif value="SN">Senegal
                            </option>
                            <option @if (Setting::get('country_code') === 'RS') selected @endif value="RS">Serbia
                            </option>
                            <option @if (Setting::get('country_code') === 'CS') selected @endif value="CS">Serbia and
                                Montenegro</option>
                            <option @if (Setting::get('country_code') === 'SC') selected @endif value="SC">Seychelles
                            </option>
                            <option @if (Setting::get('country_code') === 'SL') selected @endif value="SL">Sierra Leone
                            </option>
                            <option @if (Setting::get('country_code') === 'SG') selected @endif value="SG">Singapore
                            </option>
                            <option @if (Setting::get('country_code') === 'SX') selected @endif value="SX">Sint Maarten
                            </option>
                            <option @if (Setting::get('country_code') === 'SK') selected @endif value="SK">Slovakia
                            </option>
                            <option @if (Setting::get('country_code') === 'SI') selected @endif value="SI">Slovenia
                            </option>
                            <option @if (Setting::get('country_code') === 'SB') selected @endif value="SB">Solomon
                                Islands</option>
                            <option @if (Setting::get('country_code') === 'SO') selected @endif value="SO">Somalia
                            </option>
                            <option @if (Setting::get('country_code') === 'ZA') selected @endif value="ZA">South Africa
                            </option>
                            <option @if (Setting::get('country_code') === 'GS') selected @endif value="GS">South Georgia
                                and the South Sandwich Islands</option>
                            <option @if (Setting::get('country_code') === 'SS') selected @endif value="SS">South Sudan
                            </option>
                            <option @if (Setting::get('country_code') === 'ES') selected @endif value="ES">Spain</option>
                            <option @if (Setting::get('country_code') === 'LK') selected @endif value="LK">Sri Lanka
                            </option>
                            <option @if (Setting::get('country_code') === 'SD') selected @endif value="SD">Sudan</option>
                            <option @if (Setting::get('country_code') === 'SR') selected @endif value="SR">Suriname
                            </option>
                            <option @if (Setting::get('country_code') === 'SJ') selected @endif value="SJ">Svalbard and
                                Jan Mayen</option>
                            <option @if (Setting::get('country_code') === 'SZ') selected @endif value="SZ">Swaziland
                            </option>
                            <option @if (Setting::get('country_code') === 'SE') selected @endif value="SE">Sweden
                            </option>
                            <option @if (Setting::get('country_code') === 'CH') selected @endif value="CH">Switzerland
                            </option>
                            <option @if (Setting::get('country_code') === 'SY') selected @endif value="SY">Syrian Arab
                                Republic</option>
                            <option @if (Setting::get('country_code') === 'TW') selected @endif value="TW">Taiwan,
                                Province of China</option>
                            <option @if (Setting::get('country_code') === 'TJ') selected @endif value="TJ">Tajikistan
                            </option>
                            <option @if (Setting::get('country_code') === 'TZ') selected @endif value="TZ">Tanzania,
                                United Republic of</option>
                            <option @if (Setting::get('country_code') === 'TH') selected @endif value="TH">Thailand
                            </option>
                            <option @if (Setting::get('country_code') === 'TL') selected @endif value="TL">Timor-Leste
                            </option>
                            <option @if (Setting::get('country_code') === 'TG') selected @endif value="TG">Togo</option>
                            <option @if (Setting::get('country_code') === 'TK') selected @endif value="TK">Tokelau
                            </option>
                            <option @if (Setting::get('country_code') === 'TO') selected @endif value="TO">Tonga</option>
                            <option @if (Setting::get('country_code') === 'TT') selected @endif value="TT">Trinidad and
                                Tobago</option>
                            <option @if (Setting::get('country_code') === 'TN') selected @endif value="TN">Tunisia
                            </option>
                            <option @if (Setting::get('country_code') === 'TR') selected @endif value="TR">Turkey
                            </option>
                            <option @if (Setting::get('country_code') === 'TM') selected @endif value="TM">Turkmenistan
                            </option>
                            <option @if (Setting::get('country_code') === 'TC') selected @endif value="TC">Turks and
                                Caicos Islands</option>
                            <option @if (Setting::get('country_code') === 'TV') selected @endif value="TV">Tuvalu
                            </option>
                            <option @if (Setting::get('country_code') === 'UG') selected @endif value="UG">Uganda
                            </option>
                            <option @if (Setting::get('country_code') === 'UA') selected @endif value="UA">Ukraine
                            </option>
                            <option @if (Setting::get('country_code') === 'AE') selected @endif value="AE">United Arab
                                Emirates</option>
                            <option @if (Setting::get('country_code') === 'GB') selected @endif value="GB">United Kingdom
                            </option>
                            <option @if (Setting::get('country_code') === 'US') selected @endif value="US">United States
                            </option>
                            <option @if (Setting::get('country_code') === 'UM') selected @endif value="UM">United States
                                Minor Outlying Islands</option>
                            <option @if (Setting::get('country_code') === 'UY') selected @endif value="UY">Uruguay
                            </option>
                            <option @if (Setting::get('country_code') === 'UZ') selected @endif value="UZ">Uzbekistan
                            </option>
                            <option @if (Setting::get('country_code') === 'VU') selected @endif value="VU">Vanuatu
                            </option>
                            <option @if (Setting::get('country_code') === 'VE') selected @endif value="VE">Venezuela
                            </option>
                            <option @if (Setting::get('country_code') === 'VN') selected @endif value="VN">Viet Nam
                            </option>
                            <option @if (Setting::get('country_code') === 'VG') selected @endif value="VG">Virgin
                                Islands, British</option>
                            <option @if (Setting::get('country_code') === 'VI') selected @endif value="VI">Virgin
                                Islands, U.s.</option>
                            <option @if (Setting::get('country_code') === 'WF') selected @endif value="WF">Wallis and
                                Futuna</option>
                            <option @if (Setting::get('country_code') === 'EH') selected @endif value="EH">Western Sahara
                            </option>
                            <option @if (Setting::get('country_code') === 'YE') selected @endif value="YE">Yemen</option>
                            <option @if (Setting::get('country_code') === 'ZM') selected @endif value="ZM">Zambia
                            </option>
                            <option @if (Setting::get('country_code') === 'ZW') selected @endif value="ZW">Zimbabwe
                            </option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="social_login" class="col-xs-2 col-form-label">Social Login</label>
                    <div class="col-xs-10">
                        <select class="form-control" id="social_login" name="social_login">
                            <option value="1" @if (Setting::get('social_login', 0) == 1) selected @endif>Enable
                            </option>
                            <option value="0" @if (Setting::get('social_login', 0) == 0) selected @endif>Disable
                            </option>
                        </select>
                    </div>
                </div>

                <br/><br/>
                <h5>Other Settings</h5><br/><br/>

                <div class="form-group row">
                    <label for="f_u_url" class="col-xs-2 col-form-label">User App PlayStore Link</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('f_u_url', '') }}"
                            name="f_u_url" id="f_u_url" placeholder="User App PlayStore Link">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="f_p_url" class="col-xs-2 col-form-label">Provider App PlayStore Link</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('f_p_url', '') }}"
                            name="f_p_url" id="f_p_url" placeholder="Provider App PlayStore Link">
                    </div>
                </div>

                <br/><br/>
                <h5>Social Profiles</h5><br/><br/>

                <div class="form-group row">
                    <label for="Website Link" class="col-xs-2 col-form-label">FaceBook Page Link</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('f_f_link', '') }}"
                            name="f_f_link" id="f_f_link" placeholder="FaceBook Page Link">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="Twitter Link" class="col-xs-2 col-form-label">Twitter Link</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('f_t_link', '') }}"
                            name="f_t_link" id="f_t_link" placeholder="Twitter Link">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Website Link" class="col-xs-2 col-form-label">linkedin Link</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('f_l_link', '') }}"
                            name="f_l_link" id="f_l_link" placeholder="linkedin Link">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Website Link" class="col-xs-2 col-form-label">Instagram Link</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('f_i_link', '') }}"
                            name="f_i_link" id="f_i_link" placeholder="Instagram Link">
                    </div>
                </div>

                <br/><br/>
                <h5>Contact Page Settings</h5><br/><br/>


                <div class="form-group row">
                    <label for="Contact City" class="col-xs-2 col-form-label">Contact City</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('contact_city', '') }}"
                            name="contact_city" id="contact_city" placeholder="Contact City">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Contact Address" class="col-xs-2 col-form-label">Contact Address</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('contact_address', '') }}"
                            name="contact_address" id="contact_address" placeholder="Contact Address">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Contact Email" class="col-xs-2 col-form-label">Contact Email</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="email" value="{{ Setting::get('contact_email', '') }}"
                            name="contact_email" id="contact_email" placeholder="Contact Email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Contact Phone" class="col-xs-2 col-form-label">Contact Phone</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ str_replace(' ', '', Setting::get('contact_number', '')) }}"
                            name="contact_number" id="contact_number" placeholder="Contact Phone">
                    </div>
                </div>

                <br/><br/>
                <h5>Modules</h5><br/><br/>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Provider on Web
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('driver_on_web') == 1) checked @endif name="driver_on_web"
                            id="driver_on_web" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Accountant Panel
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('account_panel') == 1) checked @endif name="account_panel"
                            id="account_panel" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div> --}}
                {{-- <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Fleet Panel
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('vendor_panel') == 1) checked @endif name="vendor_panel"
                            id="vendor_panel" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Dispatcher Panel
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('dispatcher_panel') == 1) checked @endif name="dispatcher_panel"
                            id="dispatcher_panel" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Job Button
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('ride_btn') == 1) checked @endif name="ride_btn" id="ride_btn"
                            type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Offers Section
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('offer_section') == 1) checked @endif name="offer_section" id="offer_section"
                            type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Features Section
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('features_section') == 1) checked @endif name="features_section"
                            id="features_section" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Call to action - container
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('cta_container') == 1) checked @endif name="cta_container"
                            id="cta_container" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Contact info - container
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('contact_info_container') == 1) checked @endif name="contact_info_container"
                            id="contact_info_container" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Website
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('website_enable') == 1) checked @endif name="website_enable"
                            id="website_enable" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Multi-language
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('multilanguage_enabled') == 1) checked @endif name="multilanguage_enabled"
                            id="multilanguage_enabled" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Gender preference
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('gender_pref_enabled') == 1) checked @endif name="gender_pref_enabled"
                            id="gender_pref_enabled" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Hide Conexi Code
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('hide_conexi_code') == 1) checked @endif name="hide_conexi_code"
                            id="hide_conexi_code" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>
                @if (config('app.url') == 'https://meemcolart.com' || config('app.url') == 'https://meemcolart.com/')
                    <div class="form-group row">
                        <div class="col-xs-2 col-form-label">
                            <label for="UPI_key" class="col-form-label">
                                Show preset credentials
                            </label>
                        </div>
                        <div class="col-xs-10">
                            <input @if (Setting::get('show_preset_credentials') == 1) checked @endif name="show_preset_credentials"
                                id="show_preset_credentials" type="checkbox" class="js-switch" data-color="#43b968">
                        </div>

                    </div>
                @endif



                <br/><br/>
                <h5>Frontend</h5><br/><br/>

                <div class="form-group row">
                    <label for="Contact Email" class="col-xs-2 col-form-label">Site copyright</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('site_copyright', '') }}"
                            name="site_copyright" id="site_copyright" placeholder="Site Copyright">
                    </div>
                </div>
                <h5>Email</h5><br/><br/>

                <div class="form-group row">
                    <label for="Contact Email" class="col-xs-2 col-form-label">Site Email</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('site_email', '') }}"
                            name="site_email" id="site_email" placeholder="Site Email">
                    </div>
                </div>

                <input type="hidden" accept="image/*" name="f_img2" id="f_img2" aria-describedby="fileHelp">
                <br/>
                <h5>Themes</h5>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Theme
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <select class="form-control" name="website_theme">
                            <option value="default" @if(Setting::get('website_theme') == 'default') selected @endif>Default</option>
                            <option value="conexi"  @if(Setting::get('website_theme') == 'conexi') selected @endif>Theme 1(Conexi)</option>
                        </select>
                    </div>
                </div>


                <input type="hidden" accept="image/*" name="f_img2" id="f_img2" aria-describedby="fileHelp">
                <br/>

                <h5>Color</h5>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Color
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <select class="form-control" name="website_theme_color">
                            <option value="default" @if(Setting::get('website_theme_color') == 'default') selected @endif>Default</option>
                            <option value="blue"  @if(Setting::get('website_theme_color') == 'blue') selected @endif>Blue</option>
                            <option value="red"  @if(Setting::get('website_theme_color') == 'red') selected @endif>Red</option>
                            <option value="green"  @if(Setting::get('website_theme_color') == 'green') selected @endif>Green</option>
                            <option value="orange"  @if(Setting::get('website_theme_color') == 'orange') selected @endif>Orange</option>
                            <option value="black"  @if(Setting::get('website_theme_color') == 'black') selected @endif>Black</option>
                            <option value="purple"  @if(Setting::get('website_theme_color') == 'purple') selected @endif>Purple</option>
                            <option value="gold"  @if(Setting::get('website_theme_color') == 'gold') selected @endif>Gold</option>
                            <option value="silver"  @if(Setting::get('website_theme_color') == 'silver') selected @endif>Silver</option>
                            <option value="pink"  @if(Setting::get('website_theme_color') == 'pink') selected @endif>Pink</option>
                            <option value="turquoise"  @if(Setting::get('website_theme_color') == 'turquoise') selected @endif>Turquoise</option>
                            <option value="cyan"  @if(Setting::get('website_theme_color') == 'cyan') selected @endif>Cyan</option>
                            <option value="limegreen"  @if(Setting::get('website_theme_color') == 'limegreen') selected @endif>Lime Green</option>
                            <option value="violet"  @if(Setting::get('website_theme_color') == 'violet') selected @endif>Violet</option>
                            <option value="brown"  @if(Setting::get('website_theme_color') == 'brown') selected @endif>Brown</option>
                        </select>
                    </div>
                </div>


                <br/>
                <h5>Service Categories (For Web)</h5>
                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Transportation
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('cat_web_ecomony') == 1) checked @endif name="cat_web_ecomony"
                            id="cat_web_ecomony" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Delivery
                        </label>
                    </div>
                    <div class="col-xs-10">
                        <input @if (Setting::get('cat_web_lux') == 1) checked @endif name="cat_web_lux"
                            id="cat_web_lux" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>


                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            Towing Service
                        </label>
                    </div>

                    <div class="col-xs-10">
                        <input @if (Setting::get('cat_web_ext') == 1) checked @endif name="cat_web_ext"
                            id="cat_web_ext" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div>


                <div class="form-group row">
                    <div class="col-xs-2 col-form-label">
                        <label for="UPI_key" class="col-form-label">
                            OutStation
                        </label>
                    </div>

                    <div class="col-xs-10">
                        <input @if (Setting::get('cat_web_out') == 1) checked @endif name="cat_web_out"
                            id="cat_web_out" type="checkbox" class="js-switch" data-color="#43b968">
                    </div>

                </div> --}}

                <div class="form-group row">
                    <label for="zipcode" class="col-xs-2 col-form-label"></label>
                    <div class="col-xs-10">
                        <button type="submit" class="btn btn-primary">Update Site Settings</button>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
@endsection
