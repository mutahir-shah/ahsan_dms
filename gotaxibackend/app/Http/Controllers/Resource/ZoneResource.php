<?php

namespace App\Http\Controllers\Resource;

use App\Document;
use App\Zones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use anlutro\LaravelSettings\Facade as Setting;
use App\City;
use App\Country;
use App\ServiceType;
use App\State;
use App\ZoneService;
use App\Services\LogService;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class ZoneResource extends Controller
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
        $this->middleware('demo', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::guard('admin')->id();
        $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.ALLZONES'));
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.ALLZONES'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.ALLZONES'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.ALLZONES'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.ALLZONES'));
        
        $zones = Zones::orderBy('created_at', 'desc')
        ->when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();


        return view('admin.zone.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.ALLZONES'));
        if($add_permission == 0){
            abort(404);
        }
        $all_zones = $this->makeZoesArray();
        $countries = Country::with('states')->get();

        return view('admin.zone.create', compact('all_zones', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {   
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.ALLZONES'));
        if($add_permission == 0){
            abort(404);
        }

        $this->validate($request, [
            'name' => 'required',
            'coordinate' => 'required',
        ]);

        try {

            $json = array();
            $id = 0;

            if ($request->country) {
                $country = Country::find($request->country, ['name']);
                $country_name = $country->name;
            } else {
                $country_name = 'N/A';
            }

            if ($request->state) {
                $state = State::find($request->state, ['name']);
                $state_name = $state->name;
            } else {
                $state_name = 'N/A';
            }

            if ($request->city) {
                $city = City::find($request->city, ['name']);
                $city_name = $city->name;
            } else {
                $city_name = 'N/A';
            }

            if ($request->id > 0) {
                $zone = Zones::where('id', $request->id)->first();
                if ($zone) {
                    $zone->name = $request->name;
                    $zone->country = $country_name;
                    $zone->state = $state_name;
                    $zone->city = $city_name;
                    $zone->status = $request->status;
                    $zone->currency = $request->currency;
                    $zone->coordinate = serialize($request->coordinate);
                    $zone->updated_by = Auth::guard('admin')->id();
                    $zone->save();

                    $id = $zone;

                }

            } else {

                $zone = new Zones;
                $zone->name = $request->name;
                $zone->country = $country_name;
                $zone->state = $state_name;
                $zone->city = $city_name;
                $zone->status = $request->status;
                $zone->currency = $request->currency;
                $zone->coordinate = serialize($request->coordinate);
                $zone->created_by = Auth::guard('admin')->id();
                $zone->save();
                $id = $zone;
                $this->logService->log('Zones', 'create', 'Zone Created.', $zone);

            }

            $json['status'] = $id;
            return response()->json($json);

        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()]);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Document $providerDocument
     * @return Response
     */
    public function edit($id)
    {
        try {

            $zone = Zones::findOrFail($id);
            $zone->coordinate = $this->makeCoordinate($zone->coordinate);

            $all_zones = $this->makeZoesArray();


            return view('admin.zone.create', compact('zone', 'all_zones'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.zone.index')->with('flash_error', 'No result found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Document $providerDocument
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {

            return view('admin.zone.create');

        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Zone Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Document $providerDocument
     * @return Response
     */
    public function destroy($id)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        try {
            $zone = Zones::find($id);
            $this->logService->log('Zones', 'delete', 'Zone Deleted.', $zone);
            $zone->delete();
            ZoneService::where('zone_id', $id)->delete();

            if (!$zone) {
                return back()->with('flash_error', translateKeyword('Zone Not Found'));
            }

            // $provider_zones = DB::table('zones')->where('id', $zone->id)->get()->pluck('id')->toArray();

            // if ($provider_zones) {

            //     DB::table('zones')->whereIn('id', $provider_zones)->delete();

            // }

            return back()->with('flash_success', translateKeyword('Zone deleted successfully'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('Zone Not Found'));
        }
    }


    public function makeZoesArray()
    {
        $all_zones = [];
        $zones_obj = Zones::orderBy('created_at', 'desc')->get();
        if ($zones_obj) {
            foreach ($zones_obj as $zone) {
                $all_zones[] = ['id' => $zone->id, 'name' => $zone->name, 'latlng' => $this->makeCoordinate($zone->coordinate)];
            }
        }

        return $all_zones;

    }

    public function makeCoordinate($path)
    {
        $new_coordiante = array();
        $coordinate = unserialize($path);
        foreach ($coordinate as $coord) {
            $new_coordiante[] = $this->makeLatlng($coord);
        }

        return $new_coordiante;

    }

    public function makeLatlng($coord)
    {
        $path = explode(',', $coord);
        $latlng['lat'] = $path[0];
        $latlng['lng'] = $path[1];

        return $latlng;


    }

    public function getCountry()
    {
        return $country = Country::get();
    }

    public function getState(Request $request)
    {

        return State::where('country_id', $request->country_id)->get();
    }

    public function getCity(Request $request)
    {

        return City::where('state_id', $request->state_id)->get();
    }

    public function attachService($zone_id)
    {
        $services = ServiceType::all();
        $zoneServices = ZoneService::where('zone_id', $zone_id)->get(['service_id'])->pluck('service_id')->toArray();

        return view('admin.zone.attach', compact('services', 'zone_id', 'zoneServices'));
    }

    public function attachServiceStore(Request $request)
    {
        if (is_array($request->services) && ($request->services !== "" || $request->services !== null)) {
            if (in_array("all", $request->services)) {
                $services = ServiceType::get(['id'])->pluck('id');
                foreach ($services as $service) {
                    $serviceData = ServiceType::where('id', $service)->get()->first();
                    ZoneService::firstOrCreate(
                        [
                            'zone_id' => $request->zone_id,
                            'service_id' => $service,
                            // 'zones' => $serviceData->zones,
                            'name' => $serviceData->name,
                            'type' => $serviceData->type,
                            'image' => $serviceData->image,
                            'map_icon' => $serviceData->map_icon,
                            'price' => $serviceData->price,
                            'fixed' => $serviceData->fixed,
                            'description' => $serviceData->description,
                            'status' => $serviceData->status,
                            'minute' => $serviceData->minute,
                            'distance' => $serviceData->distance,
                            'calculator' => $serviceData->calculator,
                            'capacity' => $serviceData->capacity,
                            'phourfrom' => $serviceData->phourfrom,
                            'phourto' => $serviceData->phourto,
                            'pextra' => $serviceData->pextra,
                            'locked_pricing' => $serviceData->locked_pricing,
                            'apply_after_1' => $serviceData->apply_after_1,
                            'apply_after_2' => $serviceData->apply_after_2,
                            'apply_after_3' => $serviceData->apply_after_3,
                            'apply_after_4' => $serviceData->apply_after_4,
                            'after_2_price' => $serviceData->after_2_price,
                            'after_3_price' => $serviceData->after_3_price,
                            'after_4_price' => $serviceData->after_4_price,
                            'peak_apply_after_1' => $serviceData->peak_apply_after_1,
                            'peak_apply_after_2' => $serviceData->peak_apply_after_2,
                            'peak_apply_after_3' => $serviceData->peak_apply_after_3,
                            'peak_apply_after_4' => $serviceData->peak_apply_after_4,
                            'peak_after_1_price' => $serviceData->peak_after_1_price,
                            'peak_after_2_price' => $serviceData->peak_after_2_price,
                            'peak_after_3_price' => $serviceData->peak_after_3_price,
                            'peak_after_4_price' => $serviceData->peak_after_4_price,
                            'peak_monday' => $serviceData->peak_monday,
                            'peak_tuesday' => $serviceData->peak_tuesday,
                            'peak_wednesday' => $serviceData->peak_wednesday,
                            'peak_thursday' => $serviceData->peak_thursday,
                            'peak_friday' => $serviceData->peak_friday,
                            'peak_saturday' => $serviceData->peak_saturday,
                            'peak_sunday' => $serviceData->peak_sunday,
                        ]
                    );
                }
            } else if (in_array("", $request->services)) {
                ZoneService::where('zone_id', $request->zone_id)->delete();
            } else {
                foreach ($request->services as $service) {
                    $serviceData = ServiceType::where('id', $service)->get()->first();
                    ZoneService::firstOrCreate(
                        [
                            'zone_id' => $request->zone_id,
                            'service_id' => $service,
                            // 'zones' => $serviceData->zones,
                            'name' => $serviceData->name,
                            'type' => $serviceData->type,
                            'image' => $serviceData->image,
                            'map_icon' => $serviceData->map_icon,
                            'price' => $serviceData->price,
                            'fixed' => $serviceData->fixed,
                            'description' => $serviceData->description,
                            'status' => $serviceData->status,
                            'minute' => $serviceData->minute,
                            'distance' => $serviceData->distance,
                            'calculator' => $serviceData->calculator,
                            'capacity' => $serviceData->capacity,
                            'phourfrom' => $serviceData->phourfrom,
                            'phourto' => $serviceData->phourto,
                            'pextra' => $serviceData->pextra,
                            'locked_pricing' => $serviceData->locked_pricing,
                            'apply_after_1' => $serviceData->apply_after_1,
                            'apply_after_2' => $serviceData->apply_after_2,
                            'apply_after_3' => $serviceData->apply_after_3,
                            'apply_after_4' => $serviceData->apply_after_4,
                            'after_2_price' => $serviceData->after_2_price,
                            'after_3_price' => $serviceData->after_3_price,
                            'after_4_price' => $serviceData->after_4_price,
                            'peak_apply_after_1' => $serviceData->peak_apply_after_1,
                            'peak_apply_after_2' => $serviceData->peak_apply_after_2,
                            'peak_apply_after_3' => $serviceData->peak_apply_after_3,
                            'peak_apply_after_4' => $serviceData->peak_apply_after_4,
                            'peak_after_1_price' => $serviceData->peak_after_1_price,
                            'peak_after_2_price' => $serviceData->peak_after_2_price,
                            'peak_after_3_price' => $serviceData->peak_after_3_price,
                            'peak_after_4_price' => $serviceData->peak_after_4_price,
                            'peak_monday' => $serviceData->peak_monday,
                            'peak_tuesday' => $serviceData->peak_tuesday,
                            'peak_wednesday' => $serviceData->peak_wednesday,
                            'peak_thursday' => $serviceData->peak_thursday,
                            'peak_friday' => $serviceData->peak_friday,
                            'peak_saturday' => $serviceData->peak_saturday,
                            'peak_sunday' => $serviceData->peak_sunday,
                        ]
                    );
                }
            }
        }

        return back()->with('flash_success', translateKeyword('Zone attached successfully'));
    }

}
