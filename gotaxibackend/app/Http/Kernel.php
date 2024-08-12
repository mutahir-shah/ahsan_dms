<?php

namespace App\Http;

use App\Http\Middleware\{DemoModeMiddleware,
    DriverLocalization,
    EncryptCookies,
    ProviderApiMiddleware,
    ProviderVerified,
    RedirectIfAccount,
    RedirectIfAdmin,
    RedirectIfAuthenticated,
    RedirectIfDispatcher,
    RedirectIfFleet,
    RedirectIfNotAccount,
    RedirectIfNotAdmin,
    RedirectIfNotDispatcher,
    RedirectIfNotFleet,
    RedirectIfNotProvider,
    RedirectIfProvider,
    UserLocalization,
    UserVerified,
    VerifyCsrfToken,
    Localization,
    Permission,
    SetTimezone,
};
use Illuminate\Auth\Middleware\{Authenticate, AuthenticateWithBasicAuth, Authorize};
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;


class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        'Fideloper\Proxy\TrustProxies',
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            Localization::class,
        ],

        'api' => [
            'throttle:120,1',
            'bindings',
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'SetTimezone' => SetTimezone::class,
        'account' => RedirectIfNotAccount::class,
        'account.guest' => RedirectIfAccount::class,
        'fleet' => RedirectIfNotFleet::class,
        'fleet.guest' => RedirectIfFleet::class,
        'dispatcher' => RedirectIfNotDispatcher::class,
        'dispatcher.guest' => RedirectIfDispatcher::class,
        'provider' => RedirectIfNotProvider::class,
        'provider.guest' => RedirectIfProvider::class,
        'provider.api' => ProviderApiMiddleware::class,
        'admin' => RedirectIfNotAdmin::class,
        'permission' => Permission::class,
        'admin.guest' => RedirectIfAdmin::class,
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'throttle' => ThrottleRequests::class,
        'jwt.auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
        'jwt.refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
        'demo' => DemoModeMiddleware::class,
        'user.verified' => UserVerified::class,
        'provider.verified' => ProviderVerified::class,
        'provider.language' => DriverLocalization::class,
        'user.language' => UserLocalization::class,
        'admin.checkstatus' => \App\Http\Middleware\CheckStatus::class,
        'AdminVerifiedOTP' => \App\Http\Middleware\AdminVerifiedOTP::class,
        'FleetVerifiedOTP' => \App\Http\Middleware\FleetVerifiedOTP::class,
        'DispatcherVerifiedOTP' => \App\Http\Middleware\DispatcherVerifiedOTP::class,
        'AccountVerifiedOTP' => \App\Http\Middleware\AccountVerifiedOTP::class,
        'AdminProtectOTP' => \App\Http\Middleware\AdminProtectOTP::class,
        'DispatcherProtectOTP' => \App\Http\Middleware\DispatcherProtectOTP::class,
        'AccountProtectOTP' => \App\Http\Middleware\AccountProtectOTP::class,
        'FleetProtectOTP' => \App\Http\Middleware\FleetProtectOTP::class,
        'log.auth' => \App\Http\Middleware\LogAuthActions::class,
        'TranslationMiddleware' => \App\Http\Middleware\TranslationMiddleware::class
    ];
}
