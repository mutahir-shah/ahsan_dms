@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Map View ')

@section('content')
    <div class="content-wrapper full-height">
        <div class="container-fluid full-height">
            <div class="box box-block bg-white border-radius-10 full-height">
                <h5 class="mb-1">{{ translateKeyword('map-view') }}</h5>
                <div class="row h-100">
                    <div class="col-xs-12 h-100">
                        <div id="map"></div>
                        <div id="legend"><h3>{{ translateKeyword('note:') }} </h3></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style type="text/css">
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .full-height {
            height: calc(100vh - 60px); /* Full height minus the navbar height */
        }
        #map {
            height: 95%;
            /* min-height: 500px; */
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
@endsection

@section('scripts')
    <script type="text/javascript">
        var map;
        var users;
        var providers;
        var ajaxMarkers = [];
        var googleMarkers = [];
        var mapIcons = {
            user: '{{ asset("asset/img/marker-user.png") }}',
            active: '{{ asset("asset/img/marker-car.png") }}',
            riding: '{{ asset("asset/img/marker-car.png") }}',
            offline: '{{ asset("asset/img/marker-home.png") }}',
            unactivated: '{{ asset("asset/img/marker-plus.png") }}'
        }

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: {{ Setting::get('latitude') }}, lng: {{ Setting::get('longitude') }}},
                zoom: 12,
                minZoom: 1
            });

            setInterval(ajaxMapData, 3000);

            var legend = document.getElementById('legend');

            var div = document.createElement('div');
            div.innerHTML = '<img src="' + mapIcons['active'] + '"> ' + 'Available Driver';
            legend.appendChild(div);

            var div = document.createElement('div');
            div.innerHTML = '<img src="' + mapIcons['offline'] + '"> ' + 'Offline Driver';
            legend.appendChild(div);
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

            google.maps.Map.prototype.clearOverlays = function () {
                for (var i = 0; i < googleMarkers.length; i++) {
                    googleMarkers[i].setMap(null);
                }
                googleMarkers.length = 0;
            }
        }

        function ajaxMapData() {
            map.clearOverlays();
            $.ajax({
                url: '/admin/map/ajax',
                dataType: "JSON",
                headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken},
                type: "GET",
                success: function (data) {
                    ajaxMarkers = data;
                }
            });

            ajaxMarkers ? ajaxMarkers.forEach(addMarkerToMap) : '';
        }

        function addMarkerToMap(element, index) {
            var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(element.latitude),
                    lng: parseFloat(element.longitude)
                },
                id: element.id,
                map: map,
                title: element.first_name + " " + element.last_name,
                icon: mapIcons[element.service[0] ? element.service[0].status : 'offline'],
            });

            googleMarkers.push(marker);

            google.maps.event.addListener(marker, 'click', function () {
                window.location.href = '/admin/' + (element.service ? 'provider' : 'user') + '/' + element.user_id;
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Setting::get('map_key'); ?>&libraries=places" async defer></script>
    <script type="text/javascript">
        $(document).ready(function () {
            initMap();
        });
    </script>
@endsection
