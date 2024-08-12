<?php

namespace App\Http\Middleware;

use Auth;
use Config;
use Closure;

use Exception;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use anlutro\LaravelSettings\Facade as Setting;
use App\ProviderJwtTokens;

class ProviderApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Config::set('auth.providers.users.model', 'App\Provider');
        try {
            if (!$user = JWTAuth::parseToken()->authenticate(false, 'provider')) {
                return response()->json(['user_not_found'], 404);
            } else {
                
                 if (Setting::get('multi_device_login_driver', 0) == 0) {
                    $checkDevice = ProviderJwtTokens::where(['provider_id' => $user->id, 'token' => JWTAuth::parseToken()->getToken()->get()])->first();
                    // return response()->json(['user' => $user, 'parserd_token' => JWTAuth::parseToken()->authenticate(false, 'provider'), 'token' => JWTAuth::parseToken()->getToken()->get(), 'request' => $request->all(), 'checkDevice' => $checkDevice]);
                    if(is_null($checkDevice)){
                        return response()->json(['status' => 'Token is Invalid'], 403);
                    }
                }
                Auth::loginUsingId($user->id);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid'], 401);
            } else if ($e instanceof TokenExpiredException) {
                // try {
                //     $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                //     $user = JWTAuth::setToken($refreshed)->toUser();
                //     return response()->json(['token_type' => 'Bearer', 'access_token' => $refreshed], 200);
                // } catch (JWTException $e){
                //     return response()->json(['status' => 'Token is Expired'], 401);
                // }
                return response()->json(['status' => 'Token is Expired'], 401);
            } else {
                return response()->json(['status' => 'Authorization Token not found'], 401);
            }
        }
        return $next($request);
    }
}
