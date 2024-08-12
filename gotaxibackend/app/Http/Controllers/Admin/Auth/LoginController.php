<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpEmail;
use App\Traits\CustomAuthenticatesUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Log;
use anlutro\LaravelSettings\Facade as Setting;

class LoginController extends Controller
{
   
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers, CustomAuthenticatesUsers {
            CustomAuthenticatesUsers::sendLoginResponse insteadof AuthenticatesUsers;
        }
    use LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/admin/otp';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return Response
     */
    public function showLoginForm()
    {
        $site_color = Setting::get('site_color') ? Setting::get('site_color') : '#EC4949';
        return view('admin.auth.login', get_defined_vars());
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        // $guard = $request->guard;
        $user = Auth::guard('admin')->user();
        Log::create([
            'user_id' => $user->id,
            'module' => 'Authentication',
            'type' => 'Login',
            'action' => 'User Logged Out.',
            'description' => '',
            'payload' => $user,
        ]);
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');

    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
