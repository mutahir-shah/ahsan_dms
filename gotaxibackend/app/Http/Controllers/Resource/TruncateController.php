<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{
    Module,
    UserRequestRating,
    Dispatcher,
    ContactEnquiry,
    User,
    Provider,
    Subscription,
    Zones,
    ZoneCharge,
    BookingRequest,
    ZoneService,
    UserRequestPayment,
    Faqs,
    Promocode,
    PromocodeUsage,
    PromocodePassbook,
    ServiceType,
    WithdrawalMoney,
    Log,
    Document,
    UserRequests,
    PushNotificationLog,
    Admin,
    ProviderService,
    ProviderDocument
};
use DB;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;

class TruncateController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.TRUNCATEDATA'));
        $modules = Module::where(['is_truncate' => 1])->get();
        return view("admin.truncate.index", get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function truncate_date(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $user = Admin::find(Auth::guard('admin')->id());
        $checkPassword = Hash::check($request->password, $user->password);

        if(!$checkPassword){
            return 'false';
        }

        switch($request->type) {
            case 'Dispatcher':
                Dispatcher::truncate();
                UserRequests::truncate();
                $this->logService->log('User Requests Form', 'truncate', 'User Requests Form Truncated.', []);
                $this->logService->log('Dispatches', 'truncate', 'Dispatches Truncated.', []);
                break;
                
            case 'Booking Requests Form':
                    BookingRequest::truncate();
                    $this->logService->log('Booking Requests Form', 'truncate', 'Booking Requests Form Truncated.', []);
                    break;
            case 'Push Notifications':

                PushNotificationLog::truncate();
                $this->logService->log('Push Notification', 'truncate', 'Push Notification Truncated.', []);
                break;
    
            case 'Reviews':
                UserRequestRating::truncate();
                $this->logService->log('Reviews', 'truncate', 'Reviews Truncated.', []);
                break;
    
            case 'Contact Enquiries':
                ContactEnquiry::truncate();
                $this->logService->log('Contact Enquiries', 'truncate', 'Contact Enquiries Truncated.', []);
                break;
    
            case 'Users':
                User::truncate();
                $this->logService->log('Users', 'truncate', 'Users Truncated.', []);
                break;
    
            case 'Documents':
                Document::truncate();
                ProviderDocument::truncate();
                $this->logService->log('Document', 'truncate', 'Document Truncated.', []);
                $this->logService->log('ProviderDocument', 'truncate', 'Provider Document Truncated.', []);
                break;
            case 'Drivers':
                Provider::truncate();
                ProviderService::truncate();
                ProviderDocument::truncate();
                $this->logService->log('ProviderDocument', 'truncate', 'Provider Document Truncated.', []);
                $this->logService->log('Drivers', 'truncate', 'Drivers Truncated.', []);
                $this->logService->log('ProviderService', 'truncate', 'Provider Service Truncated.', []);
                break;
            case 'Subscription(s)':
                Subscription::truncate();
                $this->logService->log('Subcriptions', 'truncate', 'Subcriptions Truncated.', []);
                break;
            case 'Zones':
                Zones::truncate();
                ZoneCharge::truncate();
                ZoneService::truncate();
                $this->logService->log('Zones', 'truncate', 'Zones Truncated.', []);
                $this->logService->log('Zone Charges', 'truncate', 'Zone Charges Truncated.', []);
                $this->logService->log('Zone Services', 'truncate', 'Zone Services Truncated.', []);
                break;
    
            case 'Statements':
                UserRequestPayment::truncate();
                $this->logService->log('User Request Payments', 'truncate', 'User Request Payments Truncated.', []);
                break;
    
            case 'Faqs':
                Faqs::truncate();
                $this->logService->log('Faqs', 'truncate', 'Faqs Truncated.', []);
                break;
    
            case 'Promocodes':
                Promocode::truncate();
                PromocodeUsage::truncate();
                PromocodePassbook::truncate();
                $this->logService->log('Promocode', 'truncate', 'Promocode Truncated.', []);
                $this->logService->log('Promocode Usage', 'truncate', 'Promocode Usage Truncated.', []);
                $this->logService->log('Promocode Passbook', 'truncate', 'Promocode Passbook Truncated.', []);
                break;
    
            case 'Services':
                ServiceType::truncate();
                ProviderService::truncate();
                $this->logService->log('ServiceType', 'truncate', 'Service Type Truncated.', []);
                $this->logService->log('ProviderService', 'truncate', 'Provider Service Truncated.', []);
                break;
    
            case 'Withdrawal':
                WithdrawalMoney::truncate();
                $this->logService->log('Withdrawal Money', 'truncate', 'Withdrawal Money Truncated.', []);
                break;
    
            case 'Activity Logs':
                Log::truncate();
                $this->logService->log('Activity Logs', 'truncate', 'Activity Logs Truncated.', []);
                break;
    
            case 'All':
                Dispatcher::truncate();
                UserRequests::truncate();
                PushNotificationLog::truncate();
                UserRequestRating::truncate();
                ContactEnquiry::truncate();
                User::truncate();
                Provider::truncate();
                Subscription::truncate();
                Zones::truncate();
                ZoneCharge::truncate();
                ZoneService::truncate();
                UserRequestPayment::truncate();
                Faqs::truncate();
                Promocode::truncate();
                PromocodeUsage::truncate();
                PromocodePassbook::truncate();
                ServiceType::truncate();
                WithdrawalMoney::truncate();
                Log::truncate();
                BookingRequest::truncate();
                Document::truncate();
                ProviderService::truncate();
                ProviderDocument::truncate();
                $this->logService->log('BookingRequestsForm', 'truncate', 'Booking Requests Form Truncated.', []);
                $this->logService->log('Document', 'truncate', 'Document Truncated.', []);
                $this->logService->log('ProviderDocument', 'truncate', 'Provider Document Truncated.', []);
                $this->logService->log('ProviderService', 'truncate', 'Provider Service Truncated.', []);
                $this->logService->log('Dispatches', 'truncate', 'Dispatches Truncated.', []);
                $this->logService->log('User Requests', 'truncate', 'User Requests Truncated.', []);
                $this->logService->log('Push Notification', 'truncate', 'Push Notification Truncated.', []);
                $this->logService->log('Reviews', 'truncate', 'Reviews Truncated.', []);
                $this->logService->log('Contact Enquiries', 'truncate', 'Contact Enquiries Truncated.', []);
                $this->logService->log('Users', 'truncate', 'Users Truncated.', []);
                $this->logService->log('Drivers', 'truncate', 'Drivers Truncated.', []);
                $this->logService->log('Subcriptions', 'truncate', 'Subcriptions Truncated.', []);
                $this->logService->log('Zones', 'truncate', 'Zones Truncated.', []);
                $this->logService->log('Zone Charges', 'truncate', 'Zone Charges Truncated.', []);
                $this->logService->log('Zone Services', 'truncate', 'Zone Services Truncated.', []);
                $this->logService->log('User Request Payments', 'truncate', 'User Request Payments Truncated.', []);
                $this->logService->log('Faqs', 'truncate', 'Faqs Truncated.', []);
                $this->logService->log('Promocode', 'truncate', 'Promocode Truncated.', []);
                $this->logService->log('Promocode Usage', 'truncate', 'Promocode Usage Truncated.', []);
                $this->logService->log('Promocode Passbook', 'truncate', 'Promocode Passbook Truncated.', []);
                $this->logService->log('Withdrawal Money', 'truncate', 'Withdrawal Money Truncated.', []);
                break;
        }
    
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
        return response()->json(['success' => true, 'message' => 'Truncate operation completed.']);
    }
    
    
    
}
