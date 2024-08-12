<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\ProviderDevice;

use Exception;

use Log;

use anlutro\LaravelSettings\Facade as Setting;
use App\PushNotificationLog;

class SendPushNotification extends Controller

{

    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */

    public function RideAccepted($request)
    {

        return $this->sendPushToUser($request->user_id, trans('api.push.request_accepted'));
    }


    // provider changed
    public function provider_changed_to_provider($provider_id)
    {
        return $this->sendPushToProvider($provider_id, trans('api.push.provider_changed'));
    }

    public function provider_changed_to_user($user_id)
    {
        return $this->sendPushToUser($user_id, trans('api.push.provider_changed'));
    }

    public function driver_job_declined($user_id)
    {
        return $this->sendPushToUser($user_id, trans('api.push.provider_declined'));
    }

    // 

    /**
     * Offer Accepted by a user.
     *
     * @return void
     */

    public function OfferAccepted($request)
    {

        return $this->sendPushToProvider($request->provider_id, trans('api.push.offer_accepted'));
    }

    /**
     * Driver Arrived at your location.
     *
     * @return void
     */

    public function user_schedule($user)
    {

        return $this->sendPushToUser($user, trans('api.push.schedule_start'));
    }

    /**
     * Driver Arrived at your location.
     *
     * @return void
     */

    public function points_earned($user, $points = 0, $update = false)
    {
        $message = $update == true ? 'Your reward points are ' . $points . ' now.' : 'You have been awarded with ' . $points . ' reward points.';

        return $this->sendPushToUser($user, $message);
    }

    /**
     * Driver tip.
     *
     * @return void
     */


    public function driver_tip($provider, $amount)
    {
        $message = 'Your have been given a tip amount of ' . $amount;

        return $this->sendPushToProvider($provider, $message);
    }

    /**
     * New Incoming request
     *
     * @return void
     */

    public function provider_schedule($provider)
    {

        return $this->sendPushToProvider($provider, trans('api.push.schedule_start'));
    }

    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */

    public function driver_push($request, $provider_fcm = null)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $msg = $request->message;
        $title = $request->title;

        $notificationData = [
            "title" => $title,
            'message' => $msg,
            "body" => $msg,
            'sound' => true
        ];

        $androidData['notification']['title'] = $title;
        $androidData['notification']['body'] = $msg;

        $iOSData['aps']['title'] = $title;
        $iOSData['aps']['body'] = $msg;

        if ($provider_fcm != null) {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => $provider_fcm, //single token
                'notification' => $notificationData,
                'data' => $notificationData,
                // 'android' => $androidData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];
        } else {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => '/topics/driver', //single token
                'notification' => $notificationData,
                'data' => $notificationData,
                // 'android' => $androidData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];
        }

        $headers = [
            'Authorization: key=' . Setting::get('android_user_driver_key'),
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);

        // PushNotificationLog::firstOrCreate([
        //     'title' => 'Payload' , 'message' => $fcmNotification, 'receiver_id' => 0, 'app_type' => 'Driver', 'category' => 'Job'
        // ]);

        // PushNotificationLog::firstOrCreate([
        //     'title' => $provider_fcm == "" ? 'N/A' : $fcmNotification , 'message' => $result, 'receiver_id' => 0, 'app_type' => 'Driver', 'category' => 'Job'
        // ]);

        return curl_close($ch);
    }

    public function user_push($request, $user_fcm = null)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $msg = $request->message;
        $title = $request->title;

        $notificationData = [
            "title" => $title,
            'message' => $msg,
            "body" => $msg,
            'sound' => true
        ];

        $androidData['notification']['title'] = $title;
        $androidData['notification']['body'] = $msg;

        $iOSData['aps']['title'] = $title;
        $iOSData['aps']['body'] = $msg;

        if ($user_fcm != null) {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => $user_fcm, //single token
                'notification' => $notificationData,
                'data' => $notificationData,
                // 'android' => $androidData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];
        } else {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => '/topics/user', //single token
                'notification' => $notificationData,
                'data' => $notificationData,
                // 'android' => $androidData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];
        }

        $headers = [
            'Authorization: key=' . Setting::get('android_user_fcm_key'),
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        return curl_close($ch);
    }

    public function UserCancellRide($request)
    {

        return $this->sendPushToProvider($request->provider_id, trans('api.push.user_cancelled'));
    }

    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */

    public function ProviderCancellRide($request)
    {

        return $this->sendPushToUser($request->user_id, trans('api.push.provider_cancelled'));
    }

    /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */

     public function UserCancelAmount($request, $amount, $type)
     {
 
         return $this->sendPushToUser($request->user_id, trans('api.push.cancel_user_amount', ['amount' => trans('currency.' . Setting::get('currency')) . $amount, 'type' => $type]));
     }

     /**
     * New Ride Accepted by a Driver.
     *
     * @return void
     */

     public function ProviderCancelAmount($request, $amount)
     {
         return $this->sendPushToProvider($request->provider_id, trans('api.push.cancel_provider_amount', ['amount' => trans('currency.' . Setting::get('currency')) . $amount]));
     }

     

    /**
     * Driver Arrived at your location.
     *
     * @return void
     */

    public function Arrived($request)
    {

        return $this->sendPushToUser($request->user_id, trans('api.push.arrived'));
    }

    /**
     * Driver Arrived at your location.
     *
     * @return void
     */

    public function Dropped($request)
    {
        $url = url('/');
        if(!str_contains($url, 'paxiapp.us')) {
            return $this->sendPushToUser($request->user_id, trans('api.push.dropped') . ' ' . trans('currency.' . Setting::get('currency')) . $request->payment->total);
        }
    }

    /**
     * Money added to user wallet.
     *
     * @return void
     */

    public function ProviderNotAvailable($user_id)
    {

        return $this->sendPushToUser($user_id, trans('api.push.provider_not_available'));
    }

    /**
     * New Incoming request
     *
     * @return void
     */

    public function IncomingRequest($provider, $data)
    {
        // PushNotificationLog::firstOrCreate([
        //     'title' => 'Job Request: '. $data->id, 'message' => 'This is a job request push notification', 'receiver_id' => $provider, 'app_type' => 'Driver', 'category' => 'Job'
        // ]);
        return $this->sendPushToProvider($provider, trans('api.push.incoming_request'), $data, 'job_request');
    }

    /**
     * New Incoming request
     *
     * @return void
     */

     public function IncomingRequestClear($provider)
     {
        //  PushNotificationLog::firstOrCreate([
        //      'title' => 'Job Request Accepted ', 'message' => 'This is a job request accepted push notification', 'receiver_id' => $provider, 'app_type' => 'Driver', 'category' => 'Job'
        //  ]);
         return $this->sendPushToProvider($provider, trans('api.push.incoming_request_accepted'), null, 'job_accepted');
     }

    /**
     * New Incoming request
     *
     * @return void
     */

    public function WithdrawalRequest($provider)
    {

        return $this->sendPushToProvider($provider, 'Withdrawal request approved');
    }

    /**
     * Driver Documents verfied.
     *
     * @return void
     */

    public function DocumentsVerfied($provider_id, $doc_name)
    {
        return $this->sendPushToProvider($provider_id, trans('api.push.document_verfied', ['document_name' => $doc_name]));
    }

    /**
     * Driver Documents verfied.
     *
     * @return void
     */

    public function DocumentsDeleted($provider_id, $doc_name)
    {
        return $this->sendPushToProvider($provider_id, trans('api.push.document_deleted', ['document_name' => $doc_name]));
    }

    /**
     * Money added to user wallet.
     *
     * @return void
     */

    public function WalletMoney($user_id, $money)
    {

        return $this->sendPushToUser($user_id, currency($money) . ' ' . trans('api.push.added_money_to_wallet'));
    }

    /**
     * Money added to user wallet.
     *
     * @return void
     */

    public function WalletMoneyDriver($provider_id, $money)
    {

        return $this->sendPushToProvider($provider_id, currency($money) . ' ' . trans('api.push.added_money_to_wallet'));
    }

    /**
     * Money added to user wallet.
     *
     * @return void
     */

     public function WalletMoneyDeducted($user_id, $money)
     {
 
         return $this->sendPushToUser($user_id, currency($money) . ' ' . trans('api.push.deducted_money_from_wallet'));
     }

      /**
     * Money added to user wallet.
     *
     * @return void
     */

    public function ProviderWalletMoney($provider_id, $money)
    {

        return $this->sendPushToProvider($provider_id, currency($money) . ' ' . trans('api.push.added_money_to_wallet'));
    }

    /**
     * Money added to user wallet.
     *
     * @return void
     */

     public function ProviderWalletMoneyDeducted($provider_id, $money)
     {
 
         return $this->sendPushToProvider($provider_id, currency($money) . ' ' . trans('api.push.deducted_money_from_wallet'));
     }

    /**
     * Money added to user wallet.
     *
     * @return void
     */

    public function WalletMoneyReceived($user_id, $money)
    {

        return $this->sendPushToUser($user_id, currency($money) . ' has been added to your wallet');
    }

    /**
     * Money charged from user wallet.
     *
     * @return void
     */

    public function ChargedWalletMoney($user_id, $money)
    {

        return $this->sendPushToUser($user_id, currency($money) . ' ' . trans('api.push.charged_from_wallet'));
    }

    /**
     * Sending Push to a user Device.
     *
     * @return void
     */

    public function sendPushToUser($user_id, $push_message, $data = null)
    {

        try {

            $user = User::findOrFail($user_id);

            if ($user->device_token != "") {

                if ($user->device_type == 'android') {

                    return $this->sendToUser($user->device_token, $push_message, $user->device_type, $data);
                } elseif ($user->device_type == 'ios') {

                    return $this->sendToUser($user->device_token, $push_message, $user->device_type, $data);
                }
            }
        } catch (Exception $e) {

            return $e;
        }
    }

    /**
     * Sending Push to a user Device.
     *
     * @return void
     */

    public function sendPushToProvider($provider_id, $push_message, $data = null, $type = null)
    {

        try {

            $providers = ProviderDevice::where('provider_id', $provider_id)->get();
            // dd($providers->toArray());
            // PushNotificationLog::firstOrCreate([
            //     'title' => 'Providers: ', 'message' => 'Devices: ' . $providers->count(), 'receiver_id' => $provider_id, 'app_type' => 'Driver', 'category' => 'Job'
            // ]);
            
            foreach ($providers as $provider) {
                if ($provider->token != "") {

                    if ($provider->type == 'ios') {
                        // PushNotificationLog::firstOrCreate([
                        //     'title' => 'iOS: ' . $provider->token, 'message' => 'Devices: ' . $providers->count(), 'receiver_id' => $provider_id, 'app_type' => 'Driver', 'category' => 'Job'
                        // ]);
                        $this->sendToProvider($provider->token, $push_message, $provider->type, $data, null, $type);
                    } elseif ($provider->type == 'android') {
                        // PushNotificationLog::firstOrCreate([
                        //     'title' => 'Android: ' . $provider->token, 'message' => 'Devices: ' . $providers->count(), 'receiver_id' => $provider_id, 'app_type' => 'Driver', 'category' => 'Job'
                        // ]);
                        $this->sendToProvider($provider->token, $push_message, $provider->type, $data, null, $type);
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            // PushNotificationLog::firstOrCreate([
            //     'title' => 'Exception', 'message' => $e->getMessage(), 'receiver_id' => $provider_id, 'app_type' => 'Driver', 'category' => 'Job'
            // ]);
            return $e;
        }
    }

    public function sendToUser($fcmToken, $msg, $device_type, $data = null, $payload = null, $type = null)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notificationData = [
            "title" => Setting::get('site_title') . " Rider",
            'message' => $msg,
            "body" => $msg,
            'sound' => true
        ];

        $androidData['title'] = Setting::get('site_title') . " Rider";
        $androidData['message'] = $msg;
        $androidData['body'] = $msg;
        $androidData['sound'] = true;
        $androidData['data'] = $data;
        $androidData['type'] = $type;

        $iOSData['aps']['title'] = Setting::get('site_title') . " Rider";
        $iOSData['aps']['body'] = $msg;

        if ($device_type == 'android') {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => $fcmToken, //single token
                // 'data' => $androidData,
                'notification' => $androidData,
                'payload' => $androidData,
                'priority' => 'high'
            ];
        } else {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => $fcmToken, //single token
                'notification' => $notificationData,
                'data' => $notificationData,
                // 'android' => $androidData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];
        }

        if ($payload == null) {
            $payload = json_encode($fcmNotification);
        } else {
            $payload = json_encode($payload);
        }

        $headers = [
            'Authorization: key=' . Setting::get('android_user_fcm_key'),
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function sendToProvider($fcmToken, $msg, $device_type, $data = null, $payload = null, $type = null)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $notificationData = [
            'title' => Setting::get('site_title') . " Driver",
            'message' => $msg,
            'body' => $msg,
            'sound' => true,
        ];

        $androidData['title'] = Setting::get('site_title') . " Driver";
        $androidData['message'] = $msg;
        $androidData['body'] = $msg;
        $androidData['sound'] = true;
        // $androidData['data'] = $data;
        $androidData['type'] = $type;

        $iOSData['aps']['title'] = Setting::get('site_title') . " Driver";
        $iOSData['aps']['body'] = $msg;

        $dataArray = [];

        if ($device_type == 'android') {
            if ($data == null) {
                $fcmNotification = [
                    //'registration_ids' => $tokenList, //multple token array
                    'to' => $fcmToken, //single token
                    // 'data' => $androidData,
                    'notification' => $androidData,
                    // 'payload' => $androidData,
                    'priority' => 'high'
                ];
            } else {
                $dataArray['id'] = $data->id;
                $dataArray['booking_id'] = $data->booking_id; 
                $dataArray['request_category'] = $data->request_category;
                $dataArray['vweight'] = $data->vweight;
                $dataArray['returntrip'] = $data->returntrip;
                $dataArray['only_pickup'] = $data->only_pickup;
                $dataArray['set_dest_later'] = $data->set_dest_later;
                $dataArray['payment_mode'] = $data->payment_mode; 
                $dataArray['distance'] = $data->distance;
                $dataArray['amount'] =  $data->returntrip == 1 && $data->is_return_trip == 1 ? $data->return_amount : $data->amount; 
                $dataArray['specialNote'] = $data->specialNote; 
                $dataArray['s_address'] = $data->s_address;
                $dataArray['d_address'] = $data->d_address;     
                $dataArray['time_left_to_respond'] = $data->time_left_to_respond;
                $dataArray['driver_amount'] =  $data->returntrip == 1 && $data->is_return_trip == 1 ? $data->return_driver_amount : $data->driver_amount;
                $dataArray['pickup_duration'] = $data->pickup_duration;
                $dataArray['pickup_distance'] = $data->pickup_distance;
                $dataArray['drop_duration'] = $data->drop_duration;
                $dataArray['drop_distance'] = $data->drop_distance;
                $dataArray['schedule_at'] = $data->schedule_at != null ? $data->schedule_at->toDateTimeString() : null;
                $dataArray['is_free'] = $data->is_free;

                if ($data->user) { 
                    $dataArray['user']['first_name'] = $data->user->first_name;
                    $dataArray['user']['last_name'] = $data->user->last_name;
                    $dataArray['user']['picture'] = $data->user->picture; 
                    $dataArray['user']['vehicle_make'] = $data->user->vehicle_make;
                    $dataArray['user']['vehicle_number'] = $data->user->vehicle_number;
                }

                if ($data->service_type) { 
                    $dataArray['service_type']['type'] = $data->service_type->type;
                    $dataArray['service_type']['name'] = $data->service_type->name; 
                }

                // $data = [];
                
                $androidData['data'] = json_encode($dataArray);
                $fcmNotification = [
                    //'registration_ids' => $tokenList, //multple token array
                    'to' => $fcmToken, //single token
                    'data' => $androidData,
                    // 'notification' => $androidData,
                    // 'payload' => $androidData,
                    'priority' => 'high'
                ];
            }
        } else if ($device_type == 'ios') {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => $fcmToken, //single token
                'notification' => $notificationData,
                'data' => $notificationData,
                // 'android' => $androidData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];
        }

        /*
        if ($device_type == 'android') {
            if ($data == null) {
                $fcmNotification = [
                    //'registration_ids' => $tokenList, //multple token array
                    'to' => $fcmToken, //single token
                    // 'title' => Setting::get('site_title') . " Driver",
                    // 'body' => $msg,
                    'notification' => $androidData,
                    // 'payload' => $androidData,
                    'priority' => 'high'
                ];
            } else {
                $fcmNotification = [
                    //'registration_ids' => $tokenList, //multple token array
                    'to' => $fcmToken, //single token
                    // 'title' => Setting::get('site_title') . " Driver",
                    // 'body' => $msg,
                    'notification' => $androidData,
                    'data' => $androidData,
                    // 'payload' => $androidData,
                    'priority' => 'high'
                ];
            }
        } else {
            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to' => $fcmToken, //single token
                'notification' => $notificationData,
                'data' => $notificationData,
                // 'android' => $androidData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];
        }
        */

        if ($payload == null) {
            $payload = json_encode($fcmNotification);
        } else {
            $payload = json_encode($payload);
        }

        // dd($payload);

        $headers = [
            'Authorization: key=' . Setting::get('android_user_driver_key'),
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($ch);
        curl_close($ch);

        // PushNotificationLog::firstOrCreate([
        //     'title' => 'Payload' , 'message' => $payload, 'receiver_id' => 0, 'app_type' => 'Driver', 'category' => 'Job'
        // ]);

        // PushNotificationLog::firstOrCreate([
        //     'title' => $fcmToken == "" ? 'N/A' : $fcmToken , 'message' => $result, 'receiver_id' => 0, 'app_type' => 'Driver', 'category' => 'Job'
        // ]);

        // dd($result);
    }
}
