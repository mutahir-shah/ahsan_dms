@extends('user.layout.base')

@section('title', 'On Job')

@section('content')
    <style>
        #map_canvas {
            height: 395px;
            width: 100%;
        }
    </style>
    <div class="col-md-12">
        <div class="dash-content">
            @include('common.notify')
            @if (Setting::get('multi_job_website', 0) == 1)
            <div class="row no-margin">
                
                <div class="col-md-12">
                    <h4 class="page-title">
                        <a href="{{ route('web.new_job') }}" class="btn btn-warning">Request new job</a>
                    </h4>
                </div>
            </div>  
            @endif
           

            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title" id="ride_status"></h4>
                </div>
            </div>

            <div class="row no-margin">
                <div class="col-md-6" id="container">
                    <p>Loading...</p>
                </div>

                <div class="col-md-6">
                    <div class="user-request-map">
                        <div class="from-to row no-margin">
                            <div class="from">
                                <h5>FROM</h5>
                                <p>{{isset($request->s_address) ? $request->s_address : ''}}</p>
                            </div>
                            @if ($request->service_type->type != 'road_assistance')
                            <div class="to">
                                <h5>TO</h5>
                                <p>{{isset($request->d_address) ? $request->d_address : ''}}</p>

                            </div>
                            @endif
                            @if ($request->service_type->type != 'road_assistance')
                            <div class="type">
                                <h5>TYPE</h5>
                                <p>{{isset($request->service_type) ? $request->service_type->name : ''}}</p>

                            </div>
                            @endif
                        </div>
                        <?php
                        $map_icon = asset('asset/img/marker-start.png');
                        // $static_map = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=roadmap&format=png&visual_refresh=true&markers=icon:".$map_icon."%7C".$request->s_latitude.",".$request->s_longitude."&markers=icon:".$map_icon."%7C".$request->d_latitude.",".$request->d_longitude."&path=color:0x191919|weight:8|enc:".$request->route_key."&key=".env('GOOGLE_MAP_KEY');
                        ?>
                        <div class="map-image">
                            {{-- <img src="{{$static_map}}"> --}}
                            <div id="map_canvas"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('asset/js/rating.js')}}"></script>
    <script type="text/javascript">
        $('.rating').rating();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>

    <script type="text/jsx">
        var MainComponent = React.createClass({
            getInitialState: function () {
                return {data: [], currency: "{{Setting::get('currency')}}"};
            },
            componentDidMount: function () {
                $.ajax({
                    url: "{{url('status')}}",
                    type: "GET"
                })
                    .done(function (response) {

                        this.setState({
                            data: response.data[0]
                        });

                    }.bind(this));

                setInterval(this.checkRequest, 5000);
            },
            checkRequest: function () {
                $.ajax({
                    url: "{{url('status')}}",
                    type: "GET"
                })
                    .done(function (response) {
                        this.setState({
                            data: response.data[0]
                        });

                    }.bind(this));
            },
            render: function () {
                return (
                    <div>
                        <SwitchState checkState={this.state.data} currency={this.state.currency}/>
                    </div>
                );
            }
        });

        var SwitchState = React.createClass({

            componentDidMount: function () {
                this.changeLabel;
            },

            changeLabel: function () {
                if (this.props.checkState == undefined) {
                    window.location.reload();
                } else if (this.props.checkState != "") {

                    if (this.props.checkState.status == 'SEARCHING') {
                        $("#ride_status").text("{{ translateKeyword('finding_driver') }}");
                    } else if (this.props.checkState.status == 'STARTED') {
                        var provider_name = this.props.checkState.provider.first_name;
                        $("#ride_status").text(provider_name + " {{ translateKeyword('accepted_ride') }}");
                    } else if (this.props.checkState.status == 'ARRIVED') {
                        var provider_name = this.props.checkState.provider.first_name;
                        $("#ride_status").text(provider_name + " {{ translateKeyword('arrived_ride') }}");
                    } else if (this.props.checkState.status == 'PICKEDUP') {
                        $("#ride_status").text("{{ translateKeyword('onride') }}");
                    } else if (this.props.checkState.status == 'DROPPED') {
                        $("#ride_status").text("{{ translateKeyword('waiting_payment') }}");
                    } else if (this.props.checkState.status == 'COMPLETED') {
                        var provider_name = this.props.checkState.provider.first_name;
                        $("#ride_status").text("{{ translateKeyword('rate_and_review') }} " + provider_name);
                    }
                    setTimeout(function () {
                        $('.rating').rating();
                    }, 400);

                } else {
                    $("#ride_status").text('Text will appear here');
                }
            },
            render: function () {

                if (this.props.checkState != "") {

                    this.changeLabel();
                    if (this.props.checkState.status == 'SEARCHING') {
                        return (
                            <div>
                                <Searching checkState={this.props.checkState}/>
                            </div>
                        );
                    } else if (this.props.checkState.status == 'STARTED') {
                        return (
                            <div>
                                <Accepted checkState={this.props.checkState}/>
                            </div>
                        );
                    } else if (this.props.checkState.status == 'ARRIVED') {
                        return (
                            <div>
                                <Arrived checkState={this.props.checkState}/>
                            </div>
                        );
                    } else if (this.props.checkState.status == 'PICKEDUP') {
                        return (
                            <div>
                                <Pickedup checkState={this.props.checkState}/>
                            </div>
                        );
                    } else if ((this.props.checkState.status == 'DROPPED' || this.props.checkState.status == 'COMPLETED') && this.props.checkState.payment_mode == 'CASH' && this.props.checkState.paid == 0) {
                        return (
                            <div>
                                <DroppedAndCash checkState={this.props.checkState} currency={this.props.currency}/>
                            </div>
                        );
                    } else if ((this.props.checkState.status == 'DROPPED' || this.props.checkState.status == 'COMPLETED') && this.props.checkState.payment_mode == 'CARD' && this.props.checkState.paid == 0) {
                        return (
                            <div>
                                <DroppedAndCard checkState={this.props.checkState} currency={this.props.currency}/>
                            </div>
                        );
                    } else if (this.props.checkState.status == 'COMPLETED') {
                        return (
                            <div>
                                <Review checkState={this.props.checkState}/>
                            </div>
                        );
                    }
                } else {
                    return (
                        <p></p>
                    );
                }
            }
        });

        var Searching = React.createClass({
            render: function () {
                return (
                    <form action="{{url('cancel/ride')}}" method="POST">
                        {{ csrf_field() }}</input>
                <input type="hidden" name="request_id" value={this.props.checkState.id}/>
                <div className="status">
                    <h6>{{ translateKeyword('status') }}</h6>
                    <p>{{ translateKeyword('finding_driver') }}</p>
                </div>

                <button type="submit" className="full-primary-btn fare-btn">{{ translateKeyword('cancel_request') }}</button>
            </form>
            )

            }
        });

        var Accepted = React.createClass({
            render: function () {
                return (
                    <form action="{{url('cancel/ride')}}" method="POST">
                        {{ csrf_field() }}</input>
                <input type="hidden" name="request_id" value={this.props.checkState.id}/>
                <div className="status">
                    <h6>{{ translateKeyword('status') }}</h6>
                    <p>{{ translateKeyword('accepted_ride') }}</p>
                </div>
                <CancelReason/>
                <button type="button" className="full-primary-btn" data-toggle="modal"
                        data-target="#cancel-reason">{{ translateKeyword('cancel_request') }}</button>
                <br/>
                <h5><strong>{{ translateKeyword('ride_details') }}</strong></h5>
                <div className="driver-details">
                    <dl className="dl-horizontal left-right">
                        <dt>{{ translateKeyword('booking_id') }}</dt>
                        <dd>{this.props.checkState.booking_id}</dd>
                        <dt>{{ translateKeyword('payment_mode') }}</dt>
                        <dd>{this.props.checkState.payment_mode}</dd>
                        <dt>OTP Code</dt>
                        <dd>{this.props.checkState.otp}</dd>

                    </dl>
                </div>
                <h5><strong>{{ translateKeyword('driver_info') }}</strong></h5>
                <div className="driver-details">
                    <dl className="dl-horizontal left-right">
                        <dt>{{ translateKeyword('driver_name') }}</dt>
                        <dd>{this.props.checkState.provider.first_name} {this.props.checkState.provider.last_name}</dd>
                        <dt>{{ translateKeyword('driver_mobile') }}</dt>
                        <dd>{this.props.checkState.provider.mobile}</dd>
                        <dt>{{ translateKeyword('service_number') }}</dt>
                        <dd>{this.props.checkState.provider_service.service_number}</dd>
                        <dt>{{ translateKeyword('service_model') }}</dt>
                        <dd>{this.props.checkState.provider_service.service_model}</dd>
                        <dt>{{ translateKeyword('driver_rating') }}</dt>
                        <dd>
                            <div className="rating-outer">
                                <input disabled type="hidden" value={this.props.checkState.provider.rating}
                                       name="rating" className="rating"/>
                            </div>
                        </dd>

                    </dl>
                </div>

            </form>
            )

            }
        });

        var CancelReason = React.createClass({
            render: function () {
                return (
                    <div id="cancel-reason" className="modal" role="dialog">
                        <div className="modal-dialog">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <button type="button" className="close" data-dismiss="modal">&times;</button>
                                    <h4 className="modal-title">{{ translateKeyword('cancel_request') }}</h4>
                                </div>
                                <div className="modal-body">
                                    <textarea className="form-control" name="cancel_reason"
                                              placeholder="{{ translateKeyword('cancel_reason') }}" row="5"></textarea>
                                </div>
                                <div className="modal-footer">
                                    <button type="submit"
                                            className="full-primary-btn fare-btn">{{ translateKeyword('cancel_request') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                );
            }
        });

        var Arrived = React.createClass({
            render: function () {
                return (
                    <form action="{{url('cancel/ride')}}" method="POST">
                        {{ csrf_field() }}</input>
                <input type="hidden" name="request_id" value={this.props.checkState.id}/>
                <div className="status">
                    <h6>{{ translateKeyword('status') }}</h6>
                    <p>{{ translateKeyword('arrived_ride') }}</p>
                </div>
                <CancelReason/>
                <button type="button" className="full-primary-btn" data-toggle="modal"
                        data-target="#cancel-reason">{{ translateKeyword('cancel_request') }}</button>
                <br/>
                <h5><strong>{{ translateKeyword('ride_details') }}</strong></h5>
                <div className="driver-details">
                    <dl className="dl-horizontal left-right">
                        <dt>{{ translateKeyword('booking_id') }}</dt>
                        <dd>{this.props.checkState.booking_id}</dd>
                        <dt>{{ translateKeyword('payment_mode') }}</dt>
                        <dd>{this.props.checkState.payment_mode}</dd>
                        <dt>OTP Code</dt>
                        <dd>{this.props.checkState.otp}</dd>

                    </dl>
                </div>
                <h5><strong>{{ translateKeyword('driver_info') }}</strong></h5>
                <div className="driver-details">
                    <dl className="dl-horizontal left-right">
                        <dt>{{ translateKeyword('driver_name') }}</dt>
                        <dd>{this.props.checkState.provider.first_name} {this.props.checkState.provider.last_name}</dd>
                        <dt>{{ translateKeyword('driver_mobile') }}</dt>
                        <dd>{this.props.checkState.provider.mobile}</dd>
                        <dt>{{ translateKeyword('service_number') }}</dt>
                        <dd>{this.props.checkState.provider_service.service_number}</dd>
                        <dt>{{ translateKeyword('service_model') }}</dt>
                        <dd>{this.props.checkState.provider_service.service_model}</dd>
                        <dt>{{ translateKeyword('driver_rating') }}</dt>
                        <dd>
                            <div className="rating-outer">
                                <input disabled type="hidden" value={this.props.checkState.provider.rating}
                                       name="rating" className="rating"/>
                            </div>
                        </dd>

                    </dl>
                </div>
            </form>
            )

            }
        });

        var Pickedup = React.createClass({
            render: function () {
                return (
                    <div>
                        <div className="status">
                            <h6>{{ translateKeyword('status') }}</h6>
                            <p>{{ translateKeyword('onride') }}</p>
                        </div>
                        <br/>
                        <h5><strong>{{ translateKeyword('ride_details') }}</strong></h5>
                        <div className="driver-details">
                            <dl className="dl-horizontal left-right">
                                <dt>{{ translateKeyword('booking_id') }}</dt>
                                <dd>{this.props.checkState.booking_id}</dd>
                                <dt>{{ translateKeyword('payment_mode') }}</dt>
                                <dd>{this.props.checkState.payment_mode}</dd>
                                <dt>OTP Code</dt>
                                <dd>{this.props.checkState.otp}</dd>

                            </dl>
                        </div>
                        <h5><strong>{{ translateKeyword('driver_info') }}</strong></h5>
                        <div className="driver-details">
                            <dl className="dl-horizontal left-right">
                                <dt>{{ translateKeyword('driver_name') }}</dt>
                                <dd>{this.props.checkState.provider.first_name} {this.props.checkState.provider.last_name}</dd>
                                <dt>{{ translateKeyword('driver_mobile') }}</dt>
                                <dd>{this.props.checkState.provider.mobile}</dd>
                                <dt>{{ translateKeyword('service_number') }}</dt>
                                <dd>{this.props.checkState.provider_service.service_number}</dd>
                                <dt>{{ translateKeyword('service_model') }}</dt>
                                <dd>{this.props.checkState.provider_service.service_model}</dd>
                                <dt>{{ translateKeyword('driver_rating') }}</dt>
                                <dd>
                                    <div className="rating-outer">
                                        <input disabled type="hidden" value={this.props.checkState.provider.rating}
                                               name="rating" className="rating"/>
                                    </div>
                                </dd>

                            </dl>
                        </div>
                    </div>
                );
            }
        });

        var DroppedAndCash = React.createClass({

            render: function () {
                return (
                    <div>
                        <div className="status">
                            <h6>{{ translateKeyword('status') }}</h6>
                            <p>{{ translateKeyword('dropped_ride') }}</p>
                        </div>
                        <br/>
                        <h5><strong>{{ translateKeyword('ride_details') }}</strong></h5>
                        <div className="driver-details">
                            <dl className="dl-horizontal left-right">
                                <dt>{{ translateKeyword('booking_id') }}</dt>
                                <dd>{this.props.checkState.booking_id}</dd>
                                <dt>{{ translateKeyword('payment_mode') }}</dt>
                                <dd>{this.props.checkState.payment_mode}</dd>
                                <dt>OTP Code</dt>
                                <dd>{this.props.checkState.otp}</dd>

                            </dl>
                        </div>
                        <h5><strong>{{ translateKeyword('driver_info') }}</strong></h5>
                        <div className="driver-details">
                            <dl className="dl-horizontal left-right">
                                <dt>{{ translateKeyword('driver_name') }}</dt>
                                <dd>{this.props.checkState.provider.first_name} {this.props.checkState.provider.last_name}</dd>
                                <dt>{{ translateKeyword('driver_mobile') }}</dt>
                                <dd>{this.props.checkState.provider.mobile}</dd>
                                <dt>{{ translateKeyword('service_number') }}</dt>
                                <dd>{this.props.checkState.provider_service.service_number}</dd>
                                <dt>{{ translateKeyword('service_model') }}</dt>
                                <dd>{this.props.checkState.provider_service.service_model}</dd>
                                <dt>{{ translateKeyword('driver_rating') }}</dt>
                                <dd>
                                    <div className="rating-outer">
                                        <input disabled type="hidden" value={this.props.checkState.provider.rating}
                                               name="rating" className="rating"/>
                                    </div>
                                </dd>

                            </dl>
                        </div>
                        <h5><strong>{{ translateKeyword('invoice') }}</strong></h5>
                        <dl className="dl-horizontal left-right">
                            <dt>{{ translateKeyword('distance_travelled') }}</dt>
                            <dd>{this.props.checkState.distance} @if (Setting::get('distance_system') === 'metric') KM @else
                                Miles @endif </dd>
                            <dt>{{ translateKeyword('time_taken') }}</dt>
                            <dd>{this.props.checkState.travel_time} Mins</dd>
                            <dt>{{ translateKeyword('base_price') }}</dt>
                            <dd>{this.props.currency}{this.props.checkState.payment.fixed}</dd>
                            <dt>{{ translateKeyword('distance_price') }}</dt>
                            <dd>{this.props.currency}{this.props.checkState.payment.distance}</dd>
                            <dt className="Danger">{{ translateKeyword('tax_applied') }}</dt>
                            <dd>{this.props.currency}{this.props.checkState.payment.tax}</dd>
                            {this.props.checkState.use_wallet ?
                                <span>
								<dt>{{ translateKeyword('wallet_deduction') }}</dt>
                            	<dd>{this.props.currency}{this.props.checkState.payment.wallet}</dd>  
                            	</span>
                                : ''
                            }
                            {this.props.checkState.payment.discount ?
                                <span>
								<dt>{{ translateKeyword('discount_applied') }}</dt>
                            	<dd>{this.props.currency}{this.props.checkState.payment.discount}</dd>  
                            	</span>
                                : ''
                            }
                            <dt>{{ translateKeyword('total') }}</dt>
                            <dd>{this.props.currency}{this.props.checkState.payment.total}</dd>
                            <dt className="big">{{ translateKeyword('amount_paid') }}</dt>
                            <dd className="big">{this.props.currency}{this.props.checkState.payment.total}</dd>
                        </dl>
                    </div>
                );
            }
        });

        var DroppedAndCard = React.createClass({

            render: function () {
                return (
                    <div>
                        <form method="POST" action="{{url('/payment')}}">
                            {{ csrf_field() }}</input>
                        <div className="status">
                            <h6>{{ translateKeyword('status') }}</h6>
                            <p>{{ translateKeyword('dropped_ride') }}</p>
                        </div>
                        <br/>
                        <h5><strong>{{ translateKeyword('ride_details') }}</strong></h5>
                        <dl className="dl-horizontal left-right">
                            <dt>{{ translateKeyword('booking_id') }}</dt>
                            <dd>{this.props.checkState.booking_id}</dd>
                            <dt>{{ translateKeyword('driver_name') }}</dt>
                            <dd>{this.props.checkState.provider.first_name} {this.props.checkState.provider.last_name}</dd>
                            <dt>{{ translateKeyword('driver_mobile') }}</dt>
                            <dd>{this.props.checkState.provider.mobile}</dd>
                            <dt>{{ translateKeyword('service_number') }}</dt>
                            <dd>{this.props.checkState.provider_service.service_number}</dd>
                            <dt>{{ translateKeyword('service_model') }}</dt>
                            <dd>{this.props.checkState.provider_service.service_model}</dd>
                            <dt>{{ translateKeyword('driver_rating') }}</dt>
                            <dd>
                                <div className="rating-outer">
                                    <input disabled type="hidden" value={this.props.checkState.provider.rating}
                                           name="rating" className="rating"/>
                                </div>
                            </dd>
                            <dt>{{ translateKeyword('payment_mode') }}</dt>
                            <dd>{this.props.checkState.payment_mode}</dd>
                            <dt>{{ translateKeyword('km') }}</dt>
                            <dd>{this.props.checkState.distance} kms</dd>
                        </dl>
                        <h5><strong>{{ translateKeyword('invoice') }}</strong></h5>
                        <input type="hidden" name="request_id" value={this.props.checkState.id}/>
                        <dl className="dl-horizontal left-right">
                            <dt>{{ translateKeyword('base_price') }}</dt>
                            <dd>{this.props.currency}{this.props.checkState.payment.fixed}</dd>
                            <dt>{{ translateKeyword('distance_price') }}</dt>
                            <dd>{this.props.currency}{this.props.checkState.payment.distance}</dd>
                            <dt>{{ translateKeyword('tax_price') }}</dt>
                            <dd>{this.props.currency}{this.props.checkState.payment.tax}</dd>
                            <dt>{{ translateKeyword('total') }}</dt>
                            {this.props.checkState.use_wallet ?
                                <span>
								<dt>{{ translateKeyword('detection_wallet') }}</dt>
                            	<dd>{this.props.currency}{this.props.checkState.payment.wallet}</dd>  
                            	</span>
                                : ''
                            }
                            {this.props.checkState.payment.discount ?
                                <span>
								<dt>{{ translateKeyword('promotion_applied') }}</dt>
                            	<dd>{this.props.currency}{this.props.checkState.payment.discount}</dd>  
                            	</span>
                                : ''
                            }
                            <dd>{this.props.currency}{this.props.checkState.payment.total}</dd>
                            <dt className="big">{{ translateKeyword('amount_paid') }}</dt>
                            <dd className="big">{this.props.currency}{this.props.checkState.payment.total}</dd>
                        </dl>
                        <button type="submit" className="full-primary-btn fare-btn">CONTINUE TO PAY</button>
                    </form>
            </div>
            )

            }
        });

        var Review = React.createClass({
            render: function () {
                return (
                    <form method="POST" action="{{url('/rate')}}">
                        {{ csrf_field() }}</input>
                <div className="rate-review">
                    <label>{{ translateKeyword('rating') }}</label>
                    <div className="rating-outer">
                        <input type="hidden" value="5" name="rating" className="rating"/>
                    </div>
                    <input type="hidden" name="request_id" value={this.props.checkState.id}/>
                    <label>{{ translateKeyword('comment') }}</label>
                    <textarea className="form-control" name="comment" placeholder="Write Comment"></textarea>
                </div>
                <button type="submit" className="full-primary-btn fare-btn">SUBMIT</button>
            </form>
            )

            }
        });

        React.render(<MainComponent/>, document.getElementById("container"));
    </script>

{{-- <script type="text/babel" src="{{ asset('asset/js/incoming.js') }}"></script> --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('map_key')}}&libraries=places"
            async defer></script>
    <script type="text/javascript">
        $(document).ready(function () {
            initMap();
        });

        var map;

        function initMap() {
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({preserveViewport: true});

            var s_lat = '{{ $request->s_latitude}}';
            var s_lng = '{{ $request->s_longitude}}';
            var d_lat = '{{ $request->d_latitude}}';
            var d_lng = '{{ $request->d_longitude}}';

            var srcLatLng = new google.maps.LatLng(s_lat, s_lng);
            var destLatLng = new google.maps.LatLng(d_lat, d_lng);

            var mapOptions = {
                zoom: 16,
                center: srcLatLng,
                scrollwheel: true,
                // panControl: true,
                zoomControl: true,
                // mapTypeControl: true,
                // scaleControl: true,
                // streetViewControl: true,
                // overviewMapControl: true,
                preserveViewport: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                // animation: google.maps.Animation.DROP
            }

            map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

            directionsRenderer.setMap(map);
            directionsService
                .route({
                    origin: srcLatLng,
                    destination: destLatLng,
                    travelMode: google.maps.TravelMode.DRIVING,
                })
                .then((response) => {
                    directionsRenderer.setDirections(response);
                })
                .catch((e) => window.alert("Directions request failed due to " + status));

            marker = new google.maps.Marker({
                position: srcLatLng,
                map: map,
                draggable: false,
                icon: "{{ asset('asset/img/marker-car.png') }}"
            });
        }

        function getCoords() {
            $.ajax({
                url: "{{ route('provider.location', [$request->current_provider_id]) }}",
                type: "GET",
                success: function (returnedData) {
                    var latlngStr = returnedData.split(",", 2);
                    var lat = parseFloat(latlngStr[0]);
                    var lng = parseFloat(latlngStr[1]);
                    returnedDataCoords = new google.maps.LatLng(lat, lng);
                    moveMarkerMap(returnedDataCoords);
                }
            });
        }

        function moveMarkerMap(newCoords) {
            // map.panTo(newCoords);
            map.setCenter(newCoords);
            marker.setPosition(newCoords);
        }

        window.setInterval(getCoords, 5000);
    </script>
@endsection