@extends('fleet.layout.basecode')
@extends('admin.layout.base2')

@section('title', 'Request details ')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h4>Request details</h4>
                <a href="{{ url()->previous() }}" class="btn btn-default pull-right">
                    <i class="fa fa-angle-left"></i> Back
                </a>
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Booking ID :</dt>
                            <dd class="col-sm-8">{{ $request->booking_id }}</dd>

                            <dt class="col-sm-4">User Name :</dt>
                            <dd class="col-sm-8">{{ $request->user->first_name }}</dd>
                            <dt class="col-sm-4">User Email :</dt>
                            @if($request->user)
                                <dd class="col-sm-8">{{ $request->user->email }}</dd>
                            @else
                                <dd class="col-sm-8">N/A</dd>
                            @endif
                            <dt class="col-sm-4">User Mobile :</dt>
                            @if($request->user)
                                <dd class="col-sm-8">{{ $request->user->mobile }}</dd>
                            @else
                                <dd class="col-sm-8">N/A</dd>
                            @endif
                            <dt class="col-sm-4">Driver Name :</dt>
                            @if($request->provider)
                                <dd class="col-sm-8">{{ $request->provider->first_name }} {{ $request->provider->last_name }}
                                    - {{ $request->provider->mobile }}</dd>
                            @else
                                <dd class="col-sm-8">Driver not yet assigned!</dd>
                            @endif

                            <dt class="col-sm-4">Total Distance :</dt>
                            <dd class="col-sm-8">{{ $request->distance ? $request->distance : '0' }}  @if (Setting::get('distance_system') === 'metric')
                                    KM
                                @else
                                    Miles
                                @endif </dd>

                            @if($request->status == 'SCHEDULED')
                                <dt class="col-sm-4">Job Scheduled Time :</dt>
                                <dd class="col-sm-8">
                                    @if($request->schedule_at != "0000-00-00 00:00:00")
                                        {{ date('jS \of F Y h:i:s A', strtotime($request->schedule_at)) }}
                                    @else
                                        -
                                    @endif
                                </dd>
                            @else
                                @if($request->started_at != null)
                                    <dt class="col-sm-4">Job Start Time :</dt>
                                    <dd class="col-sm-8">
                                        @if($request->started_at != "0000-00-00 00:00:00")
                                            {{ date('jS \of F Y h:i:s A', strtotime($request->started_at)) }}
                                        @else
                                            -
                                        @endif
                                    </dd>
                                @endif
                                @if($request->finished_at != null)
                                    <dt class="col-sm-4">Job End Time :</dt>
                                    <dd class="col-sm-8">
                                        @if($request->finished_at != "0000-00-00 00:00:00")
                                            {{ date('jS \of F Y h:i:s A', strtotime($request->finished_at)) }}
                                        @else
                                            -
                                        @endif
                                    </dd>
                                @endif

                            @endif

                            <dt class="col-sm-4">Pickup Address :</dt>
                            <dd class="col-sm-8">{{ $request->s_address ? $request->s_address : '-' }}</dd>

                            <dt class="col-sm-4">Drop Address :</dt>
                            <dd class="col-sm-8">{{ $request->d_address ? $request->d_address : '-' }}</dd>

                            @if($request->payment)
                                <dt class="col-sm-4">Base Price :</dt>
                                <dd class="col-sm-8">{{ currency($request->payment->fixed) }}</dd>

                                <dt class="col-sm-4">Tax Price :</dt>
                                <dd class="col-sm-8">{{ currency($request->payment->tax) }}</dd>

                                <dt class="col-sm-4">Total Amount :</dt>
                                <dd class="col-sm-8">{{ currency($request->payment->total) }}</dd>
                            @endif

                            <dt class="col-sm-4">Job Status :</dt>
                            @if ($request->status == 'CANCELLED')
                                <dd class="col-sm-8">
                                    {{ $request->status }} - {{ $request->cancel_reason ? : 'N/A' }}
                                </dd>
                            @else
                                <dd class="col-sm-8">
                                    {{ $request->status }}
                                </dd>
                            @endif
                            @if ($request->status == 'COMPLETED')
                                <dt class="col-sm-4">User Review :</dt>
                                <dd class="col-sm-8">
                                    {{ $request->status }}
                                </dd>
                                <dt class="col-sm-4">Driver Review :</dt>
                                <dd class="col-sm-8">
                                    {{ $request->status }}
                                </dd>
                            @endif
                            @if ($request->status == 'COMPLETED' && $request->rating)
                                <dt class="col-sm-4">User Review :</dt>
                                <dd class="col-sm-8">
                                    Stars: {{ $request->rating->user_rating ? $request->rating->user_rating : 'N/A' }}
                                    <br/>
                                    Comment: {{ $request->rating->user_rating ? $request->rating->user_comment  : 'N/A' }}
                                    <br/>
                                </dd>
                                <dt class="col-sm-4">Driver Review :</dt>
                                <dd class="col-sm-8">
                                    Stars: {{ $request->rating->provider_rating ? $request->rating->provider_rating  : 'N/A' }}
                                    <br/>
                                    Comment: {{ $request->rating->provider_comment ? $request->rating->provider_comment  : 'N/A' }}
                                    <br/>
                                </dd>
                            @endif
                            @php
                                $userReportImages = $request->userReportImages()->get();
                                $driverReportImages = $request->driverReportImages()->get();
                            @endphp
                            @if ($userReportImages->count() > 0)
                                <dt class="col-sm-3">User Report Images:</dt>
                                <dd class="col-sm-9">
                                    @foreach ($userReportImages as $userReportImage)
                                        <a href="{{ $userReportImage->image }}" target="_blank"><img src="{{ $userReportImage->image }}" class="img-lg img-thumbnail" style="border-radius: 20px;" /></a>
                                    @endforeach
                                </dd>
                            @endif
                            @if ($driverReportImages->count() > 0)
                                <dt class="col-sm-3">Driver Report Images:</dt>
                                <dd class="col-sm-9">
                                    @foreach ($driverReportImages as $driverReportImage)
                                        <a href="{{ $driverReportImage->image }}" target="_blank"><img src="{{ $driverReportImage->image }}" class="img-lg img-thumbnail" style="border-radius: 20px;" /></a>
                                    @endforeach
                                </dd>
                            @endif
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style type="text/css">
        #map {
            height: 450px;
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript">
        var map;
        var zoomLevel = 11;

        function initMap() {

            map = new google.maps.Map(document.getElementById('map'));

            var marker = new google.maps.Marker({
                map: map,
                icon: '/asset/img/marker-start.png',
                anchorPoint: new google.maps.Point(0, -29)
            });

            var markerSecond = new google.maps.Marker({
                map: map,
                icon: '/asset/img/marker-end.png',
                anchorPoint: new google.maps.Point(0, -29)
            });

            var bounds = new google.maps.LatLngBounds();

            source = new google.maps.LatLng({{ $request->s_latitude }}, {{ $request->s_longitude }});
            destination = new google.maps.LatLng({{ $request->d_latitude }}, {{ $request->d_longitude }});

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
                    console.log(result);
                    directionsDisplay.setDirections(result);

                    marker.setPosition(result.routes[0].legs[0].start_location);
                    markerSecond.setPosition(result.routes[0].legs[0].end_location);
                }
            });

            @if($request->provider && $request->status != 'COMPLETED')
            var markerProvider = new google.maps.Marker({
                map: map,
                icon: "/asset/img/marker-car.png",
                anchorPoint: new google.maps.Point(0, -29)
            });

            provider = new google.maps.LatLng({{ $request->provider->latitude }}, {{ $request->provider->longitude }});
            markerProvider.setVisible(true);
            markerProvider.setPosition(provider);
            console.log('Provider Bounds', markerProvider.getPosition());
            bounds.extend(markerProvider.getPosition());
            @endif

            bounds.extend(marker.getPosition());
            bounds.extend(markerSecond.getPosition());
            map.fitBounds(bounds);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places"
            async defer></script>
    <script type="text/javascript">
        $(document).ready(function () {
            initMap();
        });
    </script>
@endsection