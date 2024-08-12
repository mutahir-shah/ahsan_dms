@extends('layout.base')
@section('title', 'Delivery/Transport Hub')
@section('content')

    @if (Setting::get('slider_container') == 1)

        <section class="slider_area d-flex align-items-center">
            <div class="ovarlay"></div>
            <div class="background_slider slick">
                @if (Setting::get('slider_image1') != '')
                    <div class="bg_img"
                         style="background: url({{ Setting::get('slider_image1') }}) center center / cover no-repeat scroll;">
                    </div>
                @endif
                @if (Setting::get('slider_image2') != '')
                    <div class="bg_img"
                         style="background: url({{ Setting::get('slider_image2') }}) center center / cover no-repeat scroll;">
                    </div>
                @endif
                @if (Setting::get('slider_image3') != '')
                    <div class="bg_img"
                         style="background: url({{ Setting::get('slider_image3') }}) center center / cover no-repeat scroll;">
                    </div>
                @endif
                @if (Setting::get('slider_image4') != '')
                    <div class="bg_img"
                         style="background: url({{ Setting::get('slider_image4') }}) center center / cover no-repeat scroll;">
                    </div>
                @endif
                @if (Setting::get('slider_image5') != '')
                    <div class="bg_img"
                         style="background: url({{ Setting::get('slider_image5') }}) center center / cover no-repeat scroll;">
                    </div>
                @endif
            </div>
            <div class="container">
                <div class="slider_text text-center">
                    <h1>{{ $webContent ? $webContent->site_title : '' }} <br/>{{ $webContent ? $webContent->site_sub_title : ''}}</h1>
                    @if (Setting::get('ride_btn') == 1)
                        <a href="#ride_now" class="btn slider_btn yellow_hover">{{ translateKeyword('job_now') }}</a>
                        <a name="ride_now">
                    @endif
                </div>
            </div>


            </div>

        </section>
    @endif
    <br><br><br><br> <br><br><br><br><br>

    @if (Setting::get('bookingform_on_web') == 1)
        <section class="booking_form_area bg_one">
            <div class="container">
                <div class="booking_slider slick">
                    <div class="booking_form_info ">
                        <div class="tab_img">
                            <div class="b_overlay_bg"></div>
                            <img src="{{ Setting::get('booking_form_image', 'mainindex/img/slider/booking_car.png') }}"
                                 alt="booking_car">
                        </div>
                        <div class="boking_content">
                            <h2>{{ translateKeyword('online_booking') }}</h2>
                            <form action="{{ route('booking-request') }}" class="row booking_form"
                                  data-pickme="contact-froms"
                                  method="POST">
                                {{ csrf_field() }}
                                <div class="col-md-12">
                                    <div class="form-group choose_item">
                                        @php
                                            $defaultService = '';
                                            $checked = true;
                                        @endphp
                                        @if (Setting::get('cat_web_ecomony') == 1)
                                            @php
                                               $defaultService = $defaultService == '' ? 'economy' : $defaultService;
                                            @endphp
                                            <label class="mr-3">
                                                <input type="radio" value="economy" name="radio_group"
                                                       onclick="getservices('economy')" @if($checked) checked @endif>
                                                <span>{{ translateKeyword('transportation') }}</span>
                                            </label>
                                            @php
                                                $checked = false;
                                            @endphp
                                        @endif
                                        @if (Setting::get('cat_web_lux') == 1)
                                            @php
                                                $defaultService = $defaultService == '' ? 'luxury' : $defaultService;
                                            @endphp
                                            <label class="mr-3">
                                                <input type="radio" value="luxury" name="radio_group"
                                                       onclick="getservices('luxury')" @if($checked) checked @endif>
                                                <span>{{ translateKeyword('delivery') }}</span>
                                            </label>
                                            @php
                                                $checked = false;
                                            @endphp
                                        @endif
                                        @if (Setting::get('cat_web_ext') == 1)
                                            @php
                                                $defaultService = $defaultService == '' ? 'extra_seat' : $defaultService;
                                            @endphp
                                            <label class="mr-3">
                                                <input type="radio" value="extra_seat" name="radio_group"
                                                       onclick="getservices('extra_seat')" @if($checked) checked @endif>
                                                <span>{{ translateKeyword('tow_truck') }}</span>
                                            </label>
                                            @php
                                                $checked = false;
                                            @endphp
                                        @endif
                                        @if (Setting::get('cat_web_out') == 1)
                                            @php
                                                $defaultService = $defaultService == '' ? 'outstation' : $defaultService;
                                            @endphp
                                            <label class="mr-3">
                                                <input type="radio" value="outstation" name="radio_group"
                                                       onclick="getservices('outstation')" @if($checked) checked @endif>
                                                <span>{{ translateKeyword('outstation') }}</span>
                                            </label>
                                            @php
                                                $checked = false;
                                            @endphp
                                        @endif
                                        @if (Setting::get('cat_web_dream_driver') == 1)
                                            @php
                                                $defaultService = $defaultService == '' ? 'dream_driver' : $defaultService;
                                            @endphp
                                            <label class="mr-3">
                                                <input type="radio" value="dream_driver" name="radio_group"
                                                    onclick="getservices('dream_driver')" @if($checked) checked @endif>
                                                <span>{{ translateKeyword('dream-driver') }}</span>
                                            </label>
                                            @php
                                                $checked = false;
                                            @endphp
                                        @endif
                                        @if (Setting::get('cat_web_road_assist') == 1)
                                            @php
                                                $defaultService = $defaultService == '' ? 'road_assistance' : $defaultService;
                                            @endphp
                                            <label class="mr-3">
                                                <input type="radio" value="road_assistance" name="radio_group"
                                                       onclick="getservices('road_assistance')" @if($checked) checked @endif>
                                                <span>{{ translateKeyword('road_assistance') }}</span>
                                            </label>
                                            @php
                                                $checked = false;
                                            @endphp
                                        @endif
                                        {{-- <label>
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
                                        <input type="text" class="form-control" name="name"
                                               placeholder="&#xe08a  {{ translateKeyword('full_name') }}" required>
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" id="mobile" minlength="10"
                                               maxlength="15"
                                               placeholder="&#xe090  {{ translateKeyword('phone_number') }}" required>
                                        <label class="border_line"></label>
                                    </div>
                                </div>

                                <div class="col-md-6" id="dname-field" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="dname" id="dname"
                                               placeholder="&#xe08a {{ translateKeyword('drop_off_name') }}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                <div class="col-md-6" id="dmobile-field" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="dphone" id="dmobile"
                                               placeholder="&#xe090 {{ translateKeyword('drop_off_phone') }}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                @if (Setting::get('email_field', 0) == 1)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="{{ translateKeyword('enter-email') }}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12" id="startAddress-field" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="startAddress" name="sdestination"
                                               placeholder="&#xe01d {{translateKeyword('enter-address')}}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                <div class="col-md-6" id="address1-field">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="addressField1" name="sdestination"
                                               placeholder="&#xe01d {{ translateKeyword('departure') }}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                <div class="col-md-6" id="address2-field">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="addressField2" name="edestination"
                                               placeholder="&#xe01d  {{ translateKeyword('destination') }}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                @if (Setting::get('customer_vehicle_info', 0) == 1)
                                <div class="col-md-6" id="vehicle_model-field" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="vehicle_model" name="vehicle_model"
                                            placeholder="{{translateKeyword('service_model')}}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                <div class="col-md-6" id="vehicle_number-field" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="vehicle_number" name="vehicle_number"
                                            placeholder="{{translateKeyword('service_number')}}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                @endif
                                @if (Setting::get('delivery_note', 0) == 1)
                                <div class="col-md-12" id="specialNote-field">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="specialNote" name="special_note"
                                               placeholder="{{translateKeyword('please_enter_any_extra_details_here')}}">
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12 mt-2 mb-1">
                                    <div class="alert" id="locationError"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-md-none d-lg-none d-xl-none">Select Date</label>
                                        <input type="datetime-local" class="form-control date-input-css-disable"
                                               name="date"
                                               placeholder="&#xe06b Date" required>
                                        <label class="border_line"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="border_line"></label>
                                        <select class="form-control" name="car_type" id="car_type" required>
                                            <option value="" disabled selected>{{ translateKeyword('select_service_type') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-4">
                                        <button type="submit" name="submit" class="btn slider_btn dark_hover">{{ translateKeyword('book_now') }}
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
    @endif

    <section class="featured_area bg_one">
        @if (Setting::get('offer_container') == 1)
            <div class="container">
                <div class="section_title text-center">
                    <h5>{{ translateKeyword('what_we_offer') }}</h5>
                    <h2>{{ translateKeyword('we_are_a_transportation_service') }}</h2>
                </div>
                <div class="row featured_info slick">
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            
                            <h3>{{ translateKeyword('fast_and_easy_transport') }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-hotel icon"></i>
                            <h3>{{ translateKeyword('move_anywhere_you_want') }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-car icon"></i>
                            <h3>{{ translateKeyword('book_for_others') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </section>

    @if (Setting::get('services_container') == 1)
        <section class="featured_area bg_one">

            <div class="container">
                <div class="section_title text-center">
                    <h5>{{ translateKeyword('services') }}</h5>
                    <h2>{{ $webContent->site_title }} {{ translateKeyword('taxi_services_in_areas') }}</h2>
                </div>
                <div class="row featured_info slick">
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Lidingo</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Uppland-Vasby</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Sundbyberg</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Taby</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Akersberga</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Marsta</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Enkoping</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Tumba</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Stockholm</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Sodertalje</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Sigtuna</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Mariefred</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Solna</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Vasteras</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Stockholm Arlanda Airport</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="featured_item">
                            <i class="flaticon-map icon"></i>
                            <h3>Cherokee Country Airport</h3>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    @endif

    @if (Setting::get('mockup_section') == 1)

        <section class="get_app_area sec_pad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="get_app_content">
                            <div class="section_title">
                                <h5>{{ translateKeyword('search') }} {{ $webContent ? $webContent->site_title : '' }} {{ translateKeyword('app') }}</h5>
                                <h2>{{ translateKeyword('get') }} {{ $webContent ? $webContent->site_title : '' }} {{ translateKeyword('app_now') }}</h2>
                            </div>
                            <ul>
                                <li>{{ translateKeyword('quick_and_easy_booking') }}</li>
                                <li>{{ translateKeyword('service_available') }}</li>
                                <li>{{ translateKeyword('reliable_gps_enabled') }}</li>
                                <li>{{ translateKeyword('cost_effective') }}</li>
                            </ul>
                            <a href="{{ getAppLinks()->f_u_url ?? '#' }}" class="app_btn slider_btn" target="_blank"><img
                                        src="{{ asset('mainindex/img/icon/play-store.png') }}" alt="play-store">{{ translateKeyword('google_play') }} </a>
                            <a href="{{ getAppLinks()->user_store_link_ios ?? '#' }}" class="app_btn_two slider_btn"
                               target="_blank"><img src="{{ asset('mainindex/img/icon/apple-store.png') }}"
                                                    alt="apple-store">{{ translateKeyword('apple_store') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-5 app_image">
                        @if (Setting::get('mockup_one', '') != '')
                            <div class="image_first">
                                <img src="{{ Setting::get('mockup_one') }}" alt="mockup_one">
                                <div class="shadow_bottom"></div>
                            </div>
                        @endif
                        @if (Setting::get('mockup_two', '') != '')
                            <div class="image_two">
                                <img src="{{ Setting::get('mockup_two') }}" alt="mockup_two">
                                <div class="shadow_bottom"></div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="advantage_area bg_one">
        @if (Setting::get('features_section') == 1)
            <div class="container">
                <div class="section_title text-center">
                    <h5>{{ translateKeyword('main_features') }}</h5>
                    <h2>{{ translateKeyword('our_advantages') }}</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="advantage_item">
                            <i class="flaticon-gear"></i>
                            <h3>{{ translateKeyword('pleasure') }}</h3>
                            <p>{{ translateKeyword('get_Pleasure_in_your_ride_without_any_hesitation') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="advantage_item">
                            <i class="flaticon-travel"></i>
                            <h3>{{ translateKeyword('lots_of_locations') }}</h3>
                            <p>{{ translateKeyword('available_almost_everywhere_in_this_region_explore_now') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="advantage_item">
                            <i class="flaticon-car"></i>
                            <h3>{{ translateKeyword('luxury_cars') }}</h3>
                            <p>{{ translateKeyword('get_luxury_cars_to_ride_as_per_your_demands') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="advantage_item">
                            <i class="flaticon-bag"></i>
                            <h3>{{ translateKeyword('additional_services') }}</h3>
                            <p>{{ translateKeyword('get_additional_services_as_you_need_to_travel') }}</p>
                        </div>
                    </div>
                </div>
                <div class="car_img">
                    @if (Setting::get('advantage_image_1') != '')
                        <img class="car_one wow caranimationTwo" data-wow-delay="0.3s"
                             src="{{ Setting::get('advantage_image_1', 'mainindex/img/car/car_01.png') }}"
                             alt="car_01">
                    @endif
                    @if (Setting::get('advantage_image_2') != '')
                        <img class="car_two wow caranimationOne" data-wow-delay="1s"
                             src="{{ Setting::get('advantage_image_2', 'mainindex/img/car/car_02.png') }}"
                             alt="car_02">
                    @endif
                </div>
            </div>
        @endif
    </section>


    @if (Setting::get('cta_container') == 1)
        <section class="call_action_area">

            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="action_img">
                            <div class="overlay_bg"></div>
                            <img src="{{ Setting::get('call_us_image', 'mainindex/img/action_img.jpg') }}"
                                 alt="action_img">
                        </div>
                    </div>
                    <div class="col-lg-5 d-flex align-items-center">
                        <div class="action_content">
                            <h3>{{ translateKeyword('call_us_to_make_a_booking') }}</h3>
                            <a href="tel:{{ str_replace(' ', '', Setting::get('contact_number', '')) }}"
                               class="call_btn">{{ str_replace(' ', '', Setting::get('contact_number', '')) }}</a>
                            <p>{{ translateKeyword('our_customer_care_team_will_call_you_back_and_inform_you_of_the_cost_to_travel') }}</p>
                            <a href="contact" class="slider_btn dark_hover">{{ translateKeyword('discover') }} <i class="icon_plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    @endif
    @if (Setting::get('video_on_web') == 1)
        <section class="video">

            <div class="container">
                <video class="embed-responsive-item" src="{{ Setting::get('home_page_video', '') }}" controls
                       style="width: 100%; height: 100%; object-fit: fill;"></video>
            </div>

        </section>
    @endif

@endsection
@section('scripts')
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
        }

        
        // @if(isset($defaultService))
        //     $(document).ready(function () {
        //         getservices(`{{ $defaultService }}`);
        //     });
        // @endif
       
    </script>
@endsection
