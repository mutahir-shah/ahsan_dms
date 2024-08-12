@extends('account.layout.base')


@section('title', 'Dashboard')



@section('styles')

    <link rel="stylesheet" href="{{url('admin/plugins/fontawesome-free/css/all.min.css')}}">

    <!-- Theme style -->

    <link rel="stylesheet" href="../admin/dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="{{url('mainindex/css/fontawesome-all.min.css')}}" rel="stylesheet">

@endsection



@section('content')

    <div class="content-area py-1">

        <div class="container-fluid">

            <div class="row row-md">

                <div class="col-lg-3 col-md-6 col-xs-12">

                    <div class="small-box bg-info">

                        <div class="inner">

                            <h3>{{$rides->count()}}</h3>

                            <p>Total Rides</p>

                        </div>

                        <div class="icon">

                            <i class="ion ion-bag"></i>

                        </div>

                        <a href="#" class="small-box-footer">History <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 col-xs-12">

                    <div class="small-box bg-success">

                        <div class="inner">

                            <h3>{{currency($revenue)}}</h3>

                            <p>Total Revenue</p>

                        </div>

                        <div class="icon">

                            <i class="ion ion-stats-bars"></i>

                        </div>

                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 col-xs-12">

                    <div class="small-box bg-warning">

                        <div class="inner">

                            <h3>{{$service}}</h3>

                            <p>All Services</p>

                        </div>

                        <div class="icon">

                            <i class="ion ion-person-add"></i>

                        </div>

                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 col-xs-12">

                    <div class="small-box bg-danger">

                        <div class="inner">

                            <h3>{{$user_cancelled+$provider_cancelled}}</h3>

                            <p>Cancelled Job</p>

                        </div>

                        <div class="icon">

                            <i class="ion ion-pie-graph"></i>

                        </div>

                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 col-xs-12">

                    <div class="small-box bg-danger">

                        <div class="inner">

                            <h3>{{$user_cancelled}}</h3>

                            <p>User Cancelled Rides</p>

                        </div>

                        <div class="icon">

                            <i class="ion ion-stats-bars"></i>

                        </div>

                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 col-xs-12">

                    <div class="small-box bg-primary">

                        <div class="inner">

                            <h3>{{$provider_cancelled}}</h3>

                            <p>Driver Cancelled Job</p>

                        </div>

                        <div class="icon">

                            <i class="ion ion-stats-bars"></i>

                        </div>

                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>


                <div class="col-lg-3 col-md-6 col-xs-12">

                    <div class="small-box bg-success">

                        <div class="inner">

                            <h3>{{$fleet}}</h3>

                            <p>Online Payment</p>

                        </div>

                        <div class="icon">

                            <i class="ion ion-pie-graph"></i>

                        </div>

                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 col-xs-12">

                    <div class="small-box bg-info">

                        <div class="inner">

                            <h3>{{$scheduled_rides}}</h3>

                            <p>Scheduled Job</p>

                        </div>

                        <div class="icon">

                            <i class="ion ion-pie-graph"></i>

                        </div>

                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

                    </div>

                </div>

            </div>


            <div class="row row-md mb-2">

                <div class="col-md-12">

                    <div class=" bg-white" style="box-shadow:none;">

                        <div class="box-block clearfix">

                            <h5 class="float-xs-left">Recent Rides</h5>

                        </div>

                        <table class="table mb-md-0 table " id="table-2" style="width:100%">

                            <thead>

                            <tr>

                                <th>ID</th>

                                <th>User</th>

                                <th>Driver</th>

                                <th>Job Details</th>

                                <th>Date &amp; Time</th>

                                <th>Total</th>

                                <th>Status</th>

                            </tr>

                            </thead>

                            <tbody>

                            <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>



                            @foreach($rides as $index => $ride)

                                <tr>

                                    <th scope="row">{{$index + 1}}</th>


                                    <td>{{$ride->user['first_name']}} {{$ride->user['last_name']}}</td>

                                    <td>

                                        {{@$ride->provider->first_name}}  {{@$ride->provider->last_name}}

                                    </td>

                                    <td>


                                        <a class="text-primary"
                                           href="{{route('account.requests.show',$ride->id)}}"><span
                                                    class="underline">Job Details</span></a>

                                    </td>

                                    <td>

                                        <span class="text-muted">{{$ride->created_at->diffForHumans()}}</span>

                                    </td>

                                    <td>

                                        {{ $ride->payment ? currency($ride->payment['total']) : currency(0) }}


                                    </td>

                                    <td>

                                        @if($ride->status == "COMPLETED")

                                            <span class="tag tag-success">{{$ride->status}}</span>

                                        @elseif($ride->status == "CANCELLED")

                                            <span class="tag tag-danger">{{$ride->status}}</span>

                                        @else

                                            <span class="tag tag-info">{{$ride->status}}</span>

                                        @endif

                                    </td>

                                </tr>

                                    <?php if ($index == 10) break; ?>

                            @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


        </div>

@endsection

