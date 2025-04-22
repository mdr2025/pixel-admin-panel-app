<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route; 
use PixelApp\Routes\PixelRouteManager;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        // Route::get("hello" , function()
        // {
        //     return response()->json(["Hello2"]);
        // });
        $this->routes(function()
        {
            PixelRouteManager::loadAPIRoutes();   
            PixelRouteManager::loadWebRoutes();
            PixelRouteManager::loadPixelAppPackageRoutes();

            PixelRouteManager::loadTenantRoutes();
        }); 
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            // if (app()->isLocal()) {
            //     return Limit::none();
            // }
            $key = optional($request->user())->id ?: "Admin|"  . $request->ip() . $request->path();
            return Limit::perMinute(60)->by($key);

            
            //  $key = optional($request->ip() . '|' . $request->path());
            //  Log::info('Throttle key: ' . $key);
            //  return Limit::perMinute(60)->by($key);

            return Limit::perMinute(60)->by(optional($request->user())->id ?: "Admin|"  . $request->ip());
        });

        // RateLimiter::for('admin-panel-safe', function (Request $request) {
        //     return Limit::perMinute(1000)->by($request->ip());
        // });
    } 
  
}
