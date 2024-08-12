@extends('layout.booking-base')
@section('title', 'Delivery/Transport Hub')
@section('content')
    <section class="booking_form_area bg_one">
        <div class="container">
            <div class="boking_content pb-0">
                <!--<h2>Online Booking</h2>-->
                <form action="{{ route('booking-request') }}" class="row booking_form" data-pickme="contact-froms"
                      method="POST">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group choose_item pb-0">
                            @if (Setting::get('cat_web_ecomony') == 1)
                                <label class="mr-3">
                                    <input type="radio" value="economy" name="radio_group"
                                           onclick="getservices('economy')" checked>
                                    <span>{{ translateKeyword('Economy')}}</span>
                                </label>
                            @endif
                            @if (Setting::get('cat_web_lux') == 1)
                                <label class="mr-3">
                                    <input type="radio" value="luxury" name="radio_group"
                                           onclick="getservices('luxury')">
                                    <span>{{ translateKeyword('Luxury')}}</span>
                                </label>
                            @endif
                            @if (Setting::get('cat_web_ext') == 1)
                                <label class="mr-3">
                                    <input type="radio" value="extra_seat" name="radio_group"
                                           onclick="getservices('extra_seat')">
                                    <span>{{ translateKeyword('towing-service')}}</span>
                                </label>
                            @endif
                            @if (Setting::get('cat_web_out') == 1)
                                <label class="mr-3">
                                    <input type="radio" value="outstation" name="radio_group"
                                           onclick="getservices('outstation')">
                                    <span>{{ translateKeyword('OutStation')}}</span>
                                </label>
                            @endif
                            @if (Setting::get('cat_web_dream_driver') == 1)
                            <label class="mr-3">
                                <input type="radio" value="dream_driver" name="radio_group"
                                       onclick="getservices('cat_web_dream_driver')">
                                <span>{{ translateKeyword('dream-driver')}}</span>
                            </label>
                        @endif
                            @if (Setting::get('cat_web_road_assist') == 1)
                                <label class="mr-3">
                                    <input type="radio" value="road_assistance" name="radio_group"
                                           onclick="getservices('road_assistance')">
                                    <span>{{ translateKeyword('roadside-assistance')}}</span>
                                </label>
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
                                   placeholder="&#xe08a  Pickup Name" required>
                            <label class="border_line"></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" id="mobile" minlength="10"
                                   maxlength="15"
                                   placeholder="&#xe090 Pickup Phone" required>
                            <label class="border_line"></label>
                        </div>
                    </div>

                    <div class="col-md-6" id="dname-field" style="display: none;">
                        <div class="form-group">
                            <input type="text" class="form-control" name="dname" id="dname"
                                   placeholder="&#xe08a  Drop off Name">
                            <label class="border_line"></label>
                        </div>
                    </div>
                    <div class="col-md-6" id="dmobile-field" style="display: none;">
                        <div class="form-group">
                            <input type="text" class="form-control" name="dphone" id="dmobile"
                                   placeholder="&#xe090 Drop off Phone">
                            <label class="border_line"></label>
                        </div>
                    </div>
                    <div class="col-md-12" id="startAddress-field" style="display: none;">
                        <div class="form-group">
                            <input type="text" class="form-control" id="startAddress" name="sdestination"
                                   placeholder="&#xe01d Enter Address">
                            <label class="border_line"></label>
                        </div>
                    </div>
                    <div class="col-md-6" id="address1-field">
                        <div class="form-group">
                            <input type="text" class="form-control" id="addressField1" name="sdestination"
                                   placeholder="&#xe01d Pickup Address" required>
                            <label class="border_line"></label>
                        </div>
                    </div>
                    <div class="col-md-6" id="address2-field">
                        <div class="form-group">
                            <input type="text" class="form-control" id="addressField2" name="edestination"
                                   placeholder="&#xe01d  Drop off Address" required>
                            <label class="border_line"></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="d-md-none d-lg-none d-xl-none">{{ translateKeyword('Select Date')}}</label>
                            <input type="datetime-local" class="form-control date-input-css-disable" name="date"
                                   placeholder="&#xe06b Date" required>
                            <label class="border_line"></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{-- <input type="text" class="form-control" name="car_type" placeholder="&#xe0db;  Car Type"> --}}
                            <label class="border_line"></label>
                            <select class="form-control" name="car_type" id="car_type" required>
                                <option disabled selected>{{ translateKeyword('Select service type')}}</option>
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
    </section>
@endsection
@section('scripts')
    <!-- End Google Tag Manager -->
    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('map_key')}}&libraries=places" async defer></script>
    <script language="javascript" type="application/javascript">
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
                serviceTypes = `{{ get_service_types('economy') }}`;
            } else if (service_type == 'luxury') {
                $("#dname-field").show(1000);
                $("#dmobile-field").show(1000);
                $("#address1-field").show(1000);
                $("#address2-field").show(1000);
                $("#startAddress-field").hide(1000);
                serviceTypes = `{{ get_service_types('luxury') }}`;
            } else if (service_type == 'extra_seat') {
                $("#dname-field").hide(1000);
                $("#dmobile-field").hide(1000);
                $("#address1-field").show(1000);
                $("#address2-field").show(1000);
                $("#startAddress-field").hide(1000);
                serviceTypes = `{{ get_service_types('extra_seat') }}`;
            } else if (service_type == 'outstation') {
                $("#dname-field").hide(1000);
                $("#dmobile-field").hide(1000);
                $("#address1-field").show(1000);
                $("#address2-field").show(1000);
                $("#startAddress-field").hide(1000);
                serviceTypes = `{{ get_service_types('outstation') }}`;
            } else if (service_type == 'road_assistance') {
                $("#address1-field").hide(1000);
                $("#address2-field").hide(1000);
                $("#dname-field").hide(1000);
                $("#dmobile-field").hide(1000);
                $("#startAddress-field").show(1000);
                serviceTypes = `{{ get_service_types('road_assistance') }}`;
            } else if (service_type == 'dream_driver') {
                $("#dname-field").hide(1000);
                $("#dmobile-field").hide(1000);
                $("#address1-field").show(1000);
                $("#address2-field").show(1000);
                $("#startAddress-field").hide(1000);
                serviceTypes = `{{ get_service_types('dream_driver') }}`;
            }

            serviceTypes = JSON.parse(serviceTypes.replace(/&quot;/g, '"'));
            var len = serviceTypes.length;
            $("#car_type").empty();
            $("#car_type").append("<option disabled selected>Select service type</option>");
            for (var i = 0; i < len; i++) {
                var name = serviceTypes[i].name;
                $("#car_type").append("<option value='" + name + "'>" + name + "</option>");
            }
        }

        $(document).ready(function () {
            getservices('economy');
        });
    </script>
@endsection
