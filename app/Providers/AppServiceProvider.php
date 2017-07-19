<?php

namespace App\Providers;

/**
 * Added by Sean
 *	- fixes creating indexes on MySQL versions less than 5.7.* when running Laravel 5.4.
 * 	- Added 26/01/17 as our MySQL version is 5.6.34, shipped with MAMP Pro 4.1.
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Added by Sean - see comments above.
		Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
