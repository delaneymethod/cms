<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use App\Http\Traits\{PageTrait, AssetTrait};
use Illuminate\Support\Facades\{Auth, View, Cache};

class ComposerServiceProvider extends ServiceProvider
{
	use PageTrait, AssetTrait;
	
	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (!App::runningInConsole()) {
			/*
			$cachingEnabled = config('cache.enabled');
			
			if ($cachingEnabled) {
				$pages = Cache::get('pages');
				
				if (is_null($pages)) {
					$pages = $this->getPages();
					
					$minutes = config('cache.expiry_in_minutes');
					
					Cache::put('pages', $pages, $minutes);
				}
			} else {
			*/	
				$pages = $this->getPages();
			//}
			
			View::composer('*', function ($view) use ($pages) {
				$authenticated = Auth::check();
				
				// Used to build footer links in the 1st column
				$slugs = collect(['contact', 'our-brands', 'services', 'awards']);
				
				$footerLinksLeft = collect([]);
				
				// Gets Terms and Conditions PDF
				$asset = $this->getAsset(6);
				
				$footerLinksLeft->push((object) [
					'title' => 'Terms and Conditions',
					'url' => $asset->path,
					'target' => 'target="_blank"',
				]);
				
				// Gets Privacy Policy PDF
				$asset = $this->getAsset(7);
				
				$footerLinksLeft->push((object) [
					'title' => 'Privacy Policy',
					'url' => $asset->path,
					'target' => 'target="_blank"',
				]);
				
				$slugs->each(function ($slug) use ($footerLinksLeft) {
					$page = $this->getPageBySlug($slug);
					
					$page->target = '';
					
					$footerLinksLeft->push($page);
				});
				
				// Used to build footer links in the 2nd column
				$slugs = collect(['projects', 'technical-corner', 'custom-parts', 'delivery', 'careers']);
				
				$footerLinksRight = collect([]);
				
				$slugs->each(function ($slug) use ($footerLinksRight) {
					$page = $this->getPageBySlug($slug);
					
					$page->target = '';
					
					$footerLinksRight->push($page);
				});
				
				$view->with([
					'authenticated' => $authenticated,
					'pages' => $pages,
					'footerLinksLeft' => $footerLinksLeft,
					'footerLinksRight' => $footerLinksRight,
				]);
				
				$specialViews = ['auth.login', 'auth.register', 'auth.passwords.email', 'auth.passwords.reset', 'errors::403', 'errors::404', 'errors::429', 'errors::500', 'errors::503'];
				
				$specialTitles = ['Login', 'Register', 'Reset Password', 'Set Password', '403 Error', '404 Error', '429 Error', '500 Error', '503 Error'];
				
				$found = array_search($view->getName(), $specialViews);
				
				// Sets page for special views
				if ($found !== false) {
					// Grab any page really, just so we can pass it to the view header > breadcrumbs include
					$page = $this->getPage(1);
					
					$page->breadcrumbs = collect([]);
					
					$page->breadcrumbs->push([
						'title' => $specialTitles[$found],
						'slug' => request()->path(),
						'url' => request()->url(),
					]);
					
					// Convert inners to objects
					$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
						return (object) $row;
					});
					
					$page->bannerMessage = '<h2>'.$specialTitles[$found].'</h2>';
					
					$page->bannerImage = 'https://www.grampianfasteners.com/files/1680c433-741e-4778-8522-0dcc6545d33f/bg_rigs_1_edit_darker.jpg';
					
					$view->with('page', $page);
				}
			});
				
			// Added by Sean
			View::share('sidebarSmCols', config('cms.column_widths.cp.sidebar.sm'));
			View::share('sidebarMdCols', config('cms.column_widths.cp.sidebar.md'));
			View::share('sidebarLgCols', config('cms.column_widths.cp.sidebar.lg'));
			View::share('sidebarXlCols', config('cms.column_widths.cp.sidebar.xl'));
			
			// Added by Sean
			View::share('mainSmCols', config('cms.column_widths.cp.main.sm'));
			View::share('mainMdCols', config('cms.column_widths.cp.main.md'));
			View::share('mainLgCols', config('cms.column_widths.cp.main.lg'));
			View::share('mainXlCols', config('cms.column_widths.cp.main.xl'));
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
