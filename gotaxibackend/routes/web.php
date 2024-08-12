<?php


/*

|--------------------------------------------------------------------------

| User Authentication Routes

|--------------------------------------------------------------------------

*/

use anlutro\LaravelSettings\Facade as Setting;
use App\{CMS, ContactSetting, PageContent, UserRequests, WebFaq, Zones};
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{App, Auth, Cookie, Route, Session};

Route::group(['middleware' => ['TranslationMiddleware', 'SetTimezone']], function () {
    // Begin: Authentication Rouets
    Auth::routes();
    // End: Authentication Rouets

    // Begin: Verification Routes
    Route::get('/verification', 'TwilioController@sendUserOTP')->name('sendUserOTP');
    Route::post('/verifyUserOTP', 'TwilioController@verifyUserOTP')->name('verifyUserOTP');
    // End: Verification Routes

    // Begin: Authentication Rouets
    Route::group(['prefix' => 'auth'], function () {
        Route::get('facebook', 'Auth\SocialLoginController@redirectToFaceBook');
        Route::get('facebook/callback', 'Auth\SocialLoginController@handleFacebookCallback');
        Route::get('google', 'Auth\SocialLoginController@redirectToGoogle');
        Route::get('google/callback', 'Auth\SocialLoginController@handleGoogleCallback');
    });
    // Begin: Authentication Rouets

    // Begin: Misc. Rouets
    Route::get('/track-ride', function () {
        return view('user.ride.track');
    });

    Route::post('account/kit', 'Auth\SocialLoginController@account_kit')->name('account.kit');

    Route::get('/language/{language_id}', function ($language_id = null) {
        if (!isset($language_id) && !in_array($language_id, config('app.available_locales'))) {
            abort(400);
        }
        App::setLocale($language_id);
        Session::put('translation', $language_id);
        return redirect()->back();
    })->name('language.locale');
    // End: Misc. Rouets


    /*
    
    |--------------------------------------------------------------------------
    
    | Provider Authentication Routes
    
    |--------------------------------------------------------------------------
    
    */

    Route::group(['prefix' => 'provider'], function () {
        // Begin: Verification Routes
        Route::get('/verification', 'TwilioController@sendProviderOTP')->name('sendProviderOTP');
        Route::post('/verifyProviderOTP', 'TwilioController@verifyProviderOTP')->name('verifyProviderOTP');
        // End: Verification Routes

        // Begin: Authentication Routes
        Route::group(['prefix' => 'auth'], function () {
            Route::get('facebook', 'Auth\SocialLoginController@providerToFaceBook');
            Route::get('google', 'Auth\SocialLoginController@providerToGoogle');
        });
        // End: Authentication Routes

        // Begin: Login Routes Routes
        Route::group(['prefix' => 'login'], function () {
            Route::get('/', 'ProviderAuth\LoginController@showLoginForm')->name('provider.login');
            Route::post('/', 'ProviderAuth\LoginController@login');
        });
        // End: Login Routes Routes

        // Begin: Resgiter Routes
        Route::group(['prefix' => 'register'], function () {
            Route::get('/', 'ProviderAuth\LoginController@showRegisterForm')->name('provider.register');
            Route::post('/', 'ProviderAuth\RegisterController@register');
        });
        // End: Resgiter Routes

        // Begin: Password Routes
        Route::group(['prefix' => 'password'], function () {
            Route::post('email', 'ProviderAuth\ForgotPasswordController@sendResetLinkEmail');
            Route::post('reset', 'ProviderAuth\ResetPasswordController@reset');
            Route::get('reset', 'ProviderAuth\ForgotPasswordController@showLinkRequestForm')->name('provider.reset');
            Route::get('reset/{token}', 'ProviderAuth\ResetPasswordController@showResetForm');
        });
        // End: Password Routes

        Route::post('/logout', 'ProviderAuth\LoginController@logout');
    });


    Route::post('/contact-enquiry', 'HomeController@contactEnquiry')->name('contact-enquiry');
    Route::post('/booking-request', 'HomeController@bookingRequest')->name('booking-request');

    Route::group(['middleware' => ['guest']], function () {
        // Begin: Password Routes
        Route::group(['prefix' => 'password'], function () {
            Route::post('phone', 'Auth\ForgotPasswordController@sendPasswordResetOTP');
            Route::get('phone', 'Auth\ForgotPasswordController@setPhonePasswordResetForm')->name('get-password-reset-form');
            Route::post('password-reset/phone', 'Auth\ForgotPasswordController@resetPasswordFromOTP')->name('reset-password');
        });
        // End: Password Routes

        Route::get('/register-driver', function () {
            $zones = Zones::where('status', 'active')->get();

            return view('register-driver', compact('zones'));
        });

        Route::post('/register-driver', 'Auth\RegisterController@registerDriver');
    });








    /*
    
    |--------------------------------------------------------------------------
    
    | User Routes
    
    |--------------------------------------------------------------------------
    
    */

    Route::group(['middleware' => ['auth:web', 'user.verified']], function () {
        Route::get('/dashboard', 'HomeController@index');
        Route::get('/new-job', 'HomeController@new_job')->name('web.new_job');
        Route::get('map/ajax', 'HomeController@map_ajax')->name('map.ajax');

        // user profiles

        Route::get('/profile', 'HomeController@profile')->name('user.profile');

        Route::get('/edit/profile', 'HomeController@edit_profile');

        Route::get('/profile/documents', 'HomeController@documents')->name('user.documents');

        Route::put('/profile/documents/{id}', 'HomeController@update_document')->name('user.documents.update');


        Route::post('/profile', 'HomeController@update_profile');


        // update password

        Route::get('/change/password', 'HomeController@change_password');

        Route::post('/change/password', 'HomeController@update_password');


        // ride

        Route::get('/confirm/ride', 'RideController@confirm_ride');

        Route::post('/create/ride', 'RideController@create_ride');

        Route::post('/cancel/ride', 'RideController@cancel_ride');

        Route::get('/onride', 'RideController@onride');

        Route::post('/payment', 'PaymentController@payment');

        Route::post('/rate', 'RideController@rate');


        // status check

        Route::get('/status', 'RideController@status');


        // trips

        Route::get('/trips', 'HomeController@trips');
        Route::get('/cards', 'HomeController@cards')->name('web.cards');
        Route::get('/cards/add', 'HomeController@card_add')->name('web.card.add');
        Route::post('/cards/store', 'HomeController@card_store')->name('web.card.store');
        Route::get('/cards/make-default/{card_id}', 'HomeController@card_default')->name('card.make-default');
        Route::get('/cards/delete/{card_id}', 'HomeController@card_delete')->name('card.delete');

        Route::get('/upcoming/trips', 'HomeController@upcoming_trips');


        // wallet

        Route::get('/wallet', 'HomeController@wallet');

        Route::post('/add/money', 'PaymentController@add_money');


        // payment

        Route::get('/payment', 'HomeController@payment');


        // card

        Route::resource('card', 'Resource\CardResource', [
            'as' => 'user'
        ]);


        // promotions

        Route::get('/promotions', 'HomeController@promotions_index')->name('promocodes.index');

        Route::post('/promotions', 'HomeController@promotions_store')->name('promocodes.store');
    });

    if (Setting::get('website_theme', 'default') == 'default') {

        Route::get('/login', function () {
            return view('login');
        })->name('website.login');;

        Route::get('/register', function () {
            $zones = Zones::where('status', 'active')->get();

            return view('register', compact('zones'));
        })->name('customer.register');

        Route::get('/booking', function () {
            return view('booking');
        });

        Route::get('/', function () {
            $website_languages = Setting::get('website_languages', 'en');
            if ($website_languages == '' || $website_languages == null) {
                $cookie = Cookie::make('googtrans', "/en/en", 'Session', null, null, false, false);
            } else {
                $cookie = Cookie::make('googtrans', "/en" . "/" . $website_languages, 'Session', null, null, false, false);
            }

            if (Setting::get('website_enable') == 0) {
                return view('index-upcoming');
            } else {
                if (Setting::get('force_login_page') == 0) {
                    $webContent = CMS::where('language_id', session('translation'))->first();

                    return view('index', get_defined_vars());
                } else {
                    return redirect('/login');
                }
            }
            //return  'Website is being loaded!';
        });

        Route::get('/home', function () {
            return view('home');
        });

        Route::get('/contact', function () {
            $contactSettings = ContactSetting::where('language_id', session('translation'))->first();
            return view('contact', get_defined_vars());
        });

        Route::get('/faqs', function () {
            $title = 'Frequently Asked Questions (FAQ)';
            $faqs = WebFaq::where('language_id', session('translation'))->get();

            return view('faqs', compact('title', 'faqs'));
        });

        Route::get('/blogs', function () {
            $title = 'Blogs';

            return view('blogs', compact('title'));
        });


        Route::get('/testimonials', function () {
            $title = 'Testimonials';

            return view('testimonials', compact('title'));
        });
        Route::get('about', function () {

            $pageContent = PageContent::where('language_id', session('translation'))->first();
            $title = 'About Us';

            if (App::getLocale() == 'se') {
                $page = 'page_about_swedish';
            }

            return view('about', compact('pageContent', 'title'));
        });


        Route::get('privacy', function () {

            $pageContent = PageContent::where('language_id', session('translation'))->first();
            $title = 'Privacy Policy';

            return view('privacy', compact('pageContent', 'title'));
        });


        Route::get('terms', function () {

            $pageContent = PageContent::where('language_id', session('translation'))->first();
            $title = 'Terms & Conditions';

            return view('terms', compact('pageContent', 'title'));
        });
    } else if (Setting::get('website_theme', 'default') == 'conexi') {

        Route::get('/login', function () {
            return view('themes.conexi.login');
        })->name('website.login');;

        Route::get('/register', function () {
            $zones = Zones::where('status', 'active')->get();

            return view('themes.conexi.register', compact('zones'));
        })->name('customer.register');

        Route::get('/', function () {
            return view('themes.conexi.index');
        });


        Route::get('/welcome', function () {
            return view('welcome', ["name" => "usama"]);
        });

        // Route::get('/about', function () {
        //     return view('themes.conexi.about');
        // });

        Route::get('/blog-details', function () {
            return view('themes.conexi.blog-details');
        });

        Route::get('/blog', function () {
            return view('themes.conexi.blog');
        });

        Route::get('/book-ride', function () {
            return view('themes.conexi.book-ride');
        })->name('bookride');

        Route::get('/contact', function () {
            $contactSettings = ContactSetting::where('language_id', session('translation'))->first();
            return view('themes.conexi.contact', get_defined_vars());
        });

        Route::get('/driver', function () {
            return view('themes.conexi.driver');
        });

        // // Route::get('/index2', function () {
        // //     return view('themes.conexi.index2');
        // });

        Route::get('/single-taxi', function () {
            return view('themes.conexi.single-taxi');
        });

        Route::get('/taxi', function () {
            return view('themes.conexi.taxi');
        });

        Route::get('/terms', function () {

            $page = 'page_terms';

            $title = 'Terms & Conditions';

            return view('themes.conexi.about', compact('page', 'title'));
        })->name('terms');

        Route::get('/privacy', function () {

            $page = 'page_privacy';

            $title = 'Privacy Policy';

            return view('themes.conexi.about', compact('page', 'title'));
        })->name('privacy');
    }
    Route::get('/new-pdf/{id}', function ($id) {
        $userRequest = UserRequests::with(['payment', 'user', 'service_type', 'provider'])->where('id', $id)->get()->first();

        return view('pdf.invoice-updated-english', compact('userRequest'));
    });

    Route::get('/app/pdf/{id}', function ($id) {
        $userRequest = UserRequests::with(['payment', 'user', 'service_type', 'provider'])->where('id', $id)->get()->first();

        $language_id = \App\Language::where('name', Setting::get('language_invoice'))->pluck('id')->first();
        $pdf = PDF::loadView('pdf.invoice-mobile', compact('userRequest', 'language_id'));


        return $pdf->download("Invoice-$userRequest->booking_id.pdf");
        // return 'Please enable invoice from admin!';
    })->name('app.invoice');

    Route::get('/pdf/{id}', function ($id) {
        $userRequest = UserRequests::with(['payment', 'user', 'service_type', 'provider'])->where('id', $id)->get()->first();

        $language_id = Setting::get('language_invoice');
        $pdf = PDF::loadView('pdf.invoice', compact('userRequest'));


        return $pdf->download("Invoice-$userRequest->booking_id.pdf");
        // return 'Please enable invoice from admin!';
    })->name('invoice');

    if (Setting::get('landing_page') == 1) {
        Route::get('/landing-page', 'LandingPageController@index')->name('landing.page');
    }

    Route::get('/driver/panitan', function (Request $request) {
        return redirect('https://kwiklyofficial.wordpress.com/');
    });
});
