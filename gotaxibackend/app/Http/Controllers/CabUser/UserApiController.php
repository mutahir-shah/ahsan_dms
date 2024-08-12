<?php

namespace App\Http\Controllers\CabUser;

use Illuminate\Database\Eloquent\Builder;
use App\TaxiMeterUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;
use App\BankAccount;
use Carbon\Carbon;

use App\Chat;
use App\FavouriteLocation;
use App\User;
use App\Settings;
use App\ServiceType;
use App\UserRequests;
use App\Provider;
use App\ProviderDevice;
use App\UserRequestPayment;
use App\WithdrawalMoney;
use App\UserDocument;
use App\Document;
use App\Onboarding;
use Illuminate\Support\Facades\Auth;


class UserApiController extends Controller

{

    public function getAllDocuments(Request $request)
    {

        $user_id = Auth::user()->id;
        $userDocsIds = UserDocument::where('user_id', $user_id)->pluck('document_id');

        $providerController = new ProviderApiController();
        $documents = $providerController->getDocuments(['USER'], $request, $userDocsIds);
        
        $documentsArray = [];
        foreach ($documents as $index => $document) {
            $documentsArray[$index]['did'] = $document->id;
            $documentsArray[$index]['dname'] = $document->translations[0]->name;
            $documentsArray[$index]['dtype'] = $document->dtype;
            $documentsArray[$index]['expiry_required'] = $document->expiry_required;
        }

        return response()->json([
            'error' => $documentsArray == "" ? true : false,
            'documents' => $documentsArray
        ]);
    }

    public function uploaddoc(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'did' => 'required'
        ]);

        $userDocument = UserDocument::where('user_id', $request->uid)->where('document_id', $request->did)->get()->first();

        if ($userDocument) {
            $userDocument = UserDocument::find($userDocument->id);
            if ($request->hasFile('image')) {
                $file = $request->image->store('provider/documents');
                $file = asset('storage/' . $file);
                $userDocument->url = $file;
            } else {
                $userDocument->url = '';
            }

            $userDocument->status = 'ASSESSING';
            $userDocument->expiry_date = $request->expiry_date ? $request->expiry_date : null;
            $userDocument->save();

        } else {
            $userDocument = new UserDocument;
            $userDocument->user_id = $request->uid;
            $userDocument->document_id = $request->did;
            $userDocument->expiry_date = $request->expiry_date ? $request->expiry_date : null;

            if ($request->hasFile('image')) {
                $file = $request->image->store('provider/documents');
                $file = asset('storage/' . $file);
                $userDocument->url = $file;
            } else {
                $userDocument->url = '';
            }

            $userDocument->status = 'ASSESSING';
            $userDocument->save();

            $user_id = $request->uid;
            $user = User::find($user_id);
            if ($user->status == 'doc_required') {
                //TODO: if count of uploaded document is reached update status to onboarding
                $documents = Document::where('type', 'USER')->get(['id as document_id'])->pluck('document_id');
                $documentsCount = $documents->count();
                $userDocsCount = UserDocument::where('user_id', $user_id)->whereIn('document_id', $documents)->count();
                if ($userDocsCount >= $documentsCount) {
                    User::where('id', $user_id)->update(['status' => 'onboarding']);
                }
            }
        }

        return response()->json([
            'error' => false,
            'message' => 'File Uploaded Successfully'
        ]);

    }

    public function fetchDocuments(Request $request)
    {

        $user_id = Auth::user()->id;
        $documentsArray = [];
        $documents = UserDocument::where('user_id', $user_id)
            ->with('document')
            ->whereHas('document', function (Builder $query) {
                $query->where('type', 'USER');
            })
            ->get();

        $now = Carbon::now();
        $expiry_day_limit = Setting::get('expiry_days_limit', 15);

        foreach ($documents as $index => $document) {
            $language_id = getLanguageIdFromApis($request);
            $default_language_id = getDefautlLanguage();

            $multiLangDocument = $document->document->translations()->where('language_id', $language_id)->first();
            if(is_null($multiLangDocument)){
                $multiLangDocument = $document->document->translations()->where('language_id', $default_language_id)->first();
            }

            $documentsArray[$index]['id'] = $document->document->id;
            $documentsArray[$index]['name'] = $multiLangDocument->name;
            $documentsArray[$index]['type'] = $document->document->type;
            $expiry_date = $documentsArray[$index]['expiry_date'] = $document->expiry_date ? $document->expiry_date->toFormattedDateString() : null;
            $expiry_date = $document->expiry_date == null ? null : $document->expiry_date->addDay()->startOfDay();
            $expiry_days_left = $now->diffInDays($expiry_date, false);
            // if ($document->document->expiry_required == 'YES') {
                if ($expiry_days_left >= 0 && $expiry_date != null) {
                    $expiry_days_left = $expiry_day_limit >= $expiry_days_left ? $expiry_days_left . ' Day(s)' : null;
                } else {
                    $expiry_days_left = null;
                }
            // } else {
            //     $expiry_days_left = null;
            // }
            $documentsArray[$index]['expiry_days_left'] = $expiry_days_left;
            $documentsArray[$index]['url'] = $document->url;
            $documentsArray[$index]['status'] = $document->status;
        }


        return response()->json([
                'error' => false,
                'documents' => $documentsArray
            ]
        );
    }


    public function sendpush($token, $msg, $device_type, $app_type)
    {
        $fcm_key = $app_type == 'rider' ? Setting::get('android_user_fcm_key') : Setting::get('android_user_driver_key');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $message_from = $app_type == 'rider' ? 'Driver' : 'Rider';

        $notificationData = [
            'title' => 'Chat: Message From ' . $message_from,
            // 'message' => $msg,
            "body" => $msg,
            'sound' => true
        ];

        $androidData['notification']['title'] = 'Chat: Message From ' . $message_from;
        $androidData['notification']['body'] = $msg;

        $iOSData['aps']['title'] = 'Chat: Message From ' . $message_from;
        $iOSData['aps']['body'] = $msg;

        if ($device_type == 'android') {
            $fcmNotification = [
                'to' => $token, //single token
                'data' => $notificationData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];

        } else {
            $fcmNotification = [
                'to' => $token, //single token
                'notification' => $notificationData,
                'data' => $notificationData,
                'payload' => $iOSData,
                'priority' => 'high'
            ];
        }

        $headers = [
            'Authorization: key=' . $fcm_key,
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
        curl_close($ch);
    }

   
    public function getconstdata(Request $request)
    {
        // Ftech Other Settings
        $settingsData = Settings::get(['key', 'value']);

        // Remove Old Settings Keys
        Settings::where('key', 'onboarding_user_title1')
        ->orWhere('key', 'onboarding_user_description1')
        ->orWhere('key', 'onboarding_user_title2')
        ->orWhere('key', 'onboarding_user_description2')
        ->orWhere('key', 'onboarding_user_title3')
        ->orWhere('key', 'onboarding_user_description3')
        ->orWhere('key', 'onboarding_user_title4')
        ->orWhere('key', 'onboarding_user_description4')
        ->orWhere('key', 'onboarding_user_title5')
        ->orWhere('key', 'onboarding_user_description5')
        ->orWhere('key', 'onboarding_description1')
        ->orWhere('key', 'onboarding_title1')
        ->orWhere('key', 'onboarding_description1')
        ->orWhere('key', 'onboarding_title2')
        ->orWhere('key', 'onboarding_description2')
        ->orWhere('key', 'onboarding_title3')
        ->orWhere('key', 'onboarding_description3')
        ->orWhere('key', 'onboarding_title4')
        ->orWhere('key', 'onboarding_description4')
        ->orWhere('key', 'onboarding_title5')
        ->orWhere('key', 'onboarding_description5')
        ->orWhere('key', 'onboarding_user_image1')
        ->orWhere('key', 'onboarding_user_image2')
        ->orWhere('key', 'onboarding_user_image3')
        ->orWhere('key', 'onboarding_user_image4')
        ->orWhere('key', 'onboarding_user_image5')
        ->orWhere('key', 'onboarding_image1')
        ->orWhere('key', 'onboarding_image2')
        ->orWhere('key', 'onboarding_image3')
        ->orWhere('key', 'onboarding_image4')
        ->orWhere('key', 'onboarding_image5')
        ->orWhere('key', 'page_privacy')
        ->orWhere('key', 'page_terms')
        ->delete();

        // Get Current Language
        $language_id = getLanguageIdFromApis($request);
        $default_langauge_id = getDefautlLanguage();

        $providerApiController = new ProviderApiController();

        // Get Cancellation Reasons
        $cancellationReasons = $providerApiController->getCancellationReasons('USER', $language_id, $default_langauge_id);

        foreach($cancellationReasons as $index => $reason){
            $reasonKey = 'cancel_reason_customer_' . ++$index;
            $reasonValue = $reason->reason;

            $settingsData[] = [
                'id' => $reason->parent_id == 0 ? $reason->id : $reason->parent_id,
                'key' => $reasonKey,
                'value' => $reasonValue
            ];
        }

        // Getting Onboardings
        $onBoardingProvider = $providerApiController->getOnBoardingProviders('USER' ,$language_id, $default_langauge_id);

        foreach ($onBoardingProvider as $key => $item) {
            $index = ++$key;
            // Define custom keys and values
            $titleKey = 'onboarding_user_title' . $index;
            $descriptionKey = 'onboarding_user_description' . $index;
            $imageKey = 'onboarding_user_image' . $index;
            $imageValue = $item->image;
            $titleValue = $item->translations[0]->name;
            $descriptionValue = $item->translations[0]->description;

            // Add title to the array
            $settingsData[] = [
                'key' => $titleKey,
                'value' => $titleValue
            ];

            // Add Image to the array
            $settingsData[] = [
                'key' => $imageKey,
                'value' => $imageValue
            ];

            // Add description to the array
            $settingsData[] = [
                'key' => $descriptionKey,
                'value' => $descriptionValue
            ];
        }

        $pageContent = $providerApiController->getPageContent($language_id, $default_langauge_id);

        $settingsData[] = [
            'key' => 'page_privacy',
            'value' => $pageContent->privacy_content
        ];

        $settingsData[] = [
            'key' => 'page_terms',
            'value' => $pageContent->terms_content
        ];

        $settingsData[] = [
            'key' => 'page_about',
            'value' => $pageContent->about_content
        ];

        return response()->json([
            'data' => $settingsData
        ]);
    }
    

    // public function isStaffIdExist(Request $request) {
    //     $user=User::where("mobile", $request->mobile)->get(['mobile']);
    //     return $user;

    // }

    public function deletefav(Request $request)
    {

        $favoriteLocDel = FavouriteLocation::where('id', $request->id)->delete();

        return response()->json([
            'error' => $favoriteLocDel == true ? false : true
        ]);
    }

    public function paymentdone(Request $request)
    {
        $request_id = $request->id;
        $userRequest = UserRequests::where('id', $request_id)->update(['status' => 'Completed', 'payment_mode' => 'CARD', 'paid' => 1]);
        $userRequest = UserRequests::find($request_id);

        $providerController = new ProviderController();
        $deductCommission = $providerController->deductCommission($request_id, $userRequest->provider_id);

        return response()->json([
            'error' => $userRequest == true ? false : true
        ]);
    }

    // public function getUserByPhone(Request $request) {
    //     $user = User::where("mobile", $request->mobile)->get(['email'])->first();

    //     if ($user!= null && $user->count() > 0) {
    //         $message = 'Login Successfull';
    //         $error = false;
    //         return response()->json(
    //             [
    //                 'error' => $error,
    //                 'message' => $message,
    //                 'user' => $user
    //             ]
    //         );
    //     } else {
    //         $message = 'User does not exist';
    //         $error = true;
    //         return response()->json(
    //             [
    //                 'error' => $error,
    //                 'message' => $message,
    //             ]
    //         );
    //     }
    // }

    // public function checkservicelist($service_id, $provider_id) {
    //     $providerService = ProviderService::where('service_type_id', $service_id)->where('provider_id', $provider_id)->get();

    //     return response()->json([
    //         'error' => false,
    //         'listcheck'=> $providerService
    //      ]);
    // }

    public function getchat($booking_id)
    {

        $chat = Chat::where('request_id', $booking_id)->orderBy('id', 'ASC')->get(['message', 'type']);

        return response()->json([
            'error' => $chat == "1" ? true : false,
            'chat' => $chat
        ]);
    }

    public function staffloginbyphone(Request $request)
    {

        $request->validate([
            'phone' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15',
        ]);

        $user = User::where("mobile", $request->phone)->get(['id', 'email'])->first();

        if ($user != null && $user->count() > 0) {
            $message = trans('api.phone_exists');
            $error = false;
            return response()->json(
                [
                    'error' => $error,
                    'message' => $message,
                    'user' => $user
                ]
            );
        } else {
            $message = trans('api.phone_not_exists');
            $error = true;
            return response()->json(
                [
                    'error' => $error,
                    'user' => [
                        'id' => null,
                        'email' => null
                    ],
                    'message' => $message,
                ]
            );
        }
    }

    public function addtaximeterride(Request $request)
    {

        $taxiMeter = new TaxiMeterUserRequest;
        $taxiMeter->id = null;
        $taxiMeter->provider_id = $request->id;
        $taxiMeter->distance = $request->distance;
        $taxiMeter->amount = $request->amount;
        $taxiMeter->save();

        return response()->json([
            'error' => $taxiMeter == "" ? true : false
        ]);
    }

    public function getservices($type)
    {
        $types = [];
        $serviceTypeController = new ServiceTypeController();
        $types = $serviceTypeController->getActiveServicesTypes();

        $servicesList = ServiceType::whereIn('type', $types)->get();
        // $services = ServiceType::select('id', 'name', 'image', 'type', 'capacity', 'fixed', 'price', 'minute', 'distance', 'calculator')->where('type', $type)->get();

        return response()->json([
            'error' => false,
            'services' => $servicesList
        ]);
    }

    public function addchat(Request $request)
    {

        $chat = new Chat;
        $chat->id = null;
        $chat->request_id = $request->booking_id;
        $chat->user_id = $request->uid;
        $chat->provider_id = $request->pid;
        $chat->message = $request->message;
        $chat->type = $request->type;
        $chat->delivered = 1;
        $chat->created_at = Carbon::now();
        $chat->updated_at = Carbon::now();
        $chat->save();
        
        $providerDevices = ProviderDevice::where('provider_id', $request->pid)->get(['token']);
        foreach ($providerDevices as $providerDevice) {
            $this->sendpush($providerDevice->token, $request->message, $providerDevice->type, 'driver');
        }
        
        return response()->json([
            'error' => $chat == "" ? true : false
        ]);
    }
}