@extends('themes.conexi.layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css" rel="stylesheet"
    media="screen">
<style>
    .intl-tel-input {
        z-index: 15;
        width: 100%;
        margin-bottom: 10px;
        padding-left: 25px;
    }

    .intl-tel-input .flag-container {
        padding-left: 35px !important;
    }

    /* Increase the size and change the color of the calendar icon for Chrome, Safari, and Edge */

    input[type="datetime-local"]::-webkit-calendar-picker-indicator {

        width: 15px;
        padding: 0px;
        margin: 0px;
        margin-top: 10px;
    }


    input[type="date"]::-webkit-calendar-picker-indicator {

        width: 15px;
        padding: 0px;
        margin: 0px;
        margin-top: 10px;
    }

    /* Target the specific class and style the calendar icon for Chrome, Safari, and Edge */
    .datetime-local::-webkit-calendar-picker-indicator {
        font-size: 20px;
        /* Increase the icon size */
        color: #3498db;
        /* Change the icon color */
        opacity: 1;
        /* Ensure the icon is fully visible */
    }

    /* For Firefox */
    .datetime-local::-moz-calendar-picker-indicator {
        font-size: 20px;
        /* Increase the icon size */
        color: #3498db;
        /* Change the icon color */
    }
</style>
@endpush

@section('content')
<section class="banner-style-one owl-theme owl-carousel no-dots">
    <div class="slide slide-one" style="background-image: url({{ Setting::get('slider_image1') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="banner-title">Cheap & Trusted <br> Taxi Company</h3>
                    <p>Enjoy your comfortable trip with <br> {{ Setting::get('site_title', '') }} taxi
                        company </p>
                    <div class="btn-block">
                        <a href="#" class="banner-btn">Learn More</a>
                    </div><!-- /.btn-block -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.slide -->
    <div class="slide slide-one" style="background-image: url({{ Setting::get('slider_image2') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="banner-title">Cheap & Trusted <br> Taxi Company</h3>
                    <p>Enjoy your comfortable trip with <br> {{ Setting::get('site_title', '') }} taxi
                        company </p>
                    <div class="btn-block">
                        <a href="#" class="banner-btn">Learn More</a>
                    </div><!-- /.btn-block -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.slide -->
    <div class="slide slide-one" style="background-image: url({{ Setting::get('slider_image3') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="banner-title">Cheap & Trusted <br> Taxi Company</h3>
                    <p>Enjoy your comfortable trip with <br> {{ Setting::get('site_title', '') }} taxi
                        company </p>
                    <div class="btn-block">
                        <a href="#" class="banner-btn">Learn More</a>
                    </div><!-- /.btn-block -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.slide -->
    <div class="slide slide-one" style="background-image: url({{ Setting::get('slider_image4') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="banner-title">Cheap & Trusted <br> Taxi Company</h3>
                    <p>Enjoy your comfortable trip with <br> {{ Setting::get('site_title', '') }} taxi
                        company </p>
                    <div class="btn-block">
                        <a href="#" class="banner-btn">Learn More</a>
                    </div><!-- /.btn-block -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.slide -->
    <div class="slide slide-two" style="background-image: url({{ Setting::get('slider_image5')}});">
        {{-- <div class="slide slide-two" style="background-image: url({{ asset('conexi/images/slider/slider-1-2.jpg') }});"> --}}
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="banner-title">Cheap & Trusted <br> Taxi Company</h3>
                    <p>Enjoy your comfortable trip with <br> {{ Setting::get('site_title', '') }} taxi company </p>
                    <div class="btn-block">
                        <a href="#" class="banner-btn">Learn More</a>
                    </div><!-- /.btn-block -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.slide -->
</section><!-- /.banner-style-one -->


{{-- <div class="carousel-btn-block banner-carousel-btn">
        <span class="carousel-btn left-btn"><i class="conexi-icon-left"></i></span>
        <span class="carousel-btn right-btn"><i class="conexi-icon-right"></i></span>
    </div><!-- /.carousel-btn-block banner-carousel-btn --> --}}

    <!-- /.book-ride-one starts here-->
<section class="book-ride-one taxi-style-one">
    <img src="{{ asset('conexi/images/background/booking-bg-1-1.png') }}" class="footer-bg" alt="Awesome Image" />
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="content-block">
                    <div class="block-title mb-0">
                        <div class="dot-line"></div><!-- /.dot-line -->
                        <p class="light">Looking for taxi?</p>
                        <h2 class="light">{{ translateKeyword('online_booking') }}</h2>
                    </div><!-- /.block-title -->
                    <p>Our taxis commit to make your trips unique <br> by best answering your needs.</p>
                </div><!-- /.content-block -->
            </div><!-- /.col-lg-4 -->

            <div class="col-lg-8 tab-content">
                <ul class="nav nav-tabs tab-title" role="tablist">
                    @if (Setting::get('cat_web_ecomony') == 1)
                    <li class="nav-item">
                        <a class="nav-link active" href="#transportation" role="tab" data-toggle="tab" onclick="getservices('economy')">{{ translateKeyword('transportation') }}</a>
                    </li>@endif
                    @if (Setting::get('cat_web_lux') == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="#transportation" role="tab" data-toggle="tab" onclick="getservices('luxury')">{{ translateKeyword('delivery') }}</a>
                    </li>@endif
                    @if (Setting::get('cat_web_ext') == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="#transportation" role="tab" data-toggle="tab" onclick="getservices('extra_seat')">{{ translateKeyword('tow_truck') }}</a>
                    </li>@endif
                    @if (Setting::get('cat_web_out') == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="#transportation" role="tab" data-toggle="tab" onclick="getservices('outstation')">{{ translateKeyword('outstation') }}</a>
                    </li>@endif
                    @if (Setting::get('cat_web_dream_driver') == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="#transportation" role="tab" data-toggle="tab" onclick="getservices('dream_driver')">{{ translateKeyword('dream-driver') }}</a>
                    </li>@endif
                    @if (Setting::get('cat_web_road_assist') == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="#transportation" role="tab" data-toggle="tab" onclick="getservices('road_assistance')">{{ translateKeyword('road_assistance') }}</a>
                    </li>
                    @endif
                </ul> 
                <div role="tabpanel" class="tab-pane show active  animated fadeInUp" id="transportation">
                    <form class="booking-form-one" action="{{ route('booking-request') }}" data-pickme="contact-froms" method="POST">
                        {{ csrf_field() }}
                        @php
                        $defaultService = '';
                        $services = [
                        'economy' => 'cat_web_ecomony',
                        'luxury' => 'cat_web_lux',
                        'extra_seat' => 'cat_web_ext',
                        'outstation' => 'cat_web_out',
                        'dream_driver' => 'cat_web_dream_driver',
                        'road_assistance' => 'cat_web_road_assist',
                        ];
                        @endphp

                        @foreach ($services as $service => $setting)
                        @if (Setting::get($setting) == 1)
                        @php
                        $defaultService = $defaultService == '' ? $service : $defaultService;
                        @endphp
                        @if ($loop->first)
                        <input type="hidden" name="radio_group" id="radio_group" value="{{ $service }}">
                        @endif
                        @endif
                        @endforeach

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-holder">
                                    <input type="text" name="name" require placeholder="{{ translateKeyword('full_name') }}">
                                    <i class="fa fa-user"></i>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->

                            <div class="col-lg-6">
                                <div class="input-holder">
                                    <input type="text" name="phone" id="mobile" minlength="10"
                                        maxlength="15"
                                        placeholder="{{ translateKeyword('phone_number') }}" required>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->


                            <div class="col-lg-6" id="dname-field" style="display: none;">
                                <div class="input-holder">
                                    <input type="text" name="dname" id="dname"
                                        placeholder="{{ translateKeyword('drop_off_name') }}"> <i class="fa fa-user"></i>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->

                            <div class="col-lg-6" id="dmobile-field" style="display: none;">
                                <div class="input-holder">
                                    <input type="text" name="dphone" id="dmobile"
                                        placeholder="{{ translateKeyword('drop_off_phone') }}">
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                            @if (Setting::get('email_field', 0) == 1)
                            <div class="col-lg-12">
                                <div class="input-holder">
                                    <input type="email" id="email" name="email" placeholder="{{ translateKeyword('enter-email') }}">
                                    <i class="fa fa-envelope"></i>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                            @endif

                            <div class="col-lg-12" id="startAddress-field" style="display: none;">
                                <div class="input-holder">
                                    <input type="text" id="startAddress" name="sdestination"
                                        placeholder="{{translateKeyword('enter-address')}}"> <i class="fa fa-map-marker"></i>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->


                            <div class="col-lg-6" id="address1-field">
                                <div class="input-holder">
                                    <input type="text" id="addressField1" name="sdestination"
                                        placeholder="{{ translateKeyword('departure') }}"><i class="fa fa-map-marker"></i>
                                </div>
                            </div>


                            <div class="col-lg-6" id="address2-field">
                                <div class="input-holder">
                                    <input type="text" id="addressField2" name="edestination" placeholder="{{ translateKeyword('destination') }}">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                            </div>



                            @if (Setting::get('customer_vehicle_info', 0) == 1)
                            <div class="col-lg-6" id="vehicle_model-field" style="display: none;">
                                <div class="input-holder">
                                    <input type="text" id="vehicle_model" name="vehicle_model"
                                        placeholder="{{translateKeyword('service_model')}}">

                                </div>
                            </div>
                            <div class="col-lg-6" id="vehicle_number-field" style="display: none;">
                                <div class="input-holder">
                                    <input type="text" id="vehicle_number" name="vehicle_number"
                                        placeholder="{{translateKeyword('service_number')}}">

                                </div>
                            </div>
                            @endif

                            @if (Setting::get('delivery_note', 0) == 1)
                            <div class="col-lg-12" id="specialNote-field">
                                <div class="input-holder">
                                    <input type="text" id="specialNote" name="special_note"
                                        placeholder="{{translateKeyword('please_enter_any_extra_details_here')}}">

                                </div>
                            </div>
                            @endif
                            <div class="col-lg-6">
                                <div class="input-holder">
                                    <input type="datetime-local" name="date" placeholder="Date" required class="datetime-local">
                                    <!--  <i class="conexi-icon-small-calendar"></i> -->
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="input-holder">
                                    <select class="selectpicker" name="car_type" id="car_type" required>
                                        <option value="" disabled selected>{{ translateKeyword('select_service_type') }}</option>
                                    </select>
                                    <i class="fa fa-angle-down select-icon"></i>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="input-holder">
                                    <button type="submit">{{ translateKeyword('book_now') }}</button>
                                </div><!-- /.input-holder -->
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
                    </form><!-- /.booking-form-one -->
                </div>

            </div><!-- /.col-lg-8 -->

        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.book-ride-one ends here-->

<section class="about-style-one ">
    <div class="container">
        <div class="block-title text-center">
            <div class="dot-line"></div><!-- /.dot-line -->
            <p>Welcome to our company</p>
            <h2>Your first choice <br> for traveling anywhere</h2>
        </div><!-- /.block-title -->
        <div class="row high-gutter">
            <div class="col-lg-6">
                <div class="about-image-block">
                    <img src="{{ Setting::get('connexi_booking_form_image', 'mainindex/img/slider/booking_car.png') }}"
                        alt="booking_car" />
                    {{-- <img src="{{ asset('conexi/images/resources/choise-1-1.png') }}" alt="Awesome Image" /> --}}
                    <p>There are many variations of passages of lorem ipsum available but the majority have suffered
                        alteration in some form by injected humour or random words which don't look even slightly
                        believable. If you are going to use a passage of lorem ipsum you need to be sure there isn't
                        anything embarrassing.</p>
                </div><!-- /.image-block -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="text-block">
                    <div class="video-block-one">
                        <div class="image-block">
                            <div class="inner-block">
                                <img src="{{ asset('conexi/images/resources/video-1-1.png') }}"
                                    alt="Awesome Image" />
                                <a href="{{Setting::get('youtube_link', '')}}" class="video-popup"><i
                                        class="fa fa-play"></i></a>
                                {{-- <a href="https://www.youtube.com/watch?v=hsb-fA6ApiE" class="video-popup"><i class="fa fa-play"></i></a> --}}
                            </div><!-- /.inner-block -->
                        </div><!-- /.image-block -->
                        <div class="content-block">
                            <h3>We’re specialized in providing a high quality service</h3>
                        </div><!-- /.content-block -->
                    </div><!-- /.video-block-one -->
                    <p>{{ Setting::get('index_paragraph', '') }}</p>
                    <hr class="style-one">
                    <div class="call-block">
                        <div class="left-block">
                            <div class="icon-block">
                                <i class="conexi-icon-phone-call"></i>
                            </div><!-- /.icon-block -->
                            <div class="content-block">
                                <p>Call us now and make <br>your booking</p>
                            </div><!-- /.content-block -->
                        </div><!-- /.left-block -->
                        <div class="right-block">
                            <a class="phone-number"
                                href="tel:{{ str_replace(' ', '', Setting::get('contact_number', '')) }}">{{ str_replace(' ', '', Setting::get('contact_number', '')) }}</a>
                        </div><!-- /.right-block -->
                        {{-- <div class="right-block">
                                <a class="phone-number" href="callto:888-888-0000">888 888 0000</a>
                            </div><!-- /.right-block --> --}}
                    </div><!-- /.call-block -->
                </div><!-- /.text-block -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.about-style-one -->

<section class="funfact-style-one">
    <div class="container">
        <div class="block-title text-center">
            <div class="dot-line"></div><!-- /.dot-line -->
            <p>Our fun facts</p>
            <h2>Numbers speak</h2>
        </div><!-- /.block-title text-center -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="single-funfact-one hvr-float-shadow">
                    <i class="conexi-icon-meter"></i>
                    <h3 class="counter">{{ Setting::get('km_driven', '') }}</h3>
                    <p>KM Driven</p>
                </div><!-- /.single-funfact-one -->
            </div><!-- /.col-lg-3 -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="single-funfact-one hvr-float-shadow">
                    <i class="conexi-icon-team"></i>
                    <h3 class="counter">{{ Setting::get('people_dropped', '') }}</h3>
                    <p>People Dropped</p>
                </div><!-- /.single-funfact-one -->
            </div><!-- /.col-lg-3 -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="single-funfact-one hvr-float-shadow">
                    <i class="conexi-icon-taxi"></i>
                    <h3 class="counter">{{ Setting::get('taxi_drivers', '') }}</h3>
                    <p>Taxis & Providers</p>
                </div><!-- /.single-funfact-one -->
            </div><!-- /.col-lg-3 -->
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="single-funfact-one hvr-float-shadow">
                    <i class="conexi-icon-happy"></i>
                    <h3 class="counter">{{ Setting::get('happy_people', '') }}</h3>
                    <p>Happy People</p>
                </div><!-- /.single-funfact-one -->
            </div><!-- /.col-lg-3 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.funfact-style-one -->

<section class="cta-style-two">
    <div class="container">
        <div class="content-block">
            <p>Make a call or fill form</p>
            <h3>Call our agent to get a quote.</h3>
        </div><!-- /.content-block -->
        <div class="button-block">
            <a href="book-ride" class="cta-btn">Book Taxi Now</a>
        </div><!-- /.button-block -->
    </div><!-- /.container -->
</section><!-- /.cta-style-two -->
@if(Setting::get('hide_conexi_code') == 1)
<section class="taxi-style-one">
    <div class="container">
        <div class="block-title text-center">
            <div class="dot-line"></div><!-- /.dot-line -->
            <p>Our best cars</p>
            <h2>Choose taxi</h2>
        </div><!-- /.block-title -->
        <ul class="nav nav-tabs tab-title" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#hybrid" role="tab" data-toggle="tab">hybrid taxi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#town" role="tab" data-toggle="tab">town taxi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#limousine" role="tab" data-toggle="tab">LIMOUSINE taxi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#suv" role="tab" data-toggle="tab">suv taxi</a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane show active  animated fadeInUp" id="hybrid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-1.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-bmw"></i>
                                </div><!-- /.icon-block -->
                                <h3>M5 2008 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-2.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-mercedes-benz"></i>
                                </div><!-- /.icon-block -->
                                <h3>E Class 2010 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-3.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-toyota"></i>
                                </div><!-- /.icon-block -->
                                <h3>Yaris 2014 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div>
            <div role="tabpanel" class="tab-pane animated fadeInUp" id="town">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-1.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-bmw"></i>
                                </div><!-- /.icon-block -->
                                <h3>M5 2008 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-2.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-mercedes-benz"></i>
                                </div><!-- /.icon-block -->
                                <h3>E Class 2010 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-3.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-toyota"></i>
                                </div><!-- /.icon-block -->
                                <h3>Yaris 2014 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div>
            <div role="tabpanel" class="tab-pane animated fadeInUp" id="limousine">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-1.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-bmw"></i>
                                </div><!-- /.icon-block -->
                                <h3>M5 2008 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-2.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-mercedes-benz"></i>
                                </div><!-- /.icon-block -->
                                <h3>E Class 2010 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-3.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-toyota"></i>
                                </div><!-- /.icon-block -->
                                <h3>Yaris 2014 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div>
            <div role="tabpanel" class="tab-pane animated fadeInUp" id="suv">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-1.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-bmw"></i>
                                </div><!-- /.icon-block -->
                                <h3>M5 2008 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-2.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-mercedes-benz"></i>
                                </div><!-- /.icon-block -->
                                <h3>E Class 2010 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="single-taxi-one">
                            <div class="inner-content">
                                <img src="{{ asset('conexi/images/pricing/pricing-1-3.png') }}"
                                    alt="Awesome Image" />
                                <div class="icon-block">
                                    <i class="conexi-icon-toyota"></i>
                                </div><!-- /.icon-block -->
                                <h3>Yaris 2014 Model</h3>
                                <ul class="feature-list">
                                    <li>
                                        <span class="name-line">Base Rate:</span>
                                        <span class="price-line">$4.30</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Per Mile/KM:</span>
                                        <span class="price-line">$2.00</span>
                                    </li>
                                    <li>
                                        <span class="name-line">Passengers:</span>
                                        <span class="price-line">4</span>
                                    </li>
                                </ul><!-- /.feature-list -->
                                <a href="single-taxi" class="book-taxi-btn">Book Taxi</a>
                            </div><!-- /.inner-content -->
                        </div><!-- /.single-taxi-one -->
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div>
        </div><!-- /.tab-content -->
    </div><!-- /.container -->
</section><!-- /.taxi-style-one -->
<hr class="style-one">
@endif
@if(Setting::get('hide_conexi_code') == 1)
<div class="brand-carousel-wrapper">
    <div class="container">
        <div class="brand-carousel-one owl-theme owl-carousel">
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-1.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-2.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-3.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-4.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-5.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-1.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-2.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-3.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-4.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
            <div class="item">
                <img src="{{ asset('conexi/images/brand/brand-1-5.jpg') }}" alt="Awesome Image" />
            </div><!-- /.item -->
        </div><!-- /.brand-carousel-one -->
    </div><!-- /.container -->
</div><!-- /.brand-carousel-wrapper -->
@endif
<section class="feature-style-one thm-black-bg">
    <img src="{{ asset('conexi/images/background/feature-bg-1-1.png') }}" alt="Awesome Image" class="feature-bg" />
    <div class="container">
        <div class="block-title text-center">
            <div class="dot-line"></div><!-- /.dot-line -->
            <p>GoTaxi benefit list</p>
            <h2 class="light">Why choose us</h2>
        </div><!-- /.block-title text-center -->
        <div class="row">
            <div class="col-lg-4">
                <div class="single-feature-one">
                    <div class="icon-block">
                        <i class="conexi-icon-insurance"></i>
                    </div><!-- /.icon-block -->
                    <h3><a href="#">100% Pleasure</a></h3>
                    <p>Get 100% Pleasure in your ride without any hesitions</p>
                    {{-- <a href="#" class="more-link">Read More</a> --}}
                </div><!-- /.single-feature-one -->
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <div class="single-feature-one">
                    <div class="icon-block">
                        <i class="conexi-icon-seatbelt"></i>
                    </div><!-- /.icon-block -->
                    <h3><a href="#">Lots of locations</a></h3>
                    <p>Available almost everywhere in this region, Explore now</p>
                    {{-- <a href="#" class="more-link">Read More</a> --}}
                </div><!-- /.single-feature-one -->
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <div class="single-feature-one">
                    <div class="icon-block">
                        <i class="conexi-icon-consent"></i>
                    </div><!-- /.icon-block -->
                    <h3><a href="#">Luxury Cars</a></h3>
                    <p>Get Luxury cars to ride as per your demands</p>
                    {{-- <a href="#" class="more-link">Read More</a> --}}
                </div><!-- /.single-feature-one -->
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.feature-style-one -->

@if(Setting::get('hide_conexi_code') == 1)
<section class="taxi-fare-one">
    <div class="container">
        <div class="block-title text-center">
            <div class="dot-line"></div><!-- /.dot-line -->
            <p>Our all taxi rates</p>
            <h2>Check taxi fares</h2>
        </div><!-- /.block-title -->
        <div class="row">
            <div class="col-lg-6">
                <div class="single-taxi-fare-one thm-base-bg hvr-float-shadow">
                    <div class="top-block">
                        <div class="icon-block">
                            <i class="conexi-icon-taxi"></i>
                        </div><!-- /.icon-block -->
                        <div class="text-block">
                            <h3>All taxi fares</h3>
                            <p>Lorem ipsum dolor sit amet cons adipisci elit.</p>
                        </div><!-- /.text-block -->
                    </div><!-- /.top-block -->
                    <ul class="features-list">
                        <li>
                            <div class="name-line">Initial charge:</div><!-- /.name-line -->
                            <div class="price-line">$2.50</div><!-- /.price-line -->
                        </li>
                        <li>
                            <div class="name-line">Additional Kilometre:</div><!-- /.name-line -->
                            <div class="price-line">$0.50</div><!-- /.price-line -->
                        </li>
                        <li>
                            <div class="name-line">Per 2 minutes in stopped traffic:</div><!-- /.name-line -->
                            <div class="price-line"> $0.66</div><!-- /.price-line -->
                        </li>
                    </ul><!-- /.features-list -->
                    <div class="button-block">
                        <a href="#" class="fare-btn">Order Taxi Now</a>
                    </div><!-- /.button-block -->
                </div><!-- /.single-taxi-fare-one -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="single-taxi-fare-one thm-base-bg hvr-float-shadow">
                    <div class="top-block">
                        <div class="icon-block">
                            <i class="conexi-icon-taxi"></i>
                        </div><!-- /.icon-block -->
                        <div class="text-block">
                            <h3>Additional fares</h3>
                            <p>Lorem ipsum dolor sit amet cons adipisci elit.</p>
                        </div><!-- /.text-block -->
                    </div><!-- /.top-block -->
                    <ul class="features-list">
                        <li>
                            <div class="name-line">One hour of waiting:</div><!-- /.name-line -->
                            <div class="price-line">$8.00</div><!-- /.price-line -->
                        </li>
                        <li>
                            <div class="name-line">4pm to 8pm weekday surcharge:</div><!-- /.name-line -->
                            <div class="price-line">$2.00</div><!-- /.price-line -->
                        </li>
                        <li>
                            <div class="name-line">8pm to 6am night surcharge:</div><!-- /.name-line -->
                            <div class="price-line"> $3.00</div><!-- /.price-line -->
                        </li>
                    </ul><!-- /.features-list -->
                    <div class="button-block">
                        <a href="#" class="fare-btn">Order Taxi Now</a>
                    </div><!-- /.button-block -->
                </div><!-- /.single-taxi-fare-one -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        <div class="block-text text-center">
            <p>There are many variations of passages of lorem ipsum available but the majority have suffered
                <br> alteration in some form by injected humour or random words which.
            </p>
        </div><!-- /.block-text -->
    </div><!-- /.container -->
</section><!-- /.taxi-fare-one -->



<section class="testimonials-style-one">
    <div class="container">
        <div class="block-title text-center">
            <div class="dot-line"></div><!-- /.dot-line -->
            <p class="light">Latest blog posts</p>
            <h2 class="light">News & updates</h2>
        </div><!-- /.block-title -->
        <div class="testimonials-one-pager">
            <a href="#" class="pager-item active" data-slide-index="1"><img
                    src="{{ asset('conexi/images/resources/testi-1-1.jpg') }}" alt="Awesome Image" /></a>
            <a href="#" class="pager-item" data-slide-index="2"><img
                    src="{{ asset('conexi/images/resources/testi-1-2.jpg') }}" alt="Awesome Image" /></a>
            <a href="#" class="pager-item" data-slide-index="3"><img
                    src="{{ asset('conexi/images/resources/testi-1-3.jpg') }}" alt="Awesome Image" /></a>
        </div><!-- /.testimonials-one-pager -->
        <ul class="slider testimonials-slider-one">
            <li class="slide-item">
                <div class="single-testimonial-one">
                    <p>This is due to their excellent service, competitive pricing and customer support. It’s
                        throughly refresing to get such a personal touch.</p>
                    <h3>Shana Druckman</h3>
                </div><!-- /.single-testimonial-one -->
            </li>
            <li class="slide-item">
                <div class="single-testimonial-one">
                    <p>This is due to their excellent service, competitive pricing and customer support. It’s
                        throughly refresing to get such a personal touch.</p>
                    <h3>Emanuel Mcnamara</h3>
                </div><!-- /.single-testimonial-one -->
            </li>
            <li class="slide-item">
                <div class="single-testimonial-one">
                    <p>This is due to their excellent service, competitive pricing and customer support. It’s
                        throughly refresing to get such a personal touch.</p>
                    <h3>Jodie Hadlock</h3>
                </div><!-- /.single-testimonial-one -->
            </li>
        </ul>
    </div><!-- /.container -->
    <div class="testimonials-one-slider-btn">
        <span class="carousel-btn left-btn"><i class="conexi-icon-left"></i></span>
        <span class="carousel-btn right-btn"><i class="conexi-icon-right"></i></span>
    </div><!-- /.carousel-btn-block banner-carousel-btn -->
</section><!-- /.testimonials-style-one -->

<section class="blog-style-one">
    <div class="container">
        <div class="block-title text-center">
            <div class="dot-line"></div><!-- /.dot-line -->
            <p>Latest blog posts</p>
            <h2>News & updates</h2>
        </div><!-- /.block-title -->
        <div class="row">
            <div class="col-xl-6 col-lg-12">
                <div class="single-blog-style-one">
                    <div class="image-block">
                        <div class="inner-block">
                            <a href="blog-details"><i class="fa fa-link"></i></a>
                            <img src="{{ asset('conexi/images/blog/blog-1-1.jpg') }}" alt="Awesome Image" />
                        </div><!-- /.inner-block -->
                    </div><!-- /.image-block -->
                    <div class="text-block">
                        <div class="meta-info">
                            <a href="#" class="date-block">20 Feb, 2019</a>
                            <a href="#">by Admin</a>
                            <span class="sep">.</span>
                            <a href="#">3 Comments</a>
                        </div><!-- /.meta-info -->
                        <h3><a href="blog-details">We ensure you that your journey is comfortable and safe</a>
                        </h3>
                        <p>There are many variations of passages of lorem ipsum available but the majority have
                            suffered alteration...</p>
                    </div><!-- /.text-block -->
                </div><!-- /.single-blog-style-one -->
            </div><!-- /.col-xl-6 col-lg-12 -->
            <div class="col-xl-6 col-lg-12">
                <div class="row blog-style-two-row">
                    <div class="col-xl-12 col-lg-6">
                        <div class="single-blog-style-two">
                            <div class="image-block">
                                <div class="inner-block">
                                    <a href="blog-details"><i class="fa fa-link"></i></a>
                                    <img src="{{ asset('conexi/images/blog/blog-2-1.jpg') }}"
                                        alt="Awesome Image" />
                                </div><!-- /.inner-block -->
                            </div><!-- /.image-block -->
                            <div class="text-block">
                                <a href="#" class="date-block">20 Feb, 2019</a>
                                <h3><a href="blog-details">Car with private and discreet cabman for a
                                        service</a></h3>
                                <div class="meta-info">
                                    <a href="#">by Admin</a>
                                    <span class="sep">.</span>
                                    <a href="#">3 Comments</a>
                                </div><!-- /.meta-info -->
                            </div><!-- /.text-block -->
                        </div><!-- /.single-blog-style-two -->
                    </div><!-- /.col-xl-12 -->
                    <div class="col-xl-12 col-lg-6">
                        <div class="single-blog-style-two">
                            <div class="image-block">
                                <div class="inner-block">
                                    <a href="blog-details"><i class="fa fa-link"></i></a>
                                    <img src="{{ asset('conexi/images/blog/blog-2-2.jpg') }}"
                                        alt="Awesome Image" />
                                </div><!-- /.inner-block -->
                            </div><!-- /.image-block -->
                            <div class="text-block">
                                <a href="#" class="date-block">20 Feb, 2019</a>
                                <h3><a href="blog-details">Our taxis commit to make your trips unique</a></h3>
                                <div class="meta-info">
                                    <a href="#">by Admin</a>
                                    <span class="sep">.</span>
                                    <a href="#">3 Comments</a>
                                </div><!-- /.meta-info -->
                            </div><!-- /.text-block -->
                        </div><!-- /.single-blog-style-two -->
                    </div><!-- /.col-xl-12 -->
                </div><!-- /.row -->
            </div><!-- /.col-xl-6 col-lg-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.blog-style-one -->
@endif
<section class="cta-style-one text-center">
    <div class="container">
        <p>Call 24 hour service available</p>
        <h3>Call now and book <br> our taxi for your next ride</h3>
        <a href="book-ride" class="cta-btn">Choose Your Taxi</a>
    </div><!-- /.container -->
</section><!-- /.cta-style-one -->
@endsection

@push('scripts')


<!-- Country picker with phone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
<script src="{{ asset('asset/js/custom-phone-input.js') }}"></script>
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('map_key')}}&libraries=places" async defer></script>
<script language="javascript" type="application/javascript">
    getservices(`economy`);

    function initialize() {
        var input = document.getElementById('addressField1');
        var autocomplete = new google.maps.places.Autocomplete(input);
        var input = document.getElementById('addressField2');
        var autocomplete = new google.maps.places.Autocomplete(input);
        var input = document.getElementById('startAddress');
        var autocomplete = new google.maps.places.Autocomplete(input);
    }
    google.maps.event.addDomListener(window, 'load', initialize);

    function getservices(service_type) {
        var serviceTypes;
        $('#radio_group').val(service_type);
        if (service_type == 'economy') {
            $("#dname-field").hide(1000);
            $("#dmobile-field").hide(1000);
            $("#address1-field").show(1000);
            $("#address2-field").show(1000);
            $("#startAddress-field").hide(1000);
            $("#vehicle_model-field").hide(1000);
            $("#vehicle_number-field").hide(1000);
            serviceTypes = `{{ get_service_types('economy') }}`;
        } else if (service_type == 'luxury') {
            $("#dname-field").show(1000);
            $("#dmobile-field").show(1000);
            $("#address1-field").show(1000);
            $("#address2-field").show(1000);
            $("#startAddress-field").hide(1000);
            $("#vehicle_model-field").hide(1000);
            $("#vehicle_number-field").hide(1000);
            serviceTypes = `{{ get_service_types('luxury') }}`;
        } else if (service_type == 'extra_seat') {
            $("#dname-field").hide(1000);
            $("#dmobile-field").hide(1000);
            $("#address1-field").show(1000);
            $("#address2-field").show(1000);
            $("#startAddress-field").hide(1000);
            $("#vehicle_model-field").show(1000);
            $("#vehicle_number-field").show(1000);
            serviceTypes = `{{ get_service_types('extra_seat') }}`;
        } else if (service_type == 'outstation') {
            $("#dname-field").hide(1000);
            $("#dmobile-field").hide(1000);
            $("#address1-field").show(1000);
            $("#address2-field").show(1000);
            $("#startAddress-field").hide(1000);
            $("#vehicle_model-field").hide(1000);
            $("#vehicle_number-field").hide(1000);
            serviceTypes = `{{ get_service_types('outstation') }}`;
        } else if (service_type == 'road_assistance') {
            $("#address1-field").hide(1000);
            $("#address2-field").hide(1000);
            $("#dname-field").hide(1000);
            $("#dmobile-field").hide(1000);
            $("#startAddress-field").show(1000);
            $("#vehicle_model-field").show(1000);
            $("#vehicle_number-field").show(1000);
            serviceTypes = `{{ get_service_types('road_assistance') }}`;
        } else if (service_type == 'dream_driver') {
            $("#dname-field").hide(1000);
            $("#dmobile-field").hide(1000);
            $("#address1-field").show(1000);
            $("#address2-field").show(1000);
            $("#startAddress-field").hide(1000);
            $("#vehicle_model-field").hide(1000);
            $("#vehicle_number-field").hide(1000);
            serviceTypes = `{{ get_service_types('dream_driver') }}`;
        }

        serviceTypes = JSON.parse(serviceTypes.replace(/&quot;/g, '"'));
        var len = serviceTypes.length;
        $("#car_type").empty();
        $("#car_type").append("<option value='' disabled selected>Select service type</option>");
        for (var i = 0; i < len; i++) {
            var name = serviceTypes[i].name;
            $("#car_type").append("<option value='" + name + "'>" + name + "</option>");
        }
        console.log(serviceTypes);
    }


    // @if(isset($defaultService))
    //     $(document).ready(function () {
    //         getservices(`{{ $defaultService }}`);
    //     });
    // @endif
</script>
@endpush