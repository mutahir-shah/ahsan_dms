@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Service Types ')

@section('content')

    <style>
        .table th,
        .table td {
            white-space: nowrap;
            /* Prevents text from wrapping */
            overflow: hidden;
            /* Hides overflowing content */
            text-overflow: ellipsis;
            /* Adds ellipsis for overflowing text */
        }
    </style>


    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card border-radius-10">
                        <div class="card-header">
                            <h5 class="mb-1">{{ translateKeyword('service_types') }}</h5>
                            @if ($add_permission == 1)
                                <a href="{{ route('admin.service.create') }}" style="margin-left: 1em;"
                                    class="btn btn-primary pull-right"><i class="fa fa-plus"></i>
                                    {{ translateKeyword('add-new-service') }}</a>
                            @endif
                        </div>
                        <ul class="nav nav-tabs" id="serviceTabs" role="tablist">
                            @foreach ($types as $index => $type)
                                <li class="nav-item">
                                    <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $type }}"
                                        data-toggle="tab" href="#content-{{ $type }}" role="tab"
                                        aria-controls="content-{{ $type }}"
                                        aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                        {{ translateKeyword($type) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="card-body" style="overflow: scroll;">
                            @include('common.notify')
                            <div class="tab-content">
                                @foreach ($types as $index => $type)
                                    <div class="tab-pane fade show {{ $index == 0 ? 'show active in' : '' }}"
                                        id="content-{{ $type }}" role="tabpanel"
                                        aria-labelledby="tab-{{ $type }}">
                                        <table id="table-{{ ++$index }}"
                                            class="table table-bordered table-hover table-responsive w-100">
                                            <thead>

                                                <tr>

                                                    <th>{{ translateKeyword('id') }}</th>

                                                    <th>{{ translateKeyword('service_name') }}</th>
                                                    <th>{{ translateKeyword('service_type') }}</th>

                                                    {{-- <th>Provider Name</th> --}}

                                                    <th>{{ translateKeyword('capacity') }}</th>

                                                    <th>{{ translateKeyword('Base_Price') }}</th>

                                                    {{-- <th>Base Distance</th>
            
                                            <th>Distance Price</th>
            
                                            <th>Time Price</th> --}}

                                                    <th>{{ TranslateKeyword('Pricing_Logic') }}</th>

                                                    <th>{{ translateKeyword('approved-providers') }}</th>

                                                    <th>{{ translateKeyword('active-providers') }}</th>

                                                    <th>{{ translateKeyword('Service_Image') }}</th>

                                                    <th>{{ translateKeyword('map-icon') }}</th>

                                                    <th>{{ translateKeyword('action') }}</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                @foreach ($services->where('type', $type) as $index => $service)
                                                    @php
                                                        $name =
                                                            $service->translations
                                                                ->where('language_id', session('translation'))
                                                                ->first()->name ?? $service->name;
                                                    @endphp
                                                    <tr>

                                                        <td>{{ $index + 1 }}</td>

                                                        <td>{{ $name }}</td>
                                                        <td>
                                                            @if ($service->type == 'luxury')
                                                                {{ translateKeyword('Luxury') }}
                                                            @elseif($service->type == 'economy')
                                                                {{ translateKeyword('Economy') }}
                                                            @elseif($service->type == 'extra_seat')
                                                                {{ translateKeyword('truck') }}
                                                            @elseif($service->type == 'outstation')
                                                                {{ translateKeyword('OutStation') }}
                                                            @elseif($service->type == 'road_assistance')
                                                                {{ translateKeyword('roadside-assistance') }}
                                                            @elseif($service->type == 'dream_driver')
                                                                {{ translateKeyword('dream-driver') }}
                                                            @elseif($service->type == 'rental')
                                                                {{ translateKeyword('rental') }}
                                                            @elseif($service->type == 'personal_care')
                                                                {{ translateKeyword('personal-care-services') }}
                                                            @elseif($service->type == 'medical_health')
                                                                {{ translateKeyword('medical-and-health-services') }}
                                                            @elseif($service->type == 'education_training')
                                                                {{ translateKeyword('education-and-training') }}
                                                            @elseif($service->type == 'consulting')
                                                                {{ translateKeyword('consulting-and-coaching') }}
                                                            @elseif($service->type == 'cleaning_services')
                                                                {{ translateKeyword('cleaning-services') }}
                                                            @elseif($service->type == 'maintenance')
                                                                {{ translateKeyword('maintenance-and-repairs') }}
                                                            @elseif($service->type == 'construction')
                                                                {{ translateKeyword('construction-and-renovations') }}
                                                            @elseif($service->type == 'security')
                                                                {{ translateKeyword('security') }}
                                                            @elseif($service->type == 'landscaping')
                                                                {{ translateKeyword('landscaping-services') }}
                                                            @elseif($service->type == 'garden')
                                                                {{ translateKeyword('garden-maintenance') }}
                                                            @elseif($service->type == 'outdoor_construction')
                                                                {{ translateKeyword('outdoor-constructions') }}
                                                            @elseif($service->type == 'exterior_design')
                                                                {{ translateKeyword('exterior-design-services') }}
                                                            @endif
                                                        </td>

                                                        {{-- <td>{{ $service->provider_name }}</td> --}}

                                                        <td>{{ $service->capacity }}</td>

                                                        <td>{{ currency($service->fixed) }}</td>

                                                        {{-- <td>{{$dis=distance($service->distance)}}</td>
            
                                                <td>{{ currency($service->price) }}</td>
            
                                                <td>{{ currency($service->minute) }}</td> --}}

                                                        <td>{{ translateKeyword($service->calculator) }}</td>
                                                        <td>{{ $service->services()->where('is_approved', 1)->count() }}
                                                        </td>
                                                        <td>{{ $service->services()->where('status', 'active')->count() }}
                                                        </td>

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

                                                            <form
                                                                action="{{ route('admin.service.destroy', $service->id) }}"
                                                                method="POST">

                                                                {{ csrf_field() }}

                                                                {{ method_field('DELETE') }}

                                                                @if ($edit_permission == 1)
                                                                    <a href="{{ route('admin.service.edit', $service->id) }}"
                                                                        class="btn btn-info btn-block">

                                                                        <i class="fa fa-edit"></i>
                                                                        {{ translateKeyword('edit') }}

                                                                    </a>
                                                                @endif

                                                                @if ($delete_permission == 1)
                                                                    <button class="btn btn-danger btn-block"
                                                                        onclick="return confirm('Are you sure?')">

                                                                        <i class="fa fa-trash"></i>
                                                                        {{ translateKeyword('delete') }}

                                                                    </button>
                                                                @endif

                                                            </form>

                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>

                                            <tfoot>

                                                <tr>


                                                    <th>{{ translateKeyword('id') }}</th>

                                                    <th>{{ translateKeyword('service_name') }}</th>
                                                    <th>{{ translateKeyword('service_type') }}</th>

                                                    {{-- <th>Provider Name</th> --}}

                                                    <th>{{ translateKeyword('capacity') }}</th>

                                                    <th>{{ translateKeyword('Base_Price') }}</th>

                                                    {{-- <th>Base Distance</th>
            
                                            <th>Distance Price</th>
            
                                            <th>Time Price</th> --}}

                                                    <th>{{ translateKeyword('Pricing_Logic') }}</th>

                                                    <th>{{ translateKeyword('approved-providers') }}</th>

                                                    <th>{{ translateKeyword('active-providers') }}</th>

                                                    <th>{{ translateKeyword('Service_Image') }}</th>

                                                    <th>{{ translateKeyword('map-icon') }}</th>

                                                    <th>{{ translateKeyword('action') }}</th>
                                                </tr>

                                            </tfoot>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
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

    <script>
        $(document).ready(function() {
            @foreach ($types as $index => $type)
                (function($) {
                    var tableId = '#table-{{ ++$index }}';

                    if (!$.fn.DataTable.isDataTable(tableId)) {
                        $(tableId).DataTable({
                            responsive: true,
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "columnDefs": [{
                                    "width": "10%",
                                    "targets": 0
                                }, // Adjust widths as needed
                                {
                                    "width": "20%",
                                    "targets": 1
                                },
                                {
                                    "width": "20%",
                                    "targets": 2
                                }
                                // Add more column width settings as needed
                            ]
                        });
                    }
                })(jQuery);
            @endforeach

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                @foreach ($types as $index => $type)
                    $('#table-{{ ++$index }}').DataTable().columns.adjust().draw();
                @endforeach
            });
        });
    </script>

@endsection
