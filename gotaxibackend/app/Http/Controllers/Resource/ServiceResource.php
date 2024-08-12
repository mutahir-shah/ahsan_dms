<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{Request, Response};
use App\Http\Controllers\{Controller, ServiceTypeController};
use App\Http\Requests\{StoreServiceRequest, UpdateServiceRequest};
use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\{ProviderService, ServiceType, Zones};
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use Exception;


class ServiceResource extends Controller
{
    protected $logService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::guard('admin')->id();
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.SERVICES'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.SERVICES'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.SERVICES'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.SERVICES'));

        $serviceTypeController = new ServiceTypeController();
        $types = $serviceTypeController->getActiveServicesTypes();

        if ($request->ajax()) {
            $types = [];

            $servicesList = ServiceType::whereIn('type', $types)
                ->when($data_permission != 1, function ($query) use ($user_id) {
                    return $query->where('created_by', $user_id);
                })
                ->get();


            if ($servicesList) {
                return $servicesList;
            } else {
                return [];
                // return response()->json(['error' => trans('api.services_not_found')], 500);
            }
        } else {
            $services = ServiceType::when($data_permission != 1, function ($query) use ($user_id) {
                return $query->where('created_by', $user_id);
            })
                ->get();

            return view('admin.service.index', get_defined_vars());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.SERVICES'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.SERVICES'));

        if ($add_permission == 0) {
            abort(401);
        }

        $user_id = Auth::guard('admin')->id();
        $zones = Zones::when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
            ->get();

        $types = [];
        $serviceTypeController = new ServiceTypeController();
        $types = $serviceTypeController->getActiveServicesTypesWithLanguage();

        return view('admin.service.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreServiceRequest $request)
    {
        try {
            // Validations For Apply After Pricings
            $this->checkApplyAfterValidations($request);
            // Get Default Names            
            list($firstLanguageNameKey, $firstLanguageDescriptionKey) = getDefaultNames();
            // Service Store
            $service = $request->all();
            $service['name'] = $request->{$firstLanguageNameKey};
            $service['description'] = $request->has($firstLanguageDescriptionKey) ? $request->{$firstLanguageDescriptionKey} : null;

            // Media Storage
            $service['image'] = $request->hasFile('image') ? storeFile($request->image): null;
            $service['map_icon'] = $request->hasFile('map_icon') ? storeFile($request->map_icon) : null;

            // Handling Zone Metering
            if(getSettings('zone_metering') == "1" && !empty($request->zones) && in_array("all", $request->zones)) {
                $zones = Zones::get(['id'])->pluck('id');
                $service['zones'] = serialize($zones);
            }else{
                $service['zones'] = serialize($request->zones);
            }

            // Storing Serivce Type
            $service = ServiceType::create($service);

            // Storing Multiple Serive Names
            storeMultipleDataRecords($request, $service);

            // Storing Log
            $this->logService->log('Services', 'create', 'Service Created.', $service);

            return back()->with('flash_success', translateKeyword('Service Type Saved Successfully'));
        } catch (Exception $e) {
            dd("Exception", $e);
            return back()->with('flash_error', translateKeyword('Service Type Not Found'));
        }
    }


    private function checkApplyAfterValidations($request){
        if (
            $request->has('apply_after_1') &&
            $request->has('apply_after_2') &&
            $request->has('apply_after_3') &&
            $request->has('apply_after_4')
        ) {
            if ($request->apply_after_1 != 0 && $request->apply_after_2 != 0 && $request->apply_after_3 != 0 && $request->apply_after_4 != 0) {
                if ($request->apply_after_2 != null && $request->apply_after_2 <= $request->apply_after_1) {
                    return back()->with('flash_error', translateKeyword('Apply after 2 should be greater than'));
                }

                if ($request->apply_after_3 != null && $request->apply_after_3 <= $request->apply_after_2) {
                    return back()->with('flash_error', translateKeyword('Apply after 3 should be greater than'));
                }

                if ($request->apply_after_4 != null && $request->apply_after_4 <= $request->apply_after_3) {
                    return back()->with('flash_error', translateKeyword('Apply after 3 should be greater than'));
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceType $serviceType
     * @return Response
     */
    public function show($id)
    {
        try {
            $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.SERVICES'));

            if ($add_permission == 0) {
                abort(401);
            }
            return ServiceType::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Service Type Not Found'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceType $serviceType
     * @return Response
     */
    public function edit($id)
    {
        try {
            $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.SERVICES'));
            $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.SERVICES'));
            $user_id = Auth::guard('admin')->id();
            if ($edit_permission == 0) {
                abort(401);
            }
            $zones = Zones::when($data_permission != 1, function ($query) use ($user_id) {
                return $query->where('created_by', $user_id);
            })
                ->get();
            $service = ServiceType::with('translations')->findOrFail($id);
            $types = [];

            $serviceTypeController = new ServiceTypeController();
            $types = $serviceTypeController->getActiveServicesTypesWithLanguage();

            return view('admin.service.edit', get_defined_vars());
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Service Type Not Found'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ServiceType $serviceType
     * @return Response
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        // return $request->all();


        try {

            if ($request->has('apply_after_1') && $request->has('apply_after_2') && $request->has('apply_after_3') && $request->has('apply_after_4')) {
                if ($request->apply_after_1 != 0 && $request->apply_after_2 != 0 && $request->apply_after_3 != 0 && $request->apply_after_4 != 0) {
                    if ($request->apply_after_2 != null && $request->apply_after_2 <= $request->apply_after_1) {
                        return back()->with('flash_error', translateKeyword('Apply after 2 should be greater than'));
                    }

                    if ($request->apply_after_3 != null && $request->apply_after_3 <= $request->apply_after_2) {
                        return back()->with('flash_error', translateKeyword('Apply after 3 should be greater than'));
                    }

                    if ($request->apply_after_4 != null && $request->apply_after_4 <= $request->apply_after_3) {
                        return back()->with('flash_error', translateKeyword('Apply after 3 should be greater than'));
                    }
                }
            }

            $languages = getLanguages();

            $firstLanguage = $languages->first();
            $firstLanguageNameKey = 'name_' . $firstLanguage->id;
            $firstLanguageDescriptionKey = 'description_' . $firstLanguage->id;

            $service = ServiceType::findOrFail($id);
            // $service->romanian_name = $request->romanian_name;
            // $service->romanian_description = $request->romanian_description;
            $service->name = $request->has($firstLanguageNameKey) ? $request->{$firstLanguageNameKey} : null;
            $service->description = $request->has($firstLanguageDescriptionKey) ? $request->{$firstLanguageDescriptionKey} : null;
            $service->type = $request->type;
            $service->updated_by = Auth::guard('admin')->id();
            // $service->provider_name = $request->provider_name;
            $service->capacity = $request->capacity;
            $service->fixed = $request->fixed ?: 0;
            $service->calculator = $request->calculator;
            $service->locked_pricing = $request->has('locked_pricing') ? 1 : 0;
            $service->is_free = $request->has('is_free') ? 1 : 0;
            $service->is_return_trip = $request->has('is_return_trip') ? 1 : 0;
            $service->booking_fee_type = $request->has('booking_fee_type') ? $request->booking_fee_type : null;
            $service->booking_fee_amount = $request->has('booking_fee_amount') && !is_null($request->booking_fee_amount) ? $request->booking_fee_amount : null;
            $service->commission_type = $request->has('commission_type') ? $request->commission_type : null;
            $service->commission_percentage = $request->has('commission_percentage') ? $request->commission_percentage : null;
            $service->peak1 = $request->has('peak1') ? 1 : 0;
            $service->peak2 = $request->has('peak2') ? 1 : 0;
            $service->peak3 = $request->has('peak3') ? 1 : 0;
            $service->tax_percentage = $request->has('tax_percentage') ? $request->tax_percentage : null;

            if ($request->hasFile('image')) {
                $image = $request->image->store('website');
                $image = asset('storage/' . $image);
                $service->image = $image;
            }

            if ($request->hasFile('map_icon')) {
                $map_icon = $request->map_icon->store('website');
                $map_icon = asset('storage/' . $map_icon);
                $service->map_icon = $map_icon;
            }

            $service->weight = $request->weight ? $request->weight : 0;

            if ($request->calculator != 'FIXED') {

                $service->apply_after_1 = $request->apply_after_1 ? $request->apply_after_1 : 0;
                $service->apply_after_2 = $request->apply_after_2 ? $request->apply_after_2 : 0;
                $service->apply_after_3 = $request->apply_after_3 ? $request->apply_after_3 : 0;
                $service->apply_after_4 = $request->apply_after_4 ? $request->apply_after_4 : 0;
                $service->after_1_price = $request->price ? $request->price : 0;
                $service->after_2_price = $request->after_2_price ? $request->after_2_price : 0;
                $service->after_3_price = $request->after_3_price ? $request->after_3_price : 0;
                $service->after_4_price = $request->after_4_price ? $request->after_4_price : 0;
                $service->return_trip_price_1 = $request->return_trip_price_1 ? $request->return_trip_price_1 : 0;
                $service->return_trip_price_2 = $request->return_trip_price_2 ? $request->return_trip_price_2 : 0;
                $service->return_trip_price_3 = $request->return_trip_price_3 ? $request->return_trip_price_3 : 0;
                $service->return_trip_price_4 = $request->return_trip_price_4 ? $request->return_trip_price_4 : 0;

                $service->price = $request->price ? $request->price : 0;
                $service->minute = $request->minute ? $request->minute : 0;
                $service->distance = $request->distance ? $request->distance : 0;

                $service->phourfrom = $request->phourfrom ? $request->phourfrom : null;
                $service->phourto = $request->phourto ? $request->phourto : null;
                $service->phourfromone = $request->phourfromone ? $request->phourfromone : null;
                $service->phourtoone = $request->phourtoone ? $request->phourtoone : null;
                $service->phourfromtwo = $request->phourfromtwo ? $request->phourfromtwo : null;
                $service->phourtotwo = $request->phourtotwo ? $request->phourtotwo : null;
                $service->pextra = $request->pextra ? $request->pextra : null;
                $service->pefixed = $request->pefixed ? $request->pefixed : null;

                $service->peak_apply_after_1 = $request->peak_apply_after_1 ? $request->peak_apply_after_1 : 0;
                $service->peak_apply_after_2 = $request->peak_apply_after_2 ? $request->peak_apply_after_2 : 0;
                $service->peak_apply_after_3 = $request->peak_apply_after_3 ? $request->peak_apply_after_3 : 0;
                $service->peak_apply_after_4 = $request->peak_apply_after_4 ? $request->peak_apply_after_4 : 0;
                $service->peak_after_1_price = $request->peak_after_1_price ? $request->peak_after_1_price : 0;
                $service->peak_after_2_price = $request->peak_after_2_price ? $request->peak_after_2_price : 0;
                $service->peak_after_3_price = $request->peak_after_3_price ? $request->peak_after_3_price : 0;
                $service->peak_after_4_price = $request->peak_after_4_price ? $request->peak_after_4_price : 0;
                $service->peak_return_trip_price_1 = $request->peak_return_trip_price_1 ? $request->peak_return_trip_price_1 : 0;
                $service->peak_return_trip_price_2 = $request->peak_return_trip_price_2 ? $request->peak_return_trip_price_2 : 0;
                $service->peak_return_trip_price_3 = $request->peak_return_trip_price_3 ? $request->peak_return_trip_price_3 : 0;
                $service->peak_return_trip_price_4 = $request->peak_return_trip_price_4 ? $request->peak_return_trip_price_4 : 0;

                $service->peak_percentage = $request->has('peak_percentage') ? 1 : 0;
                $service->peak_fixed_pricing = $request->has('peak_fixed_pricing') ? 1 : 0;
                $service->peak_pricing_structure_switch = $request->has('peak_pricing_structure_switch') ? 1 : 0;

                $service->peak_monday = $request->has('peak_monday') ? 1 : 0;
                $service->peak_tuesday = $request->has('peak_tuesday') ? 1 : 0;
                $service->peak_wednesday = $request->has('peak_wednesday') ? 1 : 0;
                $service->peak_thursday = $request->has('peak_thursday') ? 1 : 0;
                $service->peak_friday = $request->has('peak_friday') ? 1 : 0;
                $service->peak_saturday = $request->has('peak_saturday') ? 1 : 0;
                $service->peak_sunday = $request->has('peak_sunday') ? 1 : 0;
            }

            if (Setting::get('zone_metering', "0") == "1") {
                if (isset($request->zones) && $request->zones !== "" || $request->zones !== null) {
                    if (in_array("all", $request->zones)) {
                        $zones = Zones::get(['id'])->pluck('id');
                        $service->zones = serialize($zones);
                    } else {
                        $service->zones = serialize($request->zones);
                    }
                }
            }

            $service->save();

            foreach ($languages as $language) {
                $nameKey = 'name_' . $language->id;
                $descriptionKey = 'description_' . $language->id;

                $name = $request->has($nameKey) ? $request->{$nameKey} : null;
                $description = $request->has($descriptionKey) ? $request->{$descriptionKey} : null;

                if ($name || $description) {
                    $translation = $service->translations()->firstOrNew([
                        'language_id' => $language->id,
                    ]);

                    $translation->name = $name;
                    $translation->description = $description;
                    $translation->save();
                }
            }

            $updatedService = ServiceType::find($service->id);
            $this->logService->log('Services', 'update', 'Service Updated.', $updatedService);
            return redirect()->route('admin.service.index')->with('flash_success', translateKeyword('Service Type Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Service Type Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceType $serviceType
     * @return Response
     */
    public function destroy($id)
    {
        $serviceActivatedCount = ProviderService::where('service_type_id', $id)->count();
        try {
            if ($serviceActivatedCount == 0) {
                $service = ServiceType::find($id);
                $this->logService->log('Services', 'delete', 'Service Deleted.', $service);
                $service->translations()->delete();
                $service->delete();
                return back()->with('flash_success', translateKeyword('Service Type deleted successfully'));
            } else {
                return back()->with('flash_error', translateKeyword('Service Type Not Deleted'));
            }
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Service Type Not Found'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Service Type Not Found'));
        }
    }
}
