@extends('fleet.layout.basecode')
@extends('admin.layout.base2')

@section('title', 'Dashboard ')
@section('content')

    <div class="content-wrapper">

        <div class="container-fluid">
            <div class="row" style="padding-top: 10px;">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translateKeyword('Service')}}</span>
                            <span class="info-box-number">
               {{$service}}
            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-car-side"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translateKeyword('Total_Bookings')}}</span>
                            <span class="info-box-number">
              {{$rides->count()}}
            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i
                                    class="fas fa-file-invoice-dollar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translateKeyword('Total_Revenue')}}</span>
                            <span class="info-box-number">
              {{currency($revenue)}}
            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translateKeyword('cancelled-rides')}}</span>
                            <span class="info-box-number">
              {{$cancel_rides}}
            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>

            <div class="row row-md">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="box box-block mb-2">
                            <div class="t-content" id="total-trip-chart">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="box box-block mb-2">
                            <div class="t-content" id="payment-mode-chart">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">

                            <div class="box-block clearfix">

                                <h5 class="float-xs-left">{{ translateKeyword('Recent_Rides')}}</h5>

                            </div>

                            <table class="table table-bordered table-striped" id="example1">

                                <thead>

                                <tr>

                                    <th>{{ translateKeyword('id') }}</th>

                                    <th>{{ translateKeyword('User')}}</th>

                                    <th>{{ translateKeyword('Ride_Detail')}}</th>

                                    <th>{{ translateKeyword('Date_Time')}}</th>

                                    <th>{{ translateKeyword('Total')}}</th>

                                    <th>{{ translateKeyword('status')}}</th>

                                </tr>

                                </thead>

                                <tbody>

                                <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>



                                @foreach($rides as $index => $ride)

                                    <tr>

                                        <th scope="row">{{$index + 1}}</th>


                                        <td>{{$ride->user['first_name']}} {{$ride->user['last_name']}}</td>


                                        <td>


                                            <a class="text-primary"
                                               href="{{route('fleet.requests.show',$ride->id)}}"><span
                                                        class="underline">{{ translateKeyword('Ride_Detail')}}</span></a>


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

        </div>

    </div>

@endsection

@section('scripts')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // VISUALIZATION API AND THE PIE CHART PACKAGE. payment-mode-chart
        google.charts.load("visualization", "1", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(DrawPieChart);
        google.charts.setOnLoadCallback(DrawPieChart1);
        google.charts.setOnLoadCallback(DrawPieChart2);

        var tt = ["Element", "Density", {role: "style"}];

        function DrawPieChart() {
            var completed_rides = '<?php echo @$completed_rides; ?>';
            var cancel_rides = '<?php echo @$cancel_rides; ?>';
            var ongoing_rides = '<?php echo @$ongoing_rides; ?>';
            var scheduled_rides = '<?php echo @$scheduled_rides; ?>';
            var arrSales =
                [
                    ['Rides', 'Total Rides'],
                    ['Completed', parseInt(completed_rides)],
                    ['Cancelled', parseInt(cancel_rides)],
                    ['Active', parseInt(ongoing_rides)],
                    ['Scheduled', parseInt(scheduled_rides)]

                ];

            var options = {
                title: 'Rides',
                is3D: true,
                pieSliceText: 'value-and-percentage'
            };

            var figures = google.visualization.arrayToDataTable(arrSales);

            var chart = new google.visualization.PieChart(document.getElementById('total-trip-chart'));

            chart.draw(figures, options);
        }


        function DrawPieChart1() {

            var cash_rides = '<?php echo @$cashpayments; ?>';
            var card_rides = '<?php echo @$online_payments; ?>';
            // DEFINE AN ARRAY OF DATA. completed_rides
            var arrSales =
                [
                    ['Payment Mode', 'Payment Mode'],
                    ['Cash', parseInt(cash_rides)],
                    ['Online', parseInt(card_rides)]

                ];

            //console.log(arrSales);

            // SET CHART OPTIONS.
            var options = {
                title: 'Payment Mode',
                is3D: true,
                pieSliceText: 'value-and-percentage'
            };

            var figures = google.visualization.arrayToDataTable(arrSales);

            // WHERE TO SHOW THE CHART (DIV ELEMENT).
            var chart = new google.visualization.PieChart(document.getElementById('payment-mode-chart'));

            // DRAW THE CHART.
            chart.draw(figures, options);
        }

        function DrawPieChart2() {

            var user = '<?php echo @$user; ?>';
            var provider = '<?php echo @$provider; ?>';
            var fleets = '<?php echo @$fleet; ?>';
            // DEFINE AN ARRAY OF DATA. completed_rides
            var arrSales =
                [
                    ['Payment Mode', 'Payment Mode'],
                    ['Users', parseInt(user)],
                    ['Driver', parseInt(provider)]

                ];

            //console.log(arrSales);

            // SET CHART OPTIONS.
            var options = {
                title: 'User Data',
                is3D: true,
                pieSliceText: 'value-and-percentage'
            };

            var figures = google.visualization.arrayToDataTable(arrSales);

            // WHERE TO SHOW THE CHART (DIV ELEMENT).
            var chart = new google.visualization.PieChart(document.getElementById('user-type-chart'));

            // DRAW THE CHART.
            chart.draw(figures, options);
        }


        // window.onload = function () {

        //     var chart = new CanvasJS.Chart("chartContainer",
        //         {
        //             title: {
        //                 text: ""
        //             },
        //             axisY: {
        //                 title: "Rides"
        //             },
        //             legend: {
        //                 verticalAlign: "bottom",
        //                 horizontalAlign: "center"
        //             },
        //             data: [

        //                 {
        //                     color: "#B0D0B0",
        //                     type: "column",
        //                     showInLegend: true,
        //                     legendMarkerType: "none",
        //                     legendText: "Timing",
        //                     dataPoints: [
        //                         {x: 1, y: 14, label: "3:00 PM"},
        //                         {x: 2, y: 12, label: "3:30 PM"},
        //                         {x: 3, y: 8, label: "4:00 PM"},
        //                         {x: 4, y: 10, label: "4:30 PM"},
        //                         {x: 5, y: 7, label: "5:00 PM"},
        //                         {x: 6, y: 6, label: "5:30 PM"},
        //                         {x: 7, y: 19, label: "6:00 PM"},
        //                         {x: 8, y: 20, label: "6:30 PM"}
        //                     ]
        //                 }
        //             ]
        //         });

        //     chart.render();
        // }


    </script>
@endsection