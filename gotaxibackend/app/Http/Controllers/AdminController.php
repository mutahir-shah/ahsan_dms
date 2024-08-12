<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use anlutro\LaravelSettings\Facade as Setting;

use Exception;

use Carbon\Carbon;

use App\User;
use App\Module;

use App\Fleet;

use App\Admin;
use App\BookingRequest;
use App\ContactEnquiry;
use App\Provider;

use App\UserPayment;

use App\ServiceType;

use App\UserRequests;

use App\ProviderService;
use App\PushNotificationLog;
use App\ProviderDevice;
use App\UserRequestRating;

use App\UserRequestPayment;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper;
use App\Services\LogService;
use DateTimeZone;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Bus;
use App\Jobs\SendOtpEmailJob;

class AdminController extends Controller

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
   


    public function opt(){
        $site_color = Setting::get('site_color') ? Setting::get('site_color') : '#EC4949';
        return view('admin.auth.otp', get_defined_vars());
    }

    public function resendOpt(Request $request){
        // Custom logic here
        $user = auth()->guard('admin')->user();
        $otp = random_int(100000, 999999);
        $user->otp = $otp;
        $user->save();

        $guards = [
            'admin' => 'admin_otp',
            'account' => 'account_otp',
            'fleet' => 'fleet_otp',
            'dispatcher' => 'dispatcher_otp',
        ];

        foreach ($guards as $guard => $sessionKey) {
            if (Setting::get($guard.'_login_otp', 0) == 1 && auth()->guard($guard)->check()) {
                session()->put($sessionKey, true);
                Bus::dispatch(new SendOtpEmailJob($user->email, $otp));
            }else{
                session()->pull($sessionKey);
            }
        }

        return 'true';
    }

    public function verifyOpt(Request $request){
        $user = auth()->guard('admin')->user();

        if ($user && $user->otp == $request->otp) {
            session()->forget('admin_otp');
            return redirect("/admin/dashboard");
        }
        
        throw ValidationException::withMessages([
            "otp" => 'Invalid Otp'
        ]);
        return redirect()->back();
    }

    /**
     * Dashboard.
     *
     * @param Provider $provider
     * @return Response
     */

    public function dashboard($duration = null)
    {
        try {
            $user_id = auth()->guard('admin')->id();
            $service_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALSERVICES'));
            $service_data_permission = Helper::CheckPermission(config('const.DATA'), config('const.TOTALSERVICES'));
            $user_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALUSERS'));
            $user_data_permission = Helper::CheckPermission(config('const.DATA'), config('const.TOTALUSERS'));
            $driver_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALDRIVERS'));
            $driver_data_permission = Helper::CheckPermission(config('const.DATA'), config('const.TOTALDRIVERS'));

            $bookings_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALBOOKINGS'));
            $schedule_bookings_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALSCHEDULEBOOKINGS'));
            $driver_cancelled_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALDRIVERCANCELLED'));
            $user_cancelled_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALUSERCANCELLED'));
            $revenue_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALREVENUE'));
            $tip_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALTIP'));
            $tip_driver_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALTIPDRIVER'));
            $tip_comission_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALTIPCOMISSION'));
            $cash_payment_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALCASHPAYMENTS'));
            $online_payment_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALONLINEPAYMENTS'));
            $ios_user_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALIOSUSERS'));
            $android_user_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALANDROIDUSERS'));
            $male_user_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALMALEUSERS'));
            $female_user_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALFEMALEUSERS'));
            $ongoing_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALONGOINGRIDERS'));

            $rides_graph_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALRIDESGRAPH'));
            $payments_graph_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALPAYMENTMODEGRAPH'));
            $users_graph_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALUSERDATAGRAPH'));

            $rides_table_view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.TOTALRECENTRIDESTABLE'));
            
            if ($duration == null) {
                $rides = UserRequests::has('user')->orderBy('id', 'desc')->get();
                $cancel_rides = UserRequests::where('status', 'CANCELLED');
                $UserRequests = UserRequests::count();
                $scheduled_rides = UserRequests::where('status', 'SCHEDULED')->count();
                $canceled_rides = UserRequests::where('status', 'CANCELLED')->count();
                $completed_rides = UserRequests::where('status', 'COMPLETED')->count();
                $ongoing_rides = $UserRequests - $completed_rides - $canceled_rides - $scheduled_rides;
                $user_cancelled = UserRequests::where('status', 'CANCELLED')->where('cancelled_by', 'USER')->count();
                $provider_cancelled = UserRequests::where('status', 'CANCELLED')->where('cancelled_by', 'PROVIDER')->count();
                $cancel_rides = UserRequests::where('status', 'CANCELLED')->count();
                $service = ServiceType::when($service_data_permission != 1, function ($query) use ($user_id) {
                    return $query->where('created_by', $user_id);
                })
                ->count();
                $fleet = Fleet::count();
                $user = User::when($user_data_permission != 1, function ($query) use ($user_id) {
                    return $query->where('created_by', $user_id);
                })
                ->count();
                $completed_rides_ids = UserRequests::where('status', 'COMPLETED')->pluck('id');
                $revenue = UserRequestPayment::whereIn('request_id', $completed_rides_ids)->sum('total');
                $cashpayments = UserRequests::where('status', 'COMPLETED')->where('payment_mode', 'CASH')->count();
                $tip_sum = UserRequests::where('status', 'COMPLETED')->sum('tip_amount');
                $tip_sum_driver = UserRequests::where('status', 'COMPLETED')->sum('tip_amount_driver');
                $tip_commission = UserRequests::where('status', 'COMPLETED')->sum('commission_tip_amount');
                $online_payments = UserRequests::where('status', 'COMPLETED')->where('payment_mode', 'CARD')->count();
                $ios_devices_users = User::where('device_type', 'ios')->count();
                $android_devices_users = User::where('device_type', 'android')->count();
                $male_users = User::where('gender', 'male')->count();
                $female_users = User::where('gender', 'female')->count();
                $incoming_rides = UserRequests::where('status', '!=', 'COMPLETED')->where('status', '!=', 'CANCELLED')->count();
                $provider = Provider::when($driver_data_permission != 1, function ($query) use ($user_id) {
                    return $query->where('created_by', $user_id);
                })
                ->count();
                $providers = Provider::when($driver_data_permission != 1, function ($query) use ($user_id) {
                        return $query->where('created_by', $user_id);
                    })
                    ->orderBy('rating', 'desc')
                    ->take(10)
                    ->get();

            } else {
                $durationDateTime = Carbon::now()->subDays($duration)->toDateTimeString();
                $rides = UserRequests::has('user')->orderBy('id', 'desc')->where('created_at', '>=', $durationDateTime)->get();
                $cancel_rides = UserRequests::where('status', 'CANCELLED')->where('created_at', '>=', $durationDateTime);
                $UserRequests = UserRequests::where('created_at', '>=', $durationDateTime)->count();
                $scheduled_rides = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'SCHEDULED')->count();
                $canceled_rides = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'CANCELLED')->count();
                $completed_rides = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'COMPLETED')->count();
                $ongoing_rides = $UserRequests - $completed_rides - $canceled_rides - $scheduled_rides;
                $user_cancelled = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'CANCELLED')->where('cancelled_by', 'USER')->count();
                $provider_cancelled = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'CANCELLED')->where('cancelled_by', 'PROVIDER')->count();
                $cancel_rides = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'CANCELLED')->count();
                $service =  ServiceType::where('created_at', '>=', $durationDateTime)
                ->when($service_data_permission != 1, function ($query) use ($user_id) {
                    return $query->where('created_by', $user_id);
                })
                ->count();
                $fleet = Fleet::where('created_at', '>=', $durationDateTime)->count();
                $user =  User::where('created_at', '>=', $durationDateTime)
                ->when($service_data_permission != 1, function ($query) use ($user_id) {
                    return $query->where('created_by', $user_id);
                })
                ->count();
                $completed_rides_ids = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'COMPLETED')->pluck('id');
                $revenue = UserRequestPayment::where('created_at', '>=', $durationDateTime)->whereIn('request_id', $completed_rides_ids)->sum('total');
                $cashpayments = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'COMPLETED')->where('payment_mode', 'CASH')->count();
                $tip_sum = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'COMPLETED')->sum('tip_amount');
                $tip_sum_driver = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'COMPLETED')->sum('tip_amount_driver');
                $tip_commission = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'COMPLETED')->sum('commission_tip_amount');
                $online_payments = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', 'COMPLETED')->where('payment_mode', 'CARD')->count();
                $ios_devices_users = User::where('created_at', '>=', $durationDateTime)->where('device_type', 'ios')->count();
                $android_devices_users = User::where('created_at', '>=', $durationDateTime)->where('device_type', 'android')->count();
                $male_users = User::where('created_at', '>=', $durationDateTime)->where('gender', 'male')->count();
                $female_users = User::where('created_at', '>=', $durationDateTime)->where('gender', 'female')->count();
                $incoming_rides = UserRequests::where('created_at', '>=', $durationDateTime)->where('status', '!=', 'COMPLETED')->where('status', '!=', 'CANCELLED')->count();
                $provider = Provider::where('created_at', '>=', $durationDateTime)
                    ->when($driver_data_permission != 1, function ($query) use ($user_id) {
                        return $query->where('created_by', $user_id);
                    })
                    ->count();

                $providers = Provider::where('created_at', '>=', $durationDateTime)
                    ->when($driver_data_permission != 1, function ($query) use ($user_id) {
                        return $query->where('created_by', $user_id);
                    })
                    ->orderBy('rating', 'desc')
                    ->take(10)
                    ->get();

            }


            return view('admin.dashboard', get_defined_vars());
        } catch (Exception $e) {
            return redirect()->route('admin.user.index')->with('flash_error', translateKeyword('Something Went Wrong with Dashboard!'));
        }
    }

    public function cancellations()
    {
        $requests = UserRequests::with(['user', 'provider'])->where('status', 'CANCELLED')->orderBy('id', 'desc')->get();

        return view('admin.request.cancellations', compact('requests'));
    }

    /**
     * Heat Map.
     *
     * @param Provider $provider
     * @return Response
     */

    public function heatmap()

    {

        try {

            $rides = UserRequests::has('user')->orderBy('id', 'desc')->get();

            $providers = Provider::take(10)->orderBy('rating', 'desc')->get();

            return view('admin.heatmap', compact('providers', 'rides'));
        } catch (Exception $e) {

            return redirect()->route('admin.user.index')->with('flash_error', translateKeyword('Something Went Wrong with Dashboard!'));
        }
    }

    /**
     * Map of all Users and Drivers.
     *
     * @return Response
     */

    public function map_index()

    {

        return view('admin.map.index');
    }

    /**
     * Map of all Users and Drivers.
     *
     * @return Response
     */

    public function map_ajax()

    {
        try {
            
            $providers = Provider::where('latitude', '!=', 0)
                ->where('longitude', '!=', 0)
                ->with(['service' => function ($q) {
                    $q->where('status', '!=', 'offline');
                }])
                ->whereHas('service')
                ->get();

            $dataProviders = [];
            
            foreach($providers as $provider) {
                foreach($provider->service as $provider_service) {
                    $providerWithService = Provider::where('id', $provider->id)
                    ->with(['service' => function ($q) use ($provider_service) {
                        // $q->where('is_selected', 1);
                        $q->where('id', '=', $provider_service->id);
                    }, 'service.service_type'])->first();

                    array_push($dataProviders, $providerWithService);
                }
            }

            $users = User::where('latitude', '!=', 0)
                ->where('longitude', '!=', 0)
                ->get();

            for ($i = 0; $i < sizeof($users); $i) {
                $users[$i]->status = 'user';
            }

            $all = $users->merge($providers);

            return $all;
        } catch (Exception $e) {

            return [];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function settings()

    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.WEBSETTINGS'));
        $timezones = DateTimeZone::listIdentifiers();
        return view('admin.settings.application', get_defined_vars());
    }

    public function f_settings()

    {

        return view('admin.settings.f_settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function f_settings_store(Request $request)

    {

        if (Setting::get('demo_mode', 0) == 1) {

            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        $this->validate($request, [

            'site_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'f_img2' => 'mimes:jpeg,jpg,bmp,png|max:5242880',

        ]);

        if ($request->hasFile('f_img2')) {
            $f_img2 = $request->f_img2->store('website');
            $f_img2 = asset('storage/' . $f_img2);
            Setting::set('f_img2', $f_img2);
        }

        if ($request->hasFile('site_logo')) {
            $site_logo = $request->site_logo->store('website');
            $site_logo = asset('storage/' . $site_logo);
            Setting::set('site_logo', $site_logo);
        }

        Setting::set('site_copyright', $request->site_copyright);
        Setting::set('site_copyright_url', $request->site_copyright_url);
        Setting::set('website_theme', $request->website_theme);
        Setting::set('website_theme_color', $request->website_theme_color);

        Setting::set('f_u_url', $request->f_u_url);

        Setting::set('f_p_url', $request->f_p_url);

        Setting::set('site_link', $request->site_link);

        Setting::set('contact_message', $request->contact_message);

        Setting::set('contact_city', $request->contact_city);
     

        Setting::set('contact_address', $request->contact_address);

        Setting::set('index_paragraph', $request->index_paragraph);

        Setting::set('contact_email', $request->contact_email);

        Setting::set('contact_number_show', $request->has('contact_number_show') ? 1 : 0);

        Setting::set('contact_number', $request->contact_number);


        Setting::set('f_text1', $request->f_text1);
        Setting::set('f_text2', $request->f_text2);
        Setting::set('f_text6', $request->f_text6);
        Setting::set('f_text7', $request->f_text7);
        Setting::set('f_text8', $request->f_text8);
        Setting::set('f_text9', $request->f_text9);
        Setting::set('f_text10', $request->f_text10);
        Setting::set('f_text11', $request->f_text11);
        Setting::set('f_text12', $request->f_text12);
        Setting::set('f_text13', $request->f_text13);
        Setting::set('f_text14', $request->f_text14);
        Setting::set('f_text15', $request->f_text15);
        Setting::set('f_text16', $request->f_text16);
        Setting::set('f_text17', $request->f_text17);
        Setting::set('f_text18', $request->f_text18);
        Setting::set('f_text19', $request->f_text19);
        Setting::set('f_text20', $request->f_text20);
        Setting::set('f_text21', $request->f_text21);
        Setting::set('f_text22', $request->f_text22);
        Setting::set('f_text23', $request->f_text23);
        Setting::set('f_text24', $request->f_text24);
        Setting::set('f_text25', $request->f_text25);
        Setting::set('f_text26', $request->f_text26);
        Setting::set('f_text27', $request->f_text27);

        Setting::save();

        return back()->with('flash_success', translateKeyword('Settings Updated Successfully'));
    }

    public function settings_store(Request $request)

    {
        // return $request->all();

        if (Setting::get('demo_mode', 0) == 1) {

            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        $this->validate($request, [
            // 'map_key' => 'required',

            // 'site_title' => 'required',

            'site_icon' => 'mimes:jpeg,jpg,bmp,png|max:5242880',

            'site_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',

            'f_img2' => 'mimes:jpeg,jpg,bmp,png|max:5242880',

        ]);

        if ($request->hasFile('site_icon')) {
            $site_icon = $request->site_icon->store('website');
            $site_icon = asset('storage/' . $site_icon);
            Setting::set('site_icon', $site_icon);
        }

        if ($request->hasFile('f_mainBanner')) {
            $f_mainBanner = $request->f_mainBanner->store('website');
            $f_mainBanner = asset('storage/' . $f_mainBanner);
            Setting::set('f_mainBanner', $f_mainBanner);
        }
        if ($request->hasFile('faq_image')) {
            $faq_image = $request->faq_image->store('website');
            $faq_image = asset('storage/' . $faq_image);
            Setting::set('faq_image', $faq_image);
        }
        if ($request->hasFile('blogs_image')) {
            $blogs_image = $request->blogs_image->store('website');
            $blogs_image = asset('storage/' . $blogs_image);
            Setting::set('blogs_image', $blogs_image);
        }
        if ($request->hasFile('testinomial_image')) {
            $testinomial_image = $request->testinomial_image->store('website');
            $testinomial_image = asset('storage/' . $testinomial_image);
            Setting::set('testinomial_image', $testinomial_image);
        }
        if ($request->hasFile('home_page_video')) {
            $home_page_video = $request->home_page_video->store('website');
            $home_page_video = asset('storage/' . $home_page_video);
            Setting::set('home_page_video', $home_page_video);
        }

        if ($request->hasFile('mockup_one')) {
            $mockup_one = $request->mockup_one->store('website');
            $mockup_one = asset('storage/' . $mockup_one);
            Setting::set('mockup_one', $mockup_one);
        }

        if ($request->hasFile('mockup_two')) {
            $mockup_two = $request->mockup_two->store('website');
            $mockup_two = asset('storage/' . $mockup_two);
            Setting::set('mockup_two', $mockup_two);
        }

        if ($request->hasFile('website_login')) {
            $website_login = $request->website_login->store('website');
            $website_login = asset('storage/' . $website_login);
            Setting::set('website_login', $website_login);
        }

        if ($request->hasFile('website_register')) {
            $website_register = $request->website_register->store('website');
            $website_register = asset('storage/' . $website_register);
            Setting::set('website_register', $website_register);
        }

        if ($request->hasFile('admin_panel')) {
            $admin_panel = $request->admin_panel->store('website');
            $admin_panel = asset('storage/' . $admin_panel);
            Setting::set('admin_panel', $admin_panel);
        }

        if ($request->hasFile('slider_image1')) {
            $slider_image1 = $request->slider_image1->store('website');
            $slider_image1 = asset('storage/' . $slider_image1);
            Setting::set('slider_image1', $slider_image1);
        }
        if ($request->hasFile('slider_image2')) {
            $slider_image2 = $request->slider_image2->store('website');
            $slider_image2 = asset('storage/' . $slider_image2);
            Setting::set('slider_image2', $slider_image2);
        }

        if ($request->hasFile('slider_image3')) {
            $slider_image3 = $request->slider_image3->store('website');
            $slider_image3 = asset('storage/' . $slider_image3);
            Setting::set('slider_image3', $slider_image3);
        }

        if ($request->hasFile('slider_image4')) {
            $slider_image4 = $request->slider_image4->store('website');
            $slider_image4 = asset('storage/' . $slider_image4);
            Setting::set('slider_image4', $slider_image4);
        }

        if ($request->hasFile('slider_image5')) {
            $slider_image5 = $request->slider_image5->store('website');
            $slider_image5 = asset('storage/' . $slider_image5);
            Setting::set('slider_image5', $slider_image5);
        }

        if ($request->hasFile('f_img2')) {
            $f_img2 = $request->f_img2->store('website');
            $f_img2 = asset('storage/' . $f_img2);
            Setting::set('f_img2', $f_img2);
        }

        if ($request->hasFile('site_logo')) {
            $site_logo = $request->site_logo->store('website');
            $site_logo = asset('storage/' . $site_logo);
            Setting::set('site_logo', $site_logo);
        }

        if ($request->hasFile('site_email_logo')) {
            $site_email_logo = $request->site_email_logo->store('website');
            $site_email_logo = asset('storage/' . $site_email_logo);
            Setting::set('site_email_logo', $site_email_logo);
        }

        // Setting::set('button_color_code', $request->has('button_color_code') ? $request->button_color_code : '9809');

        // Setting::set('site_title', $request->site_title);
        // Setting::set('site_title_romanian', $request->site_title_romanian);
        // Setting::set('site_title_arabic', $request->site_title_arabic);
        // Setting::set('site_title_swedish', $request->site_title_swedish);
        // Setting::set('site_title_spanish', $request->site_title_spanish);
        // Setting::set('site_sub_title', $request->site_sub_title);
        // Setting::set('meta_title', $request->meta_title);
        // Setting::set('meta_keywords', $request->meta_keywords);
        // Setting::set('meta_description', $request->meta_description);
        // Setting::set('introduction_text', $request->introduction_text);
        Setting::set('ride_btn', $request->has('ride_btn') ? 1 : 0);
        Setting::set('offer_section', $request->has('offer_section') ? 1 : 0);
        Setting::set('introduction', $request->has('introduction') ? 1 : 0);
        Setting::set('features_section', $request->has('features_section') ? 1 : 0);
        Setting::set('tax_tps_info_field', $request->has('tax_tps_info_field') ? 1 : 0);
        Setting::set('tax_tvq_info_field', $request->has('tax_tvq_info_field') ? 1 : 0);

        if ($request->hasFile('booking_form_image')) {
            $booking_form_image = $request->booking_form_image->store('website');
            $booking_form_image = asset('storage/' . $booking_form_image);
            Setting::set('booking_form_image', $booking_form_image);
        }

        if ($request->hasFile('connexi_booking_form_image')) {
            $connexi_booking_form_image = $request->connexi_booking_form_image->store('website');
            $connexi_booking_form_image = asset('storage/' . $connexi_booking_form_image);
            Setting::set('connexi_booking_form_image', $connexi_booking_form_image);
        }

        if ($request->hasFile('advantage_image_1')) {
            $advantage_image_1 = $request->advantage_image_1->store('website');
            $advantage_image_1 = asset('storage/' . $advantage_image_1);
            Setting::set('advantage_image_1', $advantage_image_1);
        }

        if ($request->hasFile('advantage_image_2')) {
            $advantage_image_2 = $request->advantage_image_2->store('website');
            $advantage_image_2 = asset('storage/' . $advantage_image_2);
            Setting::set('advantage_image_2', $advantage_image_2);
        }

        if ($request->hasFile('call_us_image')) {
            $call_us_image = $request->call_us_image->store('website');
            $call_us_image = asset('storage/' . $call_us_image);
            Setting::set('call_us_image', $call_us_image);
        }


        // Setting::set('map_contact_page', $request->map_contact_page);

        // Setting::set('user_store_link_ios', $request->user_store_link_ios);

        // Setting::set('driver_store_link_ios', $request->driver_store_link_ios);

        // Setting::set('provider_select_timeout', $request->provider_select_timeout);

        // Setting::set('provider_search_radius', $request->provider_search_radius);

        // Setting::set('sos_number', $request->sos_number);
        // Setting::set('contact_number_show', $request->has('contact_number_show') ? 1 : 0);

        // Setting::set('contact_number', $request->contact_number);

        // Setting::set('contact_email_address', $request->contact_email_address);

        // Setting::set('social_login', $request->social_login);
        Setting::set('web_card_payment', $request->has('web_card_payment') ? 1 : 0);
        Setting::set('play_bell', $request->has('play_bell') ? 1 : 0);


        // Setting::set('f_u_url', $request->f_u_url);

        // Setting::set('f_p_url', $request->f_p_url);

        // Setting::set('contact_city', $request->contact_city);
           
        // Set the new timezone in the settings
        if($request->has('timezone')){
            Setting::set('timezone', $request->timezone);
            config(['app.timezone' => $request->timezone]);
            // Optionally, set the PHP timezone as well
            date_default_timezone_set($request->timezone);
        }

         
        // Setting::set('contact_address', $request->contact_address);
        Setting::set('index_paragraph', $request->index_paragraph);
        Setting::set('km_driven', $request->km_driven);
        Setting::set('people_dropped', $request->people_dropped);
        Setting::set('taxi_drivers', $request->taxi_drivers);
        Setting::set('happy_people', $request->happy_people);
        Setting::set('site_copyright', $request->site_copyright);
        Setting::set('site_copyright_url', $request->site_copyright_url);
        Setting::set('site_email', $request->site_email);
        Setting::set('website_theme', $request->website_theme);
        Setting::set('website_languages', $request->website_languages);
        
        $locale = $request->website_languages;
        App::setLocale($locale);
        Session::put('locale', $locale);

        // $cookie = Cookie::make('googtrans', "/en" . "/" . $request->website_languages, 'Session', null, null, false, false); //for google tranlate
        Setting::set('website_theme_color', $request->website_theme_color);

        //faqs
        // Setting::set('faqQ1', $request->faqQ1);
        // Setting::set('faqA1', $request->faqA1);
        // Setting::set('faqQ2', $request->faqQ2);
        // Setting::set('faqA2', $request->faqA2);
        // Setting::set('faqQ3', $request->faqQ3);
        // Setting::set('faqA3', $request->faqA3);
        // Setting::set('faqQ4', $request->faqQ4);
        // Setting::set('faqA4', $request->faqA4);
        // Setting::set('faqQ5', $request->faqQ5);
        // Setting::set('faqA5', $request->faqA5);
        // Setting::set('faqQ6', $request->faqQ6);
        // Setting::set('faqA6', $request->faqA6);
        // Setting::set('faqQ7', $request->faqQ7);
        // Setting::set('faqA7', $request->faqA7);
        // Setting::set('faqQ8', $request->faqQ8);
        // Setting::set('faqA8', $request->faqA8);

        // Setting::set('map_key', $request->map_key);
        // Setting::set('distance_system', $request->distance_system);
        // Setting::set('country_code', $request->country_code);

        // Setting::set('f_f_link', $request->f_f_link);
        // Setting::set('f_t_link', $request->f_t_link);
        // Setting::set('f_l_link', $request->f_l_link);
        // Setting::set('f_i_link', $request->f_i_link);
        // Setting::set('f_y_link', $request->f_y_link);

        Setting::set('youtube_link', $request->youtube_link);

        // Setting::set('latitude', $request->latitude);

        // Setting::set('longitude', $request->longitude);

        Setting::set('driver_on_web', $request->has('driver_on_web') ? 1 : 0);
        Setting::set('all_provider_dispatcher', $request->has('all_provider_dispatcher') ? 1 : 0);
        Setting::set('login_on_web', $request->has('login_on_web') ? 1 : 0);
        Setting::set('call_us', $request->has('call_us') ? 1 : 0);
        Setting::set('register_on_web', $request->has('register_on_web') ? 1 : 0);
        Setting::set('video_on_web', $request->has('video_on_web') ? 1 : 0);
        Setting::set('bookingform_on_web', $request->has('bookingform_on_web') ? 1 : 0);
        Setting::set('force_login_page', $request->has('force_login_page') ? 1 : 0);
        Setting::set('login_phone_hidden', $request->has('login_phone_hidden') ? 1 : 0);
        Setting::set('account_panel', $request->has('account_panel') ? 1 : 0);
        Setting::set('vendor_panel', $request->has('vendor_panel') ? 1 : 0);
        Setting::set('faq_switch', $request->has('faq_switch') ? 1 : 0);
        Setting::set('landing_page', $request->has('landing_page') ? 1 : 0);
        Setting::set('blogs_switch', $request->has('blogs_switch') ? 1 : 0);
        Setting::set('testinomials_switch', $request->has('testinomials_switch') ? 1 : 0);
        Setting::set('dispatcher_panel', $request->has('dispatcher_panel') ? 1 : 0);
        Setting::set('cta_container', $request->has('cta_container') ? 1 : 0);
        Setting::set('contact_info_container', $request->has('contact_info_container') ? 1 : 0);
        Setting::set('services_container', $request->has('services_container') ? 1 : 0);
        Setting::set('offer_container', $request->has('offer_container') ? 1 : 0);
        Setting::set('mockup_section', $request->has('mockup_section') ? 1 : 0);
        Setting::set('home_button', $request->has('home_button') ? 1 : 0);
        Setting::set('slider_container', $request->has('slider_container') ? 1 : 0);
        Setting::set('show_preset_credentials', $request->has('show_preset_credentials') ? 1 : 0);
        Setting::set('website_enable', $request->has('website_enable') ? 1 : 0);
        Setting::set('multilanguage_enabled', $request->has('multilanguage_enabled') ? 1 : 0);
        Setting::set('hide_conexi_code', $request->has('hide_conexi_code') ? 1 : 0);
        
        Setting::set('admin_login_otp', $request->has('admin_login_otp') ? 1 : 0);
        Setting::set('account_login_otp', $request->has('account_login_otp') ? 1 : 0);
        Setting::set('fleet_login_otp', $request->has('fleet_login_otp') ? 1 : 0);
        Setting::set('dispatcher_login_otp', $request->has('dispatcher_login_otp') ? 1 : 0);

        Setting::set('cat_web_ecomony', $request->has('cat_web_ecomony') ? 1 : 0);

        Setting::set('cat_web_lux', $request->has('cat_web_lux') ? 1 : 0);

        Setting::set('cat_web_ext', $request->has('cat_web_ext') ? 1 : 0);

        Setting::set('cat_web_out', $request->has('cat_web_out') ? 1 : 0);
        Setting::set('cat_web_dream_driver', $request->has('cat_web_dream_driver') ? 1 : 0);
        Setting::set('cat_web_road_assist', $request->has('cat_web_road_assist') ? 1 : 0);
        Setting::set('cat_web_personal_care', $request->has('cat_web_personal_care') ? 1 : 0);
        Setting::set('cat_web_medical_health', $request->has('cat_web_medical_health') ? 1 : 0);
        Setting::set('cat_web_education_training', $request->has('cat_web_education_training') ? 1 : 0);
        Setting::set('cat_web_consulting', $request->has('cat_web_consulting') ? 1 : 0);
        Setting::set('cat_web_cleaning_services', $request->has('cat_web_cleaning_services') ? 1 : 0);
        Setting::set('cat_web_maintenance', $request->has('cat_web_maintenance') ? 1 : 0);
        Setting::set('cat_web_construction', $request->has('cat_web_construction') ? 1 : 0);
        Setting::set('cat_web_security', $request->has('cat_web_security') ? 1 : 0);
        Setting::set('cat_web_landscaping', $request->has('cat_web_landscaping') ? 1 : 0);
        Setting::set('cat_web_garden', $request->has('cat_web_garden') ? 1 : 0);
        Setting::set('cat_web_outdoor_construction', $request->has('cat_web_outdoor_construction') ? 1 : 0);
        Setting::set('cat_web_exterior_design', $request->has('cat_web_exterior_design') ? 1 : 0);

        Setting::set('customer_bank_info', $request->has('customer_bank_info') ? 1 : 0);

        Setting::save();

        $this->logService->log('Settings', 'update', 'Web Settings Updated.', $request->all());

        // return redirect()->back()->with('flash_success', 'Settings Updated Successfully')->withCookie($cookie);//for google tranlate
        return redirect()->back()->with('flash_success', translateKeyword('Settings Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function settings_payment()

    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.PAYMENTSETTINGS'));
        return view('admin.payment.settings', get_defined_vars());
    }

    public function appsetting()

    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.APPSETTINGS'));
        $languages = getLanguages();
        return view('admin.payment.appsettings', get_defined_vars());
    }

    /**
     * Save payment related settings.
     *
     * @param Provider $provider
     * @return Response
     */

    


    

   


    

    public function appsetting_store(Request $request)
    {
        Setting::set('appmaintain', $request->has('appmaintain') ? 1 : 0);
        Setting::set('delivery_note', $request->has('delivery_note') ? 1 : 0);
        Setting::set('pickup_location', $request->has('pickup_location') ? 1 : 0);
        Setting::set('dropoff_location', $request->has('dropoff_location') ? 1 : 0);

        Setting::set('whatsapp_support', $request->has('whatsapp_support') ? 1 : 0);
        Setting::set('whatsapp_number', $request->whatsapp_number);
        Setting::set('sos_support', $request->has('sos_support') ? 1 : 0);
        Setting::set('sos_number', $request->sos_number);
        Setting::set('customer_support', $request->has('customer_support') ? 1 : 0);
        Setting::set('customer_support_number', $request->customer_support_number);
        Setting::set('email_support', $request->has('email_support') ? 1 : 0);
        Setting::set('email_address_support', $request->email_address_support);
        Setting::set('tawk_support', $request->has('tawk_support') ? 1 : 0);
        Setting::set('tawk_live', $request->tawk_live);
        Setting::set('widget_id', $request->widget_id);
        Setting::set('fb_chat', $request->has('fb_chat') ? 1 : 0);
        Setting::set('fb_chat_page_id', $request->fb_chat_page_id);
        Setting::set('gender_pref_enabled', $request->has('gender_pref_enabled') ? 1 : 0);
        Setting::set('user_app_rating', $request->has('user_app_rating') ? 1 : 0);
        Setting::set('driver_app_rating', $request->has('driver_app_rating') ? 1 : 0);
        Setting::set('customer_app_link_driver', $request->has('customer_app_link_driver') ? 1 : 0);
        Setting::set('driver_app_link_customer', $request->has('driver_app_link_customer') ? 1 : 0);
        Setting::set('broadcast_request_all', $request->has('broadcast_request_all') ? 1 : 0);
        Setting::set('distance_system', $request->distance_system);
        Setting::set('distance_system_calculation', $request->distance_system_calculation);
        Setting::set('country_code', $request->country_code);
        Setting::set('provider_select_timeout', $request->provider_select_timeout);
        Setting::set('provider_search_radius', $request->provider_search_radius);

        Setting::set('rider_subscription_module',  $request->has('rider_subscription_module') ?  1 : 0);
        Module::find(12)->update(['is_active'=> $request->has('rider_subscription_module') ?  1 : 0]);
        Setting::set('driver_subscription_module',  $request->has('driver_subscription_module') ?  1 : 0);
        Module::find(13)->update(['is_active' => $request->has('driver_subscription_module') ?  1 : 0]);

        if (!$request->has('subscription_module')) {
            Module::find(11)->update(['is_active' => 0]);
            Module::find(12)->update(['is_active' => 0]);
            Module::find(13)->update(['is_active' => 0]);

            Setting::set('driver_subscription_module', 0);
            Setting::set('rider_subscription_module', 0);
        }else{
            Module::find(11)->update(['is_active' => 1]);
        }

        Setting::set('rider_trial_period', $request->rider_trial_period);
        Setting::set('driver_trial_period', $request->driver_trial_period);

        Setting::set('driver_cancellation_block',  $request->has('driver_cancellation_block') ?  1 : 0);
        Setting::set('max_allowed_cancellation', $request->max_allowed_cancellation);
        Setting::set('allowed_cancellation_unit', $request->allowed_cancellation_unit);
        Setting::set('allowed_cancellation_unit_value', $request->allowed_cancellation_unit_value);

        // Setting::set('driver_subscription_module',  $request->has('driver_subscription_module') ?  1 : 0);
        // Setting::set('',  $request->has('rider_subscription_module') ?  1 : 0);

        Setting::set('tax_tps_info_field', $request->has('tax_tps_info_field') ? 1 : 0);
        Setting::set('tax_tvq_info_field', $request->has('tax_tvq_info_field') ? 1 : 0);


       



        if ($request->has('verification')) {
            Setting::set('verification', 1);
            Setting::set('twilio_verification', 0);
        } else {
            Setting::set('verification', 0);
        }

        if ($request->has('twilio_verification')) {
            Setting::set('verification', 0);
            Setting::set('twilio_verification', 1);
        } else {
            Setting::set('twilio_verification', 0);
        }


        Setting::set('twilio_sid', $request->twilio_sid);
        Setting::set('twilio_token', $request->twilio_token);
        Setting::set('twilio_from', $request->twilio_from);

        Setting::set('tip_collect', $request->has('tip_collect') ? 1 : 0);
        Setting::set('pre_booking_hourly_hold', $request->has('pre_booking_hourly_hold') ? 1 : 0);

        Setting::set('booking_pre_payment', $request->has('booking_pre_payment') ? 1 : 0);
        Setting::set('manage_card_driver', $request->has('manage_card_driver') ? 1 : 0);
        Setting::set('manage_card_passenger', $request->has('manage_card_passenger') ? 1 : 0);
        Setting::set('booking_prepayment_method', $request->has('booking_prepayment_method') ? 1 : 0);
        // Setting::set('wallet_suggest', $request->has('wallet_suggest') ? 1 : 0);
        Setting::set('wallet_sharing', $request->has('wallet_sharing') ? 1 : 0);

        Setting::set('tip_suggestion1', $request->has('tip_suggestion1') ? $request->tip_suggestion1 : 0);
        Setting::set('tip_suggestion2', $request->has('tip_suggestion2') ? $request->tip_suggestion2 : 0);
        Setting::set('tip_suggestion3', $request->has('tip_suggestion3') ? $request->tip_suggestion3 : 0);


        Setting::set('first_hold_time', $request->first_hold_time);
        Setting::set('second_hold_time', $request->second_hold_time);

        Setting::set('driver_ban_ride_cancellation', $request->has('driver_ban_ride_cancellation') ? 1 : 0);
        Setting::set('round_value_nearest_ten', $request->has('round_value_nearest_ten') ? 1 : 0);
        Setting::set('ban_number_of_days', $request->ban_number_of_days);
        Setting::set('cancelled_number_of_rides', $request->cancelled_number_of_rides);

        Setting::set('driver_earning', $request->has('driver_earning') ? 1 : 0);
        Setting::set('driver_summary', $request->has('driver_summary') ? 1 : 0);
        Setting::set('driver_document', $request->has('driver_document') ? 1 : 0);
        Setting::set('vertical_service_listing', $request->has('vertical_service_listing') ? 1 : 0);


        Setting::set('cancellation_jobs_blockage', $request->has('cancellation_jobs_blockage') ? 1 : 0);
        Setting::set('cancellation_jobs_limit', $request->cancellation_jobs_limit);
        Setting::set('cancellation_jobs_days', $request->cancellation_jobs_days);

        Setting::set('donation_suggestion1', $request->has('donation_suggestion1') ? $request->donation_suggestion1 : 0);
        Setting::set('donation_suggestion2', $request->has('donation_suggestion2') ? $request->donation_suggestion2 : 0);
        Setting::set('donation_suggestion3', $request->has('donation_suggestion3') ? $request->donation_suggestion3 : 0);


        Setting::set('wallet_suggestion1', $request->has('wallet_suggestion1') ? $request->wallet_suggestion1 : 0);
        Setting::set('wallet_suggestion2', $request->has('wallet_suggestion2') ? $request->wallet_suggestion2 : 0);
        Setting::set('wallet_suggestion3', $request->has('wallet_suggestion3') ? $request->wallet_suggestion3 : 0);



        //Rider or User
        // Setting::set('onboarding_user_title1', $request->onboarding_user_title1);
        // Setting::set('onboarding_user_description1', $request->onboarding_user_description1);
        // Setting::set('onboarding_user_title2', $request->onboarding_user_title2);
        // Setting::set('onboarding_user_description2', $request->onboarding_user_description2);
        // Setting::set('onboarding_user_title3', $request->onboarding_user_title3);
        // Setting::set('onboarding_user_description3', $request->onboarding_user_description3);
        // Setting::set('onboarding_user_title4', $request->onboarding_user_title4);
        // Setting::set('onboarding_user_description4', $request->onboarding_user_description4);
        // Setting::set('onboarding_user_title5', $request->onboarding_user_title5);
        // Setting::set('onboarding_user_description5', $request->onboarding_user_description5);

        //driver
        // Setting::set('onboarding_driver_title1', $request->onboarding_driver_title1);
        // Setting::set('onboarding_driver_description1', $request->onboarding_driver_description1);
        // Setting::set('onboarding_driver_title2', $request->onboarding_driver_title2);
        // Setting::set('onboarding_driver_description2', $request->onboarding_driver_description2);
        // Setting::set('onboarding_driver_title3', $request->onboarding_driver_title3);
        // Setting::set('onboarding_driver_description3', $request->onboarding_driver_description3);
        // Setting::set('onboarding_driver_title4', $request->onboarding_driver_title4);
        // Setting::set('onboarding_driver_description4', $request->onboarding_driver_description4);
        // Setting::set('onboarding_driver_title5', $request->onboarding_driver_title5);
        // Setting::set('onboarding_driver_description5', $request->onboarding_driver_description5);

        Setting::set('rider_faq', $request->has('rider_faq') ? 1 : 0);
        Setting::set('driver_faq', $request->has('driver_faq') ? 1 : 0);



        // Setting::set('cancel_reason', $request->has('cancel_reason') ? 1 : 0);
        // Setting::set('cancel_reason_customer_1', $request->cancel_reason_customer_1);
        // Setting::set('cancel_reason_customer_2', $request->cancel_reason_customer_2);
        // Setting::set('cancel_reason_customer_3', $request->cancel_reason_customer_3);
        // Setting::set('cancel_reason_customer_4', $request->cancel_reason_customer_4);
        // Setting::set('cancel_reason_customer_5', $request->cancel_reason_customer_5);
        // Setting::set('cancel_reason_driver_1', $request->cancel_reason_driver_1);
        // Setting::set('cancel_reason_driver_2', $request->cancel_reason_driver_2);
        // Setting::set('cancel_reason_driver_3', $request->cancel_reason_driver_3);
        // Setting::set('cancel_reason_driver_4', $request->cancel_reason_driver_4);
        // Setting::set('cancel_reason_driver_5', $request->cancel_reason_driver_5);

        //rider onboarding image
        // if ($request->hasFile('onboarding_user_image1')) {
        //     $onboarding_user_image1 = $request->onboarding_user_image1->store('website');
        //     $onboarding_user_image1 = asset('storage/' . $onboarding_user_image1);
        //     Setting::set('onboarding_user_image1', $onboarding_user_image1);
        // }
        // if ($request->hasFile('onboarding_user_image2')) {
        //     $onboarding_user_image2 = $request->onboarding_user_image2->store('website');
        //     $onboarding_user_image2 = asset('storage/' . $onboarding_user_image2);
        //     Setting::set('onboarding_user_image2', $onboarding_user_image2);
        // }

        // if ($request->hasFile('onboarding_user_image3')) {
        //     $onboarding_user_image3 = $request->onboarding_user_image3->store('website');
        //     $onboarding_user_image3 = asset('storage/' . $onboarding_user_image3);
        //     Setting::set('onboarding_user_image3', $onboarding_user_image3);
        // }

        // if ($request->hasFile('onboarding_user_image4')) {
        //     $onboarding_user_image4 = $request->onboarding_user_image4->store('website');
        //     $onboarding_user_image4 = asset('storage/' . $onboarding_user_image4);
        //     Setting::set('onboarding_user_image4', $onboarding_user_image4);
        // }

        // if ($request->hasFile('onboarding_user_image5')) {
        //     $onboarding_user_image5 = $request->onboarding_user_image5->store('website');
        //     $onboarding_user_image5 = asset('storage/' . $onboarding_user_image5);
        //     Setting::set('onboarding_user_image5', $onboarding_user_image5);
        // }

        //driver onboarding image
        // if ($request->hasFile('onboarding_driver_image1')) {
        //     $onboarding_driver_image1 = $request->onboarding_driver_image1->store('website');
        //     $onboarding_driver_image1 = asset('storage/' . $onboarding_driver_image1);
        //     Setting::set('onboarding_driver_image1', $onboarding_driver_image1);
        // }
        // if ($request->hasFile('onboarding_driver_image2')) {
        //     $onboarding_driver_image2 = $request->onboarding_driver_image2->store('website');
        //     $onboarding_driver_image2 = asset('storage/' . $onboarding_driver_image2);
        //     Setting::set('onboarding_driver_image2', $onboarding_driver_image2);
        // }

        // if ($request->hasFile('onboarding_driver_image3')) {
        //     $onboarding_driver_image3 = $request->onboarding_driver_image3->store('website');
        //     $onboarding_driver_image3 = asset('storage/' . $onboarding_driver_image3);
        //     Setting::set('onboarding_driver_image3', $onboarding_driver_image3);
        // }

        // if ($request->hasFile('onboarding_driver_image4')) {
        //     $onboarding_driver_image4 = $request->onboarding_driver_image4->store('website');
        //     $onboarding_driver_image4 = asset('storage/' . $onboarding_driver_image4);
        //     Setting::set('onboarding_driver_image4', $onboarding_driver_image4);
        // }

        // if ($request->hasFile('onboarding_driver_image5')) {
        //     $onboarding_driver_image5 = $request->onboarding_driver_image5->store('website');
        //     $onboarding_driver_image5 = asset('storage/' . $onboarding_driver_image5);
        //     Setting::set('onboarding_driver_image5', $onboarding_driver_image5);
        // }

        Setting::set('subscription_module', $request->has('subscription_module') ? 1 : 0);
        Setting::set('subscription_module_stripe_trial', $request->has('subscription_module_stripe_trial') ? 1 : 0);
        Setting::set('zone_inbound_force', $request->has('zone_inbound_force') ? 1 : 0);
        if (Setting::get('CARD', 0) == 0) {
            Setting::set('email_field', $request->has('email_field') ? 1 : 0);
        } else {
            Setting::set('email_field', 1);
        }
        Setting::set('bypass_invoice', $request->has('bypass_invoice') ? 1 : 0);
        Setting::set('show_rate_card_pricing_struct', $request->has('show_rate_card_pricing_struct') ? 1 : 0);
        Setting::set('bid_job', $request->has('bid_job') ? 1 : 0);

        Setting::set('zone_module', $request->has('zone_module') ? 1 : 0);
        Module::find(14)->update(['is_active' => $request->has('zone_module') ? 1 : 0]);
        Module::find(17)->update(['is_active' => $request->has('zone_module') ? 1 : 0]);

        Setting::set('zone_restrict_module', $request->has('zone_restrict_module') ? 1 : 0);
        Setting::set('zone_metering', $request->has('zone_metering') ? 1 : 0);
        Setting::set('service_metering', $request->has('service_metering') ? 1 : 0);
        Setting::set('ride_otp', $request->has('ride_otp') ? 1 : 0);
        Setting::set('multi_vehicle_module', $request->has('multi_vehicle_module') ? 1 : 0);
        Setting::set('multi_service_module', $request->has('multi_service_module') ? 1 : 0);
        Setting::set('vehicle_weightage', $request->has('vehicle_weightage') ? 1 : 0);
        Setting::set('schedule_booking', $request->has('schedule_booking') ? 1 : 0);
        Setting::set('wallet', $request->has('wallet') ? 1 : 0);
        Setting::set('wallet_and_coupon', $request->has('wallet_and_coupon') ? 1 : 0);
        Setting::set('driver_signup_disable', $request->has('driver_signup_disable') ? 1 : 0);
        Setting::set('driver_login_disable', $request->has('driver_login_disable') ? 1 : 0);
        Setting::set('user_login_disable', $request->has('user_login_disable') ? 1 : 0);
        Setting::set('user_signup_disable', $request->has('user_signup_disable') ? 1 : 0);
        Setting::set('round_off_value', $request->has('round_off_value') ? 1 : 0);
        Setting::set('driver_verification', $request->has('driver_verification') ? 1 : 0);
        Setting::set('driver_earning_job_request', $request->has('driver_earning_job_request') ? 1 : 0);
        Setting::set('show_pending_schedule_jobs', $request->has('show_pending_schedule_jobs') ? 1 : 0);
        Setting::set('show_pending_schedule_jobs_passenger', $request->has('show_pending_schedule_jobs_passenger') ? 1 : 0);
        Setting::set('show_pending_schedule_jobs_driver', $request->has('show_pending_schedule_jobs_driver') ? 1 : 0);
        Setting::set('cancel_ride_passenger', $request->has('cancel_ride_passenger') ? 1 : 0);
        Setting::set('code_base_job_req', $request->has('code_base_job_req') ? 1 : 0);
        Setting::set('return_trip', $request->has('return_trip') ? 1 : 0);
        Setting::set('service_time_duration', $request->has('service_time_duration') ? 1 : 0);
        Setting::set('report_images_customer', $request->has('report_images_customer') ? 1 : 0);
        Setting::set('report_images_driver', $request->has('report_images_driver') ? 1 : 0);
        Setting::set('round_value_ceiling_floor', $request->has('round_value_ceiling_floor') ? 1 : 0);
        Setting::set('block_driver', $request->has('block_driver') ? 1 : 0);
        Setting::set('block_user', $request->has('block_user') ? 1 : 0);
        Setting::set('driver_code_signup', $request->has('driver_code_signup') ? 1 : 0);
        Setting::set('user_referral', $request->has('user_referral') ? 1 : 0);
        Setting::set('driver_referral', $request->has('driver_referral') ? 1 : 0);
        Setting::set('manage_account', $request->has('manage_account') ? 1 : 0);
        Setting::set('donate_us', $request->has('donate_us') ? 1 : 0);
        Setting::set('gender_pref_run_time', $request->has('gender_pref_run_time') ? 1 : 0);
        Setting::set('favourite_driver', $request->has('favourite_driver') ? 1 : 0);
        Setting::set('free_ride', $request->has('free_ride') ? 1 : 0);
        Setting::set('dont_disturb_user', $request->has('dont_disturb_user') ? 1 : 0);
        Setting::set('multi_stops', $request->has('multi_stops') ? 1 : 0);
        Setting::set('pin_loc_map', $request->has('pin_loc_map') ? 1 : 0);
        Setting::set('promocode', $request->has('promocode') ? 1 : 0);
        Setting::set('multi_device_login_driver', $request->has('multi_device_login_driver') ? 1 : 0);
        Setting::set('multi_device_login_passenger', $request->has('multi_device_login_passenger') ? 1 : 0);
        // Setting::set('destination_time_distance_driver', $request->has('destination_time_distance_driver') ? 1 : 0);
        Setting::set('call_option_ride_start', $request->has('call_option_ride_start') ? 1 : 0);
        Setting::set('chat_option_ride_start', $request->has('chat_option_ride_start') ? 1 : 0);
        Setting::set('driver_doc_delete_expiry', $request->has('driver_doc_delete_expiry') ? 1 : 0);
        Setting::set('user_doc_delete_expiry', $request->has('user_doc_delete_expiry') ? 1 : 0);
        Setting::set('show_driver_amount_flow', $request->has('show_driver_amount_flow') ? 1 : 0);
        Setting::set('user_verification', $request->has('user_verification') ? 1 : 0);
        Setting::set('tool_tax', $request->has('tool_tax') ? 1 : 0);
        Setting::set('add_destination_later', $request->has('add_destination_later') ? 1 : 0);
        Setting::set('app_auth_preset', $request->has('app_auth_preset') ? 1 : 0);
        Setting::set('gif_splash_ios', $request->has('gif_splash_ios') ? 1 : 0);
        Setting::set('driver_whatsapp_button', $request->has('driver_whatsapp_button') ? 1 : 0);
        Setting::set('partner_company_info', $request->has('partner_company_info') ? 1 : 0);
        Setting::set('fleet_manager_address_nif', $request->has('fleet_manager_address_nif') ? 1 : 0);
        Setting::set('customer_review', $request->has('customer_review') ? 1 : 0);
        Setting::set('driver_review', $request->has('driver_review') ? 1 : 0);
        Setting::set('customer_vehicle_info', $request->has('customer_vehicle_info') ? 1 : 0);
        Setting::set('provider_single_login', $request->has('provider_single_login') ? 1 : 0);
        Setting::set('address_user', $request->has('address_user') ? 1 : 0);
        Setting::set('address_driver', $request->has('address_driver') ? 1 : 0);
        Setting::set('dob_driver', $request->has('dob_driver') ? 1 : 0);
        Setting::set('dob_user', $request->has('dob_user') ? 1 : 0);
        Setting::set('only_pickup', $request->has('only_pickup') ? 1 : 0);
        Setting::set('driver_acc_blockage_doc', $request->has('driver_acc_blockage_doc') ? 1 : 0);
        Setting::set('driver_acc_blockage_doc_value', $request->driver_acc_blockage_doc_value);

        Setting::set('arrival_time_switch', $request->has('arrival_time_switch') ? 1 : 0);
        Setting::set('pickup_time_switch', $request->has('pickup_time_switch') ? 1 : 0);
        Setting::set('drop_time_switch', $request->has('drop_time_switch') ? 1 : 0);
        
        // Setting::set('service_operation_inbound', $request->has('service_operation_inbound') ? 1 : 0);
        Setting::set('cancellation_deduction', $request->has('cancellation_deduction') ? 1 : 0);
        Setting::set('cancellation_amount', $request->cancellation_amount);
        Setting::set('cancellation_time', $request->cancellation_time);
        Setting::set('smtp_mail', $request->has('smtp_mail') ? 1 : 0);
        Setting::set('booking_email', $request->has('booking_email') ? 1 : 0);
        Setting::set('contact_email_send', $request->has('contact_email_send') ? 1 : 0);


        Setting::set('booking_fee', $request->has('booking_fee') ? 1 : 0);
        
        Setting::set('expiry_days_limit', $request->expiry_days_limit);
        Setting::set('booking_fee_amount', $request->booking_fee_amount);
        Setting::set('booking_fee_category', $request->booking_fee_category);
        // Setting::set('booking_fee_type', $request->booking_fee_type);

        Setting::set('pickup_location_radius', $request->has('pickup_location_radius') ? 1 : 0);
        Setting::set('pickup_location_radius_value', $request->pickup_location_radius_value);

        Setting::set('app_maintenance', $request->app_maintenance);

        Setting::set('invoice', $request->has('invoice') ? 1 : 0);
        Setting::set('language_invoice', $request->language_invoice);

        Setting::set('reward_point_customer', $request->has('reward_point_customer') ? 1 : 0);
        Setting::set('reward_percentage', $request->reward_percentage);

        Setting::set('driver_at_disposal', $request->has('driver_at_disposal') ? 1 : 0);
        Setting::set('driver_disposal_phone', $request->driver_disposal_phone);

        Setting::set('booking_amount_visibility', $request->has('booking_amount_visibility') ? 1 : 0);

        Setting::set('customer_pic_mandatory', $request->has('customer_pic_mandatory') ? 1 : 0);
        Setting::set('driver_pic_mandatory', $request->has('driver_pic_mandatory') ? 1 : 0);
        Setting::set('passenger_image_camera', $request->has('passenger_image_camera') ? 1 : 0);
        Setting::set('driver_image_camera', $request->has('driver_image_camera') ? 1 : 0);
        Setting::set('gender', $request->has('gender') ? 1 : 0);


        Setting::set('negotiation_module', $request->has('negotiation_module') ? 1 : 0);
        Setting::set('negotiation_type', $request->negotiation_type);
        Setting::set('negotiation_min_threshold', $request->negotiation_min_threshold);
        Setting::set('negotiation_max_threshold', $request->negotiation_max_threshold);
        Setting::set('force_schedule_job', $request->has('force_schedule_job') ? 1 : 0);
        Setting::set('custom_amount_driver', $request->has('custom_amount_driver') ? 1 : 0);
        Setting::set('instant_booking', $request->has('instant_booking') ? 1 : 0);
        Setting::set('multi_job_website', $request->has('multi_job_website') ? 1 : 0);

        Setting::set('cat_app_ecomony', $request->has('cat_app_ecomony') ? 1 : 0);

        Setting::set('cat_app_lux', $request->has('cat_app_lux') ? 1 : 0);

        Setting::set('cat_app_ext', $request->has('cat_app_ext') ? 1 : 0);

        Setting::set('cat_app_out', $request->has('cat_app_out') ? 1 : 0);
        Setting::set('cat_app_road_assist', $request->has('cat_app_road_assist') ? 1 : 0);
        Setting::set('cat_app_dream_driver', $request->has('cat_app_dream_driver') ? 1 : 0);
        Setting::set('cat_app_rental', $request->has('cat_app_rental') ? 1 : 0);
        Setting::set('cat_app_personal_care', $request->has('cat_app_personal_care') ? 1 : 0);
        Setting::set('cat_app_medical_health', $request->has('cat_app_medical_health') ? 1 : 0);
        Setting::set('cat_app_education_training', $request->has('cat_app_education_training') ? 1 : 0);
        Setting::set('cat_app_consulting', $request->has('cat_app_consulting') ? 1 : 0);
        Setting::set('cat_app_cleaning_services', $request->has('cat_app_cleaning_services') ? 1 : 0);
        Setting::set('cat_app_maintenance', $request->has('cat_app_maintenance') ? 1 : 0);
        Setting::set('cat_app_construction', $request->has('cat_app_construction') ? 1 : 0);
        Setting::set('cat_app_security', $request->has('cat_app_security') ? 1 : 0);
        Setting::set('cat_app_landscaping', $request->has('cat_app_landscaping') ? 1 : 0);
        Setting::set('cat_app_garden', $request->has('cat_app_garden') ? 1 : 0);
        Setting::set('cat_app_outdoor_construction', $request->has('cat_app_outdoor_construction') ? 1 : 0);
        Setting::set('cat_app_exterior_design', $request->has('cat_app_exterior_design') ? 1 : 0);

        Setting::set('customer_bank_info', $request->has('customer_bank_info') ? 1 : 0);

        Setting::set('android_user_fcm_key', $request->android_user_fcm_key);

        Setting::set('android_user_driver_key', $request->android_user_driver_key);

        Setting::save();
        $this->logService->log('Settings', 'update', 'App Settings Updated.', $request->all());

        return back()->with('flash_success', translateKeyword('Settings Updated Successfully'));
    
    }

    public function settings_payment_store(Request $request)

    {

        if (Setting::get('demo_mode', 0) == 1) {

            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        $this->validate($request, [

            'CARD' => 'in:on',

            'CASH' => 'in:on',

            'stripe_secret_key' => 'required_if:CARD,on|max:255',

            'stripe_publishable_key' => 'required_if:CARD,on|max:255',

            'daily_target' => 'required|integer|min:0',

            'weekly_target' => 'required|integer|min:0',

            'tax_percentage' => 'required|numeric|min:0|max:100',

            'surge_percentage' => 'required|numeric|min:0|max:100',

            'commission_percentage' => 'required|numeric|min:0|max:100',

            'surge_trigger' => 'required|integer|min:0',

            'currency' => 'required'

        ]);

        Setting::set('commission_deduction', $request->has('commission_deduction') ? 1 : 0);

        if ((Setting::get('commission_deduction', 0) == 1) && (!$request->has('commission_deduction_wallet_driver') && !$request->has('commission_deduction_account_driver')) ) {
            return back()->with('flash_error', translateKeyword('Commission deduction from driver'));
        }

        Setting::set('commission_deduction_wallet_driver', $request->has('commission_deduction_wallet_driver') ? 1 : 0);
        Setting::set('commission_deduction_on_tip', $request->has('commission_deduction_on_tip') ? 1 : 0);
        Setting::set('commission_deduction_account_driver', $request->has('commission_deduction_account_driver') ? 1 : 0);
        Setting::set('commission_deduction_wallet_blockage', $request->has('commission_deduction_wallet_blockage') ? 1 : 0);
        Setting::set('driver_wallet_threshold', $request->has('driver_wallet_threshold') ? 1 : 0);
        Setting::set('commission_deduction_account_driver', $request->has('commission_deduction_account_driver') ? 1 : 0);

        Setting::set('CARD', $request->has('CARD') ? 1 : 0);

        if (Setting::get('CARD', 0) == 1 && Setting::get('email_field', 0) == 0) {
            Setting::set('email_field', 1);
        }
        
        Setting::set('CASH', $request->has('CASH') ? 1 : 0);
        Setting::set('paypal', $request->has('paypal') ? 1 : 0);
        Setting::set('mlajan', $request->has('mlajan') ? 1 : 0);
        Setting::set('rave', $request->has('rave') ? 1 : 0);
        Setting::set('UPI', $request->has('UPI') ? 1 : 0);
        Setting::set('razor', $request->has('razor') ? 1 : 0);
        Setting::set('payu', $request->has('payu') ? 1 : 0);
        Setting::set('stc', $request->has('stc') ? 1 : 0);
        Setting::set('ad_mob', $request->has('ad_mob') ? 1 : 0);
        // Setting::set('app_id_customer', $request->app_id_customer);
        // Setting::set('ad_unit_id_customer', $request->ad_unit_id_customer);
        // Setting::set('app_id_provider', $request->app_id_provider);
        // Setting::set('ad_unit_id_provider', $request->ad_unit_id_provider);
        Setting::set('pay_mob', $request->has('pay_mob') ? 1 : 0);
        Setting::set('iframe_id', $request->iframe_id);
        Setting::set('paymob_api_key', $request->paymob_api_key);
        Setting::set('hash_key', $request->hash_key);
        Setting::set('integration_id', $request->integration_id);


        Setting::set('payu_switch', $request->has('payu_switch') ? 1 : 0);

        Setting::set('paypal_client_id', $request->paypal_client_id);
        Setting::set('merchant_code', $request->merchant_code);

        Setting::set('rave_publicKey', $request->rave_publicKey);

        Setting::set('rave_encryptionKey', $request->rave_encryptionKey);

        Setting::set('rave_country', $request->rave_country);

        if ($request->rave_country === 'GH') {
            Setting::set('rave_currency', 'GHS');
        } else if ($request->rave_country === 'KE') {
            Setting::set('rave_currency', 'KES');
        } else if ($request->rave_country === 'ZA') {
            Setting::set('rave_currency', 'ZAR');
        } else if ($request->rave_country === 'TZ') {
            Setting::set('rave_currency', 'TZS');
        } else if ($request->rave_country === 'NG') {
            Setting::set('rave_currency', 'NGN');
        } else if ($request->rave_country === 'ZM') {
            Setting::set('rave_currency', 'ZMW');
        }
        Setting::set('UPI_key', $request->UPI_key);

        Setting::set('razor_key', $request->razor_key);


        Setting::set('stc_key', $request->stc_key);

        // Setting::set('payu_key', $request->payu_key);

        // Setting::set('payu_on_testing', $request->payu_on_testing);

        // Setting::set('payu_merchant_id', $request->payu_merchant_id);

        // Setting::set('payu_api_login', $request->payu_api_login);

        // Setting::set('payu_api_key', $request->payu_api_key);

        // Setting::set('payu_account_id', $request->payu_account_id);

        // Setting::set('pse_redirect_url', $request->pse_redirect_url);

        //  Setting::set('payu_country', $request->payu_country);


        Setting::set('stripe_secret_key', $request->stripe_secret_key);

        Setting::set('stripe_publishable_key', $request->stripe_publishable_key);

        Setting::set('mercado', $request->has('mercado') ? 1 : 0);
        Setting::set('mercado_public_key', $request->mercado_public_key);
        Setting::set('mercado_access_token', $request->mercado_access_token);

        Setting::set('epayco', $request->has('epayco') ? 1 : 0);
        Setting::set('epayco_public_key', $request->epayco_public_key);
        Setting::set('epayco_private_key', $request->epayco_private_key);

        Setting::set('fathoorah', $request->has('fathoorah') ? 1 : 0);
        Setting::set('fathoorah_api_key', $request->fathoorah_api_key);
        Setting::set('fathoorah_country', $request->fathoorah_country);
        Setting::set('fathoorah_mode', $request->fathoorah_mode);

        Setting::set('paydunya', $request->has('paydunya') ? 1 : 0);
        Setting::set('paydunya_master_key', $request->paydunya_master_key);
        Setting::set('paydunya_public_key', $request->paydunya_public_key);
        Setting::set('paydunya_private_key', $request->paydunya_private_key);
        Setting::set('paydunya_token', $request->paydunya_token);
        Setting::set('paydunya_mode', $request->paydunya_mode);

        Setting::set('mtn', $request->has('mtn') ? 1 : 0);
        Setting::set('mtn_user_id', $request->mtn_user_id);
        Setting::set('mtn_user_key', $request->mtn_user_key);
        Setting::set('mtn_primary_subscription_key_collection', $request->mtn_primary_subscription_key_collection);
        Setting::set('mtn_secondary_subscription_key_collection', $request->mtn_secondary_subscription_key_collection);
        Setting::set('mtn_primary_subscription_key_disbursement', $request->mtn_primary_subscription_key_disbursement);
        Setting::set('mtn_secondary_subscription_key_disbursement', $request->mtn_secondary_subscription_key_disbursement);
        Setting::set('mtn_mode', $request->mtn_mode);

        Setting::set('araka', $request->has('araka') ? 1 : 0);
        Setting::set('araka_email', $request->araka_email);
        Setting::set('araka_password', $request->araka_password);
        Setting::set('araka_payment_page_id', $request->araka_payment_page_id);


        Setting::set('daily_target', $request->daily_target);

        Setting::set('weekly_target', $request->weekly_target);
        Setting::set('commission_tax_apply', $request->commission_tax_apply);

        Setting::set('tax_percentage', $request->tax_percentage);

        Setting::set('surge_percentage', $request->surge_percentage);

        Setting::set('commission_percentage', $request->commission_percentage);
        Setting::set('commission_type', $request->commission_type);
        Setting::set('government_charges_value', $request->government_charges_value);
        Setting::set('government_charges', $request->has('government_charges') ? 1 : 0);

        Setting::set('bank_charges_value', $request->bank_charges_value);
        Setting::set('bank_charges', $request->has('bank_charges') ? 1 : 0);
        Setting::set('bank_charges_type', $request->bank_charges_type);

        Setting::set('surge_trigger', $request->surge_trigger);
        Setting::set('provider_wallet_threshold', $request->provider_wallet_threshold);
        Setting::set('driver_account_threshold', $request->driver_account_threshold);

        // Setting::set('surge_peak_switch', $request->surge_peak_switch);
        Setting::set('surge_peak_switch', $request->has('surge_peak_switch') ? 1 : 0);
      


        Setting::set('currency', $request->currency);
        Setting::set('currency_symbol', trans('currency.' . $request->currency));

        Setting::set('booking_prefix', $request->booking_prefix);

        Setting::save();
        $this->logService->log('Settings', 'update', 'Payment Settings Updated.', $request->all());

        return back()->with('flash_success', translateKeyword('Settings Updated Successfully'));
    }

    public function provider_paid(Request $request)
    {
        $request_ids = UserRequests::where('provider_id', $request->provider_id)->get();

        foreach ($request_ids as $request_id) {
            UserRequestPayment::where('request_id', $request_id->id)
                ->update(['provider_commission_paid' => 1]);
        }

        return back()->with('flash_success', translateKeyword('Driver Statement Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function profile()

    {

        return view('admin.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function profile_update(Request $request)

    {

        if (Setting::get('demo_mode', 0) == 1) {

            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        $this->validate($request, [

            'name' => 'required|max:255',

            'email' => 'required',

            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',

        ]);

        try {

            $admin = Auth::guard('admin')->user();

            $admin->name = $request->name;

            $admin->email = $request->email;

            if ($request->hasFile('picture')) {

                $admin->picture = $request->picture->store('superadmin/profile');
            }

            $this->logService->log('Profile', 'update', 'Profile Updated.', $admin);
            $admin->save();

            return redirect()->back()->with('flash_success', translateKeyword('profile_updated'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function password()

    {

        return view('admin.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function password_update(Request $request)

    {

        if (Setting::get('demo_mode', 0) == 1) {

            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        $this->validate($request, [

            'old_password' => 'required',

            'password' => 'required|min:6|confirmed',

        ]);

        try {

            $Admin = Admin::find(Auth::guard('admin')->user()->id);

            if (password_verify($request->old_password, $Admin->password)) {

                if($request->old_password == $request->password){
                    return redirect()->back()->with('flash_error', translateKeyword('password_should_not_be_same_as_old_password'));
                }

                $Admin->password = bcrypt($request->password);

                $Admin->save();
                $this->logService->log('Profile', 'update', 'Password Updated.', $Admin);
                return redirect()->back()->with('flash_success', translateKeyword('password_updated'));
            }
            return redirect()->back()->with('flash_error', translateKeyword('old_password_is_not_correct'));

        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function payment()

    {

        try {

            $payments = UserRequests::where('paid', 1)
                ->has('user')
                ->has('provider')
                ->has('payment')
                ->orderBy('user_requests.created_at', 'desc')
                ->get();
            return view('admin.payment.payment-history', compact('payments'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function help()

    {

        try {

            $str = file_get_contents('http://appoets.com/help.json');

            $Data = json_decode($str, true);

            return view('admin.help', compact('Data'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * User Rating.
     *
     * @return Response
     */

    public function user_review()

    {

        try {

            $Reviews = UserRequestRating::where('user_id', '!=', 0)->with('user', 'provider')->orderBy('id', 'DESC')->get();

            return view('admin.review.user_review', compact('Reviews'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Booking Requests.
     *
     * @return Response
     */

    public function booking_requests_web()

    {

        try {

            $bookingRequests = BookingRequest::orderBy('id', 'DESC')->get();

            return view('admin.booking_requests', compact('bookingRequests'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Booking Requests.
     *
     * @return Response
     */

    public function booking_requests_app()

    {

        try {

            $bookingRequests = UserRequests::where('status', 'REQUESTED')->orderBy('id', 'DESC')->get();

            return view('admin.booking_requests_app', compact('bookingRequests'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Contact Enquiries.
     *
     * @return Response
     */

    public function contact_enquiries()

    {

        try {

            $contactEnquiries = ContactEnquiry::orderBy('id', 'DESC')->get();

            return view('admin.contact_enquiries', compact('contactEnquiries'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Provider Rating.
     *
     * @return Response
     */

    public function provider_review()

    {

        try {

            $Reviews = UserRequestRating::where('provider_id', '!=', 0)->with('user', 'provider')->get();

            return view('admin.review.provider_review', compact('Reviews'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProviderService
     * @return Response
     */

    public function destory_provider_service($id)
    {

        try {

            ProviderService::find($id)->delete();

            return back()->with('message', translateKeyword('Service deleted successfully'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Testing page for push notifications.
     *
     * @return Response
     */

    public function push_index()

    {

        $data = PushNotification::app('IOSUser')
            ->to('163e4c0ca9fe084aabeb89372cf3f664790ffc660c8b97260004478aec61212c')
            ->send('Hello World, i`m a push message');

        dd($data);

        $data = PushNotification::app('IOSProvider')
            ->to('a9b9a16c5984afc0ea5b681cc51ada13fc5ce9a8c895d14751de1a2dba7994e7')
            ->send('Hello World, i`m a push message');

        dd($data);
    }

    /**
     * Testing page for push notifications.
     *
     * @return Response
     */

    public function push_store(Request $request)

    {

        try {

            ProviderService::find($id)->delete();

            return back()->with('message', translateKeyword('Service deleted successfully'));
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * privacy.
     *
     * @param Provider $provider
     * @return Response
     */

    public function privacy()
    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.PRIVACYPOLICY'));
        return view('admin.pages.static', get_defined_vars())
            ->with('title', "Privacy Page")
            ->with('page', "privacy");
    }

    public function terms()
    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.TERMSCONDITIONS'));
        return view('admin.pages.terms', get_defined_vars())
            ->with('title', "Terms Page")
            ->with('page', "terms");
    }

    public function about()
    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.ABOUTUS'));
        return view('admin.pages.about', get_defined_vars())
        ->with('title', "About Page")
        ->with('page', "about");
    }
    
    public function driver()
    {
        
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.DRIVERPAGE'));
        return view('admin.pages.driver', get_defined_vars())
            ->with('title', "Driver Page")
            ->with('page', "driver");
    }

    /**
     * pages.
     *
     * @param Provider $provider
     * @return Response
     */

    public function pages(Request $request)
    {
        $this->validate($request, [
            'page' => 'required',
            'content' => 'required',
        ]);
        
        Setting::set($request->page, $request->content);
        
        if($request->has('content_swedish')) {
                Setting::set('page_about_swedish', $request->content_swedish);
            }
            
        Setting::save();
        $this->logService->log('Extras', 'updated', $$request->page . ' Updated.', $request->all());
        return back()->with('flash_success', translateKeyword('Content Updated!'));
    }

    /**
     * account statements.
     *
     * @param Provider $provider
     * @return Response
     */

    public function statement($type = 'individual')
    {

        try {

            $page = 'Ride Statement';

            if ($type == 'individual') {
                $pagecode = 3;
                $page = 'Driver Ride Statement';
            } elseif ($type == 'today') {
                $pagecode = 1;
                $page = 'Today Statement - ' . date('d M Y');
            } elseif ($type == 'monthly') {
                $pagecode = 1;
                $page = 'This Month Statement - ' . date('F');
            } elseif ($type == 'yearly') {
                $pagecode = 1;
                $page = 'This Year Statement - ' . date('Y');
            }

            $rides = UserRequests::with('payment')->orderBy('id', 'desc');

            $cancel_rides = UserRequests::where('status', 'CANCELLED');

            $revenue = UserRequestPayment::select(DB::raw(

                'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'

            ));


            $comm = UserRequestPayment::where('provider_commission_paid', "0")->select(DB::raw(

                'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'

            ));


            if ($type == 'today') {

                $rides->where('created_at', '>=', Carbon::today());

                $cancel_rides->where('created_at', '>=', Carbon::today());

                $revenue->where('created_at', '>=', Carbon::today());
            } elseif ($type == 'monthly') {

                $rides->where('created_at', '>=', Carbon::now()->month);

                $cancel_rides->where('created_at', '>=', Carbon::now()->month);

                $revenue->where('created_at', '>=', Carbon::now()->month);
            } elseif ($type == 'yearly') {

                $rides->where('created_at', '>=', Carbon::now()->year);

                $cancel_rides->where('created_at', '>=', Carbon::now()->year);

                $revenue->where('created_at', '>=', Carbon::now()->year);
            }

            $rides = $rides->get();

            $cancel_rides = $cancel_rides->count();

            $revenue = $revenue->get();
            $comm = $comm->get();

            $finalcommission = $revenue[0]->commission;

            return view('admin.providers.statement', compact('rides', 'cancel_rides', 'revenue', 'pagecode', 'comm', 'finalcommission'))
                ->with('page', $page);
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * account statements today.
     *
     * @param Provider $provider
     * @return Response
     */

    public function statement_today()
    {

        return $this->statement('today');
    }

    /**
     * account statements monthly.
     *
     * @param Provider $provider
     * @return Response
     */

    public function statement_monthly()
    {

        return $this->statement('monthly');
    }

    /**
     * account statements monthly.
     *
     * @param Provider $provider
     * @return Response
     */

    public function statement_yearly()
    {

        return $this->statement('yearly');
    }

    /**
     * account statements.
     *
     * @param Provider $provider
     * @return Response
     */

    public function statement_provider()
    {

        try {

            $providers = Provider::all();

            foreach ($providers as $index => $provider) {

                $Rides = UserRequests::where('provider_id', $provider->id)
                    ->where('status', '<>', 'CANCELLED')
                    ->get()->pluck('id');

                $providers[$index]->rides_count = $Rides->count();

                $providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
                    ->select(DB::raw(

                        'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission'

                    ))->get();
            }

            return view('admin.providers.provider-statement', get_defined_vars())->with('page', 'Providers Statement');
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */

    public function translation()
    {

        try {

            return view('admin.translation');
        } catch (Exception $e) {

            return back()->with('flash_error', translateKeyword('something_went_wrong'));
        }
    }

   

    public function subadmin()
    {
        return view('admin.subadmin');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function approve($id)
    {

        Admin::where('id', $id)->update(['status' => 1]);
        return back()->with('flash_success', translateKeyword('Admin Approved'));
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function disapprove($id)
    {

        Admin::where('id', $id)->update(['status' => 0]);
        return back()->with('flash_success', translateKeyword('Admin Disapproved'));
    }
}
