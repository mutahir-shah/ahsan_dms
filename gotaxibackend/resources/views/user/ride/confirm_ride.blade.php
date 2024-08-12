@extends('user.layout.base')


@section('title', 'Job Confirmation ')



@section('styles')

    <style type="text/css">

        .surge-block {

            background-color: black;

            width: 50px;

            height: 50px;

            border-radius: 25px;

            margin: 0 auto;

            padding: 10px;

            padding-top: 15px;

        }

        .surge-text {

            top: 11px;

            font-weight: bold;

            color: white;

        }

    </style>

@endsection



@section('content')

    <div class="dash-content">

        <div class="row no-margin">

            <div class="col-md-12">

                <h4 class="page-title">{{ translateKeyword('estimated_fare') }}</h4>

            </div>

        </div>

        @include('common.notify')

        <div class="row no-margin">

            <div class="col-md-5">

                <form action="{{url('create/ride')}}" method="POST" id="create_ride">


                    {{ csrf_field() }}


                    <dl class="dl-horizontal left-right">

                        <dt>{{ translateKeyword('service_type') }}</dt>

                        <dd>{{$service->name}}</dd>

                        <dt>{{ translateKeyword('distance') }}</dt>

                        <dd>{{$fare->distance ? $fare->distance : 'N/A'}} km</dd>

                        <dt>{{ translateKeyword('time') }}</dt>

                        <dd>{{$fare->time ? $fare->time : 'N/A'}}</dd>

                        <dt>{{ translateKeyword('tax_charges') }}</dt>

                        <dd>{{currency($fare->round_off)}}</dd>

                        <dt>{{ translateKeyword('price') }}</dt>

                        <dd>{{currency($fare->estimated_fare)}}</dd>

                        <dt><h5>{{ translateKeyword('total') }}</h5></dt>

                        <dd><h5>{{currency($fare->total)}}</h5></dd>

                        @if(Auth::user()->wallet_balance > 0)

                            <input type="checkbox" name="use_wallet" value="1"><span
                                    style="padding-left: 15px;">{{ translateKeyword('use_wallet_balance') }}</span>

                            <br>

                            <br>

                            <dt>{{ translateKeyword('available_wallet_balance') }}</dt>

                            <dd>{{currency(Auth::user()->wallet_balance)}}</dd>

                        @endif

                    </dl>


                    <input type="hidden" name="s_address" value="{{Request::get('s_address')}}">

                    <input type="hidden" name="d_address" value="{{Request::get('d_address')}}">

                    <input type="hidden" name="s_latitude" value="{{Request::get('s_latitude')}}">

                    <input type="hidden" name="s_longitude" value="{{Request::get('s_longitude')}}">

                    <input type="hidden" name="d_latitude" value="{{Request::get('d_latitude')}}">

                    <input type="hidden" name="d_longitude" value="{{Request::get('d_longitude')}}">

                    <input type="hidden" name="service_type" value="{{Request::get('service_type')}}">


                    <input type="hidden" name="amount_total_web" value="{{$fare->total}}">

                    <input type="hidden" name="distance" value="{{$fare->distance}}">
                    @if (Setting::get('delivery_note', 0) == 1)
                    <p>Special Note</p>
                    
                    <div><textarea name="specialNote" class="form-control"
                        placeholder="Please enter any extra details here..."></textarea></div> 
                    @endif
                    
                    <br/>

                    <p> {{ translateKeyword('payment_method') }}</p>

                    <select class="form-control" name="payment_mode" id="payment_mode" onchange="card(this.value);">
                        <option value="CASH" selected>CASH/IN TAXI</option>
                        <option value="CASH">WALLET</option>
                        @if(Setting::get('web_card_payment', 0) == 1)
                            @if(Setting::get('CARD') == 1)
                                @if($cards->count() > 0)
                                    <option value="CARD">CARD</option>
                                @endif
                            @endif
                        @endif
                    </select>

                    <br>

                    @if(Setting::get('web_card_payment', 0) == 1)
                        @if(Setting::get('CARD') == 1)

                            @if($cards->count() > 0)

                                <select class="form-control" name="card_id" style="display: none;" id="card_id">

                                    <option value="">Select Card</option>

                                    @foreach($cards as $card)

                                        <option value="{{$card->card_id}}">{{$card->brand}} **** ****
                                            **** {{$card->last_four}}</option>

                                    @endforeach

                                </select>

                            @endif

                        @endif
                    @endif



                    @if($fare->surge == 1)

                        <span><em>{{ translateKeyword('surge_extra') }}</em></span>

                        <div class="surge-block"><span class="surge-text">{{$fare->surge_value}}</span>

                        </div>

                    @endif


                    <button type="submit" class="half-primary-btn fare-btn">{{ translateKeyword('ride_now') }}</button>

                    <button type="button" class="half-secondary-btn fare-btn" data-toggle="modal"
                            data-target="#schedule_modal">Schedule Later
                    </button>


                </form>

            </div>

            <div class="col-md-2"></div>

            <div class="col-md-5">

                <div class="user-request-map">

                    <?php

                    $map_icon = asset('asset/img/marker-start.png');

                    function encodeURIComponent($str)
                    {
                        $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
                        return strtr(rawurlencode($str), $revert);
                    }

                    $json_direction_response = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin=' . $request->s_latitude . "," . $request->s_longitude . '&destination=' . $request->d_latitude . "," . $request->d_longitude . '&key=' . Setting::get('map_key'));

                    $data = json_decode($json_direction_response, true);

                    $polyline = encodeURIComponent($data['routes'][0]['overview_polyline']['points']);

                    $static_map = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=roadmap&format=png&visual_refresh=true&markers=icon:" . $map_icon . "%7C" . $request->s_latitude . "," . $request->s_longitude . "&markers=icon:" . $map_icon . "%7C" . $request->d_latitude . "," . $request->d_longitude . "&path=color:0x191919|weight:8|enc:" . $polyline . "&key=" . Setting::get('map_key');

                    // For Straight line
                    // $static_map = "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=600x450&maptype=roadmap&format=png&visual_refresh=true&markers=icon:".$map_icon."%7C".$request->s_latitude.",".$request->s_longitude."&markers=icon:".$map_icon."%7C".$request->d_latitude.",".$request->d_longitude."&path=color:0x191919|weight:8|".$request->s_latitude.",".$request->s_longitude."|".$request->d_latitude.",".$request->d_longitude."&key=".Setting::get('map_key'); ?>

                    <div class="map-static" style="background-image: url({{$static_map}});">

                    </div>

                    <div class="from-to row no-margin" style="background: white;">

                        <div class="from">

                            <h5>FROM</h5>

                            <p>{{$request->s_address}}</p>

                        </div>
                        @if ($service->type != 'road_assistance')
                            <div class="to">

                                <h5>TO</h5>

                                <p>{{$request->d_address}}</p>

                            </div>
                        @endif
                        

                    </div>

                </div>

            </div>

        </div>


    </div>









    <!-- Schedule Modal -->

    <div id="schedule_modal" class="modal schedule-modal" role="dialog">

        <div class="modal-dialog">


            <!-- Modal content-->

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">{{ translateKeyword('Schedule_a_ride') }}</h4>

                </div>

                <form>

                    <div class="modal-body">


                        <label>{{ translateKeyword('date') }}</label>
                        <input type="hidden" name="schedule_web" id="schedule_web" value="yes"/>
                        <input value="{{date('m/d/Y')}}" type="text" id="datepicker" placeholder="Date"
                               name="schedule_date">

                        <label>{{ translateKeyword('time') }}</label>

                        <input value="{{date('H:i')}}" type="text" id="timepicker" placeholder="Time"
                               name="schedule_time">


                    </div>

                    <div class="modal-footer">

                        <button type="button" id="schedule_button" class="btn btn-default"
                                data-dismiss="modal">{{ translateKeyword('Schedule_trip') }}</button>

                    </div>


                </form>

            </div>


        </div>

    </div>

@endsection



@section('scripts')

    <script type="text/javascript">

        $(document).ready(function () {

            $('#schedule_button').click(function () {

                $("#schedule_web").clone().attr('type', 'hidden').appendTo($('#create_ride'));

                $("#datepicker").clone().attr('type', 'hidden').appendTo($('#create_ride'));

                $("#timepicker").clone().attr('type', 'hidden').appendTo($('#create_ride'));

                document.getElementById('create_ride').submit();

            });

        });
        $('.datepicker').datepicker({
            autoclose: true
        });

        $('.timepicker').timepicker({
            autoclose: true
        });
    </script>

    <script type="text/javascript">

        var date = new Date();

        date.setDate(date.getDate() - 1);

        $('#datepicker').datepicker({

            startDate: date,
            autoclose: true

        });

        $('#timepicker').timepicker({showMeridian: false, autoclose: true});

    </script>

    <script type="text/javascript">

        function card(value) {

            if (value == 'CARD') {

                $('#card_id').fadeIn(300);

            } else {

                $('#card_id').fadeOut(300);

            }

        }

    </script>

@endsection