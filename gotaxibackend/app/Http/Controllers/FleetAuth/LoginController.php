<?php

namespace App\Http\Controllers\FleetAuth;

use App\Http\Controllers\Controller;
use App\Traits\CustomAuthenticatesUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;

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
    public $redirectTo = '/fleet/otp';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('fleet.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return Response
     */
    public function showLoginForm()
    {
        return view('fleet.auth.login');
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
        Auth::guard('fleet')->logout();

        return redirect()->route('fleet.login');

    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('fleet');
    }
}
