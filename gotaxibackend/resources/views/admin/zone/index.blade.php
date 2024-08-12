@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Zones ')

@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="box box-block bg-white" style="overflow: scroll;">
                <h5 class="mb-1"><span class="s-icon"><i class="ti-zoom-in"></i></span> &nbsp;{{ translateKeyword('Zones')}} </h5>
                <hr/>
                @if($add_permission == 1)
                    <a href="{{ route('admin.zone.create') }}" style="margin-left: 1em; color:white !important;"
                    class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ translateKeyword('add-new-zone') }}</a>
                @endif
                <table id="table-1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ translateKeyword('add-new-zone') }}</th>
                        <th>{{ translateKeyword('zone-name') }}</th>
                        <th>{{ translateKeyword('country') }}</th>
                        {{-- <th>State</th> --}}
                        <th>{{ translateKeyword('city') }}</th>
                        {{-- <th>Currency</th> --}}
                        <th>{{ translateKeyword('status') }}</th>
                        {{-- <th>Created</th> --}}
                        <th style="width:50px;">{{ translateKeyword('action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($zones as $index => $zone)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$zone->name}}</td>
                            <td>{{$zone->country}}</td>
                            {{-- <td>{{$zone->state}}</td> --}}
                            <td>{{$zone->city}}</td>
                            {{-- <td>{{$zone->currency}}</td> --}}
                            <td>{{$zone->status}}</td>
                            {{-- <td>{{ date('Y-m-d: H:i:A', strtotime( $zone->created_at ) )}}</td> --}}
                            <td style="width: 100px;">
                                <form action="{{ route('admin.zone.destroy', $zone->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{-- <a href="{{ route('admin.zone.edit', $zone->id) }}"
                                       class="btn shadow-box btn-black"><i class="fa fa-eye"></i></a> --}}
                                    @if ($add_permission == 1)
                                    <a href="{{ route('admin.zone.attach', $zone->id) }}"
                                        class="btn shadow-box btn-dark"><i class="fa fa-plus"></i> {{ translateKeyword('Services') }}</a>
                                    @endif
                                    @if ($delete_permission == 1)
                                        <button class="btn shadow-box btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i></button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ translateKeyword('add-new-zone') }}</th>
                            <th>{{ translateKeyword('zone-name') }}</th>
                            <th>{{ translateKeyword('country') }}</th>
                            {{-- <th>State</th> --}}
                            <th>{{ translateKeyword('city') }}</th>
                            {{-- <th>Currency</th> --}}
                            <th>{{ translateKeyword('status') }}</th>
                            {{-- <th>Created</th> --}}
                            <th style="width:50px;">{{ translateKeyword('action') }}</th>
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