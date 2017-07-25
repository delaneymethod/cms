<?php

namespace App\Providers;

/**
 * Added by Sean
 *	- fixes creating indexes on MySQL versions less than 5.7.* when running Laravel 5.4.
 * 	- Added 26/01/17 as our MySQL version is 5.6.34, shipped with MAMP Pro 4.1.
 */
use Illuminate\Support\Facades\View; 
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
		
		// Added by Sean
		View::share('sidebarSmCols', config('grampianfasteners.column_widths.cp.sidebar.sm'));
		View::share('sidebarMdCols', config('grampianfasteners.column_widths.cp.sidebar.md'));
		View::share('sidebarLgCols', config('grampianfasteners.column_widths.cp.sidebar.lg'));
		
		// Added by Sean
		View::share('mainSmCols', config('grampianfasteners.column_widths.cp.main.sm'));
		View::share('mainMdCols', config('grampianfasteners.column_widths.cp.main.md'));
		View::share('mainLgCols', config('grampianfasteners.column_widths.cp.main.lg'));
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
