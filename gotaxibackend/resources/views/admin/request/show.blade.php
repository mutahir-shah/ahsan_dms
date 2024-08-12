@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Request details ')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <h4>{{ translateKeyword('request-details') }}
                                @if (Setting::get('invoice', 0) == 1 && $request->status == 'COMPLETED')
                                    <a href="{{ route('invoice', [$request->id]) }}"
                                        class="btn btn-default pull-right mr-2 ml-2" target="_blank">
                                        {{ translateKeyword('download-invoice') }}
                                    </a>
                                @endif
                                <a href="{{ url()->previous() }}" class="btn btn-default pull-right">
                                    <i class="fa fa-angle-left"></i> {{ translateKeyword('back') }}
                                </a>
                            </h4>
                            <h5 class="w-100 d-flex justify-content-between mt-4">{{ translateKeyword('Booking_ID') }}#
                                {{ $request->booking_id }}
                                <span class="pull-right ml-2" style="font-size: 13px">{{ translateKeyword('job-status') }}:
                                    <span class="badge badge-primary badge-transparent"
                                        style="background-color: rgba(0, 123, 255, 0.6);">
                                        @if ($request->status == 'CANCELLED')
                                            {{ $request->status }} - {{ $request->cancel_reason ?: 'N/A' }}
                                        @else
                                            {{ $request->status }}
                                        @endif
                                    </span>
                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 text-bold">
                                    <p>{{ translateKeyword('service_name') }}:</p>
                                </div>
                                <div class="col-3">
                                    {{ $request->service_type->name }}
                                </div>

                                @if ($request->payment)
                                    <div class="col-4 text-bold">
                                        {{ translateKeyword('payment_method') }}:
                                    </div>
                                    <div class="col-2 text-right">
                                        {{ $request->payment_mode }} @if ($request->payment->wallet)
                                            & WALLET
                                        @endif
                                    </div>
                                @endif
                                @if ($request->status == 'SCHEDULED')
                                    <div class="col-3 text-bold">
                                        {{ translateKeyword('job-scheduled-time') }}:
                                    </div>
                                    <div class="col-3">
                                        @if ($request->schedule_at != '0000-00-00 00:00:00')
                                            {{ date('jS \of F Y h:i:s A', strtotime($request->schedule_at)) }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                @else
                                    @if ($request->started_at != null)
                                        <div class="col-3 text-bold">
                                            {{ translateKeyword('job-start-time') }}:
                                        </div>
                                        <div class="col-3">
                                            @if ($request->started_at != '0000-00-00 00:00:00')
                                                {{ date('jS \of F Y h:i:s A', strtotime($request->started_at)) }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    @endif
                                    @if ($request->finished_at != null)
                                        <div class="col-3 text-bold">
                                            {{ translateKeyword('job-end-time') }}:
                                        </div>
                                        <div class="col-3 text-right">
                                            @if ($request->finished_at != '0000-00-00 00:00:00')
                                                {{ date('jS \of F Y h:i:s A', strtotime($request->finished_at)) }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    @endif
                                @endif

                            </div>
                            @if ($request->service_type->type != 'road_assistance')
                                <div class="row">
                                    <div class="col-3 text-bold">
                                        {{ translateKeyword('total_distance') }}
                                    </div>
                                    <div class="col-3">
                                        {{ $request->distance ? $request->distance : '0' }} @if (Setting::get('distance_system') === 'metric')
                                            KM
                                        @else
                                            Miles
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                @if ($request->status == 'COMPLETED' && $request->rating)
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-3 text-bold">
                                                {{ translateKeyword('User_Reviews') }}:
                                            </div>
                                            <div class="col-3">
                                                {{ translateKeyword('stars') }}:
                                                {{ $request->rating->user_rating ? $request->rating->user_rating : 'N/A' }}
                                                | {{ translateKeyword('Comments') }}:
                                                {{ $request->rating->user_rating ? $request->rating->user_comment : 'N/A' }}
                                            </div>
                                            <div class="col-3 text-bold">
                                                Driver Review:
                                            </div>
                                            <div class="col-3 text-right">
                                                {{ translateKeyword('stars') }}:
                                                {{ $request->rating->provider_rating ? $request->rating->provider_rating : 'N/A' }}
                                                | {{ translateKeyword('Comments') }}:
                                                {{ $request->rating->provider_comment ? $request->rating->provider_comment : 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-3 text-bold">
                                    {{ translateKeyword('pickup_address') }}:
                                </div>
                                <div class="col-3">
                                    {{ $request->s_address ? $request->s_address : '-' }}
                                </div>
                                @if ($request->service_type->type != 'road_assistance')
                                    <div class="col-3 text-bold">
                                        {{ translateKeyword('drop-address') }}:
                                    </div>
                                    <div class="col-3">
                                        {{ $request->d_address ? $request->d_address : '-' }}
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="card-body" style="border-top: 1px solid rgba(0, 0, 0, .125)">
                            @if ($request->status == 'CANCELLED')
                                <div class="row">
                                    <div class="col-6"></div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6 text-bold">
                                                {{ translateKeyword('cancellation-amount-rider') }}:
                                            </div>
                                            <div class="col-6 text-right">
                                                {{ currency($request->cancel_amount) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6"></div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6 text-bold">
                                                {{ translateKeyword('cancellation-amount-driver') }}:
                                            </div>
                                            <div class="col-6 text-right">
                                                {{ currency($request->cancel_amount_driver) }}
                                            </div>
                                        </div>
                                    </div>
                                    @if ($request->cancel_payment_details && $request->cancel_payment_details['cancellation_deduction'])
                                        <div class="col-12">
                                            {{ translateKeyword('cancellation-amount-breakdown') }}:
                                        </div>
                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6 text-bold">
                                                    {{ translateKeyword('base-cancellation-amount') }}:
                                                </div>
                                                <div class="col-6 text-right">
                                                    {{ currency($request->cancel_payment_details['cancellation_value']) }}
                                                </div>
                                            </div>
                                        </div>

                                        @if ($request->cancel_payment_details['commission_deduction'])
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        Company's commission - @if ($request->cancel_payment_details['commission_type'] == 'percentage')
                                                            {{ $request->cancel_payment_details['commission_percentage'] }}%
                                                        @endif:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->cancel_payment_details['commission_price']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($request->cancel_payment_details['bookingFeeActive'])
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        {{ translateKeyword('booking-fee') }}:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->cancel_payment_details['bookingFeeAmount']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($request->cancel_payment_details['tax_active'])
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        Tax price -
                                                        {{ $request->cancel_payment_details['tax_percentage'] }}%:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->cancel_payment_details['tax_price']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($request->cancel_payment_details['government_charges_active'])
                                            <div class="col-6"></div>
                                            <div class="row">
                                                <div class="col-6 text-bold">
                                                    Government charges:
                                                </div>
                                                <div class="col-6 text-right">
                                                    {{ currency($request->cancel_payment_details['government_charges']) }}
                                                </div>
                                            </div>
                                        @endif

                                        @if ($request->cancel_payment_details['bank_charges_active'])
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        Bank charges - @if ($request->cancel_payment_details['bank_charges_type'] == 'percentage')
                                                            {{ $request->cancel_payment_details['bank_charges_value'] }}%
                                                        @endif:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->cancel_payment_details['bank_charges_amount']) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @else
                                @if ($request->payment)
                                    <div class="row">
                                        <div class="col-6"></div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6 text-bold">
                                                    {{ translateKeyword('ride-amount') }}:
                                                </div>
                                                <div class="col-6 text-right">
                                                    {{ currency($request->payment->t_price) }}
                                                </div>
                                            </div>
                                        </div>
                                        @if ($request->payment->tax_active)
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        {{ translateKeyword('tax') }}:
                                                        {{ $request->payment->tax_percentage }}%
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->payment->tax) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($request->payment->government_charges_active)
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        {{ translateKeyword('government-charges') }}:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->payment->government_charges) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($request->payment->wallet)
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        {{ translateKeyword('wallet_deduction') }}:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->payment->wallet) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($request->payment->provider_pay)
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        {{ translateKeyword('driver-earning') }}:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->payment->provider_pay) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($request->payment->bank_charges_active)
                                            <div class="col-6"></div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6 text-bold">
                                                        {{ translateKeyword('bank_charges_price') }}:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        {{ currency($request->payment->bank_charges_amount) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-6"></div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6 text-bold">
                                                    {{ translateKeyword('amount') }}:
                                                </div>
                                                <div class="col-6 text-right">
                                                    {{ currency($request->payment->total) }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                                <div class="row">
                                    @if ($request->tip_amount)
                                        <div class="col-6"></div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6 text-bold">
                                                    {{ translateKeyword('tip-amount-user') }}:
                                                </div>
                                                <div class="col-6 text-right">
                                                    {{ currency($request->tip_amount) }}
                                                </div>
                                            </div>

                                        </div>
                                    @endif

                                    @if ($request->tip_amount_driver)
                                        <div class="col-6"></div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6 text-bold">
                                                    {{ translateKeyword('tip-amount-driver') }}:
                                                </div>
                                                <div class="col-6 text-right">
                                                    {{ currency($request->tip_amount_driver) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    @php
                        $userReportImages = $request->userReportImages()->get();
                        $driverReportImages = $request->driverReportImages()->get();
                    @endphp
                    @if ($userReportImages->count() > 0 || $driverReportImages->count() > 0)
                        <div class="card border-radius-10">
                            @if ($userReportImages->count() > 0)
                                <div class="card-header">
                                    <div class="card-title">
                                        {{ translateKeyword('user-report-images') }}:
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach ($userReportImages as $userReportImage)
                                        <a href="{{ $userReportImage->image }}" target="_blank"><img
                                                src="{{ $userReportImage->image }}" class="img-lg img-thumbnail"
                                                style="border-radius: 20px;" /></a>
                                    @endforeach
                                </div>
                            @endif

                            @if ($driverReportImages->count() > 0)
                                <div class="card-header">
                                    <div class="card-title">
                                        {{ translateKeyword('driver-report-images') }}:
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach ($driverReportImages as $driverReportImage)
                                        <a href="{{ $driverReportImage->image }}" target="_blank"><img
                                                src="{{ $driverReportImage->image }}" class="img-lg img-thumbnail"
                                                style="border-radius: 20px;" /></a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-4">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <div class="card-title">{{ translateKeyword('driver') }}</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="avatar box-64">
                                        <img class="b-a-radius-circle shadow-white"
                                            src="{{ img($request->provider->avatar) }}" alt="{{ $request->provider->first_name }}">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-6 text-bold">
                                            {{ translateKeyword('provider_name') }}:
                                        </div>
                                        <div class="col-6">
                                            {{ $request->provider->first_name }} {{ $request->provider->last_name }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 text-bold">
                                            {{ translateKeyword('phone') }}
                                        </div>
                                        <div class="col-6">
                                            {{ $request->provider->mobile }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 text-bold">
                                            {{ translateKeyword('email') }}
                                        </div>
                                        <div class="col-6">
                                            {{ $request->provider->email }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <div class="card-title">{{ translateKeyword('user') }}</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    @if ($request->user)
                                        <img class="b-a-radius-circle shadow-white"
                                            src="{{ img($request->user->picture) }}" alt="{{ $request->user->first_name }}">
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-6 text-bold">
                                            {{ translateKeyword('User_Name') }}:
                                        </div>
                                        <div class="col-6">
                                            @if ($request->user)
                                                {{ $request->user->first_name }} {{ $request->user->last_name }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 text-bold">
                                            {{ translateKeyword('phone') }}:
                                        </div>
                                        <div class="col-6">
                                            @if ($request->user)
                                                {{ $request->user->mobile }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 text-bold">
                                            {{ translateKeyword('user-email') }}:
                                        </div>
                                        <div class="col-6">
                                            @if ($request->user)
                                                {{ $request->user->email }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-radius-10">
                        <div class="card-body">
                            @php
                                $map_icon = asset('asset/img/marker-start.png');
                                $src =
                                    'https://maps.googleapis.com/maps/api/staticmap?autoscale=2&size=640x480&maptype=terrian&format=png&visual_refresh=true&markers=icon:' .
                                    $map_icon .
                                    '%7C' .
                                    $request->s_latitude .
                                    ',' .
                                    $request->s_longitude .
                                    '&markers=icon:' .
                                    $map_icon .
                                    '%7C' .
                                    $request->d_latitude .
                                    ',' .
                                    $request->d_longitude .
                                    '&path=color:0x191919|weight:3|enc:' .
                                    $request->route_key .
                                    '&key=' .
                                    Setting::get('map_key');
                            @endphp
                            <img class="img-fluid border-radius-10" src="{{ $src }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style type="text/css">
        /* #map {
                                                                                                                                                                                                    height: 450px;
                                                                                                                                                                                                } */
    </style>

    <style>
        /* #map_canvas {
                                                                                                                                                                                                    height: 395px;
                                                                                                                                                                                                    width: 100%;
                                                                                                                                                                                                } */
    </style>
@endsection

@section('scripts')
    {{-- <script defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo Setting::get('map_key'); ?>&libraries=places"
            async defer></script> --}}
    <script type="text/javascript">
        // $(document).ready(function () {
        //     initMap();
        // });

        // var map;

        // function initMap() {
        //     const directionsService = new google.maps.DirectionsService();
        //     const directionsRenderer = new google.maps.DirectionsRenderer({preserveViewport: true});

        //     var s_lat = '{{ $request->s_latitude }}';
        //     var s_lng = '{{ $request->s_longitude }}';
        //     var d_lat = '{{ $request->d_latitude }}';
        //     var d_lng = '{{ $request->d_longitude }}';

        //     var srcLatLng = new google.maps.LatLng(s_lat, s_lng);
        //     var destLatLng = new google.maps.LatLng(d_lat, d_lng);

        //     var mapOptions = {
        //         zoom: 16,
        //         center: srcLatLng,
        //         scrollwheel: true,
        //         // panControl: true,
        //         zoomControl: true,
        //         // mapTypeControl: true,
        //         // scaleControl: true,
        //         // streetViewControl: true,
        //         // overviewMapControl: true,
        //         preserveViewport: true,
        //         mapTypeId: google.maps.MapTypeId.ROADMAP,
        //         // animation: google.maps.Animation.DROP
        //     }

        //     map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        //     directionsRenderer.setMap(map);
        //     directionsService
        //         .route({
        //             origin: srcLatLng,
        //             destination: destLatLng,
        //             travelMode: google.maps.TravelMode.DRIVING,
        //         })
        //         .then((response) => {
        //             directionsRenderer.setDirections(response);
        //         })
        //         .catch((e) => window.alert("Directions request failed due to " + status));

        //     marker = new google.maps.Marker({
        //         position: srcLatLng,
        //         map: map,
        //         draggable: false,
        //         icon: "{{ asset('asset/img/marker-car.png') }}"
        //     });
        // }

        // function getCoords() {
        //     $.ajax({
        //         url: "{{ route('provider.location', [$request->current_provider_id]) }}",
        //         type: "GET",
        //         success: function (returnedData) {
        //             var latlngStr = returnedData.split(",", 2);
        //             var lat = parseFloat(latlngStr[0]);
        //             var lng = parseFloat(latlngStr[1]);
        //             returnedDataCoords = new google.maps.LatLng(lat, lng);
        //             moveMarkerMap(returnedDataCoords);
        //         }
        //     });
        // }

        // function moveMarkerMap(newCoords) {
        //     // map.panTo(newCoords);
        //     map.setCenter(newCoords);
        //     marker.setPosition(newCoords);
        // }

        // @if ($request->status != 'COMPLETED')
        //     window.setInterval(getCoords, 5000); 
        // @endif


        /*
        var map;
        var zoomLevel = 11;

        function initMapDirections() {

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
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                console.log(result);
                directionsDisplay.setDirections(result);

                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);
            }
        });

        if ( /*___directives_script_1___*/
    </script>
@endsection
