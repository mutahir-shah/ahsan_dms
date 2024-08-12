<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Resource\ServiceResource;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    protected $UserAPI;
    protected $logService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $UserAPI)
    {
        $this->middleware('auth');
        $this->UserAPI = $UserAPI;
    }


    /**
     * Ride Confirmation.
     *
     * @return Response
     */
    public function confirm_ride(Request $request)
    {
        $fare = (new UserApiController)->estimated_fare($request)->getData();
        $service = app(ServiceResource::class)->show($request->service_type);
        $cards = (new Resource\CardResource)->index();

        if ($request->has('current_longitude') && $request->has('current_latitude')) {
            User::where('id', Auth::user()->id)->update([
                'latitude' => $request->current_latitude,
                'longitude' => $request->current_longitude
            ]);
        }

        return view('user.ride.confirm_ride', compact('request', 'fare', 'service', 'cards'));
    }

    /**
     * Create Ride.
     *
     * @return Response
     */
    public function create_ride(Request $request)
    {
        return $this->UserAPI->send_request($request);
    }

    /**
     * Get Request Status Ride.
     *
     * @return Response
     */
    public function status()
    {
        return $this->UserAPI->request_status_check();
    }

    /**
     * Cancel Ride.
     *
     * @return Response
     */
    public function cancel_ride(Request $request)
    {
        return $this->UserAPI->cancel_request($request);
    }

    /**
     * Rate Ride.
     *
     * @return Response
     */
    public function rate(Request $request)
    {
        return $this->UserAPI->rate_provider($request);
    }
}
