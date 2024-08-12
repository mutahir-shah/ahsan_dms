<?php

namespace App\Http\Controllers\ProviderAuth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Zones;

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

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/provider';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('provider.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return Response
     */
    public function showLoginForm()
    {
        (Setting::get('website_theme', 'default') == 'conexi') ? $view = 'themes.conexi.provider.auth.login' : $view = 'provider.auth.login';
        return view($view);
    }

    /**
     * Show the application's register form.
     *
     * @return Response
     */
    public function showRegisterForm()
    {
        $zones = Zones::where('status', 'active')->get();

        (Setting::get('website_theme', 'default') == 'conexi') ? $view = 'themes.conexi.provider.auth.register' : $view = 'provider.auth.register';
        return view($view, compact('zones'));
    }

    public function username()
    {
        return request()->has('mobile') ? 'mobile' : 'email';
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return RedirectResponse|Response|JsonResponse
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        if ($request->has('mobile')) {
            $request->replace([
                '_token' => $request->_token,
                'mobile' => str_replace(' ', '', $request->mobile),
                'password' => $request->password
            ]);
        }
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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
        Auth::guard('provider')->logout();

        return redirect()->route('provider.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('provider');
    }
}
