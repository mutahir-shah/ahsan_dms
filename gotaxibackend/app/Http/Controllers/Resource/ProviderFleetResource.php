<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Provider;
use App\UserRequests;
use App\Helpers\Helper;
use App\Http\Controllers\SendPushNotification;
use App\ProviderDevice;
use App\ProviderService;
use App\PushNotificationLog;
use App\Zones;

class ProviderFleetResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $providers = Provider::with('service', 'accepted', 'cancelled', 'fleetData', 'zone')
            ->where('fleet', Auth::guard('fleet')->user()->id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('fleet.providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $zones = Zones::where('status', 'active')->get();

        return view('fleet.providers.create', compact('zones'));
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|unique:providers,email|email|max:255',
            // 'mobile' => 'required|unique:providers,mobile',
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:providers,mobile',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
            'fleet' => 'nullable',
            'zone_id' => 'nullable',
            'dob' => 'nullable',
            'address' => 'nullable',
        ]);

        try {

            $provider = $request->all();
            $provider['mobile'] = str_replace(' ', '', $request->mobile);
            $provider['password'] = bcrypt($request->password);
            $provider['fleet'] = Auth::guard('fleet')->user()->id;
            if ($request->hasFile('avatar')) {
                $provider['avatar'] = $request->avatar->store('provider/profile');
            }

            $provider = Provider::create($provider);

            return back()->with('flash_success', translateKeyword('Provider Details Saved Successfully'));

        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Provider $provider
     * @return Response
     */
    public function show($id)
    {
        try {
            $provider = Provider::findOrFail($id);
            return view('fleet.providers.provider-details', compact('provider'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Provider $provider
     * @return Response
     */
    public function edit($id)
    {
        try {
            $provider = Provider::findOrFail($id);
            $zones = Zones::where('status', 'active')->get();

            return view('fleet.providers.edit', compact('provider', 'zones'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Provider $provider
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->replace([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => str_replace(' ', '', $request->mobile),
            'zone_id' => $request->zone_id ?: 0,
            'dob' => $request->dob ?: null,
            'address' => $request->address ?: null,
        ]);

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:providers,mobile,' . $id,
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'zone_id' => 'nullable',
            'dob' => 'nullable',
            'address' => 'nullable',
        ]);

        try {

            $provider = Provider::findOrFail($id);

            if ($request->hasFile('avatar')) {
                if ($provider->avatar) {
                    Storage::delete($provider->avatar);
                }
                $provider->avatar = $request->avatar->store('provider/profile');
            }

            $provider->first_name = $request->first_name;
            $provider->last_name = $request->last_name;
            $provider->mobile = str_replace(' ', '', $request->mobile);
            $provider->save();

            return redirect()->route('fleet.provider.index')->with('flash_success', translateKeyword('Provider Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Provider::find($id)->delete();
            return back()->with('message', translateKeyword('Provider deleted successfully'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Provider Not Found'));
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
            // $vehicle->status = 'active';
            $vehicle->is_approved = 1;
            $vehicle->save();

            $provider = ProviderDevice::where('provider_id', $vehicle->provider_id)->with('provider')->first();

            if ($provider->token != "") {
                PushNotificationLog::firstOrCreate([
                    'title' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved",
                    'message' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved",
                    'receiver_id' => $vehicle->provider_id,
                    'app_type' => 'Driver',
                    'category' => 'General',
                ]);

                $request = (object)array("title" => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved", 'message' => "Your vehicle($vehicle->service_number - $vehicle->service_model) is approved");

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

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function approve($id)
    {
        try {
            $provider = Provider::findOrFail($id);
            if ($provider->service) {
                $provider->update(['status' => 'approved']);
                return back()->with('flash_success', translateKeyword('Provider Approved'));
            } else {
                return redirect()->route('fleet.provider.document.index', $id)->with('flash_error', translateKeyword('Provider has not been assigned a service type!'));
            }
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
    public function disapprove($id)
    {
        Provider::where('id', $id)->update(['status' => 'violation']);
        return back()->with('flash_success', translateKeyword('Provider Disapproved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function request($id)
    {

        try {

            $requests = UserRequests::where('user_requests.provider_id', $id)
                ->RequestHistory()
                ->get();

            return view('fleet.request.index', compact('requests'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }
}
