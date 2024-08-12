@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Booking Requests ')

@section('content')
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white">
                <h5 class="mb-1">{{ translateKeyword('booking-requests')}}</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('pickup-name')}}</th>
                        <th>{{ translateKeyword('pickup-phone')}}</th>
                        <th>{{ translateKeyword('pickup_address')}}</th>
                        <th>{{ translateKeyword('drop_off_name')}}</th>
                        <th>{{ translateKeyword('drop_off_phone')}}</th>
                        <th>{{ translateKeyword('dropoff_address')}}</th>
                        <th>{{ translateKeyword('Date')}}</th>
                        <th>{{ translateKeyword('service_type')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookingRequests as $index => $review)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$review->name}}</td>
                            <td>{{$review->phone}}</td>
                            <td>{{$review->sdestination}}</td>
                            <td>{{$review->dname}}</td>
                            <td>{{$review->dphone}}</td>
                            <td>{{$review->edestination}}</td>
                            <td>{{$review->date}}</td>
                            <td>{{$review->car_type}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>{{ translateKeyword('id') }}</th>
                        <th>{{ translateKeyword('pickup-name')}}</th>
                        <th>{{ translateKeyword('pickup-phone')}}</th>
                        <th>{{ translateKeyword('pickup_address')}}</th>
                        <th>{{ translateKeyword('drop_off_name')}}</th>
                        <th>{{ translateKeyword('drop_off_phone')}}</th>
                        <th>{{ translateKeyword('dropoff_address')}}</th>
                        <th>{{ translateKeyword('Date')}}</th>
                        <th>{{ translateKeyword('service_type')}}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection