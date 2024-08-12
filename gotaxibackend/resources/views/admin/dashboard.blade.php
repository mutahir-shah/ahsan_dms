@extends('admin.layout.basecode')
@extends('admin.layout.base2')
@section('title', 'Dashboard ')
@section('content')
    <style>
        .info-box {
        box-shadow: 0 0 2px #00000020, 0 1px 3px rgba(0, 0, 0, .2);
        /* border-radius: .25rem; */
        background: #fff;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        color: #000 !important;
        height: 120px;
        border-radius: 10px;
        padding: 10px;
    }
    .my-gradiant-card{
        background-repeat:no-repeat;
        background-size:cover !important;
    }
    .info-box-icon{
        font-size: 40px !important;
        /* color: #fff; */
        color: #6E767E;
        width: 100px !important;
    }

    .info-box-content{
        height: 100%;
        font-size: 20px !important;
        /* color: #fff; */
        color: #6E767E;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 0px !important;
    }
    
    .filter-container{
        display: flex;
        /* justify-content: space-between; */
        align-items: center;
        /* gap: 10px; */
        /* flex-wrap: wrap; */
    }
    .filter-buttons{
        /* flex: 1; */
        padding: 0 5px;
    }

    .filter-buttons a{
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: {{ getSettings('site_color') }};
        border:none;
        /* background-size: cover; */
        /* height:50px; */
        font-weight: bold;
        font-size: 16px;
        border-radius: 10px;
        box-shadow: 0 0 2px #00000020, 0 1px 3px rgba(0, 0, 0, .2);
        letter-spacing:.2rem;
        transition:all 0.4s ease;
    }

    .filter-container .filter-buttons a{
        text-transform: uppercase;
        background-color: #F3F3F3;
        color: #717171;
        border:none;
        outline:none;
        padding:10px 32px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 18.5px;
    }

    .filter-buttons a:hover{
        background-color: {{ getSettings('site_color') }}!important;
    }

    .filter-buttons a.active{
        background-color: {{ getSettings('site_color') }}!important;
        text-shadow: 1px 0 0 rgba(17, 17, 17, 0.8);
        color: #fff !important;
    }


    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 1.5 !important;
    }

    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 4px 8px rgba(0, 0, 0, .3) !important;
    }

    .tag-danger {
            background-color: #DC3913;
    }
    .tag-success {
        background-color: #0E3F30;
    }

    /* .btn-dark.active {
        background:url({{ asset('admin/img/3.jpeg') }})!important;
    } */

    .tag {
        /* padding: 1.2em 1.4em 1.3em; */
        padding: 10px 10px;
        font-size: 12px;
        min-width: 20px;
        /* border-radius: 0; */
        text-transform: uppercase;
        border-radius: 5px;
    }
   
    </style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <h3>FILTERS</h1>
            <div class="filter-container">
                <div class="filter-buttons">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-block @if($duration == '') active @endif">{{ translateKeyword('All-Time') }}</a>
                </div>
                <div class="filter-buttons">
                    <a href="{{ route('admin.dashboard', [1]) }}" class="btn btn-dark btn-block @if($duration == 1) active @endif">{{ translateKeyword('Today') }}</a>
                </div>
                <div class="filter-buttons">
                    <a href="{{ route('admin.dashboard', [7]) }}" class="btn btn-dark btn-block @if($duration == 7) active @endif">{{ translateKeyword('Last-7-Days') }}</a>
                </div>
                <div class="filter-buttons">
                    <a href="{{ route('admin.dashboard', [30]) }}" class="btn btn-dark btn-block @if($duration == 30) active @endif">{{ translateKeyword('Last-Month') }}</a>
                </div>
                <div class="filter-buttons">
                    <a href="{{ route('admin.dashboard', [365]) }}" class="btn btn-dark btn-block @if($duration == 365) active @endif">{{ translateKeyword('Last-Year') }}</a>
                </div>
                
            </div>
        </div>

        <div class="container-fluid mt-3">
            <h3>STATS</h1>
            <div class="row" style="">
                @if ($service_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <a class="info-box my-gradiant-card" href="{{ route('admin.service.index') }}">
                            <span class="info-box-icon"><i class="fas fa-cog"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Services') }}</span>
                                <span class="info-box-number">
                                    {{ $service }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3 my-gradiant-card">
                        <span class="info-box-icon"><i class="fas fa-layer-group"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translateKeyword('Total_Fleets') }}</span>
                            <span class="info-box-number">{{ $fleet }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <!-- /.col -->
                @if ($user_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <a class="info-box mb-3 my-gradiant-card" href="{{ route('admin.user.index') }}">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Total_User') }}</span>
                                <span class="info-box-number">{{ $user }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </a>
                        <!-- /.info-box -->
                    </div>
                @endif
                @if ($driver_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <a class="info-box mb-3 my-gradiant-card" href="{{ route('admin.provider.index') }}">
                            <span class="info-box-icon"><i class="fas fa-taxi"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Total_Providers') }}</span>
                                <span class="info-box-number">{{ $provider }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif
            </div>
            <div class="row">
                @if ($bookings_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box my-gradiant-card">
                            <span class="info-box-icon"><i class="fas fa-car-side"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Total_Bookings') }}</span>
                                <span class="info-box-number">
                                    {{ $UserRequests }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif
                @if ($schedule_bookings_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <a class="info-box mb-3 my-gradiant-card" href="{{ route('admin.service.index') }}">
                            <span class="info-box-icon "><i class="fas fa-clock"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Scheduled_Bookings') }}</span>
                                <span class="info-box-number">{{ $scheduled_rides }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif

                @if ($driver_cancelled_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 my-gradiant-card">
                            <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Provider_Cancelled') }}</span>
                                <span class="info-box-number">{{ $provider_cancelled }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif
                <div class="clearfix hidden-md-up"></div>

                @if ($user_cancelled_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 my-gradiant-card">
                            <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('User_Cancelled') }}</span>
                                <span class="info-box-number">{{ $user_cancelled }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endif

                <!-- fix for small devices only -->



                <!-- /.col -->
            </div>
            <div class="row">
                @if ($revenue_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box my-gradiant-card">
                            <span class="info-box-icon "><i
                                    class="fas fa-file-invoice-dollar"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Total_Revenue') }}</span>
                                <span class="info-box-number">
                                    {{ isset($revenue) ? currency($revenue) : currency(0) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif

                @if (Setting::get('tip_collect', 0) == 1)
                    @if ($tip_view_permission == 1)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box my-gradiant-card">
                                <span class="info-box-icon "><i
                                        class="fas fa-file-invoice-dollar"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ translateKeyword('Tip_Sum') }}</span>
                                    <span class="info-box-number">
                                        {{ isset($tip_sum) ? currency($tip_sum) : currency(0) }}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    @endif
                    @if ($tip_driver_view_permission == 1)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box my-gradiant-card">
                                <span class="info-box-icon "><i
                                        class="fas fa-file-invoice-dollar"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ translateKeyword('Tip_Sum_Driver') }}</span>
                                    <span class="info-box-number">
                                        {{ isset($tip_sum_driver) ? currency($tip_sum_driver) : currency(0) }}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    @endif
                    @if (Setting::get('commission_deduction_on_tip', 0) == 1)
                        @if ($tip_comission_view_permission == 1)
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box my-gradiant-card">
                                    <span class="info-box-icon "><i
                                            class="fas fa-file-invoice-dollar"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ translateKeyword('Tip_Comission') }}</span>
                                        <span class="info-box-number">
                                            {{ isset($tip_commission) ? currency($tip_commission) : currency(0) }}
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                        @endif
                    @endif
                @endif

                @if ($cash_payment_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 my-gradiant-card">
                            <span class="info-box-icon"><i
                                    class="fas fa-money-bill-wave"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Cash_Payments') }}</span>
                                <span class="info-box-number">{{ $cashpayments }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif
                @if ($online_payment_view_permission == 1)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 my-gradiant-card">
                            <span class="info-box-icon"><i class="fas fa-wallet"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Online_Payments') }}</span>
                                <span class="info-box-number">{{ $online_payments }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif

                @if ($ios_user_view_permission == 1)
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 my-gradiant-card">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('iOS Users') }}</span>
                                <span class="info-box-number">{{ $ios_devices_users }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif

                @if ($android_user_view_permission == 1)
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 my-gradiant-card">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Android Users') }}</span>
                                <span class="info-box-number">{{ $android_devices_users }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif

                @if ($male_user_view_permission == 1)
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 my-gradiant-card">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Male Users') }}</span>
                                <span class="info-box-number">{{ $male_users }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif

                @if ($female_user_view_permission == 1)
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3 my-gradiant-card">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{translateKeyword('Female Users') }}</span>
                                <span class="info-box-number">{{ $female_users }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif

                @if ($ongoing_view_permission == 1)
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <a class="info-box mb-3 my-gradiant-card" href="{{ route('admin.requests.scheduled') }}">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Ongoing Rides') }}</span>
                                <span class="info-box-number">{{ $incoming_rides }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                @endif
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">

                </div>

            </div>

            <div class="row row-md">

                @if ($rides_graph_view_permission == 1)
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="card border-radius-10">
                            <div class="box box-block mb-0">
                                <div class="t-content" id="total-trip-chart">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($payments_graph_view_permission == 1)
                    <div class="col-lg-4 col-md-4 col-xs-12" >
                        <div class="card border-radius-10">
                            <div class="box box-block mb-0">
                                <div class="t-content" id="payment-mode-chart">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($users_graph_view_permission == 1)
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="card border-radius-10">
                            <div class="box box-block mb-0">
                                <div class="t-content" id="user-type-chart">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>

            @if ($rides_table_view_permission == 1)
                <div class="row">
                    <div class="col-12">
                        <div class="card border-radius-10">

                            <div class="card-body">

                                <div class="box-block clearfix">

                                    <h5 class="float-xs-left">{{ translateKeyword('Recent_Rides') }}</h5>

                                </div>

                                <table class="table table-bordered " id="example1">

                                    <thead>

                                        <tr>

                                            <th>{{ translateKeyword('ID') }}</th>

                                            <th>{{ translateKeyword('User') }}</th>

                                            <th>{{ translateKeyword('Ride_Detail') }}</th>

                                            <th>{{ translateKeyword('Date') }} &amp; {{ translateKeyword('Time') }}</th>

                                            <th>{{ translateKeyword('Total') }}</th>

                                            <th>{{ translateKeyword('Status') }}</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>



                                        @foreach ($rides as $index => $ride)
                                            <tr>

                                                <th>{{ $ride->id }}</th>


                                                <td>{{ $ride->user['first_name'] }} {{ $ride->user['last_name'] }}</td>


                                                <td>


                                                    <a class="text-primary"
                                                        href="{{ route('admin.requests.show', $ride->id) }}"><span
                                                            class="underline">{{ translateKeyword('Ride_Detail') }}</span></a>


                                                </td>

                                                <td>

                                                    <span
                                                        class="text-muted">{{ $ride->created_at->diffForHumans() }}</span>

                                                </td>

                                                <td>

                                                    {{ $ride->payment ? currency($ride->payment['total']) : currency(0) }}

                                                </td>

                                                <td>

                                                    @if ($ride->status == 'COMPLETED')
                                                        <span class="tag tag-success">{{ translateKeyword($ride->status) }}</span>
                                                    @elseif($ride->status == 'CANCELLED')
                                                        <span class="tag tag-danger">{{ translateKeyword($ride->status) }}</span>
                                                    @else
                                                        <span class="tag tag-info">{{ $ride->status }}</span>
                                                    @endif

                                                </td>

                                            </tr>

                                            <?php if ($index == 10) {
                                                break;
                                            } ?>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

@endsection

@section('scripts')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // VISUALIZATION API AND THE PIE CHART PACKAGE. payment-mode-chart
        google.charts.load("visualization", "1", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(DrawPieChart);
        google.charts.setOnLoadCallback(DrawPieChart1);
        google.charts.setOnLoadCallback(DrawPieChart2);

        var tt = ["Element", "Density", {
            role: "style"
        }];

        function DrawPieChart() {
            var completed_rides = '<?php echo @$completed_rides; ?>';
            var cancel_rides = '<?php echo @$canceled_rides; ?>';
            var ongoing_rides = '<?php echo @$ongoing_rides; ?>';
            var scheduled_rides = '<?php echo @$scheduled_rides; ?>';
            var arrSales = [
                ['Rides', 'Total Rides'],
                ["{{ translateKeyword('completed') }}", parseInt(completed_rides)],
                ["{{ translateKeyword('cancelled') }}", parseInt(cancel_rides)],
                ["{{ translateKeyword('active') }}", parseInt(ongoing_rides)],
                ["{{ translateKeyword('Schedulednow') }}", parseInt(scheduled_rides)]

            ];

            var options = {
                title: "{{ translateKeyword('rides-new') }}",
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
            var arrSales = [
                ['Payment Mode', 'Payment Mode'],
                ["{{ translateKeyword('cash') }}", parseInt(cash_rides)],
                ["{{ translateKeyword('online') }}", parseInt(card_rides)]

            ];

            //console.log(arrSales);

            // SET CHART OPTIONS.
            var options = {
                title: "{{ translateKeyword('payment_mode') }}",
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

            // DEFINE AN ARRAY OF DATA.
            var arrSales = [
                ['Payment Mode', 'Payment Mode'],
                ["{{ translateKeyword('users') }}", parseInt(user)],
                ["{{ translateKeyword('driver') }}", parseInt(provider)],
                ["{{ translateKeyword('fleet') }}", parseInt(fleets)]
            ];

            // SET CHART OPTIONS.
            var options = {
                title: "{{ translateKeyword('user-data') }}",
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
