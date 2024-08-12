@php use Carbon\Carbon; @endphp
@extends('dispatcher.layout.base')

@section('title', 'Dispatcher ')

@section('content')
    <div class="content-area py-1" id="dispatcher-panel">
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.5.0/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.5.0/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.24.0/babel.min.js"></script>

    <script type="text/javascript">
        window.Tranxit = {!! json_encode([
        "minDate" => Carbon::today()->format('Y-m-d\TH:i'),
        "maxDate" => Carbon::today()->addDays(30)->format('Y-m-d\TH:i'),
        "map" => false,
    ]) !!}
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("body").addClass("compact-sidebar");
        });
    </script>
    <style>
        .my-card input {
            margin-bottom: 10px;
        }

        .my-card label.checkbox-inline {
            margin-top: 10px;
            margin-right: 5px;
            margin-bottom: 0;
        }

        .my-card label.checkbox-inline input {
            position: relative;
            top: 3px;
            margin-right: 3px;
        }

        .my-card .card-header .btn {
            font-size: 10px;
            padding: 3px 7px;
        }

        .tag.my-tag {
            padding: 10px 15px;
            font-size: 11px;
        }

        .add-nav-btn {
            padding: 5px 15px;
            min-width: 0;
        }

        .dispatcher-nav li span {
            background-color: transparent;
            color: #000 !important;
            padding: 5px 12px;
        }

        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff !important;
            padding: 5px 12px;
        }

        .dispatcher-nav li.active span,
        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff !important;
            padding: 5px 12px;
        }

        .update-schedule-btn {
            box-shadow: 0 0 5px 0 gray;
            margin-right: 3px;
            margin-bottom: 3px;
            color: #c71212 !important;
            font-size: .9rem !important;
        }
        .user_info__wrapper { 
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }

        .user_info__img { 
            width: 30px;
            height: 30px;
        }
    </style>
    <script type="text/javascript">
        var destination_latitude = 0, destination_longitude = 0, source_latitude = 0, source_longitude = 0;

        var map, mapMarkers = [];
        var source, destination;

        var users;
        var providers;
        var ajaxMarkers = [];
        var googleMarkers = [];
        var mapIcons = {
            user: '{{ asset("asset/img/marker-user.png") }}',
            active: '{{ asset("asset/img/marker-green.png") }}',
            riding: '{{ asset("asset/img/marker-red.png") }}',
            offline: '{{ asset("asset/img/marker-red.png") }}',
            unactivated: '{{ asset("asset/img/marker-red.png") }}',
        };

        var s_input, d_input;
        var s_latitude, s_longitude;
        var d_latitude, d_longitude;
        var distance;

        function initMap() {
            window.Tranxit.map = true;
        }

        function createRideInitialize() {

            console.log('createRideInitialize');

            s_input = document.getElementById('s_address');
            d_input = document.getElementById('d_address');

            s_latitude = document.getElementById('s_latitude');
            s_longitude = document.getElementById('s_longitude');

            d_latitude = document.getElementById('d_latitude');
            d_longitude = document.getElementById('d_longitude');

            distance = document.getElementById('distance');

            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: {{ Setting::get('latitude') }}, lng: {{ Setting::get('longitude') }}},
                zoom: 2,
            });

            var autocomplete_source = new google.maps.places.Autocomplete(s_input);
            autocomplete_source.bindTo('bounds', map);

            var autocomplete_destination = new google.maps.places.Autocomplete(d_input);
            autocomplete_destination.bindTo('bounds', map);

            var service = new google.maps.places.PlacesService(map);
            var des_service = new google.maps.places.PlacesService(map);

            var marker = new google.maps.Marker({
                map: map,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29),
                icon: '/asset/img/marker-start.png'
            });

            var markerSecond = new google.maps.Marker({
                map: map,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29),
                icon: '/asset/img/marker-end.png'
            });

            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});

            google.maps.event.addListener(map, 'click', updateMarker);
            google.maps.event.addListener(map, 'click', updateMarkerSecond);

            google.maps.event.addListener(marker, 'dragend', updateMarker);
            google.maps.event.addListener(markerSecond, 'dragend', updateMarkerSecond);

            autocomplete_source.addListener('place_changed', function (event) {
                marker.setVisible(false);
                var place = autocomplete_source.getPlace();

                if (place.hasOwnProperty('place_id')) {
                    if (!place.geometry) {
                        window.alert("Autocomplete's returned place contains no geometry");
                        return;
                    }
                    updateSource(place.geometry.location);
                } else {
                    service.textSearch({
                        query: place.name
                    }, function (results, status) {
                        if (status == google.maps.places.PlacesServiceStatus.OK) {
                            console.log('Autocomplete Has No Property');
                            updateSource(results[0].geometry.location);
                            s_input.value = results[0].formatted_address;
                        }
                    });
                }
            });

            autocomplete_destination.addListener('place_changed', function (event) {
                markerSecond.setVisible(false);
                var place = autocomplete_destination.getPlace();

                if (place.hasOwnProperty('place_id')) {
                    if (!place.geometry) {
                        window.alert("Autocomplete's returned place contains no geometry");
                        return;
                    }
                    updateDestination(place.geometry.location);
                } else {
                    des_service.textSearch({
                        query: place.name
                    }, function (results, status) {
                        if (status == google.maps.places.PlacesServiceStatus.OK) {
                            updateDestination(results[0].geometry.location);

                            console.log('destination', results[0]);
                            d_input.value = results[0].formatted_address;
                        }
                    });
                }
            });

            function updateSource(location) {
                map.panTo(location);
                marker.setPosition(location);
                marker.setVisible(true);
                map.setZoom(15);
                updateSourceForm(location.lat(), location.lng());
                if (destination != undefined) {
                    updateRoute();
                }
            }

            function updateDestination(location) {
                map.panTo(location);
                markerSecond.setPosition(location);
                markerSecond.setVisible(true);
                updateDestinationForm(location.lat(), location.lng());
                updateRoute();
            }

            var distance_system = `{{ Setting::get('distance_system', 'metric') }}`;

            function updateRoute() {
                directionsDisplay.setMap(null);
                directionsDisplay.setMap(map);

                directionsService.route({
                    origin: source,
                    destination: destination,
                    travelMode: google.maps.TravelMode.DRIVING,
                    unitSystem: distance_system == 'metric' ? google.maps.UnitSystem.METRIC : google.maps.UnitSystem.IMPERIAL,
                }, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(result);

                        marker.setPosition(result.routes[0].legs[0].start_location);
                        markerSecond.setPosition(result.routes[0].legs[0].end_location);

                        distance.value = result.routes[0].legs[0].distance.value / 1000;
                    }
                });
            }

            function updateSourceForm(lat, lng) {
                s_latitude.value = lat;
                s_longitude.value = lng;

                source = new google.maps.LatLng(lat, lng);
            }

            function updateDestinationForm(lat, lng) {
                d_latitude.value = lat;
                d_longitude.value = lng;
                destination = new google.maps.LatLng(lat, lng);
            }

            function updateMarker(event) {

                marker.setVisible(true);
                marker.setPosition(event.latLng);

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            s_input.value = results[0].formatted_address;
                            s_state.value = '';
                            s_country.value = '';
                            s_city.value = '';
                            s_pin.value = '';
                        } else {
                            alert('No Address Found');
                        }
                    } else {
                        alert('Geocoder failed due to: ' + status);
                    }
                });

                updateSource(event.latLng);
            }

            function updateMarkerSecond(event) {

                markerSecond.setVisible(true);
                markerSecond.setPosition(event.latLng);

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            d_input.value = results[0].formatted_address;
                            d_state.value = '';
                            d_country.value = '';
                            d_city.value = '';
                            d_pin.value = '';
                        } else {
                            alert('No Address Found');
                        }
                    } else {
                        alert('Geocoder failed due to: ' + status);
                    }
                });

                updateDestination(event.latLng);
            }
        }

        function ongoingInitialize(trip) {
            console.log('ongoingRidesInitialize', trip);
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: {{ Setting::get('latitude') }}, lng: {{ Setting::get('longitude') }}},
                zoom: 2,
            });

            var bounds = new google.maps.LatLngBounds();

            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
                icon: '/asset/img/marker-start.png'
            });

            var markerSecond = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
                icon: '/asset/img/marker-end.png'
            });

            source = new google.maps.LatLng(trip.s_latitude, trip.s_longitude);
            destination = new google.maps.LatLng(trip.d_latitude, trip.d_longitude);

            marker.setPosition(source);
            markerSecond.setPosition(destination);

            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
            directionsDisplay.setMap(map);

            directionsService.route({
                origin: source,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING
            }, function (result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(result);

                    marker.setPosition(result.routes[0].legs[0].start_location);
                    markerSecond.setPosition(result.routes[0].legs[0].end_location);
                }
            });

            if (trip.provider) {
                var markerProvider = new google.maps.Marker({
                    map: map,
                    icon: "/asset/img/marker-car.png",
                    anchorPoint: new google.maps.Point(0, -29)
                });

                provider = new google.maps.LatLng(trip.provider.latitude, trip.provider.longitude);
                markerProvider.setVisible(true);
                markerProvider.setPosition(provider);
                console.log('Provider Bounds', markerProvider.getPosition());
                bounds.extend(markerProvider.getPosition());
            }
            bounds.extend(marker.getPosition());
            bounds.extend(markerSecond.getPosition());
            map.fitBounds(bounds);
        }

        function assignProviderShow(providers, trip) {
            console.log('assignProviderShow', trip, providers)

            var bounds = new google.maps.LatLngBounds();
            bounds.extend({lat: trip.s_latitude, lng: trip.s_longitude});
            bounds.extend({lat: trip.d_latitude, lng: trip.d_longitude});

            providers.forEach(function (provider) {
                var marker = new google.maps.Marker({
                    position: {lat: provider.latitude, lng: provider.longitude},
                    map: map,
                    provider_id: provider.id,
                    title: provider.first_name + " " + provider.last_name,
                    icon: '/asset/img/marker-car.png'
                });

                var content = "<p>Name : " + provider.first_name + " " + provider.last_name + "</p>" +
                    "<p>Rating : " + provider.rating + "</p>" +
                    "<p>Service Type : " + provider.service.service_type.name + "</p>" +
                    "<p>Car Model  : " + provider.service.service_type.name + "</p>" +
                    "<a href='/dispatcher/dispatcher/trips/" + trip.id + '/' + provider.id + "' class='btn btn-success'>Assign this Provider</a>";

                marker.infowindow = new google.maps.InfoWindow({
                    content: content
                });

                marker.addListener('click', function () {
                    marker.infowindow.open(map, marker);
                });

                bounds.extend(marker.getPosition());
                mapMarkers.push(marker);

            });

            map.fitBounds(bounds);
        }

        function assignProviderPopPicked(provider, markers=mapMarkers) {
            var index;
            for (var i = markers.length - 1; i >= 0; i--) {
                if (markers[i].provider_id == provider.id) {
                    index = i;
                }
                markers[i].infowindow.close();
            }
            console.log("index", index);
            // markers[index].setPosition({lat: provider.latitude, lng: provider.longitude});
            markers[index].infowindow.open(map, markers[index]);
        }

        function worldMapInitialize(argument) {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: {{ Setting::get('latitude') }}, lng: {{ Setting::get('longitude') }}},
                zoom: 6,
            });

            //For adding drivers

            /*
            var legend = document.getElementById("legend");

            // var div = document.createElement('div');
            // div.innerHTML = '<img src="' + mapIcons['user'] + '"> ' + 'User';
            // legend.appendChild(div);

            var div = document.createElement("div");
            div.innerHTML =
            '<img src="' + mapIcons["offline"] + '"> ' + "Unavailable Provider";
            legend.appendChild(div);

            var div = document.createElement("div");
            div.innerHTML =
            '<img src="' + mapIcons["active"] + '"> ' + "Available Provider";
            legend.appendChild(div);

            var div = document.createElement("div");
            div.innerHTML =
            '<img src="' + mapIcons["unactivated"] + '"> ' + "Unactivated Provider";
            legend.appendChild(div);
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
            */
            google.maps.Map.prototype.clearOverlays = function () {
                for (var i = 0; i < googleMarkers.length; i++) {
                    googleMarkers[i].setMap(null);
                }
                googleMarkers.length = 0;
            };
            setInterval(ajaxMapData, 60000);
        }

        window.onload = ajaxMapData;

        function ajaxMapData() {
            map.clearOverlays();
            $.ajax({
                url: "/dispatcher/map/ajax",
                dataType: "JSON",
                headers: {"X-CSRF-TOKEN": window.Laravel.csrfToken},
                type: "GET",
                success: function (data) {
                    ajaxMarkers = data;

                    ajaxMarkers && ajaxMarkers.forEach(function (provider) {
                    var marker = new google.maps.Marker({
                        position: {lat: provider.latitude, lng: provider.longitude},
                        map: map,
                        provider_id: provider.id,
                        title: provider.first_name + " " + provider.last_name,
                        icon: "/asset/img/marker-car.png",
                    });

                    var content =
                        "<p>Name : " +
                        provider.first_name +
                        " " +
                        provider.last_name +
                        "</p>" +
                        "<p>Mobile: " +
                        provider.mobile +
                        "<p>Rating : " +
                        provider.rating +
                        "</p>" +
                        "<p>Service Type : " +
                        (provider.service?.service_type?.name  || 'N/A')+
                        "</p>" +
                        "<p>Car Model  : " +
                        (provider.service?.service_model || 'N/A') +
                        "</p>" +
                        "<p>Car Number  : " +
                        (provider.service?.service_number  || 'N/A')+
                        "</p>";

                    marker.infowindow = new google.maps.InfoWindow({
                        content: content,
                    });

                    marker.addListener("click", function () {
                        assignProviderPopPicked(provider,googleMarkers);
                    });

                    googleMarkers.push(marker);
                });
                },
            });
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
                icon: mapIcons[element.service ? element.service.status : element.status],
            });

            googleMarkers.push(marker);

            // google.maps.event.addListener(marker, "click", function () {
            //     window.location.href =
            //     "/admin/" + element.service ? "provider" : "user" + "/" + element.user_id;
            // });
        }
    </script>
    {{-- <script type="text/javascript" src="{{ asset('asset/js/dispatcher-map.js') }}"></script> --}}
    <script type="text/babel" src="{{ asset('asset/js/dispatcher.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('map_key')}}&libraries=places" async
            defer></script>
    <script type="text/javascript">
        $(document).ready(function () {
            initMap();
        });
    </script>
@endsection

@section('styles')

    <style type="text/css">
        .my-card input {
            margin-bottom: 10px;
        }

        .my-card label.checkbox-inline {
            margin-top: 10px;
            margin-right: 5px;
            margin-bottom: 0;
        }

        .my-card label.checkbox-inline input {
            position: relative;
            top: 3px;
            margin-right: 3px;
        }

        .my-card .card-header .btn {
            font-size: 10px;
            padding: 3px 7px;
        }

        .tag.my-tag {
            padding: 10px 15px;
            font-size: 11px;
        }

        .add-nav-btn {
            padding: 5px 15px;
            min-width: 0;
        }

        .dispatcher-nav li span {
            background-color: transparent;
            color: #000 !important;
            padding: 5px 12px;
        }

        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff !important;
            padding: 5px 12px;
        }

        .dispatcher-nav li.active span,
        .dispatcher-nav li span:hover,
        .dispatcher-nav li span:focus,
        .dispatcher-nav li span:active {
            background-color: #20b9ae;
            color: #fff !important;
            padding: 5px 12px;
        }

        @media (max-width: 767px) {
            .navbar-nav {
                display: inline-block;
                float: none !important;
                margin-top: 10px;
                width: 100%;
            }

            .navbar-nav .nav-item {
                display: block;
                width: 100%;
                float: none;
            }

            .navbar-nav .nav-item .btn {
                display: block;
                width: 100%;
            }

            .navbar .navbar-toggleable-sm {
                padding-top: 0;
            }
        }

        .items-list {
            height: 450px;
            overflow-y: scroll;
        }

        #map {
            height: 100%;
            min-height: 450px;
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
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css"/>
@endsection