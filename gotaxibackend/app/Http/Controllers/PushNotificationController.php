<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\PushNotificationLog;
use App\ProviderDevice;
use App\Services\LogService;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{
    protected $logService;
    protected $user_id;

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
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.PUSHNOTIFICATIONS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.PUSHNOTIFICATIONS'));
       
        $driverPushNotifications = PushNotificationLog::where('app_type', 'Driver')
        ->when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->orderBy('id', 'DESC')
        ->get(['title', 'message'])
        ->unique('title');

        $userPushNotifications = PushNotificationLog::where('app_type', 'User')
        ->when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->orderBy('id', 'DESC')
        ->get(['title', 'message'])
        ->unique('title');

        
        return view('admin.push', get_defined_vars());
    }

    public function push_user($id)
    {
        try {
            return view('admin.pushuser', compact('id'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

     public function push_provider($id)
    {
        try {
            return view('admin.pushprovider', compact('id'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

     public function push_specific_user(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|max:255',
                'message' => 'required|max:255',
            ]);

            $user = User::findOrFail($request->id);
            $user_id = Auth::guard('admin')->id();
            if ($user->device_token != "") {
                $pushData = PushNotificationLog::create([
                    'title' => $request->title,
                    'message' => $request->has('message') ? $request->message : '',
                    'receiver_id' => $user->id,
                    'app_type' => 'User',
                    'category' => 'General',
                    'created_by' => $user_id
                ]);
                $this->logService->log('Push Notification', 'create', 'Push Notification Sent To Rider.', $pushData);
                (new SendPushNotification)->user_push($request, $user->device_token);
            }

            return back()->with('flash_success', translateKeyword('Push Notification Sent'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    public function push_specific_provider(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|max:255',
                'message' => 'required|max:255',
            ]);

            $provider_id = $request->id;
            $providerDevices = ProviderDevice::where('provider_id', $provider_id)->get();
            $user_id = Auth::guard('admin')->id();
            foreach ($providerDevices as $providerDevice) {
                if ($providerDevice->token != "") {
                    $data = PushNotificationLog::create([
                        'title' => $request->title,
                        'message' => $request->has('message') ? $request->message : '',
                        'receiver_id' => $provider_id,
                        'app_type' => 'Driver',
                        'category' => 'General',
                        'created_by' => $user_id
                    ]);
                    $this->logService->log('Push Notification', 'create', 'Push Notification Sent To Provider.', '', $data);
                    (new SendPushNotification)->driver_push($request, $providerDevice->token);
                }
            }

            return back()->with('flash_success', translateKeyword('Push Notification Sent'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }


    public function user_push(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'message' => 'required|max:255',
        ]);

        $users = User::get();
        $user_id = Auth::guard('admin')->id();
        foreach ($users as $user) {
            $data = PushNotificationLog::firstOrCreate([
                'title' => $request->title,
                'message' => $request->message,
                'receiver_id' => $user->id,
                'app_type' => 'User',
                'category' => 'General',
                'created_by' => $user_id
            ]);
            $this->logService->log('Push Notification', 'create', 'Push Notification Sent To User.', '', $data);

        }

        (new SendPushNotification)->user_push($request);

        return back()->with('flash_success', translateKeyword('Push Notification to Users'));
    }

    public function driver_push(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'message' => 'required|max:255',
        ]);

        $drivers = ProviderDevice::get();
        $user_id = Auth::guard('admin')->id();
        foreach ($drivers as $driver) {
            $data = PushNotificationLog::firstOrCreate([
                'title' => $request->title,
                'message' => $request->message,
                'receiver_id' => $driver->provider_id,
                'app_type' => 'Driver',
                'category' => 'General',
                'created_by' => $user_id
            ]);
            $this->logService->log('Push Notification', 'create', 'Push Notification Sent To Driver.', $data);
        }


        (new SendPushNotification)->driver_push($request);

        return back()->with('flash_success', translateKeyword('Push Notification to Drivers'));
    }
}
