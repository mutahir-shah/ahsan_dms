<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['TranslationMiddleware', 'SetTimezone']], function () {

    // Begin: Login Routes
    Route::group(['prefix' => 'login'], function(){
        Route::get('/', 'Admin\Auth\LoginController@showLoginForm')->name('login');
        Route::post('/', 'Admin\Auth\LoginController@login');
    });
    // End: Login Routes
    
    // Begin: Password Routes
    Route::group(['prefix' => 'password'], function(){
        Route::post('email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
        Route::post('reset', 'Admin\Auth\ResetPasswordController@reset');
        Route::get('reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm');
        Route::get('reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');
    });
    // End: Password Routes
    
    Route::post('/logout', 'Admin\Auth\LoginController@logout');

    Route::get('set-translation/{langauge_id}', function ($language_id) {
        Session::put('translation', $language_id);
        return redirect()->back();
    });

    Route::group(['middleware' => 'AdminProtectOTP'], function () {
        Route::get('/otp', 'AdminController@opt')->name('otp');
        Route::post('/verify-otp', 'AdminController@verifyOpt')->name('verify-otp');
        Route::post('/resend-otp', 'AdminController@resendOpt')->name('resend-otp');
    });

    Route::group(['middleware' => ['AdminVerifiedOTP', 'admin']], function () {
        Route::get('/', 'AdminController@dashboard')->name('index')
            ->middleware('admin.checkstatus')
            ->middleware('permission:' . config('const.DASHBOARD')  . ',' . config('const.VIEW'));

        Route::get('/dashboard/{duration?}', 'AdminController@dashboard')->name('dashboard')->middleware('admin.checkstatus');
        Route::get('/heatmap', 'AdminController@heatmap')->name('heatmap')->middleware('permission:' . config('const.EAGLEEYE')  . ',' . config('const.VIEW'));
        Route::get('/translation', 'AdminController@translation')->name('translation');
        Route::get('/subadmin', 'AdminController@subadmin')->name('subadmin');

        /**Begin: Push Notifications Routes*/
        Route::group(['as' => 'push.', 'middleware' => 'permission:' . config('const.PUSHNOTIFICATIONS')  . ',' . config('const.VIEW')], function () {
            Route::get('/push', 'PushNotificationController@index')->name('index');
            Route::get('/push/user/{id}',  'PushNotificationController@push_user')->name('user');
            Route::get('/push/provider/{id}',  'PushNotificationController@push_provider')->name('provider');
            Route::post('/push/user',  'PushNotificationController@push_specific_user')->name('user.post');
            Route::post('/push/provider',  'PushNotificationController@push_specific_provider')->name('provider.post');
            // Note: The Routes Using For Sent Notifications
            Route::post('/user_push', 'PushNotificationController@user_push')->name('user_push');
            Route::post('/driver_push', 'PushNotificationController@driver_push')->name('driver_push');
        });
        /**End: Push Notifications Routes*/

        Route::post('/fetch-user', 'UserApiController@fetchUser')->name('admin.fetchUser');

        Route::group(['as' => 'dispatcher.', 'prefix' => 'dispatcher', 'middleware' => 'permission:' . config('const.DISPATCHER')  . ',' . config('const.VIEW')], function () {
            Route::get('/', 'DispatcherController@admin_index')->name('index');
            Route::post('/', 'DispatcherController@store');
            Route::get('/{id}/update-schedule', 'DispatcherController@editSchedule')->name('edit-schedule');
            Route::put('/{user_request}/update-schedule', 'DispatcherController@updateSchedule')->name('update-schedule');
            Route::get('/', 'DispatcherController@admin_index')->name('index');
            Route::get('/trips', 'DispatcherController@trips')->name('trips');
            Route::get('/data/count', 'DispatcherController@count_new_data')->name('data-count');
            Route::get('/users/mark_viewed', 'DispatcherController@mark_users_as_viewed')->name('mark_users_as_viewed');
            Route::get('/providers/mark_viewed', 'DispatcherController@mark_providers_as_viewed')->name('mark_providers_as_viewed');
            Route::get('/booking-requests/mark_viewed', 'DispatcherController@mark_booking_requests_as_viewed')->name('mark_booking_requests_as_viewed');
            Route::get('/contact-enquiries/mark_viewed', 'DispatcherController@mark_contact_enquiries_as_viewed')->name('mark_contact_enquiries_as_viewed');

            Route::get('/cancelled', 'DispatcherController@cancelled')->name('cancelled');
            Route::get('/cancel', 'DispatcherController@cancel')->name('cancel');
            Route::get('/trips/{trip}/{provider}', 'DispatcherController@assign')->name('assign');
            Route::get('/users', 'DispatcherController@users')->name('users');
            Route::get('/providers', 'DispatcherController@providers')->name('providers');
        });

        Route::get('/zone/getCountry', 'Resource\ZoneResource@getCountry')->name('getcountry');
        Route::get('/zone/getState', 'Resource\ZoneResource@getState')->name('getstate');
        Route::get('/zone/getCity', 'Resource\ZoneResource@getCity')->name('getcity');

        /*Begin: Accountant Merged Routes*/
        Route::group(['prefix' => 'account'], function () {
            Route::get('new_account', 'Resource\AccountBankResource@new_account')->name('account.index')
                ->middleware('permission:' . config('const.NEWACCOUNT')  . ',' . config('const.VIEW'));
            Route::get('approved_account', 'Resource\AccountBankResource@approved_account')->name('account.approved')
                ->middleware('permission:' . config('const.APPROVEDACCOUNT')  . ',' . config('const.VIEW'));
            Route::get('new_withdraw', 'Resource\AccountBankResource@new_withdraw')->name('withdraw.new')
                ->middleware('permission:' . config('const.WITHDRAWREQUESTS')  . ',' . config('const.VIEW'));
            Route::get('approved_withdraw', 'Resource\AccountBankResource@approved_withdraw')->name('withdraw.approved')
                ->middleware('permission:' . config('const.APPROVEDREQUESTS')  . ',' . config('const.VIEW'));
            Route::get('disapproved_withdraw', 'Resource\AccountBankResource@disapproved_withdraw')->name('withdraw.disapproved')
                ->middleware('permission:' . config('const.DISAPPROVEDREQUESTS')  . ',' . config('const.VIEW'));
            // statements
            Route::get('/{id}/statement', 'Resource\ProviderResource@statement')->name('account.statement');
            Route::get('/statement', 'AccountController@statement')->name('account.ride.statement');
            Route::get('/statement/provider', 'AccountController@statement_provider')->name('account.ride.statement.provider');
            Route::get('/statement/range', 'AccountController@statement_range')->name('account.ride.statement.range');
            Route::get('/statement/today', 'AccountController@statement_today')->name('account.ride.statement.today');
            Route::get('/statement/monthly', 'AccountController@statement_monthly')->name('account.ride.statement.monthly');
            Route::get('/statement/yearly', 'AccountController@statement_yearly')->name('account.ride.statement.yearly');
            Route::get('/openTicket/{type?}', 'AccountController@openTicket')->name('account.openTicket');
            Route::get('/closeTicket', 'AccountController@closeTicket')->name('account.closeTicket');
            Route::get('/openTicketDetail/{id}', 'AccountController@openTicketDetail')->name('account.openTicketDetail');
            Route::patch('/transfer/{id}', 'AccountController@transfer')->name('account.transfer');
        });



        Route::get('zone/attach-service/{zone_id}', 'Resource\ZoneResource@attachService')->name('zone.attach')
            ->middleware('permission:' . config('const.ALLZONES')  . ',' . config('const.VIEW'));
        Route::post('zone/attach-service', 'Resource\ZoneResource@attachServiceStore')->name('zone.attach.store');
        Route::resource('user/{user}/document', 'Resource\UserDocumentResource', ['names' => 'user_documents']);
        Route::get('user/{user}/enable', 'Resource\UserResource@enable')->name('user.enable');
        Route::get('user/{user}/disable', 'Resource\UserResource@disable')->name('user.disable');
        
        // Language Routes
        Route::group(['prefix' => 'language', 'as' => 'language.'], function(){
            Route::post('keywords/{id}', 'LanguageController@languageKeywords')->name('language-keyword');
            Route::get('change-default/{id}', 'LanguageController@changeDefault')->name('change-default');
            Route::get('change-status/{id}', 'LanguageController@changeStatus')->name('change-status');
            Route::get('manage-translation/{id}', 'LanguageController@manageTranslation')->name('manage-translation');
            Route::post('update-translation', 'LanguageController@updateTranslation')->name('update-translation');
            Route::post('import-language', 'LanguageController@languageImport')->name('import');
        });
        Route::resource('language', 'LanguageController');

        // Blog Routes
        Route::get('/blogs/change-featured/{id}', 'BlogController@makeFeatured')->name('blogs.make-featured');
        Route::resource('blogs', 'BlogController');

        Route::resource('user', 'Resource\UserResource')
            ->middleware('permission:' . config('const.USERS')  . ',' . config('const.VIEW'));

        Route::resource('provider', 'Resource\ProviderResource')
            ->middleware('permission:' . config('const.DRIVERS')  . ',' . config('const.VIEW'));

        Route::resource('zone-service', 'Resource\ZoneServiceResource')
            ->middleware('permission:' . config('const.ZONESERVICES')  . ',' . config('const.VIEW'));

        Route::resource('faqs', 'Resource\FaqsResource')
            ->middleware('permission:' . config('const.FAQS')  . ',' . config('const.VIEW'));

        Route::resource('promocode', 'Resource\PromocodeResource')
            ->middleware('permission:' . config('const.PROMOCODES')  . ',' . config('const.VIEW'));

        Route::resource('zone', 'Resource\ZoneResource')
            ->middleware('permission:' . config('const.ALLZONES')  . ',' . config('const.VIEW'));

        Route::resource('zone-charges', 'Resource\ZoneChargeResource')
            ->middleware('permission:' . config('const.ALLZONECHARGES')  . ',' . config('const.VIEW'));

        Route::resource('document', 'Resource\DocumentResource')
            ->middleware('permission:' . config('const.DOCUMENTS')  . ',' . config('const.VIEW'));

        Route::resource('service', 'Resource\ServiceResource')
            ->middleware('permission:' . config('const.SERVICES')  . ',' . config('const.VIEW'));

        /*End: Accountant Merged Routes*/
        Route::resource('subscription-user', 'Resource\SubscriptionUserResource')->except(['show'])
            ->middleware('permission:' . config('const.RIDERSUBSCRIPTIONS')  . ',' . config('const.VIEW'));

        Route::resource('subscription-provider', 'Resource\SubscriptionDriverResource')->except(['show'])
            ->middleware('permission:' . config('const.DRIVERSUBSCRIPTIONS')  . ',' . config('const.VIEW'));

        /**Begin: Statements Routes*/
        Route::get('/statement', 'AdminController@statement')->name('ride.statement')
            ->middleware('permission:' . config('const.OVERALLSTATMENTS')  . ',' . config('const.VIEW'));

        Route::get('/statement/provider', 'AdminController@statement_provider')->name('ride.statement.provider')
            ->middleware('permission:' . config('const.PROVIDERSTATMENTS')  . ',' . config('const.VIEW'));

        Route::get('/statement/today', 'AdminController@statement_today')->name('ride.statement.today')
            ->middleware('permission:' . config('const.DAILYSTATMENTS')  . ',' . config('const.VIEW'));

        Route::get('/statement/monthly', 'AdminController@statement_monthly')->name('ride.statement.monthly')
            ->middleware('permission:' . config('const.MONTHLYSTATMENTS')  . ',' . config('const.VIEW'));

        Route::get('/statement/yearly', 'AdminController@statement_yearly')->name('ride.statement.yearly')
            ->middleware('permission:' . config('const.YEARLYSTATMENTS')  . ',' . config('const.VIEW'));

        /**End: Statements Routes*/

        /**Begin: History Routes*/
        Route::resource('requests', 'Resource\TripResource');

        Route::get('scheduled', 'Resource\TripResource@scheduled')->name('requests.scheduled')
            ->middleware('permission:' . config('const.UPCOMINGORDERS')  . ',' . config('const.VIEW'));

        Route::get('meterhistory', 'TaximeterController@meterhistory')->name('ride.meterhistory')
            ->middleware('permission:' . config('const.TAXIMETERHISTORY')  . ',' . config('const.VIEW'));

        Route::get('payment', 'AdminController@payment')->name('payment')
            ->middleware('permission:' . config('const.PAYMENTHISTORY')  . ',' . config('const.VIEW'));

        Route::get('promocodes/usage', 'PromocodeController@promocode_usage')->name('promocode.usage')
            ->middleware('permission:' . config('const.PROMOCODEHISTORY')  . ',' . config('const.VIEW'));
        /**End: History Routes*/

        /**Begin: Settings Routes*/
        Route::get('settings', 'AdminController@settings')->name('settings')
            ->middleware('permission:' . config('const.WEBSETTINGS')  . ',' . config('const.VIEW'));

        Route::get('f_settings', 'AdminController@f_settings')->name('f_settings');
        Route::post('settings/store', 'AdminController@settings_store')->name('settings.store');

        Route::get('settings/payment', 'AdminController@settings_payment')->name('settings.payment')
            ->middleware('permission:' . config('const.PAYMENTSETTINGS')  . ',' . config('const.VIEW'));

        Route::post('settings/payment', 'AdminController@settings_payment_store')->name('settings.payment.store');

        Route::get('settings/appsetting', 'AdminController@appsetting')->name('settings.appsetting')
            ->middleware('permission:' . config('const.APPSETTINGS')  . ',' . config('const.VIEW'));

        Route::post('settings/appsetting', 'AdminController@appsetting_store')->name('settings.appsetting.store');
        /**End: Settings Routes*/

        // Web CMS
        Route::get('cms/web-cms', 'CMSController@webindex')->name('cms.web');
        Route::post('cms/web-cms/update', 'CMSController@updateWebContent')->name('cms.web-content-update');
        Route::post('cms/web-cms/contact-update', 'CMSController@contactUpdate')->name('cms.contact-update');
        Route::post('cms/web-cms/update-social-links', 'CMSController@updateSocialLinks')->name('cms.update-social-links');
        Route::post('cms/web-cms/update-app-links', 'CMSController@updateAppLinks')->name('cms.update-app-links');
        Route::post('cms/web-cms/web-media', 'CMSController@updateWebMedia')->name('cms.web-media');
        Route::post('cms/web-cms/web-color', 'CMSController@updateWebColor')->name('cms.web-color');
        Route::post('cms/web-cms/google-map', 'CMSController@updateGoogleMap')->name('cms.google-map');
        Route::post('cms/web-cms/update-pages-content', 'CMSController@updatePagesContent')->name('cms.web-pages-content');
        Route::resource('cms/web-cms/webfaqs', 'WebFaqController');

        // App CMS
        Route::get('cms/app-cms', 'CMSController@appindex')->name('cms.app');
        Route::post('cms/app-cms/cancellation', 'CMSController@updateCancellationReason')->name('cms.app.cancellation-update');
        Route::resource('cms/cancellation', 'CancellationController');
        Route::resource('cms/app-cms/onboardings', 'OnboardingController');
        // Route::get('cms/app-cms/')

        /**Begin: Extra Routes*/
        Route::get('/privacy', 'AdminController@privacy')->name('privacy')
            ->middleware('permission:' . config('const.PRIVACYPOLICY')  . ',' . config('const.VIEW'));
        Route::post('/pages', 'AdminController@pages')->name('pages.update');

        Route::get('/terms', 'AdminController@terms')->name('terms')
            ->middleware('permission:' . config('const.TERMSCONDITIONS')  . ',' . config('const.VIEW'));

        Route::get('/about', 'AdminController@about')->name('about')
            ->middleware('permission:' . config('const.ABOUTUS')  . ',' . config('const.VIEW'));

        Route::get('/driver', 'AdminController@driver')->name('driver')
            ->middleware('permission:' . config('const.DRIVERPAGE')  . ',' . config('const.VIEW'));
        /**End: Extra Routes*/

        /**Begin: Administration Routes*/
        Route::resource('/role', 'Resource\RoleController')
            ->middleware('permission:' . config('const.USERROLES')  . ',' . config('const.VIEW'));

        Route::resource('admin', 'Resource\AdminResource')
            ->middleware('permission:' . config('const.MANAGEUSERS')  . ',' . config('const.VIEW'));

        Route::get('admin/{id}/approve', 'Resource\AdminResource@approve')->name('admin.approve');
        Route::get('admin/{id}/disapprove', 'Resource\AdminResource@disapprove')->name('admin.disapprove');

        Route::resource('/activity-logs', 'Resource\ActivityLogController')
            ->middleware('permission:' . config('const.ACTIVITYLOG')  . ',' . config('const.VIEW'));

            Route::post('/truncate/truncate-data', 'Resource\TruncateController@truncate_date');
            Route::get('/truncate/truncate-data', 'Resource\TruncateController@truncate_date')->name('truncate.truncate-data');
        Route::resource('/truncate', 'Resource\TruncateController')
            ->middleware('permission:' . config('const.TRUNCATEDATA')  . ',' . config('const.VIEW'));

        /**End: Administration Routes*/

        /**Begin: Accounts Routes*/
        Route::get('new_account', 'Resource\AdminBankResource@new_account')
            ->middleware('permission:' . config('const.NEWACCOUNT')  . ',' . config('const.VIEW'));

        Route::get('approved_account', 'Resource\AdminBankResource@approved_account')
            ->middleware('permission:' . config('const.APPROVEDACCOUNT')  . ',' . config('const.VIEW'));
        /**End: Accounts Routes*/


        Route::get('user/reset-user-referral/{user_id}', 'Resource\UserResource@resetUserReferral')->name('user.reset-user-referral');
        Route::get('user/reset-driver-referral/{user_id}', 'Resource\UserResource@resetDriverReferral')->name('user.reset-driver-referral');
        Route::post('user/mass-destroy', 'Resource\UserResource@massDestroy')->name('user.mass-destroy');
        Route::post('admin/mass-destroy', 'Resource\AdminResource@massDestroy')->name('admin.mass-destroy');
        Route::resource('dispatch-manager', 'Resource\DispatcherResource');
        Route::resource('account-manager', 'Resource\AccountResource');
        Route::resource('fleet', 'Resource\FleetResource');
        Route::post('provider/mass-destroy', 'Resource\ProviderResource@massDestroy')->name('provider.mass-destroy');
        Route::get('provider/reset-user-referral/{provider_id}', 'Resource\ProviderResource@resetUserReferral')->name('provider.reset-user-referral');
        Route::get('provider/reset-driver-referral/{provider_id}', 'Resource\ProviderResource@resetDriverReferral')->name('provider.reset-driver-referral');
        Route::resource('package', 'Resource\PackageResource');
        // Route::get('subscription-user', 'Resource\SubscriptionResource@user_subscription')->name('user_subscription');
        // Route::get('subscription-provider', 'Resource\SubscriptionResource@provider_subscription')->name('provider_subscription');


        Route::group(['as' => 'provider.'], function () {
            Route::get('review/provider', 'AdminController@provider_review')->name('review');
            Route::get('provider/{id}/approve', 'Resource\ProviderResource@approve')->name('approve');
            Route::get('provider/{id}/disapprove', 'Resource\ProviderResource@disapprove')->name('disapprove');
            Route::get('provider/{vehicle_id}/approve-vehicle', 'Resource\ProviderResource@approveVehicle')->name('approveVehicle');
            Route::get('provider/{vehicle_id}/disapprove-vehicle', 'Resource\ProviderResource@disapproveVehicle')->name('disapproveVehicle');
            Route::get('provider/{vehicle_id}/{provider_id}/select-vehicle', 'Resource\ProviderResource@selectVehicle')->name('selectVehicle');
            Route::get('provider/{id}/request', 'Resource\ProviderResource@request')->name('request');
            Route::get('provider/{id}/changestatus', 'Resource\ProviderResource@changestatus')->name('changestatus');
            Route::get('provider/{id}/statement', 'Resource\ProviderResource@statement')->name('statement');
            Route::resource('provider/{provider}/document', 'Resource\ProviderDocumentResource');
            Route::get('provider/{provider_id}/service/{service}', 'Resource\ProviderDocumentResource@service_edit')->name('service_type.edit');
            Route::post('provider/{provider_id}/service/{service}', 'Resource\ProviderDocumentResource@service_update')->name('service_type.update');
            Route::delete('provider/{provider}/service/{service}', 'Resource\ProviderDocumentResource@service_destroy')->name('document.service');
        });
        Route::group(['as' => 'package.'], function () {
            Route::resource('package/{package}/service', 'Resource\PackageAssignResource');
            Route::delete('package/{package}/service/{service}', 'Resource\PackageAssignResource@service_destroy')->name('package.service');
        });
        Route::get('bank/{id}/approve', 'Resource\AdminBankResource@bank_approve')->name('bank.approve');
        Route::resource('bank', 'Resource\AdminBankResource');

        Route::get('new_withdraw', 'Resource\AdminBankResource@new_withdraw');
        Route::get('approved_withdraw', 'Resource\AdminBankResource@approved_withdraw');
        Route::get('disapproved_withdraw', 'Resource\AdminBankResource@disapproved_withdraw');

        Route::get('review', 'AdminController@user_review')->name('review')
            ->middleware('permission:' . config('const.REVIEWS')  . ',' . config('const.VIEW'));
        Route::get('cancellations', 'AdminController@cancellations')->name('cancellations')
            ->middleware('permission:' . config('const.CANCELLATIONS')  . ',' . config('const.VIEW'));
        Route::get('contact-enquiries', 'AdminController@contact_enquiries')->name('contact-enquiries')
            ->middleware('permission:' . config('const.CONTACTENQUIRIES')  . ',' . config('const.VIEW'));
        Route::get('map', 'AdminController@map_index')->name('map.index')
            ->middleware('permission:' . config('const.COUNTRYVIEW')  . ',' . config('const.VIEW'));

        Route::get('booking-requests-web', 'AdminController@booking_requests_web')->name('booking-requests-web');
        Route::get('booking-requests-app', 'AdminController@booking_requests_app')->name('booking-requests-app');
        Route::get('user/{id}/request', 'Resource\UserResource@request')->name('user.request');

        Route::get('map/ajax', 'AdminController@map_ajax')->name('map.ajax');



        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::get('profile', 'AdminController@profile')->name('profile')
            ->middleware('permission:' . config('const.ACCOUNTSETTINGS')  . ',' . config('const.VIEW'));

        Route::post('profile', 'AdminController@profile_update')->name('profile.update');

        Route::get('password', 'AdminController@password')->name('password')
            ->middleware('permission:' . config('const.CHANGEPASSWORD')  . ',' . config('const.VIEW'));

        Route::post('password', 'AdminController@password_update')->name('password.update');





        Route::get('provider/{provider_id}/paid', 'AdminController@provider_paid')->name('provider.paid');

        // Static Pages - Post updates to pages.update when adding new static pages.

        Route::get('/help', 'AdminController@help')->name('help');
        // Route::get('/send/push', 'AdminController@push')->name('push');
        // Route::post('/send/push', 'AdminController@send_push')->name('send.push');



        Route::get('/dispatch', function () {
            return view('admin.dispatch.index');
        });

        Route::get('/cancelled', function () {
            return view('admin.dispatch.cancelled');
        });

        Route::get('/ongoing', function () {
            return view('admin.dispatch.ongoing');
        });

        Route::get('/schedule', function () {
            return view('admin.dispatch.schedule');
        });

        Route::get('/add', function () {
            return view('admin.dispatch.add');
        });

        Route::get('/assign-provider', function () {
            return view('admin.dispatch.assign-provider');
        });

        Route::get('/dispute', function () {
            return view('admin.dispute.index');
        });

        Route::get('/dispute-create', function () {
            return view('admin.dispute.create');
        });

        Route::get('/dispute-edit', function () {
            return view('admin.dispute.edit');
        });

        Route::get('/changestatusalloffline', function () {
            \DB::table('provider_services')
                ->where('status', '!=', 'riding')
                ->update(['status' => 'offline']);

            return back()->with('flash_success', 'Providers Status Updated to Offline Successfully');
        });

        Route::get('/changestatusallonline', function () {
            \DB::table('provider_services')
                ->where('status', '!=', 'riding')
                ->update(['status' => 'active']);

            return back()->with('flash_success', 'Providers Status Updated to Online Successfully');
        });
    });

});
