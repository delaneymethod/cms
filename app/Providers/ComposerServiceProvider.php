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
use Illuminate\Support\Facades\{View, Cache};

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
				$view->with('pages', $pages);
			});
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
