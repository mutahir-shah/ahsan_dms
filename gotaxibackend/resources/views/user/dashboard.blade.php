@extends('user.layout.base')

@section('title', 'Home ')

@section('content')
    <style>
        .service-back {
            margin-top: 20px;
            border: solid 2px;
            border-radius: 5px 5px 5px 5px;
        }
        #map {
            height: 100%;
            min-height: 800px;
        }

        #legend {
            font-family: Arial, sans-serif;
            background: rgba(255, 255, 255, 0.8);
            padding: 10px;
            margin: 10px;
            border: 2px solid #f3f3f3;
        }

        #legend h3 {
            margin-top: 0;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        #legend img {
            vertical-align: middle;
            margin-bottom: 5px;
        }
    </style>
    <script>
        var disableDestination = false;
        function hideShowDest(cat = null) {
            if(cat == 'road_assistance') {
                disableDestination = true;
                document.getElementById('destination-input').style.display = 'none';

                var originLatitude = document.getElementById("origin_latitude");
                var originLongitude = document.getElementById("origin_longitude");
                var destinationLatitude = document.getElementById("destination_latitude");
                var destinationLongitude = document.getElementById("destination_longitude");

                var originInput = document.getElementById("origin-input");
                var destinationInput = document.getElementById("destination-input")

                destinationInput.value = originInput.value;
                destinationLatitude.value = originLatitude.value;
                destinationLongitude.value = originLongitude.value;


            } else {
                disableDestination = false;
                document.getElementById('destination-input').style.display = 'block';
                document.getElementById('destination-input').value = '';
            }
        }
    </script>
    
    <div class="dash-content">
        
        <div class="row no-margin">

            <div class="col-md-12">
                @if(str_contains(config('app.url'), 'https://beegone.se'))
                <h3 class="page-title">Book a ride</h3>
                @else
                <h3 class="page-title">{{ trans('user.Where_are_you_going') }}</h3>
                @endif
            </div>
    
        </div>
        @include('common.notify')
        <div class="row no-margin">
            <div class="col-md-6">
                <ul class="nav nav-tabs">
                    @php
                        $activated = $services->count() == 1 ? true : false;
                    @endphp
                    @if (Setting::get('cat_web_ecomony') == 1)
                        <li 
                        @if (Setting::get('cat_web_ecomony') == 1)
                            @if (!$activated)
                                class="active"
                            @endif
                            @php
                                $activated = true;
                            @endphp
                        @endif 
                        >
                        @if(str_contains(config('app.url'), 'https://beegone.se'))
                         <a href="#Economy" data-toggle="tab" onclick="hideShowDest()">Taxi</a>
                        @else
                         <a href="#Economy" data-toggle="tab" onclick="hideShowDest()">{{ trans('website.transportation') }}</a>
                        @endif
                        
                    </li>
                    @endif

                    @if (Setting::get('cat_web_lux') == 1)
                        <li
                        @if(Setting::get('cat_web_lux') == 1)
                            @if (!$activated)
                                class="active"
                            @endif
                            @php
                                $activated = true;
                            @endphp
                        @endif
                        ><a href="#Luxury" data-toggle="tab" onclick="hideShowDest()">{{ trans('website.delivery') }}</a></li>
                    @endif

                    @if (Setting::get('cat_web_ext') == 1)
                        <li
                        @if(Setting::get('cat_web_ext') == 1)
                                @if (!$activated)
                                class="active"
                            @endif
                            @php
                                $activated = true;
                            @endphp
                        @endif
                        ><a href="#ExtraSeat" data-toggle="tab" onclick="hideShowDest()">{{ trans('website.tow_truck') }}</a></li>
                    @endif

                    @if (Setting::get('cat_web_out') == 1)
                        <li
                        @if(Setting::get('cat_web_out') == 1)
                                @if (!$activated)
                                class="active"
                            @endif
                            @php
                                $activated = true;
                            @endphp
                        @endif
                        ><a href="#Outstation" data-toggle="tab" onclick="hideShowDest()">{{ trans('website.outstation') }}</a></li>
                    @endif

                    @if (Setting::get('cat_web_dream_driver') == 1)
                        <li
                        @if(Setting::get('cat_web_dream_driver') == 1)
                                @if (!$activated)
                                class="active"
                            @endif
                            @php
                                $activated = true;
                            @endphp
                        @endif
                        ><a href="#dream_driver" data-toggle="tab" onclick="hideShowDest()">Dream Driver</a></li>
                    @endif

                    @if (Setting::get('cat_web_road_assist') == 1)
                        <li
                        @if(Setting::get('cat_web_road_assist') == 1)
                                @if (!$activated)
                                class="active"
                            @endif
                            @php
                                $activated = true;
                            @endphp
                        @endif
                        ><a href="#road_assistance" data-toggle="tab" onclick="hideShowDest('road_assistance')">{{ translateKeyword('road_assistance') }}</a></li>
                    @endif
                </ul>
                <form action="{{ url('confirm/ride') }}" method="GET" onkeypress="return disableEnterKey(event);" onsubmit="return formValidator()">

                    <div class="input-group dash-form" style="margin-top: 15px;">

                        <input type="text" class="form-control" id="origin-input" name="s_address"
                            placeholder="Enter pickup location" Required>

                    </div>

                    <div class="input-group dash-form" style="margin-top: 15px;">

                        <input type="text" class="form-control" id="destination-input" name="d_address"
                            placeholder="Enter drop location">

                    </div>

                    <input type="hidden" name="s_latitude" id="origin_latitude">

                    <input type="hidden" name="s_longitude" id="origin_longitude">

                    <input type="hidden" name="d_latitude" id="destination_latitude">

                    <input type="hidden" name="d_longitude" id="destination_longitude">

                    <input type="hidden" name="current_longitude" value="0.00" id="origin_longitude">

                    <input type="hidden" name="current_latitude" value="0.00" id="origin_latitude">
                    <div class="tab-content" style="background: white;">
                        @php
                            $activated = $services->count() == 1 ? true : false;
                        @endphp
                        @if (Setting::get('cat_web_ecomony') == 1)
                        <div id="Economy"
                            @if(Setting::get('cat_web_ecomony') == 1)
                                    @if (!$activated)
                                        class="tab-pane active"
                                    @else
                                        class="tab-pane"
                                    @endif
                                @php
                                    $activated = true;
                                @endphp
                            @endif
                            >
                            <div class="car-detail2">
                                @foreach ($economy as $service)
                                    <div class="car-radio service-back">
                                        <input type="radio" name="service_type" value="{{ $service->id }}"
                                            id="service_{{ $service->id }}"
                                            @if ($loop->first) checked="checked" @endif>
                                        <label for="service_{{ $service->id }}" style="float:center;">
                                            <div class="car-radio-inner">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="col-6 align-self-center">
                                                            <div class="img"><img src="{{ image($service->image) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-6  align-self-center">
                                                            <div class="name align-self-center">
                                                                <span>{{ $service->name }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if (Setting::get('cat_web_lux') == 1)
                        <div id="Luxury"
                                @if(Setting::get('cat_web_lux') == 1)
                                    @if (!$activated)
                                        class="tab-pane active"
                                    @else
                                        class="tab-pane"
                                    @endif
                                    @php
                                        $activated = true;
                                    @endphp
                                @endif
                            >
                            <div class="car-detail2">
                                @foreach ($luxury as $service)
                                    <div class="car-radio service-back">
                                        <input type="radio" name="service_type" value="{{ $service->id }}"
                                            id="service_{{ $service->id }}"
                                            @if ($loop->first) checked="checked" @endif>
                                        <label for="service_{{ $service->id }}" style="float:center;">
                                            <div class="car-radio-inner">
                                                <div class="row">
                                                    <div class="col-6 align-self-center">
                                                        <div class="img"><img src="{{ image($service->image) }}"></div>
                                                    </div>
                                                    <div class="col-6  align-self-center">
                                                        <div class="name align-self-center">
                                                            <span>{{ $service->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if (Setting::get('cat_web_ext') == 1)
                        <div id="ExtraSeat"
                            @if(Setting::get('cat_web_ext') == 1)
                                @if (!$activated)
                                    class="tab-pane active"
                                @else
                                    class="tab-pane"
                                @endif
                                @php
                                    $activated = true;
                                @endphp
                            @endif
                            >
                            <div class="car-detail2">
                                @foreach ($extra_seat as $service)
                                    <div class="car-radio service-back">
                                        <input type="radio" name="service_type" value="{{ $service->id }}"
                                            id="service_{{ $service->id }}"
                                            @if ($loop->first) checked="checked" @endif>
                                        <label for="service_{{ $service->id }}" style="float:center;">
                                            <div class="car-radio-inner">
                                                <div class="row">
                                                    <div class="col-6 align-self-center">
                                                        <div class="img"><img src="{{ image($service->image) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6  align-self-center">
                                                        <div class="name align-self-center">
                                                            <span>{{ $service->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if (Setting::get('cat_web_out') == 1)
                        <div id="Outstation"
                            @if(Setting::get('cat_web_out') == 1)
                                @if (!$activated)
                                    class="tab-pane active"
                                @else
                                    class="tab-pane"
                                @endif
                                @php
                                    $activated = true;
                                @endphp
                            @endif
                            >
                            {{-- <div class="col-12">
                                <label for="return_t" style="margin-top: 20px;"> <input type="checkbox" name="return_t"
                                        id="return_t" style="margin-right: 10px;">{{ trans('user.return_again') }}
                                </label>
                            </div> --}}
                            <div class="car-detail2" style="margin-top: -10px;">
                                @foreach ($outstation as $service)
                                    <div class="car-radio service-back">
                                        <input type="radio" name="service_type" value="{{ $service->id }}"
                                            id="service_{{ $service->id }}"
                                            @if ($loop->first) checked="checked" @endif>
                                        <label for="service_{{ $service->id }}" style="float:center;">
                                            <div class="car-radio-inner">
                                                <div class="row">
                                                    <div class="col-6 align-self-center">
                                                        <div class="img"><img src="{{ image($service->image) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6  align-self-center">
                                                        <div class="name align-self-center">
                                                            <span>{{ $service->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if (Setting::get('cat_web_road_assist') == 1)
                        <div id="road_assistance"
                            @if(Setting::get('cat_web_road_assist') == 1)
                                @if (!$activated)
                                    class="tab-pane active"
                                @else
                                    class="tab-pane"
                                @endif
                                @php
                                    $activated = true;
                                @endphp
                            @endif
                            >
                            {{-- <div class="col-12">
                                <label for="return_t" style="margin-top: 20px;"> <input type="checkbox" name="return_t"
                                        id="return_t" style="margin-right: 10px;">{{ trans('user.return_again') }}
                                </label>
                            </div> --}}
                            <div class="car-detail2" style="margin-top: -10px;">
                                @foreach ($road_assistance as $service)
                                    <div class="car-radio service-back">
                                        <input type="radio" name="service_type" value="{{ $service->id }}"
                                            id="service_{{ $service->id }}"
                                            @if ($loop->first) checked="checked" @endif>
                                        <label for="service_{{ $service->id }}" style="float:center;">
                                            <div class="car-radio-inner">
                                                <div class="row">
                                                    <div class="col-6 align-self-center">
                                                        <div class="img"><img src="{{ image($service->image) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-6  align-self-center">
                                                        <div class="name align-self-center">
                                                            <span>{{ $service->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="full-primary-btn fare-btn">Continue</button>

                </form>

            </div>

            <div class="col-md-6">

                <div class="map-responsive">

                    <div id="map">

                    </div>
                    <div id="legend"><h3>Note: </h3></div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        window.Laravel = { "csrfToken": "{{ csrf_token() }}" };
    </script>
    <script type="text/javascript">
        var current_latitude = '{{Setting::get('latitude')}}';

        var current_longitude = '{{Setting::get('longitude')}}';
    </script>

    <script type="text/javascript">
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(success, fail);

        } else {

            console.log('Sorry, your browser does not support geolocation services');

            initMap();

        }

        function success(position) {

            // document.getElementById('long').value = position.coords.longitude;

            // document.getElementById('lat').value = position.coords.latitude

            if (position.coords.longitude != "" && position.coords.latitude != "") {

                current_longitude = position.coords.longitude;

                current_latitude = position.coords.latitude;

            }

            initMap();

        }

        function fail() {

            // Could not obtain location

            console.log('unable to get your location');

            initMap();

        }
    </script>

    {{-- <script type="text/javascript" src="{{ asset('asset/js/map.js') }}"></script> --}}

    <script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('map_key')}}&libraries=places" async defer></script>

    <script type="text/javascript">
       function disableEnterKey(e) {
        

        //Disable Enter Key
        var key;

        if (window.e)

            key = window.e.keyCode; // IE

        else

            key = e.which; // Firefox

        if (key == 13)

            return e.preventDefault();

        }

        function formValidator() {
            var originInput = document.getElementById("origin-input").value;
            var destinationInput = document.getElementById("destination-input").value;
            if(originInput == destinationInput && !disableDestination) {
                alert('Source and destination address should not be same!');
                return false;
            } else {
                return true;
            }
        }
        
        var map;
        var users;
        var providers;
        var ajaxMarkers = [];
        var googleMarkers = [];
        var mapIcons = {
        user: '{{ asset("asset/img/marker-user.png") }}',
        active: '{{ asset("asset/img/marker-car.png") }}',
        riding: '{{ asset("asset/img/marker-plus.png") }}',
        offline: '{{ asset("asset/img/marker-plus.png") }}',
        unactivated: '{{ asset("asset/img/marker-plus.png") }}',
        };

        function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            mapTypeControl: false,
            zoomControl: true,
            center: {
                lat: parseFloat(current_latitude),
                lng: parseFloat(current_longitude)
            },
            zoom: 12,
            styles: [{
                    elementType: "geometry",
                    stylers: [{
                        color: "#f5f5f5"
                    }]
                },
                {
                    elementType: "labels.icon",
                    stylers: [{
                        visibility: "off"
                    }],
                },
                {
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#616161"
                    }]
                },
                {
                    elementType: "labels.text.stroke",
                    stylers: [{
                        color: "#f5f5f5"
                    }],
                },
                {
                    featureType: "administrative.land_parcel",
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#bdbdbd"
                    }],
                },
                {
                    featureType: "landscape.man_made",
                    elementType: "geometry",
                    stylers: [{
                        color: "#e4e8e9"
                    }],
                },
                {
                    featureType: "poi",
                    elementType: "geometry",
                    stylers: [{
                        color: "#eeeeee"
                    }],
                },
                {
                    featureType: "poi",
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#757575"
                    }],
                },
                {
                    featureType: "poi.park",
                    elementType: "geometry",
                    stylers: [{
                        color: "#e5e5e5"
                    }],
                },
                {
                    featureType: "poi.park",
                    elementType: "geometry.fill",
                    stylers: [{
                        color: "#7de843"
                    }],
                },
                {
                    featureType: "poi.park",
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#9e9e9e"
                    }],
                },
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [{
                        color: "#ffffff"
                    }],
                },
                {
                    featureType: "road.arterial",
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#757575"
                    }],
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry",
                    stylers: [{
                        color: "#dadada"
                    }],
                },
                {
                    featureType: "road.highway",
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#616161"
                    }],
                },
                {
                    featureType: "road.local",
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#9e9e9e"
                    }],
                },
                {
                    featureType: "transit.line",
                    elementType: "geometry",
                    stylers: [{
                        color: "#e5e5e5"
                    }],
                },
                {
                    featureType: "transit.station",
                    elementType: "geometry",
                    stylers: [{
                        color: "#eeeeee"
                    }],
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [{
                        color: "#c9c9c9"
                    }],
                },
                {
                    featureType: "water",
                    elementType: "geometry.fill",
                    stylers: [{
                        color: "#9bd0e8"
                    }],
                },
                {
                    featureType: "water",
                    elementType: "labels.text.fill",
                    stylers: [{
                        color: "#9e9e9e"
                    }],
                },
            ],
        });


        new AutocompleteDirectionsHandler(map);

        //For adding drivers
        setInterval(ajaxMapData, 3000);

        var legend = document.getElementById("legend");

        // var div = document.createElement('div');
        // div.innerHTML = '<img src="' + mapIcons['user'] + '"> ' + 'User';
        // legend.appendChild(div);

        // var div = document.createElement("div");
        // div.innerHTML =
        //     '<img src="' + mapIcons["offline"] + '"> ' + "Unavailable Provider";
        // legend.appendChild(div);

        var div = document.createElement("div");
        div.innerHTML =
            '<img src="' + mapIcons["active"] + '"> ' + "Available Driver";
        legend.appendChild(div);

        // var div = document.createElement("div");
        // div.innerHTML =
        //     '<img src="' + mapIcons["unactivated"] + '"> ' + "Unactivated Provider";
        // legend.appendChild(div);
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

        google.maps.Map.prototype.clearOverlays = function() {
            for (var i = 0; i < googleMarkers.length; i++) {
                googleMarkers[i].setMap(null);
            }
            googleMarkers.length = 0;
        };
        }

        /**
        * @constructor
        */

        function AutocompleteDirectionsHandler(map) {
        this.map = map;
        this.originPlaceId = null;
        this.destinationPlaceId = null;
        this.travelMode = "DRIVING";
        var originInput = document.getElementById("origin-input");
        var destinationInput = document.getElementById("destination-input");
        var modeSelector = document.getElementById("mode-selector");
        var originLatitude = document.getElementById("origin_latitude");
        var originLongitude = document.getElementById("origin_longitude");
        var destinationLatitude = document.getElementById("destination_latitude");
        var destinationLongitude = document.getElementById("destination_longitude");

        var polylineOptionsActual = new google.maps.Polyline({
            strokeColor: "#111",
            strokeOpacity: 0.8,
            strokeWeight: 4,
        });

        this.directionsService = new google.maps.DirectionsService();
        this.directionsDisplay = new google.maps.DirectionsRenderer({
            suppressMarkers: false,
            polylineOptions: polylineOptionsActual,
        });
        this.directionsDisplay.setMap(map);

        var originAutocomplete = new google.maps.places.Autocomplete(originInput);
        var destinationAutocomplete = new google.maps.places.Autocomplete(
            destinationInput
        );

        originAutocomplete.addListener("place_changed", function(event) {
            var place = originAutocomplete.getPlace();

            if (place.hasOwnProperty("place_id")) {
                if (!place.geometry) {
                    // window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                originLatitude.value = place.geometry.location.lat();
                originLongitude.value = place.geometry.location.lng();

                if(disableDestination) {
                    destinationLatitude.value = place.geometry.location.lat();
                    destinationLongitude.value = place.geometry.location.lng();
                }
            } else {
                service.textSearch({
                        query: place.name,
                    },
                    function(results, status) {
                        if (status == google.maps.places.PlacesServiceStatus.OK) {
                            originLatitude.value = results[0].geometry.location.lat();
                            originLongitude.value = results[0].geometry.location.lng();

                            if(disableDestination) {
                                destinationLatitude.value = results[0].geometry.location.lat();
                                destinationLongitude.value = results[0].geometry.location.lng();
                            }
                        }
                    }
                );
            }
        });

        navigator.geolocation.getCurrentPosition(function (position) {
            const latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(latLng);

            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
            });

            marker.setPosition(latLng);
            marker.setVisible(true);

            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latLng }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            window.latLng = latLng;
                            originInput.value = results[0].formatted_address;
                            originLatitude.value = latLng.lat();
                            originLongitude.value = latLng.lng();

                            if(disableDestination) {
                                destinationInput.value = results[0].formatted_address;
                                destinationLatitude.value = latLng.lat();
                                destinationLongitude.value = latLng.lng();
                            }
                        }
                    }
                });
        });

        destinationAutocomplete.addListener("place_changed", function(event) {
            var place = destinationAutocomplete.getPlace();

            if (place.hasOwnProperty("place_id")) {
                if (!place.geometry) {
                    // window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                destinationLatitude.value = place.geometry.location.lat();
                destinationLongitude.value = place.geometry.location.lng();
            } else {
                service.textSearch({
                        query: place.name,
                    },
                    function(results, status) {
                        if (status == google.maps.places.PlacesServiceStatus.OK) {
                            destinationLatitude.value = results[0].geometry.location.lat();
                            destinationLongitude.value = results[0].geometry.location.lng();
                        }
                    }
                );
            }
        });

        this.setupPlaceChangedListener(originAutocomplete, "ORIG");
        this.setupPlaceChangedListener(destinationAutocomplete, "DEST");
        }

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.

        AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(
        autocomplete,
        mode
        ) {
        var me = this;
        autocomplete.bindTo("bounds", this.map);
        autocomplete.addListener("place_changed", function() {
            var place = autocomplete.getPlace();
            if (!place.place_id) {
                // window.alert("Please select an option from the dropdown list.");
                return;
            }
            if (mode === "ORIG") {
                me.originPlaceId = place.place_id;
            } else {
                me.destinationPlaceId = place.place_id;
            }
            me.route();
        });
        };

        AutocompleteDirectionsHandler.prototype.route = function() {
        if (!this.originPlaceId || !this.destinationPlaceId) {
            return;
        }

        var me = this;

        this.directionsService.route({
                origin: {
                    placeId: this.originPlaceId
                },
                destination: {
                    placeId: this.destinationPlaceId
                },
                travelMode: this.travelMode,
            },
            function(response, status) {
                if (status === "OK") {
                    me.directionsDisplay.setDirections(response);
                } else {
                    // window.alert('Directions request failed due to ' + status);
                }
            }
        );
        };

        function ajaxMapData() {
        map.clearOverlays();
        $.ajax({
            url: "/map/ajax",
            dataType: "JSON",
            headers: {
                "X-CSRF-TOKEN": window.Laravel.csrfToken
            },
            type: "GET",
            success: function(data) {
                // console.log("Ajax Response", data);
                ajaxMarkers = data;
            },
        });

        ajaxMarkers ? ajaxMarkers.forEach(addMarkerToMap) : "";
        }

        function addMarkerToMap(element, index) {
        marker = new google.maps.Marker({
            position: {
                lat: parseFloat(element.latitude),
                lng: parseFloat(element.longitude),
            },
            id: element.id,
            map: map,
            title: element.first_name + " " + element.last_name,
            icon: mapIcons['active'],
        });

        googleMarkers.push(marker);

        // google.maps.event.addListener(marker, "click", function() {
        //     window.location.href =
        //         "/admin/" + element.service ? "provider" : "user" + "/" + element.user_id;
        // });
        }
    </script>



@endsection
