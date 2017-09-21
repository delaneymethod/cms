<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{View, Schema};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    /**
		 * Added by Sean
		 *	- fixes creating indexes on MySQL versions less than 5.7.* when running Laravel 5.4.
		 * 	- Added 26/01/17 as our MySQL version is 5.6.34, shipped with MAMP Pro 4.1.
		 */
		Schema::defaultStringLength(191);
		
		// Added by Sean
		View::share('sidebarSmCols', config('cms.column_widths.cp.sidebar.sm'));
		View::share('sidebarMdCols', config('cms.column_widths.cp.sidebar.md'));
		View::share('sidebarLgCols', config('cms.column_widths.cp.sidebar.lg'));
		
		// Added by Sean
		View::share('mainSmCols', config('cms.column_widths.cp.main.sm'));
		View::share('mainMdCols', config('cms.column_widths.cp.main.md'));
		View::share('mainLgCols', config('cms.column_widths.cp.main.lg'));
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
