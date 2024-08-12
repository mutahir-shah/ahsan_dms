@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Zone With Services ')

@section('content')

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-1">{{ translateKeyword('zone-with-services') }} </h5>
                            {{-- <a href="{{ route('admin.service.create') }}" style="margin-left: 1em;"
                                class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Service</a> --}}
                        </div>
                        <div class="card-body" style="overflow: scroll;">
                            @include('common.notify')
                            <table id="table-1" class="table table-bordered table-hover table-responsive">
                                <thead>

                                <tr>

                                    <th>{{ translateKeyword('zone-with-services') }}</th>
                                    <th>{{ translateKeyword('zone-name') }}</th>

                                    <th>{{ translateKeyword('service_name') }}</th>

                                    {{-- <th>Provider Name</th> --}}

                                    <th>{{ translateKeyword('capacity') }}</th>

                                    <th>{{ translateKeyword('Base_Price') }}</th>

                                    {{-- <th>Base Distance</th>

                                <th>Distance Price</th>

                                <th>Time Price</th> --}}

                                    <th>{{ translateKeyword('Pricing_Logic') }}</th>

                                    <th>{{ translateKeyword('Service_Image') }}</th>

                                    <th>{{ translateKeyword('map-icon') }}</th>

                                    <th>{{ translateKeyword('action') }}</th>

                                </tr>

                                </thead>

                                <tbody>

                                @foreach ($services as $index => $service)
                                    <tr>

                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $service->zone ? $service->zone->name : 'N/A' }}</td>

                                        <td>{{  $service->service ? $service->service->name : 'N/A'  }}</td>


                                        {{-- <td>{{ $service->provider_name }}</td> --}}

                                        <td>{{ $service->capacity }}</td>

                                        <td>{{ currency($service->fixed) }}</td>

                                        {{-- <td>{{$dis=distance($service->distance)}}</td>

                                    <td>{{ currency($service->price) }}</td>

                                    <td>{{ currency($service->minute) }}</td> --}}

                                        <td>{{translateKeyword($service->calculator) }}</td>

                                        <td>

                                            @if ($service->image)
                                                <img src="{{ $service->image }}" style="height: 50px">
                                            @else
                                                N/A
                                            @endif

                                        </td>

                                        <td>

                                            @if ($service->image)
                                                <img src="{{ $service->map_icon }}" style="height: 50px">
                                            @else
                                                N/A
                                            @endif

                                        </td>

                                        <td>

                                            <form action="{{ route('admin.zone-service.destroy', $service->id) }}"
                                                  method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('admin.zone-service.edit', $service->id) }}"
                                                   class="btn btn-info btn-block">

                                                    <i class="fa fa-edit"></i> {{ translateKeyword('edit') }}

                                                </a>
                                                <button class="btn shadow-box btn-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i> {{ translateKeyword('delete')}}
                                                </button>
                                            </form>


                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <th>{{ translateKeyword('zone-with-services') }}</th>
                                        <th>{{ translateKeyword('zone-name') }}</th>
    
                                        <th>{{ translateKeyword('service_name') }}</th>
    
                                        {{-- <th>Provider Name</th> --}}
    
                                        <th>{{ translateKeyword('capacity') }}</th>
    
                                        <th>{{ translateKeyword('Base_Price') }}</th>
    
                                        {{-- <th>Base Distance</th>
    
                                    <th>Distance Price</th>
    
                                    <th>Time Price</th> --}}
    
                                        <th>{{ translateKeyword('Pricing_Logic') }}</th>
    
                                        <th>{{ translateKeyword('Service_Image') }}</th>
    
                                        <th>{{ translateKeyword('map-icon') }}</th>
    
                                        <th>{{ translateKeyword('action') }}</th>
    
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection
