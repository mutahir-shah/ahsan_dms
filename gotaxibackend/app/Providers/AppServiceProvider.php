<?php

namespace App\Providers;

use App\Services\LogService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('translateKeyword', function($value) {
            return "<?php echo translateKeyword($value); ?>";
        });

        Blade::directive('settings', function($value) {
            return "<?php echo Setting::get($value); ?>";
        });
        
        // Validator::extend('alphanumeric', function ($attribute, $value, $parameters, $validator) {
        //     return preg_match('/^[a-zA-Z0-9\s]+$/', $value);
        // });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LogService::class, function ($app) {
            return new LogService();
        });

        
    }
}
