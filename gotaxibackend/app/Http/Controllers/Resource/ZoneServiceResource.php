<?php

namespace App\Http\Controllers\Resource;

use App\Document;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use anlutro\LaravelSettings\Facade as Setting;
use Exception;
use App\Helpers\Helper;
use App\Provider;
use App\ProviderService;
use App\ZoneService;
use App\Zones;
use Illuminate\Http\Response;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;

class ZoneServiceResource extends Controller
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
        $this->middleware('demo', ['only' => ['update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::guard('admin')->id();
        $view_permission = Helper::CheckPermission(config('const.EDIT'), config('const.ZONESERVICES'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.ZONESERVICES'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.ZONESERVICES'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.ZONESERVICES'));

        $services = ZoneService::with('service', 'zone')->get();
        if ($request->ajax()) {
            return $services;
        } else {
            return view('admin.zone.service.index', compact('services'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ZoneService $serviceType
     * @return Response
     */
    public function edit($id)
    {
        try {
            $zones = Zones::all();
            $service = ZoneService::findOrFail($id);
            return view('admin.zone.service.edit', compact('service', 'zones'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Zone Service Pricing Not Found'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ZoneService $serviceType
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fixed' => 'required|numeric',
            'minute' => 'nullable|numeric',
            'apply_after_1' => 'nullable|numeric',
            'apply_after_2' => 'nullable|numeric',
            'apply_after_3' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'after_2_price' => 'nullable|numeric',
            'after_3_price' => 'nullable|numeric',
            'image' => 'mimes:ico,png'
        ]);

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

            $service = ZoneService::findOrFail($id);

            $service->capacity = $request->capacity;
            $service->fixed = $request->fixed;
            $service->calculator = $request->calculator;
            $service->description = $request->description;
            $service->type = $request->type;
            $service->locked_pricing = $request->has('locked_pricing') ? 1 : 0;
            $service->is_free = $request->has('is_free') ? 1 : 0;
            $service->commission_type = $request->has('commission_type') ? $request->commission_type : null;
            $service->commission_percentage = $request->has('commission_percentage') ? $request->commission_percentage : null;
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

                $service->price = $request->price ? $request->price : 0;
                $service->minute = $request->minute ? $request->minute : 0;
                $service->distance = $request->distance ? $request->distance : 0;

                $service->phourfrom = $request->phourfrom;
                $service->phourto = $request->phourto;
                $service->pextra = $request->pextra;

                $service->peak_apply_after_1 = $request->peak_apply_after_1 ? $request->peak_apply_after_1 : 0;
                $service->peak_apply_after_2 = $request->peak_apply_after_2 ? $request->peak_apply_after_2 : 0;
                $service->peak_apply_after_3 = $request->peak_apply_after_3 ? $request->peak_apply_after_3 : 0;
                $service->peak_apply_after_4 = $request->peak_apply_after_4 ? $request->peak_apply_after_4 : 0;
                $service->peak_after_1_price = $request->peak_after_1_price ? $request->peak_after_1_price : 0;
                $service->peak_after_2_price = $request->peak_after_2_price ? $request->peak_after_2_price : 0;
                $service->peak_after_3_price = $request->peak_after_3_price ? $request->peak_after_3_price : 0;
                $service->peak_after_4_price = $request->peak_after_4_price ? $request->peak_after_4_price : 0;


                $service->peak_percentage = $request->has('peak_percentage') ? 1 : 0;
                $service->peak_fixed_pricing = $request->has('peak_fixed_pricing') ? 1 : 0;

                $service->peak_monday = $request->has('peak_monday') ? 1 : 0;
                $service->peak_tuesday = $request->has('peak_tuesday') ? 1 : 0;
                $service->peak_wednesday = $request->has('peak_wednesday') ? 1 : 0;
                $service->peak_thursday = $request->has('peak_thursday') ? 1 : 0;
                $service->peak_friday = $request->has('peak_friday') ? 1 : 0;
                $service->peak_saturday = $request->has('peak_saturday') ? 1 : 0;
                $service->peak_sunday = $request->has('peak_sunday') ? 1 : 0;

            }

            // if ($request->zones !== "" ) {
            //     if (in_array("all", $request->zones)) {
            //         $zones = Zones::get(['id'])->pluck('id')->toArray();
            //         $service->zones = serialize($zones);
            //     } else {
            //         $service->zones = serialize($request->zones);
            //     }
            // }

            $service->save();

            return redirect()->route('admin.zone-service.index')->with('flash_success', translateKeyword('Zone Service Pricing Updated'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Zone Service Pricing Not Found'));
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

            $zone = ZoneService::where('id', $id)->first();

            if (!$zone) {
                return back()->with('flash_error', translateKeyword('Zone service Not Found'));
            }

            $zone->delete();

            return back()->with('flash_success', translateKeyword('Zone service deleted'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('Zone service Not Found'));
        }
    }
}