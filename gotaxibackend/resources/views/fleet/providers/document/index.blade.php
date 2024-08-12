@extends('fleet.layout.basecode')
@extends('admin.layout.base2')

@section('title', 'Provider Documents ')

@section('content')

    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                @include('common.notify')
                @php
                    $vehicle_id = null;
                    if(Session::has('vehicle_id')) {
                        $vehicle_id = Session::get('vehicle_id');
                    }
                @endphp
                <h4 class="col-12">Provider Service Type Allocation</h4>
                <div class="row">
                    <div class="col-xs-12">
                        <fieldset>
                            <form action="{{ route('fleet.provider.document.store', $provider->id) }}" method="POST">
                                <h5>Create New</h5>
                                {{ csrf_field() }}
                                <div class="col-xs-3">
                                    <input type="hidden" name="type" value="Service"/>
                                    {{-- <select class="form-control input" name="service_type[]" required multiple>
                                        @forelse($ServiceTypes as $Type)
                                            <option value="{{ $Type->id }}">{{ $Type->name }}</option>
                                        @empty
                                            <option>- Please Create a Service Type -</option>
                                        @endforelse
                                    </select> --}}
                                    {{-- <label for="vehicle1">Select service(s)</label> --}}
                                    @if (Setting::get('multi_service_module', 0) == 1) {
                                        @forelse($ServiceTypes as $index => $Type)
                                            <label for="vehicle1">{{ $Type->name }}</label>
                                            <input type="checkbox" name="service_type[]" value="{{ $Type->id }}" />
                                            &nbsp;&nbsp;&nbsp;
                                            @if ($index % 2 == 0)
                                                <br />
                                            @endif
                                        @empty
                                            <h6>- Please Create a Service Type -</h6>
                                        @endforelse
                                    @else
                                        <select name="service_type" id="service_type" class="form-control">
                                            @forelse($ServiceTypes as $index => $Type)
                                                <option value="{{ $Type->id }}">{{ $Type->name }}</option>
                                            @empty
                                                <h6>- Please Create a Service Type -</h6>
                                            @endforelse
                                        </select>
                                    @endif
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" required name="service_number" class="form-control"
                                           placeholder="Number (CY 98769)">
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" required name="service_model" class="form-control"
                                           placeholder="Model (Audi R8 - Black)">
                                </div>
                                <div class="col-xs-3">
                                    <button class="btn btn-primary btn-block" type="submit">Add</button>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        @if($ProviderService->count() > 0)
                            <hr><h6>Allocated Services : </h6>
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Service Name</th>
                                    <th>Service Number</th>
                                    <th>Service Model</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ProviderService as $service)
                                    <tr>
                                        <td>{{ $service->service_type ? $service->service_type->name : 'N/A' }}</td>
                                        <td>{{ $service->service_number }}</td>
                                        <td>{{ $service->service_model }}</td>
                                        <td>
                                            <form action="{{ route('fleet.provider.document.service', [$provider->id, $service->id]) }}"
                                                  method="POST">
                                                @if ($service->is_approved == 1)
                                                    <a class="btn btn-info btn-block mb-2"
                                                       href="{{ route('fleet.provider.disapproveVehicle', $service->id) }}">Disable</a>
                                                @else
                                                    <a class="btn btn-success btn-block mb-2"
                                                       href="{{ route('fleet.provider.approveVehicle', $service->id) }}">Enable</a>
                                                @endif
                                                @if ($service->is_selected == 1)
                                                    <a class="btn btn-dark btn-block mb-2"
                                                       href="javascript:">Selected</a>
                                                @else
                                                    <a class="btn btn-warning btn-block mb-2"
                                                       href="{{ route('fleet.provider.selectVehicle', [$service->id, $provider->id]) }}">Select</a>
                                                @endif
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                @if ($service->is_selected == 0)
                                                    <button class="btn btn-danger btn-block">Delete</a>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Service Name</th>
                                    <th>Service Number</th>
                                    <th>Service Model</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        @endif
                        <hr>
                    </div>

                </div>
            </div>
            <div class="box box-block bg-white">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if($vehicle_id == null) active @endif" id="driver-tab" data-toggle="tab"
                           href="#driver" role="tab"
                           aria-controls="driver" aria-selected="true">Provider</a>
                    </li>
                    @foreach ($ProviderService as $index => $Service)
                        <li class="nav-item">
                            <a class="nav-link @if($vehicle_id == $Service->id) active @endif"
                               id="vehicle-tab{{ $index }}" data-toggle="tab" href="#vehicle{{ $index }}" role="tab"
                               aria-controls="vehicle{{ $index }}" aria-selected="false">Vehicle
                                <b>({{ $Service->service_number . ' - ' .  $Service->service_model }})</b></a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show @if($vehicle_id == null) active in @endif" id="driver" role="tabpanel"
                     aria-labelledby="driver-tab">
                    <div class="box box-block bg-white">
                        <h4 class="col-12">Provider Documents</h4>
                        <div class="row">
                            <div class="col-xs-12">
                                <fieldset>
                                    <form action="{{ route('fleet.provider.document.store', $provider->id) }}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                        <h5>Create New</h5>
                                        {{ csrf_field() }}
                                        <div class="col-xs-3">
                                            <select class="form-control input" name="document_id" required>
                                                <option selected disabled>Please select document</option>
                                                @forelse($DocumentsDriver as $Document)
                                                    <option value="{{ $Document->id }}">{{ $Document->name }}</option>
                                                @empty
                                                    <option disabled>- Please Create a Document -</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-xs-3">
                                            <input type="file" name="document" required
                                                   accept="application/pdf, image/*">
                                        </div>
                                        <div class="col-xs-3">
                                            <button class="btn btn-primary btn-block" type="submit">Add</button>
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="table-1" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Document Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($DocumentsDriverData as $Index => $Document)
                                                <tr>
                                                    <td>{{ $Index + 1 }}</td>
                                                    <td>{{ $Document->document->name }}</td>
                                                    <td>{{ $Document->status }}</td>
                                                    <td>
                                                        <div class="input-group-btn">
                                                            <a href="{{ route('fleet.provider.document.edit', [$provider->id, $Document->id]) }}"><span
                                                                        class="btn btn-success btn-large">View</span></a>
                                                            <button class="btn btn-danger btn-large" form="form-delete">
                                                                Delete
                                                            </button>
                                                            <form action="{{ route('fleet.provider.document.destroy', [$provider->id, $Document->id]) }}"
                                                                  method="POST" id="form-delete"
                                                                  onsubmit="return confirm('Are you sure?');">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Document Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($ProviderServiceVehicle as $index => $ServiceMain)
                    <div class="tab-pane fade show @if($vehicle_id == $ServiceMain->id) active in @endif"
                         id="vehicle{{ $index }}" role="tabpanel" aria-labelledby="vehicle-tab{{ $index }}">
                        <div class="box box-block bg-white">
                            <h4 class="col-12">Vehicle Documents</h4>
                            <div class="row">
                                <div class="col-xs-12">
                                    <fieldset>
                                        <form action="{{ route('fleet.provider.document.store', $provider->id) }}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            <h5>Create New</h5>
                                            {{ csrf_field() }}
                                            <div class="col-xs-3">
                                                <select class="form-control input" name="document_id" required>
                                                    <option selected disabled>Please select document</option>
                                                    @forelse($DocumentsVehicle as $Document)
                                                        <option value="{{ $Document->id }}">{{ $Document->name }}</option>
                                                    @empty
                                                        <option disabled>- Please Create a Document -</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            {{-- <div class="col-xs-3"> --}}
                                            <input type="hidden" name="vehicle_id" value="{{ $ServiceMain->id }}">
                                            {{-- <select class="form-control input" name="vehicle_id" required>
                                                <option selected disabled>Please select vehicle</option>
                                                @forelse($ProviderService as $Service)
                                                        <option value="{{ $Service->id }}">{{ $Service->service_number . ' - ' .  $Service->service_model }}</option>
                                                @empty
                                                    <option disabled>- Please Create a Document -</option>
                                                @endforelse
                                            </select> --}}
                                            {{-- </div> --}}
                                            <div class="col-xs-3">
                                                <input type="file" name="document" required
                                                       accept="application/pdf, image/*">
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn btn-primary btn-block" type="submit">Add</button>
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="table-1" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document Type</th>
                                                    <th>Vehicle Details</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($DocumentsVehicleData as $Index => $Document)
                                                    @if((isset($Document->vehicle) && $ServiceMain->id == $Document->vehicle->id))
                                                        {{-- || $Document->vehicle == null --}}
                                                        <tr>
                                                            <td>{{ $Index + 1 }}</td>
                                                            <td>{{ $Document->document->name }}</td>
                                                            @if($Document->vehicle != null)
                                                                <td>
                                                                    <b>Service: </b>{{ $Document->vehicle->service_type->name }}
                                                                    <br/><b>Number: </b>{{ $Document->vehicle->service_number }}
                                                                    <br/><b>Model: </b>{{ $Document->vehicle->service_model }}
                                                                </td>
                                                            @else
                                                                <td>N/A</td>
                                                            @endif
                                                            <td>{{ $Document->status }}</td>
                                                            <td>
                                                                <div class="input-group-btn">
                                                                    <form action="{{ route('fleet.provider.document.destroy', [$provider->id, $Document->id]) }}"
                                                                          method="POST" id="form-delete"
                                                                          onsubmit="return confirm('Are you sure?');">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <a href="{{ route('fleet.provider.document.edit', [$provider->id, $Document->id]) }}"><span
                                                                                    class="btn btn-success btn-large">View</span></a>
                                                                        <button type="submit"
                                                                                class="btn btn-danger btn-large">Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document Type</th>
                                                    <th>Vehicle Details</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection