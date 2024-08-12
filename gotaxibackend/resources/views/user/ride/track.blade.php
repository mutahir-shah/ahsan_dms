<script  src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('map_key')}}&libraries=places" async
        defer></script>
<script type="text/javascript">
    $(document).ready(function () {
        initMap();
    });

    function initMap() {
        var myLatLng = new google.maps.LatLng(33.729601, 73.0751509);

        var mapOptions = {
            zoom: 16,
            center: myLatLng,
            scrollwheel: true,
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            overviewMapControl: true,
            mapTypeId: google.maps.MapTypeId.roadmap,
            animation: google.maps.Animation.DROP
        }

        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: false
        });

    }

    // google.maps.event.addDomListener(window, 'load', initialize);

    function getCoords() {

        // $.ajax({
        //     url: "../ajaxscript.php",
        //     type: "POST",
        //     data: {
        //         foo: "bar"
        //     },
        //     dataType: "text",
        //     success: function(returnedData) {
        //         alert(returnedData);
        //         moveMarkerMap(returnedData);
        //     }
        // });
        var input = "33.7300567,73.0755081";
        var latlngStr = input.split(",", 2);
        var lat = parseFloat(latlngStr[0]);
        var lng = parseFloat(latlngStr[1]);
        returnedData = new google.maps.LatLng(lat, lng);
        moveMarkerMap(returnedData);
    }

    function moveMarkerMap(newCoords) {
        // var newLatLang = new google.maps.LatLng(newCoords);
        // map.panTo(newCoords);
        map.setCenter(newCoords);
        marker.setPosition(newCoords);
    }

    window.setInterval(getCoords, 5000);
</script>
<style>
    #map_canvas {
        height: 100%;
        width: 100%;
    }
</style>
<div id="map_canvas"></div>