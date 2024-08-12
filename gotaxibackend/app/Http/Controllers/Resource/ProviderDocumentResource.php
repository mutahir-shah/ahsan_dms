<?php

namespace App\Http\Controllers\Resource;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendPushNotification;
use App\Http\Controllers\ServiceTypeController;

use App\Provider;
use App\ServiceType;
use App\ProviderService;
use App\ProviderDocument;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Setting;

class ProviderDocumentResource extends Controller
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
            $ProviderVehicles = ProviderService::where('provider_id', $provider_id)->with('service_type')->where('is_child', 0)->get();
            $ServiceTypes = ServiceType::all();
            
            $types = [];
            $serviceTypeController = new ServiceTypeController();
            $types = $serviceTypeController->getActiveServicesTypesWithLanguage();
            
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
            $ProviderServiceVehicle = ProviderService::where('provider_id', $provider_id)->with(['service_type'])->where('is_child', 0)->get();
            $DocumentsVehicleData = ProviderDocument::where('provider_id', $provider_id)
                ->with(['document', 'vehicle'])
                ->whereHas('document', function (Builder $query) {
                    $query->where('type', 'VEHICLE');
                })
                ->whereHas('vehicle', function (Builder $query) {
                    $query->where('is_child', 0);
                })
                ->get();
            
            $isSelectedCheck = ProviderService::where(['provider_id' => $provider_id, 'is_selected' => 1])->where('is_child', 0)->count();
            return view('admin.providers.document.index', get_defined_vars());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.index');
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
            $reSync = 0;
            $serviceNames = [];
            $newServiceNames = [];
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

                   
                    // This is for allowing only one vehicle to be registered in one service
                    $providerServiceCount = ProviderService::where('service_type_id', $vtype)
                    ->where('service_number', strtolower($request->service_number))
                    ->count();

                    if ($providerServiceCount == 0) {

                        $checkProviderService = ProviderService::where([
                            'service_number' =>  strtolower($request->service_number),
                        ])->first();
                        if(!is_null($checkProviderService) && $checkProviderService->provider_id != $provider_id){
                            return redirect()->route('admin.provider.document.index', $provider_id)->with('flash_error', 'This vehicle is not belongs to you!');
                        }   

                        $serviceParent = ProviderService::where('service_model', $request->service_model)
                        ->where('service_number', strtolower($request->service_number))->whereNull('parent_id')->get([
                            'id'
                        ])
                        ->first();

                        if($serviceParent) {
                            $parent_id = $serviceParent->id;
                            $isChild = 1;
                        }

                        $providerService = ProviderService::create([
                            'provider_id' => $provider_id,
                            'service_type_id' => $vtype,
                            'status' => 'offline',
                            'service_number' => strtolower($request->service_number),
                            'service_model' => $request->service_model,
                            'service_weight_allowed_kg' => $request->vweight ? $request->vweight : 0,
                            'is_approved' => $isApproved,
                            'is_child' => $isChild,
                            'parent_id' => $parent_id
                        ]);

                        $newServiceType = ServiceType::where('id', $vtype)->pluck('name')->first();
                        array_push($newServiceNames, $newServiceType);
                        
                        if ($index == 0 && !$serviceParent) {
                            $parent_id = $providerService->id;
                        }
                    } else {
                        $reSync = 1;
                        $serviceType = ServiceType::where('id', $vtype)->pluck('name')->first();
                        array_push($serviceNames, $serviceType);
                    }


                    array_push($serviceTypesArray, $vtype);

                }
                if($reSync) {
                    return redirect()->route('admin.provider.document.index', $provider_id)->with('flash_info', translateKeyword('Provider service type re-synced'));
                } else {
                    return redirect()->route('admin.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider service type created'));
                }

            } else {
                // This is for allowing only one vehicle to be registered in one service
                $providerServiceCount = ProviderService::where('service_type_id', $request->service_type)
                    ->where('service_number', strtolower($request->service_number))
                    ->count();

                $isChild = 0;
                $parent_id = null;
                if ($providerServiceCount == 0) {

                        $providerService = ProviderService::create([
                            'provider_id' => $provider_id,
                            'service_type_id' => $request->service_type,
                            'status' => 'offline',
                            'service_number' => strtolower($request->service_number),
                            'service_model' => $request->service_model,
                            'service_weight_allowed_kg' => $request->vweight ? $request->vweight : 0,
                            'is_approved' => $isApproved,
                            'is_child' => $isChild,
                            'parent_id' => $parent_id
                        ]);
                        return redirect()->route('admin.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider service type created'));
                } else {
                    return redirect()->route('admin.provider.document.index', $provider_id)->with('flash_error', translateKeyword('Provider service type already created!'));
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
                    'expiry_date' => $request->expiry_date ? : null,
                ]);

                if ($vehicle_id == null) {
                    return redirect()->route('admin.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider document added successfully!'));
                } else {
                    return redirect()->route('admin.provider.document.index', $provider_id)->with(['flash_success' => translateKeyword('Provider document added successfully!'), 'vehicle_id' => $vehicle_id]);
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
                    'expiry_date' => $request->expiry_date ? : null,
                ]);


                if ($vehicle_id == null) {
                    return redirect()->route('admin.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider document added successfully!'));
                } else {
                    return redirect()->route('admin.provider.document.index', $provider_id)->with(['flash_success' => translateKeyword('Provider document added successfully!'), 'vehicle_id' => $vehicle_id]);
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

            return view('admin.providers.document.edit', compact('Document'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function service_edit($provider_id, $id)
    {
        try {
            $ServiceTypes = ServiceType::all();
            $Service = ProviderService::where('provider_id', $provider_id)
                ->findOrFail($id);

            return view('admin.providers.services.edit', compact('Service', 'ServiceTypes'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.provider.document.index', $provider_id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function service_update(Request $request, $provider_id, $id)
    {
        try {
            $Service = ProviderService::find($id);

            $checkServiceProivder = ProviderService::where([
                'provider_id' => $provider_id,
                'service_number' => $request->service_number,
                'service_type_id' => $request->service_type,
            ])->where('id', '!=', $id)->first();

            if(!is_null($checkServiceProivder)){
                return redirect()->back()->with('flash_error', 'This service type is already exists');
            }

            $Service->service_type_id = $request->service_type;
            // $Service->service_number = $request->service_number;
            // $Service->service_model = $request->service_model;
            // $Service->service_weight_allowed_kg = $request->service_weight_allowed_kg ?: 0;
            $Service->update();

            return redirect()->route('admin.provider.document.index', $Service->provider_id)->with('flash_success', translateKeyword('Provider service updated successfully!'));

        } catch (ModelNotFoundException $e) {
            return redirect()->back();
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
            $Document = ProviderDocument::with('document')->where('provider_id', $provider_id)
                ->findOrFail($id);
            $Document->update(['status' => 'ACTIVE']);

            (new SendPushNotification)->DocumentsVerfied($provider_id, $Document->document->name);

            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider document has been approved.'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.provider.document.index', $provider_id)
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
            
            $providerDoc = ProviderDocument::with('document')->where('id', $id)->first();

            (new SendPushNotification)->DocumentsDeleted($provider_id, $providerDoc->document->name);

            $Document = ProviderDocument::destroy($id);


            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider document has been deleted'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.provider.document.index', $provider_id)
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
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider service has been deleted.'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_error', translateKeyword('Provider service not found!'));
        }
    }
}
