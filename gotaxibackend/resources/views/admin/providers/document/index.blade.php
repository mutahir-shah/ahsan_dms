@php use App\ProviderService; @endphp
@php use App\ServiceType; @endphp
@extends('admin.layout.base')
@extends('admin.layout.base2')

@section('title', 'Provider Documents ')

@section('content')

    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <div class="content-wrapper">
        <div class="container-fluid">
            {{-- <div class="card">
                <div class="card-header mb-10">
                    <div class="row"> <div class="col"> <a href="{{ route('admin.provider.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> </div> </div>
                        
                </div>
            </div>     --}}
            <div class="box box-block bg-white border-radius-10">
                @include('common.notify')
                @if ($isSelectedCheck == 0 && $ProviderServiceVehicle->count() > 0)
                    <div class="alert alert-danger alert-dismissible">
                        <p class="m-0"><strong>Alert!</strong> Please select at least one service before uploading the
                            document.</p>
                    </div>
                @endif

                @php
                    $vehicle_id = null;
                    if (Session::has('vehicle_id')) {
                        $vehicle_id = Session::get('vehicle_id');
                    }
                @endphp
                <h4 class="col-12">{{ translateKeyword('Provider Service Type Allocation') }}</h4>
                <div class="row">
                    <div class="col"><a href="{{ route('admin.provider.index') }}" class="btn btn-default pull-right"><i
                                class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a></div>
                </div>

                @if (Setting::get('multi_vehicle_module', 0) == 1 ||
                        Setting::get('multi_service_module', 0) == 1 ||
                        $ProviderService->count() == 0)
                    <div class="row">
                        <div class="col-xs-12">
                            <fieldset>
                                <form action="{{ route('admin.provider.document.store', $provider->id) }}" method="POST">
                                    <h4 class="mb-4">{{ translateKeyword('create-new-attach-vehicle') }}</h4>
                                    {{ csrf_field() }}

                                    <div class="col-xs-3">
                                        <label for="" class="form-label">{{ translateKeyword('Service Number') }}</label>
                                        <input type="text" required name="service_number" class="form-control"
                                            placeholder="Number (CY 98769)">
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="" class="form-label">{{ translateKeyword('Service Model') }}</label>
                                        <input type="text" required name="service_model" class="form-control"
                                            placeholder="Model (Audi R8 - Black)">
                                    </div>
                                    @if (Setting::get('vehicle_weightage', 0) == 1)
                                        <div class="col-xs-3">
                                            <label for="" class="form-label">{{ translateKeyword('Service Weight') }}</label>
                                            <input type="number" required name="service_weight_allowed_kg"
                                                class="form-control" placeholder="Enter weight in kgs" min="0">
                                        </div>
                                    @endif
                                    <div class="col-xs-12 mt-3">
                                        <input type="hidden" name="type" value="Service" />
                                        {{-- <select class="form-control input" name="service_type[]" required multiple>
                                            @forelse($ServiceTypes as $Type)
                                                <option value="{{ $Type->id }}">{{ $Type->name }}</option>
                                            @empty
                                                <option>- Please Create a Service Type -</option>
                                            @endforelse
                                        </select> --}}
                                        {{-- <label for="vehicle1">Select service(s)</label> --}}
                                        <ul class="nav nav-tabs" id="serviceTabs" role="tablist">


                                            @if (Setting::get('multi_service_module', 0) == 1)
                                                @foreach ($types as $type)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                        id="tab-{{ $type['value'] }}" data-toggle="tab"
                                                        href="#content-{{ $type['value'] }}" role="tab"
                                                        aria-controls="content-{{ $type['value'] }}"
                                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                        @lang($type['language'])
                                                    </a>
                                                </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        <div class="tab-content mt-3" id="serviceTabsContent">
                                            @foreach ($types as $type)
                                                <div class="tab-pane {{ $loop->first ? 'show active' : '' }}"
                                                    id="content-{{ $type['value'] }}" role="tabpanel"
                                                    aria-labelledby="tab-{{ $type['value'] }}">
                                                    @if (Setting::get('multi_service_module', 0) == 1)
                                                        @forelse($ServiceTypes->where('type', $type['value']) as $index => $Type)
                                                            <div>
                                                                <input type="checkbox" name="service_type[]"
                                                                    value="{{ $Type->id }}" />
                                                                <label
                                                                    for="service_type_{{ $Type->id }}">&nbsp;&nbsp;{{ $Type->name }}</label>
                                                                <br />
                                                            </div>
                                                        @empty
                                                            <h6>- {{ translateKeyword('Please Create a Service Type') }} -
                                                            </h6>
                                                        @endforelse
                                                    @else
                                                        <select name="service_type" id="service_type" class="form-control">
                                                            <option disabled>@lang($type['language'])</option>
                                                            @foreach ($ServiceTypes->where('type', $type['value']) as $index => $Type)
                                                                <option value="{{ $Type->id }}">--{{ $Type->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    <div class="col-xs-3 mt-3">
                                        <button class="btn btn-success"
                                            type="submit">{{ translateKeyword('add') }}</button>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                @endif

            </div>

            <div class="box box-block bg-white border-radius-10">
                <div class="row">
                    <div class="col-xs-12">
                        @if ($ProviderService->count() > 0)
                            <h4>{{ translateKeyword('Allocated Services') }} : </h4>
                            <table id="table-1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ translateKeyword('service_name') }}</th>
                                        <th>{{ translateKeyword('service_number') }}</th>
                                        <th>{{ translateKeyword('service_model') }}</th>
                                        @if (Setting::get('vehicle_weightage', 0) == 1)
                                            <th>{{ translateKeyword('Weight Allowed(kg)') }}</th>
                                        @endif
                                        <th>{{ translateKeyword('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ProviderService as $service)
                                        <tr>
                                            <td>{{ $service->service_type ? $service->service_type->name : 'N/A' }} |
                                                Status:
                                                {{ $service->status == 'active' || $service->status == 'riding' ? ($service->status == 'active' ? 'Online' : 'Riding') : 'Offline' }}
                                            </td>
                                            <td>{{ $service->service_number }}</td>
                                            <td>{{ $service->service_model }}</td>
                                            @if (Setting::get('vehicle_weightage', 0) == 1)
                                                <td>{{ $service->service_weight_allowed_kg }}</td>
                                            @endif
                                            <td>
                                                <form
                                                    action="{{ route('admin.provider.document.service', [$provider->id, $service->id]) }}"
                                                    method="POST">
                                                    @if ($service->status != 'riding')
                                                        @if ($service->status == 'active')
                                                            <a href="{{ route('admin.provider.changestatus', $service->id) }}"
                                                                class="btn btn-block btn-danger"><i
                                                                    class="fa fa-account"></i>
                                                                {{ translateKeyword('Go Offline') }}</a>
                                                        @else
                                                            <a href="{{ route('admin.provider.changestatus', $service->id) }}"
                                                                class="btn btn-block btn-success"><i
                                                                    class="fa fa-account"></i>
                                                                {{ translateKeyword('Go Online') }}</a>
                                                        @endif
                                                        @if ($service->is_approved == 1)
                                                            <a class="btn btn-info btn-block mb-2"
                                                                href="{{ route('admin.provider.disapproveVehicle', $service->id) }}">{{ translateKeyword('Disable') }}</a>
                                                        @else
                                                            <a class="btn btn-success btn-block mb-2"
                                                                href="{{ route('admin.provider.approveVehicle', $service->id) }}">{{ translateKeyword('Enable') }}</a>
                                                        @endif
                                                    @endif
                                                    @if ($service->is_selected == 1)
                                                        <a class="btn btn-dark btn-block mb-2"
                                                            href="javascript:">{{ translateKeyword('Selected') }}</a>
                                                    @else
                                                        <a class="btn btn-warning btn-block mb-2"
                                                            href="{{ route('admin.provider.selectVehicle', [$service->id, $provider->id]) }}">{{ translateKeyword('Select') }}</a>
                                                    @endif
                                                    @if ($service->status != 'riding')
                                                        <a class="btn btn-warning btn-block mb-2"
                                                            href="{{ route('admin.provider.service_type.edit', [$provider->id, $service->id]) }}">{{ translateKeyword('Edit') }}</a>
                                                    @endif
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    @if ($service->is_selected == 0)
                                                        <button
                                                            class="btn btn-danger btn-block">{{ translateKeyword('delete') }}</a>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{ translateKeyword('service_name') }}</th>
                                        <th>{{ translateKeyword('service_number') }}</th>
                                        <th>{{ translateKeyword('service_model') }}</th>
                                        <th>{{ translateKeyword('action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                        <hr>
                    </div>

                </div>
            </div>
            <div class="box box-block bg-white border-radius-10">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if ($vehicle_id == null) active @endif" id="driver-tab"
                            data-toggle="tab" href="#driver" role="tab" aria-controls="driver"
                            aria-selected="true">{{ translateKeyword('provider') }}</a>
                    </li>
                    @foreach ($ProviderVehicles as $index => $Service)
                        <li class="nav-item">
                            <a class="nav-link @if ($vehicle_id == $Service->id) active @endif"
                                id="vehicle-tab{{ $index }}" data-toggle="tab"
                                href="#vehicle{{ $index }}" role="tab"
                                aria-controls="vehicle{{ $index }}"
                                aria-selected="false">{{ translateKeyword('vehicle') }}
                                <b>({{ $Service->service_number . ' - ' . $Service->service_model }})</b></a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show @if ($vehicle_id == null) active in @endif" id="driver"
                    role="tabpanel" aria-labelledby="driver-tab">
                    <div class="box box-block bg-white border-radius-10">
                        <h4 class="col-12">{{ translateKeyword('Provider Documents') }}</h4>
                        <div class="row">
                            <div class="col-xs-12">
                                <fieldset>
                                    <form action="{{ route('admin.provider.document.store', $provider->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        <h5>{{ translateKeyword('create-new') }}</h5>
                                        {{ csrf_field() }}
                                        <div class="col-xs-3">
                                            <select class="form-control input" name="document_id"
                                                data-expiry-input-id="provider_expiry_date" data-document-id required>
                                                <option selected disabled value="">
                                                    {{ translateKeyword('Please select document') }}</option>
                                                @forelse($DocumentsDriver as $Document)
                                                    <option value="{{ $Document->id }}"
                                                        data-required="{{ $Document->expiry_required }}">
                                                        {{ $Document->name }}</option>
                                                @empty
                                                    <option disabled>- {{ translateKeyword('Please Create a Document') }} -
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-xs-3">
                                            <input class="form-control" type="date" name="expiry_date"
                                                min="{{ \Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}"
                                                id="provider_expiry_date" style="visibility: hidden" />
                                        </div>

                                        <div class="col-xs-3">
                                            <input type="file" name="document" required
                                                accept="application/pdf, image/*">
                                        </div>
                                        <div class="col-xs-3">
                                            <button class="btn btn-primary btn-block"
                                                type="submit">{{ translateKeyword('add') }}</button>
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="table-1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ translateKeyword('document_type') }}</th>
                                                    <th>{{ translateKeyword('Expiry') }} </th>
                                                    <th>{{ translateKeyword('status') }}</th>
                                                    <th>{{ translateKeyword('action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($DocumentsDriverData as $Index => $Document)
                                                    @php
                                                        $now = \Carbon\Carbon::now();
                                                        $expiry_days_left = $now->diffInDays(
                                                            $Document->expiry_date,
                                                            false,
                                                        );
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $Index + 1 }}</td>
                                                        <td>{{ $Document->document->name }}</td>
                                                        <td> <b>{{ translateKeyword('Required') }}: </b>
                                                            {{ $Document->document->expiry_required }}
                                                            <br />
                                                            <b>{{ translateKeyword('Date') }}:
                                                            </b>{{ $Document->expiry_date ? $Document->expiry_date->toFormattedDateString() : 'N/A' }}
                                                            <br />
                                                            <b>{{ translateKeyword('Day(s) Left') }}:</b>
                                                            {{ $expiry_days_left }}
                                                        </td>
                                                        <td>{{ $Document->status }}</td>
                                                        <td>
                                                            <div class="input-group-btn">
                                                                <form
                                                                    action="{{ route('admin.provider.document.destroy', [$provider->id, $Document->id]) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure?');">
                                                                    <a
                                                                        href="{{ route('admin.provider.document.edit', [$provider->id, $Document->id]) }}"><span
                                                                            class="btn btn-success btn-large">{{ translateKeyword('View') }}</span></a>
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <button
                                                                        class="btn btn-danger btn-large">{{ translateKeyword('delete') }}
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ translateKeyword('document_type') }}</th>
                                                    <th>{{ translateKeyword('Expiry') }} </th>
                                                    <th>{{ translateKeyword('status') }}</th>
                                                    <th>{{ translateKeyword('action') }}</th>
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
                    @php
                        $vehicleDocsArray = [];
                    @endphp
                    @foreach ($DocumentsVehicleData as $Index => $Document)
                        @php
                            if (isset($Document->vehicle) && $ServiceMain->id == $Document->vehicle->id) {
                                array_push($vehicleDocsArray, $Document->document->id);
                            }
                        @endphp
                    @endforeach
                    <div class="tab-pane fade show @if ($vehicle_id == $ServiceMain->id) active in @endif"
                        id="vehicle{{ $index }}" role="tabpanel"
                        aria-labelledby="vehicle-tab{{ $index }}">
                        <div class="box box-block bg-white">
                            <h4 class="col-12">{{ translateKeyword('Vehicle Documents') }}</h4>
                            <div class="row">
                                <div class="col-xs-12">
                                    <fieldset>
                                        <form action="{{ route('admin.provider.document.store', $provider->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            <h5>{{ translateKeyword('create-new') }}</h5>
                                            {{ csrf_field() }}
                                            <div class="col-xs-3">
                                                <select class="form-control input" name="document_id"
                                                    data-expiry-input-id="vehicle_expiry_id_{{ $index }}"
                                                    data-document-id required>
                                                    <option selected disabled value="">
                                                        {{ translateKeyword('Please select document') }}
                                                    </option>
                                                    @forelse($DocumentsVehicle as $Document)
                                                        @if (in_array($Document->id, $vehicleDocsArray) == false)
                                                            <option value="{{ $Document->id }}"
                                                                data-required="{{ $Document->expiry_required }}">
                                                                {{ $Document->name }}</option>
                                                        @endif
                                                    @empty
                                                        <option disabled>-
                                                            {{ translateKeyword('Please Create a Document') }} -</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                                <input class="form-control" type="date"
                                                    id="vehicle_expiry_id_{{ $index }}" name="expiry_date" />
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
                                                <button class="btn btn-primary btn-block"
                                                    type="submit">{{ translateKeyword('add') }}</button>
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="table-1" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ translateKeyword('document_type') }}</th>
                                                        <th>{{ translateKeyword('Expiry') }}</th>
                                                        <th>{{ translateKeyword('Vehicle Details') }}</th>
                                                        <th>{{ translateKeyword('status') }}</th>
                                                        <th>{{ translateKeyword('action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($DocumentsVehicleData as $Index => $Document)
                                                        {{-- {{ $ServiceMain->id . ' - ' . $Document->vehicle->id }} --}}
                                                        @if (isset($Document->vehicle) && $ServiceMain->id == $Document->vehicle->id)
                                                            {{-- || $Document->vehicle == null --}}
                                                            @php
                                                                $now = \Carbon\Carbon::now();
                                                                $expiry_days_left = $now->diffInDays(
                                                                    $Document->expiry_date,
                                                                    false,
                                                                );
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $Index + 1 }}</td>
                                                                <td>{{ $Document->document->name }}</td>
                                                                <td> <b>{{ translateKeyword('Required') }}: </b>
                                                                    {{ $Document->document->expiry_required }}
                                                                    <br />
                                                                    <b>{{ translateKeyword('Date') }}:
                                                                    </b>{{ $Document->expiry_date ? $Document->expiry_date->toFormattedDateString() : 'N/A' }}
                                                                    <br />
                                                                    <b>{{ translateKeyword('Day(s) Left') }}:</b>
                                                                    {{ $expiry_days_left }}
                                                                </td>
                                                                @if ($Document->vehicle != null)
                                                                    <td><b>{{ translateKeyword('Service') }}: </b>
                                                                        @if (Setting::get('multi_vehicle_module', 0) == 1)
                                                                            @php
                                                                                $ProviderServiceTypesVehicle = ProviderService::where(
                                                                                    'id',
                                                                                    $Document->vehicle->id,
                                                                                )
                                                                                    ->orWhere(
                                                                                        'parent_id',
                                                                                        $Document->vehicle->id,
                                                                                    )
                                                                                    ->pluck('service_type_id')
                                                                                    ->toArray();
                                                                                $serviceTypeNamesArray = ServiceType::whereIn(
                                                                                    'id',
                                                                                    $ProviderServiceTypesVehicle,
                                                                                )
                                                                                    ->pluck('name')
                                                                                    ->toArray();
                                                                            @endphp
                                                                            {{ implode(', ', $serviceTypeNamesArray) }}
                                                                        @else
                                                                            {{ $Document->vehicle->service_type->name }}
                                                                        @endif
                                                                        <br /><b>{{ translateKeyword('Number') }}:
                                                                        </b>{{ $Document->vehicle->service_number }}
                                                                        <br /><b>{{ translateKeyword('Model') }}:
                                                                        </b>{{ $Document->vehicle->service_model }}
                                                                    </td>
                                                                @else
                                                                    <td>N/A</td>
                                                                @endif
                                                                <td>{{ $Document->status }}</td>
                                                                <td>
                                                                    <div class="input-group-btn">
                                                                        <form
                                                                            action="{{ route('admin.provider.document.destroy', [$provider->id, $Document->id]) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Are you sure?');">
                                                                            {{ csrf_field() }}
                                                                            {{ method_field('DELETE') }}
                                                                            <a
                                                                                href="{{ route('admin.provider.document.edit', [$provider->id, $Document->id]) }}"><span
                                                                                    class="btn btn-success btn-large">{{ translateKeyword('View') }}</span></a>
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-large">{{ translateKeyword('delete') }}
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
                                                        <th>{{ translateKeyword('document_type') }}</th>
                                                        <th>{{ translateKeyword('Expiry') }}</th>
                                                        <th>{{ translateKeyword('Vehicle Details') }}</th>
                                                        <th>{{ translateKeyword('status') }}</th>
                                                        <th>{{ translateKeyword('action') }}</th>
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

    <script>
        window.addEventListener('load', _ => {
            const documentIdSelectElems = document.querySelectorAll('[data-document-id]');

            documentIdSelectElems.forEach(select => {
                const expiryInput = document.querySelector(
                    `#${select.getAttribute('data-expiry-input-id')}`);
                const updateExpiryRequired = () => {
                    const isExpiryRequired = select.options[select.selectedIndex].getAttribute(
                        'data-required') === 'YES';
                    expiryInput.style.visibility = isExpiryRequired ? 'initial' : 'hidden';
                    isExpiryRequired ? expiryInput.setAttribute('required', 'true') : expiryInput
                        .removeAttribute('required');
                };

                select.addEventListener('change', updateExpiryRequired);
                updateExpiryRequired();
            });
        });
    </script>
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
@endsection
