@extends('account.layout.base')

@section('title', $page)

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h3>{{$page}}</h3>

                <div class="clearfix" style="margin-top: 15px;">
                    <form class="form-horizontal" action="{{route('account.ride.statement.range')}}" method="GET"
                          enctype="multipart/form-data" role="form">

                        <div class="form-group row col-md-5">
                            <label for="name" class="col-xs-4 col-form-label">Date From</label>
                            <div class="col-xs-8">
                                <input class="form-control" type="date" name="from_date" required
                                       placeholder="From Date">
                            </div>
                        </div>

                        <div class="form-group row col-md-5">
                            <label for="email" class="col-xs-4 col-form-label">Date To</label>
                            <div class="col-xs-8">
                                <input class="form-control" type="date" required name="to_date" placeholder="To Date">
                            </div>
                        </div>
                        <div class="form-group row col-md-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

                <div style="text-align: center;padding: 20px;color: blue;font-size: 24px;">
                    <p><strong>
                            <span>Over All Earning : {{currency($revenue[0]->overall)}}</span>
                            <br>
                            <span>Over All Commission : {{currency($revenue[0]->commission)}}</span>
                        </strong></p>
                </div>

                <div class="row">

                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="box box-block bg-white tile tile-1 mb-2">
                            <div class="t-icon right"><span class="bg-danger"></span><i class="ti-rocket"></i></div>
                            <div class="t-content">
                                <h6 class="text-uppercase mb-1">Total No. of Rides</h6>
                                <h1 class="mb-1">{{$rides->count()}}</h1>
                                <span class="text-muted font-90">% down from cancelled Request</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="box box-block bg-white tile tile-1 mb-2">
                            <div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
                            <div class="t-content">
                                <h6 class="text-uppercase mb-1">Revenue</h6>
                                <h1 class="mb-1">{{currency($revenue[0]->overall)}}</h1>
                                <i class="fa fa-caret-up text-success mr-0-5"></i><span>from {{$rides->count()}} Rides</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="box box-block bg-white tile tile-1 mb-2">
                            <div class="t-icon right"><span class="bg-warning"></span><i class="ti-archive"></i></div>
                            <div class="t-content">
                                <h6 class="text-uppercase mb-1">Cancelled Rides</h6>
                                <h1 class="mb-1">{{$cancel_rides}}</h1>
                                <i class="fa fa-caret-down text-danger mr-0-5"></i><span>for @if($cancel_rides == 0)
                                        0.00
                                    @else
                                        {{round($cancel_rides/$rides->count(),2)}}%
                                    @endif Rides</span>
                            </div>
                        </div>
                    </div>

                    <div class="row row-md mb-2" style="padding: 15px;">
                        <div class="col-md-12">
                            <div class="box bg-white">
                                <div class="box-block clearfix">
                                    <h5 class="float-xs-left">Earnings</h5>
                                    <div class="float-xs-right">
                                    </div>
                                </div>

                                @if(count($rides) != 0)
                                    <table class="table table-striped table-bordered dataTable" id="table-2">
                                        <thead>
                                        <tr>
                                            <td>Booking ID</td>
                                            <td>Driver name</td>
                                            <td>Start time</td>
                                            <td>End time</td>
                                            <td>Picked up</td>
                                            <td>Dropped</td>
                                            <td>Request Details</td>
                                            <td>Distance</td>
                                            <td>Payment Mode</td>
                                            <td>Commission</td>
                                            <td>Dated on</td>
                                            <td>Status</td>
                                            <td>Earned</td>
                                            <td>Trip Price</td>
                                            <td>Request Details</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                                        @foreach($rides as $index => $ride)
                                            <tr>
                                                <td>{{ $ride->booking_id }}</td>
                                                @if (Setting::get('partner_company_info', 0) == 1)
                                                    <td>{!! $ride->provider ? $ride->provider->first_name . ' ' . $ride->provider->last_name . '<br/> <b>Company Name:</b>' . ($ride->provider->company_name ? $ride->provider->company_name : 'N/A')  . '<br/> <b>Company Address:</b>' . ($ride->provider->company_address ? $ride->provider->company_address : 'N/A')  . '<br/> <b>Company VAT:</b>' . ($ride->provider->company_vat ? $ride->provider->company_vat : 'N/A') : 'N/A' !!}</td>
                                                @else
                                                    <td>{{ $ride->provider ? $ride->provider->first_name . ' ' . $ride->provider->last_name : 'N/A' }}</td>
                                                @endif
                                                <td>{{ $ride->started_at ? $ride->started_at->format('g:i a') : 'N/A' }}</td>
                                                <td>{{ $ride->finished_at ? $ride->finished_at->format('g:i a') : 'N/A' }}</td>
                                                <td>
                                                    @if($ride->s_address != '')
                                                        {{$ride->s_address}}
                                                    @else
                                                        Not Provided
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($ride->d_address != '')
                                                        {{$ride->d_address}}
                                                    @else
                                                        Not Provided
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="text-primary"
                                                       href="{{route('account.requests.show',$ride->id)}}"><span
                                                                class="underline">View Job Details</span></a>
                                                    @if (Setting::get('invoice', 0) == 1 && $ride->status == 'COMPLETED')
                                                        <br/>
                                                        <a class="text-primary"
                                                           href="{{ route('invoice', [$ride->id]) }}"
                                                           target="_blank"><span
                                                                    class="underline">Download Invoice</span></a>
                                                    @endif


                                                </td>

                                                <td> {{$ride->distance . ' Km'}}</td>
                                                <td> {{ $ride->payment ? $ride->payment['payment_mode'] : $ride->payment_mode }}</td>

                                                <td>{{ $ride->payment ? currency($ride->payment['commision']) : currency(0) }}</td>
                                                <td>
                                                    <span class="text-muted">{{date('d M Y',strtotime($ride->created_at))}}</span>
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
                                                <td>{{$ride->payment ? currency($ride->payment['fixed'] + $ride->payment['distance']) : currency(0) }}</td>
                                                <td> {{$ride->payment ? currency($ride->payment['fixed'] + $ride->payment['distance'] + $ride->payment['commision']) : currency(0)}}</td>
                                                <td>
                                                    @if($ride->status != "CANCELLED")
                                                        <a class="text-primary"
                                                           href="{{route('account.requests.show',$ride->id)}}"><span
                                                                    class="underline">View Ride Details</span></a>
                                                    @else
                                                        <span>No Details Found </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tfoot>
                                        <tr>
                                            <td>Booking ID</td>
                                            <td>Driver name</td>
                                            <td>Start time</td>
                                            <td>End time</td>
                                            <td>Picked up</td>
                                            <td>Dropped</td>
                                            <td>Request Details</td>
                                            <td>Distance</td>
                                            <td>Payment Mode</td>
                                            <td>Commission</td>
                                            <td>Dated on</td>
                                            <td>Status</td>
                                            <td>Earned</td>
                                            <td>Trip Price</td>
                                            <td>Request Details</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    <h6 class="no-result">No results found</h6>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
