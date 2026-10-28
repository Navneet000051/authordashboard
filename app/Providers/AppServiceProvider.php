<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // The legacy CodeIgniter controller ran error_reporting(0), so the app
        // relies on PHP warnings/notices (undefined properties, array keys and
        // variables) being silently ignored across its views. Laravel promotes
        // those same warnings to fatal ErrorExceptions. Drop them from the
        // active error_reporting level so the ported pages behave as they did
        // originally; genuine errors (E_ERROR and friends) still surface.
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED);
    }
}
