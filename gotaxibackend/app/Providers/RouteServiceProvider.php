<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        // $this->mapAccountRoutes();

        // $this->mapFleetRoutes();

        // $this->mapDispatcherRoutes();

        $this->mapProviderRoutes();


        $this->mapProviderApiRoutes();

        $this->mapCabUserApiRoutes();

        $this->mapCabUserProviderApiRoutes();

        //
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::group([
            'middleware' => ['web'],
            'prefix' => 'admin',
            'as' => 'admin.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/admin.php');
        });
    }

    /**
     * Define the "provider" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapProviderRoutes()
    {
        Route::group([
            'middleware' => ['web', 'provider'],
            'prefix' => 'provider',
            'as' => 'provider.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/provider.php');
        });
    }

    /**
     * Define the "dispatcher" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapDispatcherRoutes()
    {
        Route::group([
            'middleware' => ['web', 'dispatcher'],
            'prefix' => 'dispatcher',
            'as' => 'dispatcher.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/dispatcher.php');
        });
    }

    /**
     * Define the "fleet" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapFleetRoutes()
    {
        Route::group([
            'middleware' => ['web', 'fleet'],
            'prefix' => 'fleet',
            'as' => 'fleet.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/fleet.php');
        });
    }

    /**
     * Define the "account" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAccountRoutes()
    {
        Route::group([
            'middleware' => ['web', 'account'],
            'prefix' => 'account',
            'as' => 'account.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/account.php');
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api/user',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapProviderApiRoutes()
    {
        Route::group([
            // 'middleware' => 'provider.api',
            'namespace' => $this->namespace,
            'prefix' => 'api/provider',
        ], function ($router) {
            require base_path('routes/providerapi.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCabUserApiRoutes()
    {
        Route::group([
            // 'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api/user',
        ], function ($router) {
            require base_path('routes/cabuser_api.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCabUserProviderApiRoutes()
    {
        Route::group([
            // 'middleware' => 'provider.api',
            'namespace' => $this->namespace,
            'prefix' => 'api/provider',
        ], function ($router) {
            require base_path('routes/cabuser_providerapi.php');
        });
    }
}
