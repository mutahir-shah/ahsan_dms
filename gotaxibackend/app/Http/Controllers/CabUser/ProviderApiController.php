<?php

namespace App\Http\Controllers\CabUser;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\ServiceTypeController;

use App\Document;
use App\BankAccount;
use App\WithdrawalMoney;
use App\Settings;
use App\TaxiMeterUserRequest;
use App\UserRequests;
use App\Chat;
use App\City;
use App\Provider;
use App\ProviderService;
use App\ProviderDocument;
use App\ServiceType;
use App\CancellationReason;
use App\Language;
use App\Onboarding;
use App\PageContent;
use anlutro\LaravelSettings\Facade as Setting;
use App\CMS;
use App\Http\Controllers\UserApiController;
use App\ProviderDevice;
use App\User;
use App\Zones;
use Exception;
use Illuminate\Support\Facades\DB;

class ProviderApiController extends Controller
{
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

    public function getAllservices()
    {
        $types = [];
        $serviceTypeController = new ServiceTypeController();
        $types = $serviceTypeController->getActiveServicesTypes();

        $servicesList = ServiceType::whereIn('type', $types)->get();
        // $services = ServiceType::select('id', 'name', 'image', 'type', 'capacity', 'fixed', 'price', 'minute', 'distance', 'calculator')->where('type', $type)->get();

        return response()->json([
            'error' => false,
            'serviceslist' => $servicesList
        ]);
    }

    public function getAllDocuments(Request $request)
    {
        $provider_id = Auth::user()->id;

        if ($request->type == 'vehicle') {

            $this->validate($request, [
                'vehicle_id' => 'required|numeric|exists:provider_services,id',
            ]);
            
            $providerDocsIds = ProviderDocument::where('vehicle_id', $request->vehicle_id)->where('provider_id', $provider_id)->pluck('document_id');

            if (count($providerDocsIds)) {
                $documents = $this->getDocuments(['VEHICLE'], $request, $providerDocsIds);
            } else {
                $documents = $this->getDocuments(['VEHICLE'], $request);
            }

        } else if ($request->type == 'driver') {
            $providerDocsIds = ProviderDocument::where('provider_id', $provider_id)->pluck('document_id');
            if (count($providerDocsIds)) {
                $documents = $this->getDocuments(['DRIVER'], $request, $providerDocsIds);
            } else {
                $documents = $this->getDocuments(['DRIVER'], $request);
            }
        } else {
            $activeVehicle = ProviderService::where('provider_id', $provider_id)->whereNull('parent_id')->where('is_selected', 1)->get(['id'])->first();
            $providerWithVehicleDocsIds = ProviderDocument::where('vehicle_id', $activeVehicle->id)->where('provider_id', $provider_id)->pluck('document_id')->toArray();
            $providerDocsIds = ProviderDocument::where('provider_id', $provider_id)->pluck('document_id')->toArray();
            $providerDocsIdsArray = array_merge($providerWithVehicleDocsIds, $providerDocsIds);
            if (count($providerDocsIdsArray)) {
                $documents = $this->getDocuments(['DRIVER', 'VEHICLE'], $request, $providerDocsIds);
            } else {
                $documents = $this->getDocuments(['DRIVER', 'VEHICLE'], $request);
            }
        }

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

    public function getDocuments($type, $request, $providerDocsIds = null){
        $language_id = getLanguageIdFromApis($request);
        $default_language_id = getDefautlLanguage();
        
        $documents = Document::whereHas('translations', function($query) use($language_id) {
            $query->where('language_id', $language_id);
        })
        ->with(['translations' => function($query) use($language_id) {
            $query->where('language_id', $language_id);
        }])
        ->when($providerDocsIds, function($query) use ($providerDocsIds) {
            $query->whereNotIn('id', $providerDocsIds);
        })
        ->whereIn('type', $type)
        ->get(['id', 'name as dname', 'type as dtype', 'expiry_required']);

        if ($documents->isEmpty()) {
            $documents = Document::whereHas('translations', function($query) use($default_language_id) {
                $query->where('language_id', $default_language_id);
            })
            ->with(['translations' => function($query) use($default_language_id) {
                $query->where('language_id', $default_language_id);
            }])
            ->when($providerDocsIds, function($query) use ($providerDocsIds) {
                $query->whereNotIn('id', $providerDocsIds);
            })
            ->whereIn('type', $type)
            ->get(['id', 'name as dname', 'type as dtype', 'expiry_required']);
        }

        // Get only the first translation if it exists
        $documents->each(function ($document) {
            if ($document->translations->isNotEmpty()) {
                $document->setRelation('translations', $document->translations->take(1));
            }
        });

        return $documents;
    }

    public function fetchDocuments(Request $request)
    {

        $provider_id = Auth::user()->id;
        $documentsArray = [];
        if ($request->type == 'vehicle') {

            $this->validate($request, [
                'vehicle_id' => 'required|numeric|exists:provider_services,id',
            ]);

            $documents = ProviderDocument::where('provider_id', $provider_id)->where('vehicle_id', $request->vehicle_id)
                ->with('document')
                ->whereHas('document', function (Builder $query) {
                    $query->where('type', 'VEHICLE');
                })
                ->get();
        } else if ($request->type == 'driver') {
            $documents = ProviderDocument::where('provider_id', $provider_id)
                ->with('document')
                ->whereHas('document', function (Builder $query) {
                    $query->where('type', 'DRIVER');
                })
                ->get();
        } else if ($request->type == 'user') {
            $documents = ProviderDocument::where('provider_id', $provider_id)
                ->with('document')
                ->whereHas('document', function (Builder $query) {
                    $query->where('type', 'USER');
                })
                ->get();
        } else {
            $documents = ProviderDocument::where('provider_id', $provider_id)
                ->whereHas('document')
                ->with('document')
                ->get();
        }

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

        $vehiclesArray = [];
        $vehicles = ProviderService::where('provider_id', $provider_id)->with('service_type')->where('is_child', 0)->get();
        foreach ($vehicles as $index => $vehicle) {
            $vehiclesArray[$index]['id'] = (string)$vehicle->id;
            $vehiclesArray[$index]['name'] = $vehicle->service_model . ' - ' . $vehicle->service_number;
        }


        return response()->json(
            [
                'error' => false,
                'vehicles' => $vehiclesArray,
                'documents' => $documentsArray
            ]
        );
    }

    public function getbankaccount($id)
    {

        $bankaccount = BankAccount::where('provider_id', $id)->get(['id as bid', 'account_name', 'type', 'bank_name', 'account_number', 'IFSC_code', 'MICR_code'])->first();

        //Old Keys
        // $withdrawal_moneys_pending = WithdrawalMoney::where('provider_id', $id)->where('status', 'WAITING')->sum('amount');
        // $withdrawal_moneys_paid = WithdrawalMoney::where('provider_id', $id)->where('status', 'APPROVED')->sum('amount');

        // $bankaccount->pending = $withdrawal_moneys_pending; 
        // $bankaccount->paid = $withdrawal_moneys_paid;
        // $bankaccount->total = $withdrawal_moneys_pending + $withdrawal_moneys_paid;

        //New Keys
        $withdrawal_moneys_current_balance = WithdrawalMoney::where('provider_id', $id)->whereNull('status')->sum('amount');
        $withdrawal_moneys_paid = WithdrawalMoney::where('provider_id', $id)->where('status', 'APPROVED')->sum('amount');
        $withdrawal_moneys_pending = WithdrawalMoney::where('provider_id', $id)->where('status', 'WAITING')->sum('amount');

        if (!$bankaccount) {
            $bankaccount = (object)[];
            // $bankaccount->bid = 'N/A'; 
            // $bankaccount->account_name = 'N/A'; 
            // $bankaccount->bank_name = 'N/A'; 
            // $bankaccount->account_number = 'N/A'; 
            // $bankaccount->IFSC_code = 'N/A'; 
            // $bankaccount->MICR_code = 'N/A'; 
            $bankaccount->bid = (string)0;
        } else {
            $bankaccount->bid = (string)$bankaccount->bid;
        }

        $bankaccount->current_balance = $withdrawal_moneys_current_balance;
        $bankaccount->withdrawn = (string) $withdrawal_moneys_paid;
        $bankaccount->pending_withdraw = $withdrawal_moneys_pending;
        $bankaccount->revenue = $withdrawal_moneys_paid + $withdrawal_moneys_pending;

        return response()->json(
            [
                'error' => false,
                'bankaccount' => $bankaccount
            ]
        );
    }

    public function addbankaccount(Request $request)
    {

        $bankAccount = BankAccount::where('provider_id', $request->id)->get(['id'])->first();

        if ($bankAccount == null) {
            $BankAccount = new BankAccount;
            $BankAccount->account_name = $request->name;
            $BankAccount->type = $request->type;
            $BankAccount->bank_name = $request->bankname;
            $BankAccount->account_number = $request->accountnumber;
            $BankAccount->IFSC_code = $request->ifsc;
            $BankAccount->MICR_code = $request->micr;
            $BankAccount->routing_number = $request->has('routing_number') ? $request->routing_number : '0';
            $BankAccount->provider_id = $request->id;
            $BankAccount->account_type = 'Driver';
            $BankAccount->status = 'APPROVED';
            $BankAccount->country = $request->country;
            $BankAccount->currency = $request->currency;
            $BankAccount->save();

            return response()->json([
                'error' => $BankAccount == "" ? true : false
            ]);
        } else {
            $BankAccount = BankAccount::find($bankAccount->id);
            $BankAccount->account_name = $request->name;
            $BankAccount->type = $request->type;
            $BankAccount->bank_name = $request->bankname;
            $BankAccount->account_number = $request->accountnumber;
            $BankAccount->IFSC_code = $request->ifsc;
            $BankAccount->MICR_code = $request->micr;
            $BankAccount->routing_number = $request->has('routing_number') ? $request->routing_number : '0';
            $BankAccount->provider_id = $request->id;
            $BankAccount->account_type = 'Driver';
            $BankAccount->status = 'APPROVED';
            $BankAccount->country = $request->country;
            $BankAccount->currency = $request->currency;
            $BankAccount->save();

            return response()->json([
                'error' => $BankAccount == "" ? true : false
            ]);
        }
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

        $user = User::where('id', $request->uid)->get(['device_token'])->first();
        $this->sendpush($user->device_token, $request->message, $user->device_type, 'rider');

        return response()->json([
            'error' => $chat == "" ? true : false
        ]);
    }

    public function driverloginbyphone(Request $request)
    {

        $request->validate([
            'phone' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15',
        ]);

        $types = [];
        $serviceTypeController = new ServiceTypeController();
        $types = $serviceTypeController->getActiveServicesTypes($request);

        $provider = Provider::where("mobile", $request->phone)->get(['id', 'email'])->first();
        $userApiController = new UserApiController();
        $service = $userApiController->getServicesWithMultiLanguage($types, $request)->map(function($service) {
            $service->name = $service->translations[0]->name;
            $service->description = $service->translations[0]->description;
            unset($service->translations);
            return $service;
        });
        $zones = Zones::where('status', 'active')->get();

        if ($provider != null && $provider->count() > 0) {
            $message = translateKeywordApis("phone_exists", $request);
            $error = false;
            return response()->json(
                [
                    'error' => $error,
                    'message' => $message,
                    'user' => $provider,
                    'serviceslist' => $service,
                    'zonesList' => $zones
                ]
            );
        } else {
            $message = translateKeywordApis("phone_not_exists", $request);
            $error = true;
            return response()->json(
                [
                    'error' => $error,
                    'message' => $message,
                    'user' => [
                        'id' => null,
                        'email' => null
                    ],
                    'serviceslist' => $service,
                    'zonesList' => $zones
                ]
            );
        }
    }

    public function adddriverwallet(Request $request)
    {

        try {
            $provider_id = $request->id;

            $provider = Provider::where('id', $provider_id)->get(['wallet'])->first();
            $amount = $provider->wallet + $request->amount;
            if ($amount > 0) {
                $status = "approved";
            } else {
                $status = "low_balance";
            }
            $walletUpdate = Provider::where('id', $provider_id)->update(['wallet' => $amount, 'status' => $status]);

            return response()->json([
                'error' => $walletUpdate == 1 ? false : true
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateservice(Request $request)
    {

        $provider = new ProviderService;
        $provider->id = null;
        $provider->provider_id = $request->pid;
        $provider->service_type_id = $request->sid;
        $provider->status = 'active';
        $provider->service_number = '';
        $provider->service_model = '';
        $provider->save();

        return response()->json([
            'error' => $provider == "" ? true : false
        ]);
    }

    public function uploaddoc(Request $request)
    {
        if ($request->has('vid')) {
            $providerDocument = ProviderDocument::where('provider_id', $request->pid)->where('document_id', $request->did)->where('vehicle_id', $request->vid)->get()->first();
        } else {
            $providerDocument = ProviderDocument::where('provider_id', $request->pid)->where('document_id', $request->did)->get()->first();
        }

        if ($providerDocument) {
            $providerDocument = ProviderDocument::find($providerDocument->id);

            if ($request->hasFile('image')) {
                $file = $request->image->store('provider/documents');
                $file = asset('storage/' . $file);
                $providerDocument->url = $file;
            } else {
                $providerDocument->url = '';
            }

            $providerDocument->status = 'ASSESSING';
            $providerDocument->expiry_date = $request->expiry_date ? $request->expiry_date : null;
            $providerDocument->save();
        } else {
            $providerDocument = new ProviderDocument;
            $providerDocument->provider_id = $request->pid;
            $providerDocument->document_id = $request->did;
            $providerDocument->vehicle_id = $request->vid ? $request->vid : null;
            $providerDocument->expiry_date = $request->expiry_date ? $request->expiry_date : null;

            if ($request->hasFile('image')) {
                $file = $request->image->store('provider/documents');
                $file = asset('storage/' . $file);
                $providerDocument->url = $file;
            } else {
                $providerDocument->url = '';
            }

            $providerDocument->status = 'ASSESSING';
            $providerDocument->save();
        }

        $provider_id = $request->pid;
        $provider = Provider::find($provider_id);
        if ($provider->status == 'doc_required') {
            //TODO: if count of uploaded document is reached update status to onboarding
            $documents = Document::whereIn('type', ['DRIVER', 'VEHICLE'])->get(['id as document_id'])->pluck('document_id');
            $documentsCount = $documents->count();
            $providerDocsCount = ProviderDocument::where('provider_id', $provider_id)->whereIn('document_id', $documents)->count();
            if ($providerDocsCount >= $documentsCount) {
                Provider::where('id', $provider_id)->update(['status' => $provider->is_approved == 0 ? 'onboarding' : 'in_review']);
            }
        }

        return response()->json([
            'error' => false,
            'message' => translateKeywordApis("file_uploaded_successfully", $request)
        ]);
    }

    public function getconstdata(Request $request)
    {
        // Ftech Other Settings
        $settingsData = Settings::get(['key', 'value']);

        // Remove Old Settings Keys
        Settings::where('key', 'onboarding_driver_title1')
        ->orWhere('key', 'onboarding_driver_description1')
        ->orWhere('key', 'onboarding_driver_title2')
        ->orWhere('key', 'onboarding_driver_description2')
        ->orWhere('key', 'onboarding_driver_title3')
        ->orWhere('key', 'onboarding_driver_description3')
        ->orWhere('key', 'onboarding_driver_title4')
        ->orWhere('key', 'onboarding_driver_description4')
        ->orWhere('key', 'onboarding_driver_title5')
        ->orWhere('key', 'onboarding_driver_description5')
        ->orWhere('key', 'onboarding_driver_image1')
        ->orWhere('key', 'onboarding_driver_image2')
        ->orWhere('key', 'onboarding_driver_image3')
        ->orWhere('key', 'onboarding_driver_image4')
        ->orWhere('key', 'onboarding_driver_image5')
        ->orWhere('key', 'page_privacy')
        ->orWhere('key', 'page_terms')
        ->delete();


        // Get Current Language
        $language_id = getLanguageIdFromApis($request);
        $default_langauge_id = getDefautlLanguage();

        // Get Cancellation Reasons
        $cancellationReasons = $this->getCancellationReasons('DRIVER', $language_id, $default_langauge_id);

        foreach($cancellationReasons as $index => $reason){
            $reasonKey = 'cancel_reason_driver_' . ++$index;
            $reasonValue = $reason->reason;

            $settingsData[] = [
                'id' => $reason->parent_id == 0 ? $reason->id : $reason->parent_id,
                'key' => $reasonKey,
                'value' => $reasonValue
            ];
        }

        // Getting Onboardings
        $onBoardingProvider = $this->getOnBoardingProviders('DRIVER' ,$language_id, $default_langauge_id);
    
        foreach ($onBoardingProvider as $key => $item) {
            $index = ++$key;
            // Define custom keys and values
            $titleKey = 'onboarding_driver_title' . $index;
            $descriptionKey = 'onboarding_driver_description' . $index;
            $imageKey = 'onboarding_driver_image' . $index;
            $imageValue = $item->image;
            $titleValue = $item->translations[0]->name;
            $descriptionValue = $item->translations[0]->description;

            // Add title to the array
            $settingsData[] = [
                'key' => $titleKey,
                'value' => $titleValue
            ];

            // Add description to the array
            $settingsData[] = [
                'key' => $descriptionKey,
                'value' => $descriptionValue
            ];

            // Add Image to the array
            $settingsData[] = [
                'key' => $imageKey,
                'value' => $imageValue
            ];
        }

        $pageContent = $this->getPageContent($language_id, $default_langauge_id);

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

    public function getCancellationReasons($type, $language_id, $default_language_id){
        $cancellationReasons = CancellationReason::where([
            'type' => $type,
            'language_id' => $language_id
        ])->get(['id','reason']);

        if($cancellationReasons->isEmpty()){
            $cancellationReasons = CancellationReason::where([
                'type' => $type,
                'language_id' => $default_language_id
            ])->get(['id','reason']);
        }

        return $cancellationReasons;
    }

    public function getOnBoardingProviders($type, $language_id, $default_language_id){
        $onboardings = Onboarding::where('type', $type)
        ->whereHas('translations', function($query) use($language_id) {
            $query->where('language_id', $language_id);
        })
        ->with(['translations' => function($query) use($language_id) {
            $query->where('language_id', $language_id);
        }])
        ->get();
        
        if($onboardings->isEmpty()){
            $onboardings = Onboarding::where('type', $type)
                ->whereHas('translations', function($query) use($default_language_id) {
                    $query->where('language_id', $default_language_id);
                })
                ->with(['translations' => function($query) use($default_language_id) {
                    $query->where('language_id', $default_language_id);
                }])
                ->get();
        }
        
        return $onboardings;
    
    }

    public function getPageContent($language_id, $default_language_id){
        $pageContent = PageContent::where('language_id', $language_id)->first();

        if(!$pageContent){
            $pageContent = PageContent::where('language_id', $default_language_id)->first();
        }

        return $pageContent;
    }

    public function deleteservice(Request $request)
    {

        $deleteProviderService = ProviderService::where('provider_id', $request->pid)->where('service_type_id', $request->sid)->delete();

        return response()->json([
            'error' => $deleteProviderService == 1 ? true : false,
        ]);
    }

    public function getcity()
    {

        $cities = City::select('name')->get();
        $verification = Settings::select('value')->where('key', 'verification')->first();

        return response()->json([
            'error' => false,
            'city' => $cities,
            'verification' => $verification->value == 1 ? true : false
        ]);
    }

    public function getchat($booking_id)
    {

        $chat = Chat::where('request_id', $booking_id)->orderBy('id', 'ASC')->get(['message', 'type']);

        return response()->json([
            'error' => $chat == "1" ? true : false,
            'chat' => $chat
        ]);
    }

    public function addwithdraw(Request $request)
    {

        // $withdrawal_moneys_current_balance = WithdrawalMoney::where('provider_id', $request->id)->whereNull('status')->sum('amount');

        // if ($withdrawal_moneys_current_balance > $request->amount) {
        //     $withDraw = new WithdrawalMoney;
        //     $withDraw->id = null;
        //     $withDraw->bank_account_id = $request->bid;
        //     $withDraw->provider_id = $request->id;
        //     $withDraw->amount = $withdrawal_moneys_current_balance - $request->amount;
        //     $withDraw->status = NULL;
        //     $withDraw->created_at = Carbon::now();
        //     $withDraw->updated_at = Carbon::now();
        //     $withDraw->save();
        // } else if ($withdrawal_moneys_current_balance == $request->amount) {
        //     $withDraw = WithdrawalMoney::where('bank_account_id', $request->bid)->where('provider_id', $request->id)->update(['status' => 'WAITING']);
        // }

        $withDrawRequested = WithdrawalMoney::where('provider_id', $request->id)->whereNull('status')->update(['status' => 'REQUESTED']);

        $withDraw = new WithdrawalMoney;
        $withDraw->bank_account_id = $request->bid;
        $withDraw->provider_id = $request->id;
        $withDraw->amount = $request->amount;
        $withDraw->status = 'WAITING';
        $withDraw->save();

        return response()->json([
            'error' => $withDrawRequested == 0 ? true : false
        ]);
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

    public function startorder(Request $request)
    {

        $userRequest = UserRequests::where('id', $request->id)->get(['provider_id', 'current_provider_id', 'service_type_id'])->first();
        if ($userRequest->provider_id == 0) {
            $providerServiceActiveCount = ProviderService::where('status', 'active')
                ->where('provider_id', $userRequest->current_provider_id)
                ->where('service_type_id', $userRequest->service_type_id)
                ->count();
        } else {
            $providerServiceActiveCount = ProviderService::where('status', 'active')
                ->where('provider_id', $userRequest->provider_id)
                ->where('service_type_id', $userRequest->service_type_id)
                ->count();
        }

        $error = true;
        if ($providerServiceActiveCount > 0) {
            $userRequestUpdate = UserRequests::where('id', $request->id)->update(['status' => 'STARTED']);
            if ($userRequest->provider_id == 0) {
                $providerServiceUpdate = ProviderService::where('provider_id', $userRequest->current_provider_id)->update(['status' => 'riding']);
            } else {
                $providerServiceUpdate = ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'riding']);
            }
            $error = false;
        } /* else if ($providerServiceActiveCount == 0) {
            $userRequestUpdate = UserRequests::where('id', $request->id)->update(['status' => 'STARTED']);
            if ($userRequest->provider_id == 0) {
                $providerServiceUpdate = ProviderService::create(['provider_id' => $userRequest->current_provider_id, 'service_type_id' => $userRequest->service_type_id, 'status' => 'riding']);
            } else {
                $providerServiceUpdate = ProviderService::create(['provider_id' => $userRequest->provider_id, 'service_type_id' => $userRequest->service_type_id, 'status' => 'riding']);
            }
            
            $error = false;
        } */

        return response()->json([
            'error' => $error
        ]);
    }
}
