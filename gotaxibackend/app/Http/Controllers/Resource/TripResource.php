<?php

namespace App\Http\Controllers\Resource;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserRequests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use anlutro\LaravelSettings\Facade as Setting;
use App\Services\LogService;
use App\Helpers\Helper;

class TripResource extends Controller
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
    public function index()
    {
        try {
            $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.PASTHISTORY'));
            $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.PASTHISTORY'));
            if($view_permission == 0){
                abort(401);
            }
            $requests = UserRequests::RequestHistory()->orderBy('id', 'DESC')->get();
            // dd($requests);
            return view('admin.request.index', get_defined_vars());
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function Fleetindex()
    {
        try {
            $requests = UserRequests::RequestHistory()
                ->whereHas('provider', function ($query) {
                    $query->where('fleet', Auth::guard('fleet')->user()->id);
                })->orderBy('id', 'DESC')->get();
            return view('fleet.request.index', compact('requests'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function scheduled()
    {
        try {
            $requests = UserRequests::where('status', 'SCHEDULED')
                ->RequestHistory()
                ->get();

            return view('admin.request.scheduled', compact('requests'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function Fleetscheduled()
    {
        try {
            $requests = UserRequests::where('status', 'SCHEDULED')
                ->whereHas('provider', function ($query) {
                    $query->where('fleet', Auth::guard('fleet')->user()->id);
                })
                ->get();

            return view('fleet.request.scheduled', compact('requests'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
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
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $request = UserRequests::with(['rating', 'userReportImages','driverReportImages'])->findOrFail($id);
            return view('admin.request.show', compact('request'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function Fleetshow($id)
    {
        try {
            $request = UserRequests::with(['rating'])->findOrFail($id);
            return view('fleet.request.show', compact('request'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function Accountshow($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            return view('account.request.show', compact('request'));
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $userRequest = UserRequests::findOrFail($id);
            $this->logService->log('PastHistory', 'delete', 'Past History Deleted.', $userRequest);
            $userRequest->delete();
            return back()->with('flash_success', 'Request Deleted!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function Fleetdestroy($id)
    {
        try {
            $userRequest = UserRequests::findOrFail($id);
            $userRequest->delete();
            return back()->with('flash_success', 'Request Deleted!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
}
