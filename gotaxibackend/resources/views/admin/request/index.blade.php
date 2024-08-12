@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Request History ')

@section('content')

    <link rel="stylesheet" href="{{url('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <h3 class="card-title">{{ translateKeyword('request_history')}}</h3>

                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            @if(count($requests) != 0)
                                <table id="table-1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ translateKeyword('Booking_ID') }}</th>
                                        <th>{{ translateKeyword('User_Name')}}</th>
                                        <th>{{ translateKeyword('Provider_Name')}}</th>
                                        <th>{{ translateKeyword('Date_Time')}}</th>
                                        <th>{{ translateKeyword('status')}}</th>
                                        <th>{{ translateKeyword('amount')}}</th>
                                        <th>{{ translateKeyword('Payment_Mode')}}</th>
                                        <th>{{ translateKeyword('Payment_Status')}}</th>
                                        <th>{{ translateKeyword('action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($requests as $index => $request)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $request->booking_id }}</td>
                                            <td>
                                                @if($request->user)
                                                    {{ $request->user->first_name }} {{ $request->user->last_name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($request->provider)
                                                    {{ $request->provider->first_name }} {{ $request->provider->last_name }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($request->created_at)
                                                    <span>{{ $request->created_at->toDayDateTimeString() . ' - ' . $request->created_at->diffForHumans() }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $request->status }}</td>
                                            <td>
                                                @if($request->payment != "")
                                                    {{ currency($request->payment->total) }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $request->payment ? $request->payment->payment_mode : 'N/A' }} @if (isset($request->payment) && $request->payment->wallet) & WALLET @endif</td>
                                            <td>
                                                @if($request->paid)
                                                    {{ translateKeyword('paid')}}
                                                @else
                                                    {{ translateKeyword('not-paid-new')}}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button"
                                                            class="btn btn-primary waves-effect dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                        {{ translateKeyword('action')}}
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a href="{{ route('admin.requests.show', $request->id) }}"
                                                           class="dropdown-item">
                                                            <i class="fa fa-search"></i> {{ translateKeyword('more-details')}}
                                                        </a>
                                                        <form action="{{ route('admin.requests.destroy', $request->id) }}"
                                                              method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            @if ($delete_permission == 1)    
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fa fa-trash"></i> {{ translateKeyword('delete')}}
                                                                </button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ translateKeyword('Booking_ID') }}</th>
                                        <th>{{ translateKeyword('User_Name')}}</th>
                                        <th>{{ translateKeyword('Provider_Name')}}</th>
                                        <th>{{ translateKeyword('Date_Time')}}</th>
                                        <th>{{ translateKeyword('status')}}</th>
                                        <th>{{ translateKeyword('amount')}}</th>
                                        <th>{{ translateKeyword('Payment_Mode')}}</th>
                                        <th>{{ translateKeyword('Payment_Status')}}</th>
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
            </div>
        </section>
    </div>



    <script src="{{url('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
@endsection