@extends('user.layout.base')

@section('title', 'My Trips ')

@section('content')

    <div class="col-md-12">
        <div class="dash-content">
            <div class="row no-margin">
                <div class="col-md-12">
                    <h4 class="page-title">{{ translateKeyword('my_trips') }}</h4>
                </div>
            </div>

            <div class="row no-margin ride-detail">
                <div class="col-md-12">
                    @if ($trips->count() > 0)

                        <table class="table table-condensed" style="border-collapse:collapse;">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>{{ translateKeyword('booking_id') }}</th>
                                <th>{{ translateKeyword('date') }}</th>
                                <th>{{ translateKeyword('name') }}</th>
                                <th>Status</th>
                                <th>{{ translateKeyword('amount') }}</th>
                                <th>{{ translateKeyword('type') }}</th>
                                <th>{{ translateKeyword('payment') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($trips as $trip)
                                <tr data-toggle="collapse" data-target="#trip_{{ $trip->id }}"
                                    class="accordion-toggle collapsed">
                                    <td><span class="arrow-icon fa fa-chevron-right"></span></td>
                                    <td>{{ $trip->booking_id }}</td>
                                    <td>{{ date('d-m-Y', strtotime($trip->assigned_at)) }}</td>
                                    @if ($trip->provider)
                                        <td>{{ $trip->provider->first_name }} {{ $trip->provider->last_name }}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td>{{ $trip->status }}</td>
                                    @if ($trip->status != 'CANCELLED' && $trip->payment)
                                        <td>{{ currency($trip->payment->total) }}</td>
                                    @else
                                        <td>{{ currency($trip->cancel_amount) }}</td>
                                    @endif
                                    @if ($trip->service_type)
                                        <td>{{ $trip->service_type->name }}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td> {{ $trip->payment_mode }}</td>
                                </tr>
                                <tr class="hiddenRow">
                                    <td colspan="12">
                                        <div class="accordian-body collapse row" id="trip_{{ $trip->id }}">
                                            <div class="col-md-6">
                                                <div class="my-trip-left">
                                                        <?php
                                                        $map_icon = asset('asset/img/marker-start.png');
                                                        $static_map = 'https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=terrain&format=png&visual_refresh=true&markers=icon:' . $map_icon . '%7C' . $trip->s_latitude . ',' . $trip->s_longitude . '&markers=icon:' . $map_icon . '%7C' . $trip->d_latitude . ',' . $trip->d_longitude . '&path=color:0x191919|weight:8|enc:' . $trip->route_key . '&key=' . Setting::get('map_key'); ?>
                                                    <div class="map-static">
                                                        <img src="{{ $static_map }}" height="280px;">
                                                    </div>
                                                    <div class="from-to row no-margin">
                                                        <div class="from">
                                                            <h5>{{ translateKeyword('from') }}</h5>
                                                            <h6>{{ date('H:i A - d-m-y', strtotime($trip->started_at)) }}
                                                            </h6>
                                                            <p>{{ $trip->s_address }}</p>
                                                        </div>
                                                        @if ($trip->service_type->type != 'road_assistance')
                                                        <div class="to">
                                                            <h5>{{ translateKeyword('to') }}</h5>
                                                            <h6>{{ date('H:i A - d-m-y', strtotime($trip->finished_at)) }}
                                                            </h6>
                                                            <p>{{ $trip->d_address }}</p>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">

                                                <div class="mytrip-right">

                                                    <div class="fare-break">

                                                        <h4 class="text-center">
                                                            <strong>
                                                                @if ($trip->service_type)
                                                                    {{ $trip->service_type->name }}
                                                                @endif
                                                                @if($trip->status != 'CANCELLED') - {{ translateKeyword('fare_breakdown') }} @endif
                                                            </strong>
                                                        </h4>
                                                        @if ($trip->status != 'CANCELLED' && $trip->payment)
                                                        <h5>{{ translateKeyword('base_price') }} <span>
                                                                    @if ($trip->payment)
                                                                    {{ currency($trip->payment->fixed) }}
                                                                @endif
                                                                </span></h5>
                                                        <h5><strong>{{ translateKeyword('bank_charges_price') }} </strong><span><strong>
                                                                    @if ($trip->payment)
                                                                    {{ currency($trip->payment->bank_charges_amount) }}
                                                                @endif
                                                                </strong></span></h5>
                                                        <h5><strong>{{ translateKeyword('tax_price') }} </strong><span><strong>
                                                                        @if ($trip->payment)
                                                                        {{ currency($trip->payment->tax) }}
                                                                    @endif
                                                                    </strong></span></h5>
                                                        <h5 class="big"><strong>{{ translateKeyword('charged') }}
                                                                - {{ $trip->payment_mode }} </strong><span><strong>
                                                                        @if ($trip->payment)
                                                                        {{ currency($trip->payment->total) }}
                                                                    @endif
                                                                    </strong></span></h5>
                                                        @else
                                                        @php
                                                            // $trip->cancel_payment_details = json_decode($trip->cancel_payment_details, true);
                                                        @endphp
                                                        @if ($trip->cancel_payment_details && isset($trip->cancel_payment_details['cancellation_deduction']))
                                                        <fieldset class="col-md-12 box">
                                                            <legend>Cancellation Amount Breakdown:</legend>
                                                            <dt class="col-sm-6">Base Cancellation Amount:</dt>
                                                            <dd class="col-sm-6">{{ currency($trip->cancel_payment_details['cancellation_value']) }}</dd>

                                                            @if ($trip->cancel_payment_details['commission_deduction'])
                                                                <dt class="col-sm-6">Company's commission - @if($trip->cancel_payment_details['commission_type'] == 'percentage') {{ $trip->cancel_payment_details['commission_percentage'] }}% @endif:</dt>
                                                                <dd class="col-sm-6">{{ currency($trip->cancel_payment_details['commission_price']) }}</dd>
                                                            @endif

                                                            @if ($trip->cancel_payment_details['bookingFeeActive'])
                                                                <dt class="col-sm-6">Booking fee:</dt>
                                                                <dd class="col-sm-6">{{ currency($trip->cancel_payment_details['bookingFeeAmount']) }}</dd>
                                                            @endif

                                                            @if ($trip->cancel_payment_details['tax_active'])
                                                                <dt class="col-sm-6">Tax price - {{ $trip->cancel_payment_details['tax_percentage'] }}%:</dt>
                                                                <dd class="col-sm-6">{{ currency($trip->cancel_payment_details['tax_price']) }}</dd>
                                                            @endif

                                                            @if ($trip->cancel_payment_details['government_charges_active'])
                                                                <dt class="col-sm-6">Government charges:</dt>
                                                                <dd class="col-sm-6">{{ currency($trip->cancel_payment_details['government_charges']) }}</dd>
                                                            @endif

                                                            @if (isset($trip->cancel_payment_details['bank_charges_active']) && $trip->cancel_payment_details['bank_charges_active'])
                                                                <dt class="col-sm-6">Bank charges - @if($trip->cancel_payment_details['bank_charges_type'] == 'percentage') {{ $trip->cancel_payment_details['bank_charges_value'] }}% @endif:</dt>
                                                                <dd class="col-sm-6">{{ currency($trip->cancel_payment_details['bank_charges_amount']) }}</dd>
                                                            @endif
                                                        </fieldset>
                                                        @endif
                                                    @endif
                                                    </div>

                                                    <div class="trip-user">
                                                        @if ($trip->provider)
                                                            <div class="user-img"
                                                                 style="background-image: url({{ img($trip->provider ? '/storage/' . $trip->provider->avatar : '') }});">
                                                            </div>
                                                        @else
                                                            <div class="user-img">
                                                            </div>
                                                        @endif
                                                        <div class="user-right">
                                                            @if ($trip->provider)
                                                                <h5>{{ $trip->provider->first_name }}
                                                                    {{ $trip->provider->last_name }}
                                                                    <br/> Phone: {{$trip->provider->mobile}}</h5>
                                                            @else
                                                                <h5>- </h5>
                                                            @endif
                                                            @if ($trip->rating)
                                                                <div class="rating-outer">
                                                                    <input type="hidden" class="rating"
                                                                           value="{{ $trip->rating->user_rated }}"/>

                                                                </div>
                                                                <p>User Comment: {{ $trip->rating->user_comment? : 'N/A' }}</p>
                                                                <p>Driver Comment: {{ $trip->rating->provider_comment? : 'N/A' }}</p>
                                                            @else
                                                                -
                                                            @endif
                                                            @php
                                                                $userReportImages = $trip->userReportImages()->get();
                                                                $driverReportImages = $trip->driverReportImages()->get();
                                                            @endphp
                                                            @if ($userReportImages->count() > 0)
                                                                <p>User Report Images:
                                                                    @foreach ($userReportImages as $userReportImage)
                                                                        <a href="{{ $userReportImage->image }}" target="_blank"><img src="{{ $userReportImage->image }}" class="img-lg img-thumbnail" style="border-radius: 20px;" /></a>
                                                                    @endforeach
                                                                </p>
                                                            @endif
                                                            @if ($driverReportImages->count() > 0)
                                                                <p>Driver Report Images:
                                                                    @foreach ($driverReportImages as $driverReportImage)
                                                                        <a href="{{ $driverReportImage->image }}" target="_blank"><img src="{{ $driverReportImage->image }}" class="img-lg img-thumbnail" style="border-radius: 20px;" /></a>
                                                                    @endforeach
                                                                </p>
                                                            @endif
                                                            @if ($trip->status == 'CANCELLED')
                                                                <p><b>Reason: </b>{{ $trip->cancel_reason? : 'N/A'}}</p> 
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    @else
                        <hr>
                        <p style="text-align: center;">{{ translateKeyword('no_history_available') }}</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
