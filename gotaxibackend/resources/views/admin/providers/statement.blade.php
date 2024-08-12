@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', $page)

@section('content')

    <link rel="stylesheet" href="{{ url('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white border-radius-10">

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-car-side"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Total_Bookings') }}</span>
                                <span class="info-box-number">
                                    {{ $rides->count() }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('cancelled-rides')}}</span>
                                <span class="info-box-number">{{ $cancel_rides }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-1"><i
                                    class="fas fa-file-invoice-dollar"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('Total_Revenue') }}</span>
                                <span class="info-box-number">
                                    {{ currency($revenue[0]->overall) }}
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ translateKeyword('total-commision')}} <b>{{ currency($finalcommission) }}</b></span>
                                @if (isset($provider_id))
                                    @if ($finalcommission > 0)
                                        <a href="{{ route('admin.provider.paid', $provider_id) }}">
                                            <button style="margin-top: 10px" type="button" class="btn btn-success">Paid
                                                {{ translateKeyword('by-driver')}}
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.provider.paid', $provider_id) }}">
                                            <button style="margin-top: 10px" type="button" class="btn btn-success">Paid
                                                {{ translateKeyword('to-driver')}}
                                            </button>
                                        </a>
                                    @endif

                                @endif
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                </div>

            </div>
        </div>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <h3 class="card-title">{{ $page }}</h3>

                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            <div class="box-block clearfix">
                                <h5 class="float-xs-left">{{ translateKeyword('earnings')}}</h5>
                                <div class="float-xs-right">
                                </div>
                            </div>
                            @if (count($rides) != 0)
                                <table id="table-1" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td>{{ translateKeyword('Booking_ID')}}</td>
                                            <td>{{ translateKeyword('picked-up')}}</td>
                                            <td>{{ translateKeyword('dropped')}}</td>
                                            <td>{{ translateKeyword('request-details')}}</td>
                                            <td>{{ translateKeyword('Commission')}}</td>
                                            <td>{{ translateKeyword('dated-on')}}</td>
                                            <td>{{ translateKeyword('status')}}</td>
                                            <td>{{ translateKeyword('earned')}}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                                        @foreach ($rides as $index => $ride)
                                            <tr>
                                                <td>{{ $ride->booking_id }}</td>
                                                <td>
                                                    @if ($ride->s_address != '')
                                                        {{ $ride->s_address }}
                                                    @else
                                                        {{ translateKeyword('not-provided')}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ride->d_address != '')
                                                        {{ $ride->d_address }}
                                                    @else
                                                        {{ translateKeyword('not-provided')}}
                                                    @endif
                                                </td>
                                                <td>

                                                    <a class="text-primary"
                                                        href="{{ route('admin.requests.show', $ride->id) }}"><span
                                                            class="underline">{{ translateKeyword('View_Ride_Details')}}</span></a>
                                                    @if (Setting::get('invoice', 0) == 1 && $ride->status == 'COMPLETED')
                                                        <br />
                                                        <a class="text-primary" href="{{ route('invoice', [$ride->id]) }}"
                                                            target="_blank"><span class="underline">{{ translateKeyword('download-invoice')}}</span></a>
                                                    @endif

                                                </td>
                                                <td>{{ $ride->payment ? currency($ride->payment['commision']) : currency(0) }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-muted">{{ date('d M Y', strtotime($ride->created_at)) }}</span>
                                                </td>
                                                <td>
                                                    @if ($ride->status == 'COMPLETED')
                                                        <span class="tag tag-success">{{ $ride->status }}</span>
                                                    @elseif($ride->status == 'CANCELLED')
                                                        <span class="tag tag-danger">{{ $ride->status }}</span>
                                                    @else
                                                        <span class="tag tag-info">{{ $ride->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $ride->payment ? currency($ride->payment['distance']) : currency(0) }}
                                                </td>

                                            </tr>
                                        @endforeach

                                    <tfoot>
                                        <tr>
                                            <td>{{ translateKeyword('Booking_ID')}}</td>
                                            <td>{{ translateKeyword('picked-up')}}</td>
                                            <td>{{ translateKeyword('dropped')}}</td>
                                            <td>{{ translateKeyword('request-details')}}</td>
                                            <td>{{ translateKeyword('Commission')}}</td>
                                            <td>{{ translateKeyword('dated-on')}}</td>
                                            <td>{{ translateKeyword('status')}}</td>
                                            <td>{{ translateKeyword('earned')}}</td>
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



    <script src="{{ url('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endsection
