@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', $page)

@section('content')

    <link rel="stylesheet" href="../../admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <h3 class="card-title">{{$page}}</h3>

                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            <div class="box-block clearfix">
                                <h5 class="float-xs-left">{{ translateKeyword('earnings')}}</h5>
                                <div class="float-xs-right">
                                </div>
                            </div>
                            @if(count($providers) != 0)
                                <table id="table-1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td>{{ translateKeyword('provider_name')}}</td>
                                        <td>{{ translateKeyword('name')}}</td>
                                        <td>{{ translateKeyword('status')}}</td>
                                        <td>{{ translateKeyword('Total_Rides')}}</td>
                                        <td>{{ translateKeyword('Total_Earning') }}</td>
                                        <td>{{ translateKeyword('Commission')}}</td>
                                        <td>{{ translateKeyword('Joined_at')}}</td>
                                        <td>{{ translateKeyword('details')}}</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $diff = ['-success', '-info', '-warning', '-danger']; ?>
                                    @foreach($providers as $index => $provider)
                                        <tr>
                                            <td>
                                                {{$provider->first_name}}
                                                {{$provider->last_name}}
                                            </td>
                                            <td>
                                                {{$provider->mobile}}
                                            </td>
                                            <td>
                                                @if($provider->status == "approved")
                                                    <span class="tag tag-success">{{$provider->status}}</span>
                                                @elseif($provider->status == "banned")
                                                    <span class="tag tag-danger">{{$provider->status}}</span>
                                                @else
                                                    <span class="tag tag-info">{{$provider->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($provider->rides_count)
                                                    {{$provider->rides_count}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($provider->payment)
                                                    {{currency($provider->payment[0]->overall)}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($provider->payment)
                                                    {{currency($provider->payment[0]->commission)}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($provider->created_at)
                                                    <span class="text-muted">{{$provider->created_at->diffForHumans()}}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('admin.provider.statement', $provider->id)}}">{{ translateKeyword('view-by-job')}}</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tfoot>
                                    <tr>
                                        <td>{{ translateKeyword('provider_name')}}</td>
                                        <td>{{ translateKeyword('name')}}</td>
                                        <td>{{ translateKeyword('status')}}</td>
                                        <td>{{ translateKeyword('Total_Rides')}}</td>
                                        <td>{{ translateKeyword('Total_Earning') }}</td>
                                        <td>{{ translateKeyword('Commission')}}</td>
                                        <td>{{ translateKeyword('Joined_at')}}</td>
                                        <td>{{ translateKeyword('details')}}</td>
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


    <script src="../../admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection
