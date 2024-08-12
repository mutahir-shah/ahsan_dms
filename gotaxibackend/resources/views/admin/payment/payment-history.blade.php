@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Payment History ')

@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">
                <h5 class="mb-1">{{ translateKeyword('payment_history')}}</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                    <tr>
                        <th>{{ translateKeyword('request_id')}}</th>
                        <th>{{ translateKeyword('transaction_id')}}</th>
                        <th>{{ translateKeyword('from')}}</th>
                        <th>{{ translateKeyword('to') }}</th>
                        <th>{{ translateKeyword('total_amount')}}</th>
                        <th>{{ translateKeyword('payment_mode')}}</th>
                        <th>{{ translateKeyword('payment_status')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $index => $payment)

                        <tr>
                            <td>{{$payment->id}}</td>
                            <td>{{$payment->booking_id}}</td>
                            <td>{{$payment->user->first_name}} {{$payment->user->last_name}}</td>
                            <td>{{$payment->provider->first_name}} {{$payment->provider->last_name}}</td>
                            <td>{{currency($payment->payment->total)}}</td>
                            <td>{{$payment->payment_mode}}</td>
                            <td>
                                @if($payment->paid)
                                    {{ translateKeyword('paid')}}
                                @else
                                    {{ translateKeyword('not-paid-new')}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>{{ translateKeyword('request_id')}}</th>
                        <th>{{ translateKeyword('transaction_id')}}</th>
                        <th>{{ translateKeyword('from')}}</th>
                        <th>{{ translateKeyword('to') }}</th>
                        <th>{{ translateKeyword('total_amount')}}</th>
                        <th>{{ translateKeyword('payment_mode')}}</th>
                        <th>{{ translateKeyword('payment_status')}}</th>
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