<?php

namespace App\Http\Controllers\Resource;

use App\Fleet;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Exception;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Http\Response;
use Storage;
use App\Zones;

class FleetResource extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => ['update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $fleets = Fleet::orderBy('created_at', 'desc')->get();
        return view('admin.fleet.index', compact('fleets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $zones = Zones::where('status', 'active')->get();

        return view('admin.fleet.create', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'company' => 'required|max:255',
            'address' => 'nullable',
            'nif' => 'nullable',
            'email' => 'required|unique:fleets,email|email|max:255',
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:fleets,mobile',
            'logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
            'zone_id' => 'nullable'
        ]);

        try {

            $fleet = $request->all();
            $fleet['password'] = bcrypt($request->password);
            if ($request->hasFile('logo')) {
                $fleet['logo'] = $request->logo->store('fleet');
            }

            $fleet = Fleet::create($fleet);

            return back()->with('flash_success', translateKeyword('Fleet Details Saved Successfully'));

        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Fleet Not Found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Fleet $fleet
     * @return Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Fleet $fleet
     * @return Response
     */
    public function edit($id)
    {
        try {
            $fleet = Fleet::findOrFail($id);
            $zones = Zones::where('status', 'active')->get();

            return view('admin.fleet.edit', compact('fleet', 'zones'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Fleet $fleet
     * @return Response
     */
    public function update(Request $request, $id)
    {


        try {

            $fleet = Fleet::findOrFail($id);

            $this->validate($request, [
                'name' => 'required|max:255',
                'company' => 'required|max:255',
                'address' => 'nullable',
                'nif' => 'nullable',
                'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:fleets,mobile,' . $fleet->id,
                'logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
                'zone_id' => 'nullable'
            ]);

            if ($request->hasFile('logo')) {
                Storage::delete($fleet->logo);
                $fleet->logo = $request->logo->store('fleet');
            }

            $fleet->name = $request->name;
            $fleet->company = $request->company;
            $fleet->address = $request->address;
            $fleet->nif = $request->nif;
            $fleet->zone_id = $request->zone_id;
            $fleet->mobile = str_replace(' ', '', $request->mobile);
            $fleet->save();

            return redirect()->route('admin.fleet.index')->with('flash_success', translateKeyword('Fleet Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Fleet Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Fleet $Fleet
     * @return Response
     */
    public function destroy($id)
    {

        try {
            Fleet::find($id)->delete();
            return back()->with('message', translateKeyword('Fleet deleted successfully'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Fleet Not Found'));
        }
    }

}
