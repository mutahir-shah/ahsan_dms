<?php

namespace App\Http\Controllers\Resource;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendPushNotification;

use App\Provider;
use App\ServiceType;
use App\ProviderService;
use App\ProviderDocument;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use anlutro\LaravelSettings\Facade as Setting;
use App\ProviderDevice;
use App\PushNotificationLog;

class ProviderFleetDocumentResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, $provider_id)
    {
        try {
            $provider = Provider::findOrFail($provider_id);
            $ProviderService = ProviderService::where('provider_id', $provider_id)->with('service_type')->get();
            $ServiceTypes = ServiceType::all();

            $providerDocsIds = ProviderDocument::where('provider_id', $provider_id)->pluck('document_id');
            if (count($providerDocsIds)) {
                $DocumentsDriver = Document::whereNotIn('id', $providerDocsIds)->where('type', 'DRIVER')->get();

            } else {
                $DocumentsDriver = Document::where('type', 'DRIVER')->get();
            }

            $DocumentsVehicle = Document::where('type', 'VEHICLE')->get();

            $DocumentsDriverData = ProviderDocument::where('provider_id', $provider_id)
                ->with(['document'])
                ->whereHas('document', function (Builder $query) {
                    $query->where('type', 'DRIVER');
                })
                ->get();
            $ProviderServiceVehicle = ProviderService::where('provider_id', $provider_id)->where('is_child', 0)->with('service_type')->get();
            $DocumentsVehicleData = ProviderDocument::where('provider_id', $provider_id)
                ->with(['document', 'vehicle'])
                ->whereHas('document', function (Builder $query) {
                    $query->where('type', 'VEHICLE');
                })
                ->whereHas('vehicle', function (Builder $query) {
                    $query->where('is_child', 0);
                })
                ->get();

            return view('fleet.providers.document.index', compact('provider', 'ServiceTypes', 'ProviderService', 'ProviderServiceVehicle','DocumentsDriver', 'DocumentsVehicle', 'DocumentsVehicleData', 'DocumentsDriverData'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('fleet.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, $provider_id)
    {
        if ($request->type == 'Service') {
            $this->validate($request, [
                'service_type' => 'required|exists:service_types,id',
                'service_number' => 'required',
                'service_model' => 'required',
            ]);

            $isApproved = 0;
            if (Setting::get('driver_verification', 0) == 1) {
                $isApproved = 1;
            }

            if (Setting::get('multi_service_module', 0) == 1) {
                $serviceTypesArray = array();
                $isChild = 0;
                $servicesArray = $request->service_type;
                $parent_id = null;
                foreach ($servicesArray as $index => $vtype) {
                    if ($index == 0) {
                        $isChild = 0;
                    } else {
                        $isChild = 1;
                    }

                    $providerService = ProviderService::create([
                        'provider_id' => $provider_id,
                        'service_type_id' => $vtype,
                        'status' => 'offline',
                        'service_number' => strtolower($request->service_number),
                        'service_model' => $request->service_model,
                        'service_weight_allowed_kg' => $request->vweight ? $request->vweight : 0,
                        'is_selected' => 0,
                        'is_approved' => $isApproved,
                        'is_child' => $isChild,
                        'parent_id' => $parent_id
                    ]);

                    if ($index == 0) {
                        $parent_id = $providerService->id;
                    }

                    array_push($serviceTypesArray, $vtype);
                }

                return redirect()->route('fleet.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider service type created'));
            } else {
                // This is for allowing only one vehicle to be registered in one service
                $providerServiceCount = ProviderService::where('service_type_id', $request->service_type)
                    ->where('service_number', strtolower($request->service_number))
                    ->count();

                if ($providerServiceCount == 0) {
                    ProviderService::create([
                        'provider_id' => $provider_id,
                        'service_type_id' => $request->service_type,
                        'status' => 'offline',
                        'service_number' => strtolower(strtolower($request->service_number)),
                        'service_model' => $request->service_model,
                        'service_weight_allowed_kg' => $request->service_weight_allowed_kg ?: 0,
                        'is_approved' => 0,
                        'is_selected' => 0,
                        'is_child' => 0,
                        'parent_id' => 0
                    ]);
                    return redirect()->route('fleet.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider service type created'));
                } else {
                    return redirect()->route('fleet.provider.document.index', $provider_id)->with('flash_error', translateKeyword('Provider service type already created!'));
                }
            }

        } else {
            $this->validate($request, [
                'document_id' => 'integer|required',
                'document' => 'mimes:jpg,jpeg,png,pdf',
            ]);

            try {

                $vehicle_id = $request->vehicle_id ? $request->vehicle_id : null;
                if ($vehicle_id == null) {
                    $Document = ProviderDocument::where('provider_id', $provider_id)
                        ->where('document_id', $request->document_id)
                        ->firstOrFail();
                } else {
                    $Document = ProviderDocument::where('provider_id', $provider_id)
                        ->where('document_id', $request->document_id)
                        ->where('vehicle_id', $request->vehicle_id)
                        ->firstOrFail();
                }


                $file = $request->document->store('provider/documents');
                $file = asset('storage/' . $file);

                $Document->update([
                    'url' => $file,
                    'status' => 'ASSESSING',
                ]);

                if ($vehicle_id == null) {
                    return redirect()->route('fleet.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider document added successfully!'));
                } else {
                    return redirect()->route('fleet.provider.document.index', $provider_id)->with(['flash_success' => translateKeyword('Provider document added successfully!'), 'vehicle_id' => $vehicle_id]);
                }


            } catch (ModelNotFoundException $e) {

                $file = $request->document->store('provider/documents');
                $file = asset('storage/' . $file);

                ProviderDocument::create([
                    'url' => $file,
                    'provider_id' => $provider_id,
                    'document_id' => $request->document_id,
                    'vehicle_id' => $request->vehicle_id ? $request->vehicle_id : null,
                    'status' => 'ASSESSING',
                ]);


                if ($vehicle_id == null) {
                    return redirect()->route('fleet.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider document added successfully!'));
                } else {
                    return redirect()->route('fleet.provider.document.index', $provider_id)->with(['flash_success' => translateKeyword('Provider document added successfully!'), 'vehicle_id' => $vehicle_id]);
                }

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($provider_id, $id)
    {
        try {
            $Document = ProviderDocument::where('provider_id', $provider_id)
                ->findOrFail($id);

            return view('fleet.providers.document.edit', compact('Document'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('fleet.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $provider_id, $id)
    {
        try {

            $Document = ProviderDocument::where('provider_id', $provider_id)
                ->where('id', $id)
                ->firstOrFail();
            $Document->update(['status' => 'ACTIVE']);

            return redirect()
                ->route('fleet.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider document has been approved.'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('fleet.provider.document.index', $provider_id)
                ->with('flash_error', translateKeyword('Provider not found!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($provider_id, $id)
    {
        try {

            $provider = Provider::find($provider_id);
            $provider->status = 'doc_required';
            $provider->save();

            $Document = ProviderDocument::destroy($id);

            return redirect()
                ->route('fleet.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider document has been deleted'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('fleet.provider.document.index', $provider_id)
                ->with('flash_error', translateKeyword('Provider not found!'));
        }
    }

    /**
     * Delete the service type of the provider.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function service_destroy(Request $request, $provider_id, $id)
    {
        try {

            $ProviderService = ProviderService::destroy($id);

            $providerDocs = ProviderDocument::where('vehicle_id', $id)->delete();

            return redirect()
                ->route('fleet.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider service has been deleted.'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('fleet.provider.document.index', $provider_id)
                ->with('flash_error', translateKeyword('Provider service not found!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function approveVehicle($vehicle_id)
    {
        try {

            $vehicle = ProviderService::find($vehicle_id);
            $vehicle->status = 'active';
            $vehicle->is_approved = 1;
            $vehicle->save();

            $provider = ProviderDevice::where('provider_id', $vehicle->provider_id)->with('provider')->first();

            if (isset($provider->token) && $provider->token != "") {
                PushNotificationLog::firstOrCreate([
                    'title' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved",
                    'message' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved",
                    'receiver_id' => $vehicle->provider_id,
                    'app_type' => 'Driver',
                    'category' => 'General',
                ]);

                $request = (object) array("title" => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved", 'message' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved");

                (new SendPushNotification)->driver_push($request, $provider->token);
            }

            return back()->with('flash_success', translateKeyword('Vehicle approved'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Something went wrong! Please try again later.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function selectVehicle($vehicle_id, $provider_id)
    {
        try {

            $vehicles = ProviderService::where('provider_id', $provider_id)->update(['is_selected' => 0, 'status' => 'offline']);

            $vehicle = ProviderService::find($vehicle_id);
            $vehicle->status = 'active';
            $vehicle->is_selected = 1;
            $vehicle->save();

            //parent selection
            if ($vehicle->parent_id) {
                $vehiclesParentActivated = ProviderService::where('id', $vehicle->parent_id)->orWhere('parent_id', $vehicle->parent_id)->update(['is_selected' => 1, 'status' => 'active']);
            }

            return back()->with('flash_success', translateKeyword('Vehicle selected'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Something went wrong! Please try again later.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function disapproveVehicle($vehicle_id)
    {
        try {

            $vehicle = ProviderService::find($vehicle_id);
            $vehicle->status = 'offline';
            $vehicle->is_approved = 0;
            $vehicle->save();

            return back()->with('flash_success', translateKeyword('Vehicle disapproved'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Something went wrong! Please try again later.'));
        }
    }
}
