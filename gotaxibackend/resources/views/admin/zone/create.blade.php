@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Add Zone ')
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.7.10/vue.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<style>
    html,
    body {
        padding: 0;
        margin: 0;
        width: 100%;
        height: 100%;
    }

    #map {
        padding: 0;
        margin: 0;
        width: 100%;
        height: 80%;
    }

    #submit_zone_btn {
        background-color: #b01d23;
        color: #fff !important;
        font-weight: bold;
    }

    .intr {
        color: red;
        font-style: italic;
    }

    #panel {
        width: 200px;
        font-family: Arial, sans-serif;
        font-size: 13px;
        float: right;
        margin: 10px;
    }

    #color-palette {
        clear: both;
        display: none;
    }

    .color-button {
        width: 14px;
        height: 14px;
        font-size: 0;
        margin: 2px;
        float: left;
        cursor: pointer;
    }

    #delete-button {
        margin-top: 5px;
        display: none;
    }

    .gmnoprint > div:nth-child(4),
    .gmnoprint > div:nth-child(5) {
        display: none !important;
    }
</style>

<body>

<div class="content-wrapper" style="">
    <div class="container-fluid">
        @section('content')

            <div class='box' style="background: #fff;">
                <h5 style='padding: 10px;margin-bottom: -15px;'><span class="s-icon"><i
                                class="ti-zoom-in"></i></span>&nbsp;
                    {{ translateKeyword('add-location') }}</h5>
                <hr>
                <input id="pac-input" class="form-control" type="text" placeholder="{{ translateKeyword('enter-location')}}"
                       style="top:5px!important;width:50%;">

                <div id="panel">
                    <div id="color-palette"></div>
                    <div>
                        <button id="delete-button">{{ translateKeyword('delete-selected-shape') }}</button>
                    </div>
                </div>
                <div id="map"></div>

            </div>
    </div>
</div>
@include('admin.layout.partials.zone_form')

@endsection

@section('scripts')
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=geometry,places,drawing&ext=.js" async defer>
    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            initialize();
        });

        //google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: {lat: {{ Setting::get('latitude') }}, lng: {{ Setting::get('longitude') }}},
                // mapTypeId: google.maps.MapTypeId.SATELLITE,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true,
                zoomControl: true
            });

            var polyOptions = {
                strokeWeight: 0,
                fillOpacity: 0.45,
                editable: true,
                draggable: true
            };
            // Creates a drawing manager attached to the map that allows the user to draw
            // markers, lines, and shapes.
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                markerOptions: {
                    draggable: true
                },
                polylineOptions: {
                    editable: true,
                    draggable: true
                },
                rectangleOptions: polyOptions,
                circleOptions: polyOptions,
                polygonOptions: polyOptions,
                map: map
            });
            google.maps.Map.prototype.clearOverlays = function () {
                for (var i = 0; i < googleMarkers.length; i++) {
                    googleMarkers[i].setMap(null);
                }
                googleMarkers.length = 0;
            }

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
                var newShape = e.overlay;

                newShape.type = e.type;
                // console.log(newShape.getPath());

                if (e.type !== google.maps.drawing.OverlayType.MARKER) {
                    // Switch back to non-drawing mode after drawing a shape.
                    drawingManager.setDrawingMode(null);

                    console.log('polygon path array', e.overlay.getPath().getArray());
                    $.each(e.overlay.getPath().getArray(), function (key, latlng) {
                        var lat = latlng.lat();
                        var lon = latlng.lng();
                        console.log(lat, lon);
                        var path = lat + ',' + lon;
                        polygonArray.push(path);
                        //str_input += lat +' '+ lon +',';
                    });

                    //console.log( polygonArray );
                    //$('#zoneModel').modal('show');
                    //   str_input = str_input.substr(0,str_input.length-1) + '))';
                    // console.log('the str_input will be:', str_input);
                    //alert('done');
                    $('#zoneModel').modal('show');

                    // Add an event listener that selects the newly-drawn shape when the user
                    // mouses down on it.
                    google.maps.event.addListener(newShape, 'click', function (e) {
                        $('#zoneModel').modal('show');
                        if (e.vertex !== undefined) {
                            if (newShape.type === google.maps.drawing.OverlayType.POLYGON) {
                                var path = newShape.getPaths().getAt(e.path);

                                path.removeAt(e.vertex);
                                if (path.length < 3) {
                                    newShape.setMap(null);
                                }
                            }
                            if (newShape.type === google.maps.drawing.OverlayType.POLYLINE) {
                                var path = newShape.getPath();

                                path.removeAt(e.vertex);
                                if (path.length < 2) {
                                    newShape.setMap(null);
                                }
                            }
                        }
                        setSelection(newShape);
                    });
                    setSelection(newShape);
                } else {
                    google.maps.event.addListener(newShape, 'click', function (e) {
                        setSelection(newShape);
                    });
                    setSelection(newShape);
                }
            });

            google.maps.Map.prototype.clearOverlays = function () {
                for (var i = 0; i < googleMarkers.length; i++) {
                    googleMarkers[i].setMap(null);
                }
                googleMarkers.length = 0;
            }

            // Clear the current selection when the drawing mode is changed, or when the
            // map is clicked.
            google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
            google.maps.event.addListener(map, 'click', clearSelection);
            google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);

            buildColorPalette();

            // SearchBox code
            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });


            if (edit_polygon) {

                drawingManager.setOptions({
                    drawingMode: null,
                    drawingControl: false
                });

                var edit_poly_options = {
                    fillColor: '#BCDCF9',
                    fillOpacity: 0.0,
                    strokeWeight: 2,
                    strokeColor: '#57ACF9',
                    zIndex: 1
                };
                edit_poly_options.clickable = true;
                edit_poly_options.editable = true;
                edit_poly_options.paths = makeZoneArray(edit_polygon);
                var shape = new google.maps.Polygon(edit_poly_options);
                shape.setMap(map);

                var place_polygon_path = shape.getPath();
                google.maps.event.addListener(place_polygon_path, 'set_at', function () {
                    polygonArray = [];
                    for (var i = 0; i < shape.getPath().getLength(); i++) {
                        var path = shape.getPath().getAt(i).lat() + ',' + shape.getPath().getAt(i).lng();
                        polygonArray.push(path);
                    }
                });

                google.maps.event.addListener(shape, 'click', function () {
                    $('#zoneModel').modal('show');
                });
            }

            showAllPolygons();

        }

        var zoneModel = $('#zoneModel');
        var zoneForm = $('#zoneForm');
        var zoneClose = zoneForm.find('#zone_close');
        var zoneSubmitBtn = zoneForm.find('#submit_zone_btn');

        zoneModel.modal({
            backdrop: 'static',
            keyboard: false
        });
        zoneModel.modal('hide');

        var map;
        var geocoder;
        var drawingManager;
        var selectedShape;
        var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
        var selectedColor;
        var colorButtons = {};
        var polygons = [];
        var polygonArray = [];
        var googleMarkers = [];
        var all_zones = [];
        var edit_polygon;

        var polygonOptions = {
            fillColor: '#BCDCF9',
            fillOpacity: 0.0,
            strokeWeight: 2,
            strokeColor: '#57ACF9',
            zIndex: 1
        };
        var markerOptions = {
            icon: 'images/car-icon.png'
        };
        var drawingControl = true;

        @if (isset($zone))
            edit_zone = {!! json_encode($zone) !!};
        if (edit_zone) {
            edit_polygon = edit_zone.coordinate;
        }
        @endif

        @if (count($all_zones))
        var all_zones = {!! json_encode($all_zones) !!};
        @endif


        function initMap() {
            infoWindow = new google.maps.InfoWindow;

            map = new google.maps.Map(document.getElementById("map"), {
                center: {lat: {{ Setting::get('latitude') }}, lng: {{ Setting::get('longitude') }}},
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            initdrawingManager();

            google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
                for (var i = 0; i < polygon.getPath().getLength(); i++) {
                    var path = polygon.getPath().getAt(i).lat() + ',' + polygon.getPath().getAt(i).lng();
                    polygonArray.push(path);

                }

                $('#zoneModel').modal('show');

                console.log(polygonArray);
            });

            // google.maps.event.addListener(drawingManager, 'circlecomplete', function (circle) {
            //     console.log(circle);
            //     alert(1);
            //     $('#zoneModel').modal('show');

            // });


            google.maps.Map.prototype.clearOverlays = function () {
                for (var i = 0; i < googleMarkers.length; i++) {
                    googleMarkers[i].setMap(null);
                }
                googleMarkers.length = 0;
            }


            if (edit_polygon) {

                drawingManager.setOptions({
                    drawingMode: null,
                    drawingControl: false
                });

                var edit_poly_options = {
                    fillColor: '#BCDCF9',
                    fillOpacity: 0.0,
                    strokeWeight: 2,
                    strokeColor: '#57ACF9',
                    zIndex: 1
                };
                edit_poly_options.clickable = true;
                edit_poly_options.editable = true;
                edit_poly_options.paths = makeZoneArray(edit_polygon);
                var shape = new google.maps.Polygon(edit_poly_options);
                shape.setMap(map);

                var place_polygon_path = shape.getPath();
                google.maps.event.addListener(place_polygon_path, 'set_at', function () {
                    polygonArray = [];
                    for (var i = 0; i < shape.getPath().getLength(); i++) {
                        var path = shape.getPath().getAt(i).lat() + ',' + shape.getPath().getAt(i).lng();
                        alert(path);
                        polygonArray.push(path);
                    }
                });

                google.maps.event.addListener(shape, 'click', function () {
                    $('#zoneModel').modal('show');
                });
            }

            showAllPolygons();
        }

        function initdrawingManager() {
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },

                drawingControl: drawingControl,
                polygonOptions: polygonOptions
            });
            drawingManager.setMap(map);
        }

        var edit_zone = null;

        function showAllPolygons() {
            var options = polygonOptions;
            options.paths = null;
            if (all_zones.length) {
                all_zones.forEach(function (zone, ind) {
                    options.paths = makeZoneArray(zone.latlng);
                    if (edit_zone) {
                        if (edit_zone.id != zone.id) {
                            var shape = new google.maps.Polygon(options);
                            shape.setMap(map);
                        }
                    } else {
                        var shape = new google.maps.Polygon(options);
                        shape.setMap(map);
                    }
                });
            }
        }

        function clearSelection() {
            if (selectedShape) {
                if (selectedShape.type !== 'marker') {
                    selectedShape.setEditable(false);
                }

                selectedShape = null;
            }
        }

        function setSelection(shape) {
            if (shape.type !== 'marker') {
                clearSelection();
                shape.setEditable(true);
                selectColor(shape.get('fillColor') || shape.get('strokeColor'));
            }

            selectedShape = shape;
        }

        function deleteSelectedShape() {
            if (selectedShape) {
                selectedShape.setMap(null);
            }
        }

        function selectColor(color) {
            selectedColor = color;
            for (var i = 0; i < colors.length; ++i) {
                var currColor = colors[i];
                colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
            }

            // Retrieves the current options from the drawing manager and replaces the
            // stroke or fill color as appropriate.
            var polylineOptions = drawingManager.get('polylineOptions');
            polylineOptions.strokeColor = color;
            drawingManager.set('polylineOptions', polylineOptions);

            /*var rectangleOptions = drawingManager.get('rectangleOptions');
            rectangleOptions.fillColor = color;
            drawingManager.set('rectangleOptions', rectangleOptions);

            var circleOptions = drawingManager.get('circleOptions');
            circleOptions.fillColor = color;
            drawingManager.set('circleOptions', circleOptions);*/

            var polygonOptions = drawingManager.get('polygonOptions');
            polygonOptions.fillColor = color;
            drawingManager.set('polygonOptions', polygonOptions);
        }

        function setSelectedShapeColor(color) {
            if (selectedShape) {
                if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
                    selectedShape.set('strokeColor', color);
                } else {
                    selectedShape.set('fillColor', color);
                }
            }
        }

        function makeColorButton(color) {
            var button = document.createElement('span');
            button.className = 'color-button';
            button.style.backgroundColor = color;
            google.maps.event.addDomListener(button, 'click', function () {
                selectColor(color);
                setSelectedShapeColor(color);
            });

            return button;
        }

        function buildColorPalette() {
            var colorPalette = document.getElementById('color-palette');
            for (var i = 0; i < colors.length; ++i) {
                var currColor = colors[i];
                var colorButton = makeColorButton(currColor);
                colorPalette.appendChild(colorButton);
                colorButtons[currColor] = colorButton;
            }
            selectColor(colors[0]);
        }


        /*google.maps.event.addListener(shape, 'click', function() {
                    $('#zoneModel').modal('show');
                });*/

        // zoneSubmitBtn.on('click', function(e) {
        //   alert(0);
        //     checkArgForAddZone(polygonArray);
        // });

        $("body").on("click", "#submit_zone_btn", function () {
            checkArgForAddZone(polygonArray);
        })

        function initdrawingManager() {
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },

                drawingControl: drawingControl,
                polygonOptions: polygonOptions
            });
            drawingManager.setMap(map);
        }

        function showAllPolygons() {
            var options = polygonOptions;
            options.paths = null;
            if (all_zones.length) {
                all_zones.forEach(function (zone, ind) {
                    options.paths = makeZoneArray(zone.latlng);
                    if (edit_zone) {
                        if (edit_zone.id != zone.id) {
                            var shape = new google.maps.Polygon(options);
                            shape.setMap(map);
                        }
                    } else {
                        var shape = new google.maps.Polygon(options);
                        shape.setMap(map);
                    }
                });
            }
        }


        function checkArgForAddZone(path_coordinate) {

            var name = $('#zoneForm').find('input[name=zone_name]').val();
            var country_name = $('#zoneForm').find('#country_name').val();
            var state_name = $('#zoneForm').find('#state_name').val();
            var city_name = $('#zoneForm').find('#city_name').val();
            var currency_name = $('#zoneForm').find('select[name=currency_name]').val();
            var status_name = $("input[name='status_name']:checked").val();
            var zone_id = $('#zoneForm').find('#zone_id').val();

            zone_id = (zone_id.length) ? zone_id : 0;

            if (!name.length) {
                alert('Please enter a zone name!');
                $('#zoneModel').modal('show');
                return false;
            }

            if (!path_coordinate.length) {
                alert('Please draw a zone!');
                return false;
            }

            addZone(zone_id, name, country_name, state_name, city_name, status_name, currency_name, path_coordinate);

        }

        function addZone(zone_id, zone_name, country_name, state_name, city_name, status_name, currency_name,
                         path_coordinate) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                },
                url: '{{ url('/admin/zone') }}',
                dataType: 'JSON',
                type: 'POST',
                data: {
                    id: zone_id,
                    name: zone_name,
                    country: country_name,
                    state: state_name,
                    city: city_name,
                    status: status_name,
                    currency: currency_name,
                    coordinate: path_coordinate
                },
                success: function (json) {
                    if (json.status) {
                        window.location.replace("{{ route('admin.zone.index') }}");
                    }
                }
            });
        }

        function makeZoneArray(polygonArg) {
            var zoneArray = [];
            if (polygonArg) {
                polygonArg.forEach(function (item, ind) {
                    zoneArray[ind] = {
                        lat: parseFloat(item['lat']),
                        lng: parseFloat(item['lng'])
                    };
                });
            }
            return zoneArray;
        }

        $("#peak_data").click(function () {
            var i = $('.peak_day').length;

            var day_p = $("#peak_day option:selected").text();
            var start_time_p = $("#peak_start_time option:selected").text();
            var end_time_p = $("#peak_end_time option:selected").text();
            var peak_fare = $("#peak_fare").val();


            // alert(day_p+' '+start_time_p+' '+end_time_p+' '+peak_fare);
            //   console.log($("#reg-form").serialize());
            var data = {
                '_token': "JdtePtUBweqHBGcWKR1OMlPZiZ1fxBBThU0gQmcs",
                'day': day_p,
                'start_time': start_time_p,
                'end_time': end_time_p,
                'fare_in_percentage': peak_fare,
                'peak_night_type': 'PEAK'
            };
            $.post("https://97pixelsdev.com/ilyft/admin/addpeakAnight", data, function (res) {
                // console.log(res);

                // var resdata = $.parseJSON(res);
                // console.log(res);
                // console.log(res.data);
                if (res.status == 1) {
                    alert('You cant create duplicate day');
                }
                // $('#peakAdded').empty();
                // alert(i);
                if (i >= 6) {
                    $("#peakAdded").append(
                        '<div class="form-group row"><p style="color:red;text-align: center">You can add maximum 7 days</p></div>'
                    );
                } else {
                    // $("#peakAdded").append('<div class="form-group row"><label for="store_link_ios" class="col-xs-2 col-form-label"></label><div class="col-xs-2"><select  class="form-control peak_day" name="peak_day[]" id="peak_day"><option>Day</option><option value="Monday">Monday </option><option value="Tuesday">Tuesday </option><option value="Wednesday">Wednesday </option><option value="Thursday">Thursday </option><option value="Friday">Friday </option><option value="Saturday">Saturday </option><option value="Sunday">Sunday </option></select></div><div class="col-xs-2"><select  class="form-control" name="peak_start_time[]" id="peak_start_time"><option>Start Time</option><option value="12 AM">12 AM </option>                        <option value="1 AM">1 AM </option>                        <option value="2 AM">2 AM </option>                        <option value="3 AM">3 AM </option>                        <option value="4 AM">4 AM </option>                        <option value="5 AM">5 AM </option>                        <option value="6 AM">6 AM </option>                        <option value="7 AM">7 AM </option>                        <option value="8 AM">8 AM </option>                        <option value="9 AM">9 AM </option>                        <option value="10 AM">10 AM </option>                        <option value="11 AM">11 AM </option>                        <option value="12 PM">12 PM </option>                        <option value="1 PM">1 PM </option>                        <option value="2 PM">2 PM </option>                        <option value="3 PM">3 PM </option>                        <option value="4 PM">4 PM </option>                        <option value="5 PM">5 PM </option>                        <option value="6 PM">6 PM </option>                        <option value="7 PM">7 PM </option>                        <option value="8 PM">8 PM </option>                        <option value="9 PM">9 PM </option>                        <option value="10 PM">10 PM </option>                        <option value="11 PM">11 PM </option>                        </select></div><div class="col-xs-2"><select  class="form-control" name="peak_end_time[]" id="peak_end_time"><option>End Time</option><option value="12 AM">12 AM </option><option value="1 AM">1 AM </option><option value="2 AM">2 AM </option><option value="3 AM">3 AM </option><option value="4 AM">4 AM </option><option value="5 AM">5 AM </option><option value="6 AM">6 AM </option><option value="7 AM">7 AM </option><option value="8 AM">8 AM </option><option value="9 AM">9 AM </option><option value="10 AM">10 AM </option><option value="11 AM">11 AM </option><option value="12 PM">12 PM </option><option value="1 PM">1 PM </option><option value="2 PM">2 PM </option><option value="3 PM">3 PM </option><option value="4 PM">4 PM </option><option value="5 PM">5 PM </option><option value="6 PM">6 PM </option><option value="7 PM">7 PM </option><option value="8 PM">8 PM </option><option value="9 PM">9 PM </option><option value="10 PM">10 PM </option><option value="11 PM">11 PM </option></select></div><div class="col-xs-2"><input class="form-control" type="text" value="" name="peak_fare[]" id="peak_fare" placeholder="Peak Fare(%)"></div><div class="col-xs-2"><button type="button" class="btn btn-primary" id="peak_data" onclick="removeRow(this)">-</button></div></div>');
                    $("#peakAdded").append(
                        '<div class="form-group row"><label for="store_link_ios" class="col-xs-2 col-form-label"></label><div class="col-xs-2"><select  class="form-control peak_day" name="peak_day[]" id="peak_day"><option>Day</option><option value="Monday">Monday </option><option value="Tuesday">Tuesday </option><option value="Wednesday">Wednesday </option><option value="Thursday">Thursday </option><option value="Friday">Friday </option><option value="Saturday">Saturday </option><option value="Sunday">Sunday </option></select></div><div class="col-xs-2"><input type="time" class="form-control validation" name="peak_start_time[]" id="peak_start_time"></div><div class="col-xs-2"><input type="time" class="form-control validation" name="peak_end_time[]" id="peak_end_time"></div><div class="col-xs-2"><input class="form-control validation" type="text" value="" name="peak_fare[]" id="peak_fare" placeholder="Peak Fare(%)"></div><div class="col-xs-2"><button type="button" class="btn btn-primary" id="peak_data" onclick="removeRow(this)">-</button></div></div>'
                    );
                }

            });
        });

        function removeRow(input) {
            input.parentNode.parentNode.remove()
        }

        $("#night_data").click(function () {
            var start_time_n = $("#night_start_time option:selected").text();
            var end_time_n = $("#night_end_time option:selected").text();
            var night_fare = $("#night_fare").val();

            // alert(day_p+' '+start_time_p+' '+end_time_p+' '+peak_fare);
            //   console.log($("#reg-form").serialize());
            var data = {
                '_token': "JdtePtUBweqHBGcWKR1OMlPZiZ1fxBBThU0gQmcs",
                'start_time': start_time_n,
                'end_time': end_time_n,
                'fare_in_percentage': night_fare,
                'peak_night_type': 'NIGHT'
            };
            $.post("addpeakAnight", data, function (res) {
                // console.log(res);

                // var resdata = $.parseJSON(res);
                // console.log(res.data);

                $('#nightAdded').empty();

                $.each(res.data, function (key, val) {
                    $("#nightAdded").append(
                        " <div class='form-group row'><label  class='col-xs-2 col-form-label'></label><div class='col-xs-2'><input class='form-control' type='text' value=" +
                        val.start_time +
                        "></div><div class='col-xs-2'><input class='form-control' type='text' value=" +
                        val.end_time +
                        "></div><div class='col-xs-2'><input class='form-control' type='text' value=" +
                        val.fare_in_percentage + "></div></div>");

                    // console.log(key + " : " + val.day);


                });
            });
        });

        $("select#peak_hour").change(function () {

            var selectedd = $(this).children("option:selected").val();

            if (selectedd === 'NO') {

                $(".peakHide").hide();
            }

            if (selectedd === 'YES') {

                $(".peakHide").show();
            }

        });

        // alert($( "#peak_hour option:selected" ).text());

        $("select#night_hour").change(function () {

            var selectedd = $(this).children("option:selected").val();

            if (selectedd === 'NO') {

                $(".nightHide").hide();
            }

            if (selectedd === 'YES') {

                $(".nightHide").show();
            }


        });

        var wId = null;

        $('#accountApproved').click(function () {

            var id = $(this).attr('data');


            $.ajax({

                url: 'https://97pixelsdev.com/ilyft/admin/approved_account?id=' + id,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-Requested-With', 'XMLhttpsRequest');
                },
                success: function (result) {


                    location.reload();
                    $("#msg").html('you have successfully approved');
                    console.log(result);


                }
            });

        });

        let countries = '';
        let states = '';
        let cities = '';

        function getCountries() {
            axios.get(`{{ route('api.countries') }}`)
                .then(function (response) {
                    countries = response.data;
                    var len = response.data.length;

                    $("#country_name").empty();
                    $("#country_name").append("<option value='0'>Select Country</option>");


                    for (var i = 0; i < len; i++) {

                        var id = countries[i].id;
                        var name = countries[i].name;
                        $("#country_name").append("<option value='" + id + "'>" + name + "</option>");
                    }
                });
        }

        $(document).ready(function () {
            getCountries();
        });


        function getStates() {

            var country_id = $('#country_name option:selected').val();
            axios.get(`{{ route('api.states') }}` + '/' + country_id)
                .then(function (response) {
                    states = response.data;
                    var len = response.data.length;

                    $("#state_name").empty();
                    $("#state_name").append("<option value='0'>Select State</option>");
                    for (var i = 0; i < len; i++) {
                        var id = states[i].id;
                        var name = states[i].name;
                        $("#state_name").append("<option value='" + id + "'>" + name + "</option>");
                    }
                });

        }

        function getCities() {

            var state_id = $('#state_name option:selected').val();
            axios.get(`{{ route('api.cities') }}` + '/' + state_id)
                .then(function (response) {
                    cities = response.data;
                    var len = response.data.length;

                    $("#city_name").empty();
                    $("#city_name").append("<option value='0'>Select City</option>");

                    for (var i = 0; i < len; i++) {
                        var id = cities[i].id;
                        var name = cities[i].name;

                        $("#city_name").append("<option value='" + id + "'>" + name + "</option>");
                    }
                });

        }

        // WRITE THE VALIDATION SCRIPT.
        function isValid(el, evnt) {
            var charC = (evnt.which) ? evnt.which : evnt.keyCode;
            if (charC == 46) {
                if (el.value.indexOf('.') === -1) {
                    return false;
                } else {
                    return false;
                }
            } else {
                if (charC > 31 && (charC < 48 || charC > 57))
                    return false;
            }
            return true;
        }
    </script>

@endsection
