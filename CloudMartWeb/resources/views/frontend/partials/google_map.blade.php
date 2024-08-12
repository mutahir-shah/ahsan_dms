 
<script>
    function initialize(lat = 24.774265, long = 46.738586, id_format = '') {
        var map = new google.maps.Map(document.getElementById(id_format + 'map'), {
            center: {
                lat: lat,
                lng: long
            },
            zoom: 13
        });

        const locationButton = document.createElement("a");

        locationButton.innerHTML = '<i  style="font-size:larger;" class="las la-search-location fas"></i> {{ translate('Locate Me')}}';

        locationButton.classList.add("custom-map-control-button");

        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(locationButton);

        var myLatlng = new google.maps.LatLng(lat, long);

        var input = document.getElementById(id_format + 'searchInput');
        input.classList.add("form-control");
        input.classList.add("search-input-map");
        //                console.log(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            anchorPoint: new google.maps.Point(0, -29),
            draggable: true,
        });

        locationButton.addEventListener("click", () => {
            // Try HTML5 geolocation.
            var geo_place = navigator.geolocation;
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        console.log(pos);
                        $.get({
                            url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=${pos.lat},${pos.lng}&sensor=true&key=AIzaSyC3ditlwETzQ2qlKjSmWMbOGa4xizfHrbQ`,
                            success(data) {
                                //console.log(data.results[0].formatted_address);
                                document.getElementById('g_address').innerHTML = data.results[0].formatted_address;
                            }
                        });

                        document.getElementById(id_format + 'latitude').value = pos.lat;
                        document.getElementById(id_format + 'longitude').value = pos.lng;

                        console.log(position);

                        marker.setPosition(pos);

                        map.setCenter(pos);
                    },
                   
                );

            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }



        });

        map.addListener('click', function(event) {
            marker.setPosition(event.latLng);
            document.getElementById(id_format + 'latitude').value = event.latLng.lat();
            document.getElementById(id_format + 'longitude').value = event.latLng.lng();
            infowindow.setContent('Latitude: ' + event.latLng.lat() + '<br>Longitude: ' + event.latLng.lng());
            infowindow.open(map, marker);
        });

        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById(id_format + 'latitude').value = event.latLng.lat();
            document.getElementById(id_format + 'longitude').value = event.latLng.lng();
            infowindow.setContent('Latitude: ' + event.latLng.lat() + '<br>Longitude: ' + event.latLng.lng());
            infowindow.open(map, marker);
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            /*
            marker.setIcon(({
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));
            */
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);

            //Location details
            for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] == 'postal_code') {
                    document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;

                }
                if (place.address_components[i].types[0] == 'country') {
                    document.getElementById('country').innerHTML = place.address_components[i].long_name;
                }
            }
            document.getElementById('location').innerHTML = place.formatted_address;
            document.getElementById('g_address').innerHTML = place.formatted_address;

            document.getElementById(id_format + 'latitude').value = place.geometry.location.lat();
            document.getElementById(id_format + 'longitude').value = place.geometry.location.lng();

        });

    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&language=en&callback=initialize" async defer></script>