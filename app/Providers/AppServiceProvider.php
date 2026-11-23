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
        /*if (!function_exists('oci_connect')) {
            \Log::error('oci_connect function is missing in this environment.');
        } else {
            \Log::info('oci_connect function is available.');
        }*/
    }
}
