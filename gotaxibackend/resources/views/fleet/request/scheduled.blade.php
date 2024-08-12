@extends('fleet.layout.basecode')
@extends('admin.layout.base2')

@section('title', 'Scheduled Rides ')

@section('content')

    <link rel="stylesheet" href="{{url('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white">
                <h5 class="mb-1">Scheduled Rides</h5>
                @if(count($requests) != 0)
                    <table class="table table-striped table-bordered dataTable" id="table-2">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Request Id</th>
                            <th>User Name</th>
                            <th>Driver Name</th>
                            <th>Scheduled Date & Time</th>
                            <th>Status</th>
                            <th>Payment Mode</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $index => $request)
                            <tr>
                                <td>{{$index + 1}}</td>

                                <td>{{$request->id}}</td>
                                <td>{{$request->user->first_name}} {{$request->user->last_name}}</td>
                                <td>
                                    @if($request->provider_id)
                                        {{$request->provider->first_name}} {{$request->provider->last_name}}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{$request->schedule_at}}</td>
                                <td>
                                    {{$request->status}}
                                </td>

                                <td>{{ $request->payment ? $request->payment->payment_mode : $request->payment_mode }}</td>
                                <td>
                                    @if($request->paid)
                                        Paid
                                    @else
                                        Not Paid
                                    @endif
                                </td>
                                <td>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">Action
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('fleet.requests.show', $request->id) }}"
                                                   class="btn btn-default"><i class="fa fa-search"></i> More Details</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Request Id</th>
                            <th>User Name</th>
                            <th>Driver Name</th>
                            <th>Scheduled Date & Time</th>
                            <th>Status</th>
                            <th>Payment Mode</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                @else
                    <h6 class="no-result">No results found</h6>
                @endif
            </div>

        </div>
    </div>


    <script src="{{url('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
@endsection