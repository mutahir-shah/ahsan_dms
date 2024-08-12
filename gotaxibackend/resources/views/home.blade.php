@extends('layout.base')
@section('title', 'Delivery/Transport Hub')
@section('content')
    <section class="slider_area d-flex align-items-center">
        <div class="ovarlay"></div>
        <div class="background_slider slick">
            @if(Setting::get('slider_image1')!='')
                <div class="bg_img"
                     style="background: url(@settings('slider_image1')) center center / cover no-repeat scroll;"></div>
            @endif
            @if(Setting::get('slider_image2')!='')
                <div class="bg_img"
                     style="background: url({{ Setting::get('slider_image2') }}) center center / cover no-repeat scroll;"></div>
            @endif
            @if(Setting::get('slider_image3')!='')
                <div class="bg_img"
                     style="background: url({{ Setting::get('slider_image3') }}) center center / cover no-repeat scroll;"></div>
            @endif
            @if(Setting::get('slider_image4')!='')
                <div class="bg_img"
                     style="background: url({{ Setting::get('slider_image4') }}) center center / cover no-repeat scroll;"></div>
            @endif
            @if(Setting::get('slider_image5')!='')
                <div class="bg_img"
                     style="background: url({{ Setting::get('slider_image5') }}) center center / cover no-repeat scroll;"></div>
            @endif
        </div>
        <div class="container">
            <div class="slider_text text-center">
                <h1>{{Setting::get('site_title', '')}} <br>{{ translateKeyword('Gets You There')}}</h1>
                <a href="#ride_now" class="btn slider_btn yellow_hover">{{ translateKeyword('f_50')}}</a>
                <a name="ride_now">
            </div>
        </div>
    </section>
    <section class="booking_form_area bg_one">
        <div class="container">
            <div class="booking_slider slick">
                <div class="booking_form_info">
                    <div class="tab_img">
                        <div class="b_overlay_bg"></div>
                        <img src="mainindex/img/slider/booking_car.png" alt="booking_car">
                    </div>
                    <div class="boking_content">
                        <h2>{{ translateKeyword('online_booking')}}</h2>
                        <form action="{{ route('booking-request') }}" class="row booking_form"
                              data-pickme="contact-froms" method="POST">
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <div class="form-group choose_item">
                                    <label>
                                        <input type="radio" value="Taxi" name="radio_group" checked>
                                        <span>Taxi</span>
                                    </label>
                                    {{--  <label>
                                         <input type="radio" value="Delivery" name="radio_group">
                                         <span>Delivery</span>
                                     </label>
                                     <label>
                                         <input type="radio" value="Towing Service" name="radio_group">
                                         <span>Truck</span>
                                     </label>
                                     <label>
                                         <input type="radio" value="Outstation" name="radio_group">
                                         <span>Kids Pickup</span>
                                     </label> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="&#xe08a  Your Name"
                                           required>
                                    <label class="border_line"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="phone" placeholder="&#xe090  Phone"
                                           required>
                                    <label class="border_line"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="addressField1" name="sdestination"
                                           placeholder="&#xe01d  Start Destination" required>
                                    <label class="border_line"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="addressField2" name="edestination"
                                           placeholder="&#xe01d  End Destination" required>
                                    <label class="border_line"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="datetime-local" class="form-control date-input-css" name="date"
                                           placeholder="&#xe06b Date" required>
                                    <label class="border_line"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{-- <input type="text" class="form-control" name="car_type" placeholder="&#xe0db;  Car Type"> --}}
                                    <label class="border_line"></label>
                                    <select class="form-control" name="car_type">
                                        <option disabled selected>{{ translateKeyword('Select service type')}}</option>
                                        @foreach (get_all_service_types() as $serviceType)
                                            <option value="{{$serviceType->name}}">{{$serviceType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <button type="submit" name="submit" class="btn slider_btn dark_hover">{{ translateKeyword('book_now')}}
                                    </button>
                                </div>

                                <div class="form-result alert">
                                    <div class="content"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="featured_area bg_one">
        <div class="container">
            <div class="section_title text-center">
                <h5>{{ translateKeyword('what_we_offer')}}</h5>
                <h2>{{ translateKeyword('we_are_a_transportation_service')}}</h2>
            </div>
            <div class="row featured_info slick">
                <div class="col-lg-12">
                    <div class="featured_item">
                        <i class="flaticon-map icon"></i>
                        <h3>{{ translateKeyword('fast_and_easy_transport')}}</h3>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="featured_item">
                        <i class="flaticon-hotel icon"></i>
                        <h3>{{ translateKeyword('move_anywhere_you_want')}}</h3>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="featured_item">
                        <i class="flaticon-hotel icon"></i>
                        <h3>{{ translateKeyword('f_15')}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="get_app_area sec_pad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="get_app_content">
                        <div class="section_title">
                            <h5>Search {{Setting::get('site_title', '')}} App</h5>
                            <h2>Get {{Setting::get('site_title', '')}} APP Now</h2>
                        </div>
                        <ul>
                            <li>{{ translateKeyword('quick_and_easy_booking')}}</li>
                            <li>{{ translateKeyword('service_available')}}</li>
                            <li>{{ translateKeyword('reliable_gps_enabled')}}</li>
                            <li>{{ translateKeyword('cost_effective')}}</li>
                        </ul>
                        <a href="{{Setting::get('f_u_url', '')}}" class="app_btn slider_btn" target="_blank"><img
                                    src="{{ asset('mainindex/img/icon/play-store.png') }}" alt="play-store">Google Play</a>
                        <a href="{{Setting::get('user_store_link_ios', '')}}" class="app_btn_two slider_btn"
                           target="_blank"><img
                                    src="{{ asset('mainindex/img/icon/apple-store.png') }}" alt="apple-store">App Store</a>
                    </div>
                </div>
                <div class="col-lg-5 app_image">
                    <div class="image_first">
                        @if(Setting::get('mockup_one')!='')
                            <img src="{{ Setting::get('mockup_one') }}" alt="mockup_one" style="height: 641px;">
                        @endif
                        <div class="shadow_bottom"></div>
                    </div>
                    <div class="image_two">
                        @if(Setting::get('mockup_one')!='')
                            <img src="{{ Setting::get('mockup_two') }}" alt="mockup_two" style="height: 641px;">
                        @endif
                        <div class="shadow_bottom"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="advantage_area bg_one">
        <div class="container">
            <div class="section_title text-center">
                <h5>Main Features</h5>
                <h2>Our Advantages</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="advantage_item">
                        <i class="flaticon-gear"></i>
                        <h3>100% Pleasure</h3>
                        <p>Get 100% Pleasure in your ride without any hesitions</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="advantage_item">
                        <i class="flaticon-travel"></i>
                        <h3>Lots of locations</h3>
                        <p>Available almost everywhere in this region, Explore now</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="advantage_item">
                        <i class="flaticon-car"></i>
                        <h3>Luxury Cars</h3>
                        <p>Get Luxury cars to ride as per your demands</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="advantage_item">
                        <i class="flaticon-bag"></i>
                        <h3>Additional Services</h3>
                        <p>Get additional services as you need to travel</p>
                    </div>
                </div>
            </div>
            <div class="car_img">
                <img class="car_one wow caranimationTwo" data-wow-delay="0.3s" src="mainindex/img/car/car_01.png"
                     alt="car_01">
                <img class="car_two wow caranimationOne" data-wow-delay="1s" src="mainindex/img/car/car_02.png"
                     alt="car_02">
            </div>
        </div>
    </section>
    <section class="call_action_area">
        @if(Setting::get('cta_container') == 1)
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="action_img">
                            <div class="overlay_bg"></div>
                            <img src="mainindex/img/action_img.jpg" alt="action_img">
                        </div>
                    </div>
                    <div class="col-lg-5 d-flex align-items-center">
                        <div class="action_content">
                            <h3>Call us to Make a Booking</h3>
                            <a href="tel:{{ str_replace(' ', '', Setting::get('contact_number', '')) }}"
                               class="call_btn">{{ str_replace(' ', '', Setting::get('contact_number', '')) }}</a>
                            <p>Our Customer Care Team will call you back and inform you of the cost to travel</p>
                            <a href="contact" class="slider_btn dark_hover">Discover <i class="icon_plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </section>
    <!-- End Google Tag Manager -->
    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=
<?php 
echo Setting::get('map_key');
?>&libraries=places" async defer></script>
    <script language="javascript" type="application/javascript">
        function initialize() {
            var input = document.getElementById('addressField1');
            var autocomplete = new google.maps.places.Autocomplete(input);
            var input = document.getElementById('addressField2');
            var autocomplete = new google.maps.places.Autocomplete(input);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endsection
