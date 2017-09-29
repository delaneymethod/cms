<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Providers;

use App;
use App\Http\Traits\PageTrait;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Auth, View, Cache};

class ComposerServiceProvider extends ServiceProvider
{
	use PageTrait;
	
	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (!App::runningInConsole()) {
			$cachingEnabled = config('cache.enabled');
			
			if ($cachingEnabled) {
				$pages = Cache::get('pages');
				
				if (is_null($pages)) {
					$pages = $this->getPages();
					
					$minutes = config('cache.expiry_in_minutes');
					
					Cache::put('pages', $pages, $minutes);
				}
			} else {
				$pages = $this->getPages();
			}
			
			View::composer('*', function ($view) use ($pages) {
				$authenticated = Auth::check();
				
				$view->with([
					'authenticated' => $authenticated,
					'pages' => $pages,
				]);
				
				$authViews = [
					'auth.login',
					'auth.register',
					'auth.passwords.email',
					'auth.passwords.reset',
					'errors::403',
					'errors::404',
					'errors::429',
					'errors::500',
					'errors::503',
				];
				
				if (in_array($view->getName(), $authViews)) {
					// Grab any page really, just so we can pass it to the view header > breadcrumbs include
					$page = $this->getPage(1);
					
					$view->with('page', $page);
				}
			});
				
			// Added by Sean
			View::share('sidebarSmCols', config('cms.column_widths.cp.sidebar.sm'));
			View::share('sidebarMdCols', config('cms.column_widths.cp.sidebar.md'));
			View::share('sidebarLgCols', config('cms.column_widths.cp.sidebar.lg'));
			
			// Added by Sean
			View::share('mainSmCols', config('cms.column_widths.cp.main.sm'));
			View::share('mainMdCols', config('cms.column_widths.cp.main.md'));
			View::share('mainLgCols', config('cms.column_widths.cp.main.lg'));
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	}
}
