@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Scheduled Rides ')

@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white border-radius-10">
                <h5 class="mb-1">{{ translateKeyword('scheduled_rides')}}</h5>
                @if(count($requests) != 0)
                    <table class="table table-striped table-bordered dataTable" id="table-2">
                        <thead>
                        <tr>
                            <th>{{ translateKeyword('id') }}</th>
                            <th>{{ translateKeyword('Request_Id')}}</th>
                            <th>{{ translateKeyword('User_Name')}}</th>
                            <th>{{ translateKeyword('Provider_Name')}}</th>
                            <th>{{ translateKeyword('Scheduled_Date_Time')}}</th>
                            <th>{{ translateKeyword('status')}}</th>
                            <th>{{ translateKeyword('payment_mode')}}</th>
                            <th>{{ translateKeyword('payment_status')}}</th>
                            <th>{{ translateKeyword('action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $index => $request)
                            <tr>
                                <td>{{$index + 1}}</td>

                                <td>{{$request->id}}</td>
                                <td>
                                    @if($request->user)
                                        {{ $request->user->first_name }} {{ $request->user->last_name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($request->provider)
                                        {{$request->provider->first_name}} {{$request->provider->last_name}}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{$request->schedule_at}}</td>
                                <td>
                                    {{$request->status}}
                                </td>

                                <td>{{ $request->payment ? $request->payment->payment_mode : 'N/A' }}</td>
                                <td>
                                    @if($request->paid)
                                        {{ translateKeyword('paid')}}
                                    @else
                                        {{ translateKeyword('not-paid-new')}}
                                    @endif
                                </td>
                                <td>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">{{ translateKeyword('action')}}
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.requests.show', $request->id) }}"
                                                   class="btn btn-default"><i class="fa fa-search"></i> {{ translateKeyword('more-details')}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ translateKeyword('id') }}</th>
                            <th>{{ translateKeyword('Request_Id')}}</th>
                            <th>{{ translateKeyword('User_Name')}}</th>
                            <th>{{ translateKeyword('Provider_Name')}}</th>
                            <th>{{ translateKeyword('Scheduled_Date_Time')}}</th>
                            <th>{{ translateKeyword('status')}}</th>
                            <th>{{ translateKeyword('payment_mode')}}</th>
                            <th>{{ translateKeyword('payment_status')}}</th>
                            <th>{{ translateKeyword('action')}}</th>
                        </tr>
                        </tfoot>
                    </table>
                @else
                    <h6 class="no-result">{{ translateKeyword('no-results-found')}}</h6>
                @endif
            </div>

        </div>
    </div>


    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection