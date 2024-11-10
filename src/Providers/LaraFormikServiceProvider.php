<?php


namespace Kathore\LaraFormik\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Kathore\LaraFormik\Commands\InstallLaraFormik;
use Kathore\LaraFormik\Controllers\TestController;

class LaraFormikServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Publish Vue.js or JS files
            $this->publishes([
                __DIR__ . '/../Http' => app_path('Http'),
                __DIR__ . '/../resources/js' => resource_path('js'),
            ], 'lara-formik');

            $this->publishes([
                __DIR__ . '/../resources/css' => resource_path('css'),
            ], 'lara-formik-css');

            $this->commands([
                InstallLaraFormik::class,
            ]);
//            $this->registerTestRoute();
        }
    }

    protected function registerTestRoute()
    {
        // Register the route dynamically for the package
        Route::get('/lara-formik', TestController::class);

        Log::info("Test route registered.");
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        // You can bind services or singletons if needed
    }
}
