<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\ZoneCharge;
use App\Zones;
use Illuminate\Http\Request;
use App\Services\LogService;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class ZoneChargeResource extends Controller
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
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::guard('admin')->id();
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.ALLZONECHARGES'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.ALLZONECHARGES'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.ALLZONECHARGES'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.ALLZONECHARGES'));

        $zoneCharges = ZoneCharge::when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();

        return view('admin.zone-charges.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.ALLZONECHARGES'));
        if($add_permission == 0){
            abort(401);
        }
        $user_id = Auth::guard('admin')->id();

        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.ALLZONECHARGES'));

        $zones = Zones::when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();
        return view('admin.zone-charges.create', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|unique:zone_charges',
            'zone_id' => 'required|exists:zones,id',
            'type' => 'required',
            'charge_type' => 'required',
            'charge_value' => 'required|numeric',
        ]);
        $request['created_by'] = Auth::guard('admin')->id();
        $zoneCharges = ZoneCharge::create($request->all());
        $this->logService->log('ZoneCharges', 'create', 'Zone Charges Created.', $zoneCharges);
        
        return redirect()->route('admin.zone-charges.index')->with('flash_success', translateKeyword('Zone Charge Saved Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.ALLZONECHARGES'));
        if($edit_permission == 0){
            abort(401);
        }
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.ALLZONECHARGES'));
        $user_id = Auth::guard('admin')->id();

        $zoneCharge = ZoneCharge::with('zone')->findOrFail($id);
        $zones = Zones::when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();

        
        return view('admin.zone-charges.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'name' => 'required|unique:zone_charges,name,' . $id,
            'zone_id' => 'required|exists:zones,id',
            'type' => 'required',
            'charge_type' => 'required',
            'charge_value' => 'required|numeric',
        ]);
        $request['updated_by'] = Auth::guard('admin')->id();
        ZoneCharge::where('id', $id)->update($request->all());

        $zoneCharges = ZoneCharge::find($id);
        $this->logService->log('ZoneCharges', 'update', 'Zone Charges Updated.', $zoneCharges);

        return redirect()->route('admin.zone-charges.index')->with('flash_success', translateKeyword('Zone Charge Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zoneCharges = ZoneCharge::find($id);
        $this->logService->log('ZoneCharges', 'delete', 'Zone Charges Deleted.', $zoneCharges);
        $zoneCharges->delete();
        return back()->with('message', translateKeyword('Zone Charge deleted successfully'));
    }
}
