<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Providers;

use App;
use Exception;
use Illuminate\Support\ServiceProvider;
use App\Http\Traits\{PageTrait, AssetTrait};
use Illuminate\Support\Facades\{Auth, View};

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
			View::composer('*', function ($view) {
				try {
					$authenticated = Auth::check();
				
					$footerLinksRight = collect([]);
				
					$footerLinksLeft = collect([]);
					
					$pages = $this->getPages();
					
					$page = null;
			
					// Used to build footer links in the 1st column
					$slugs = collect(['contact', 'manufacturers', 'services', 'awards']);
				
					// Gets Terms and Conditions PDF - 2 matches asset id
					$asset = $this->getAsset(2);
				
					$footerLinksLeft->push((object) [
						'title' => 'Terms and Conditions',
						'url' => $asset->path,
						'target' => 'target="_blank"',
					]);
					
					// Gets Privacy Policy PDF - 1 matches asset id
					$asset = $this->getAsset(1);
						
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
				
					$slugs->each(function ($slug) use ($footerLinksRight) {
						$page = $this->getPageBySlug($slug);
					
						$page->target = '';
					
						$footerLinksRight->push($page);
					});
				
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
						
						$page->bannerContent = '<h2>'.$specialTitles[$found].'</h2>';
						
						$page->bannerImage = '/uploads/bg_rigs_1_edit_darker.jpg';
						
						$view->with([
							'page' => $page,
						]);
					}
					
					$view->with([
						'authenticated' => $authenticated,
						'pages' => $pages,
						'footerLinksLeft' => $footerLinksLeft,
						'footerLinksRight' => $footerLinksRight,
					]);
					
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
				} catch (Exception $exception) {
					exit('<h2>500 Internal Server Error</h2><p>Something went wrong on our servers while we were processing your request.</p><p>We&#39;re really sorry about this, and will work hard to get this resolved as soon as possible.</p><h3>Exception</h3><small><pre>'.$exception->getMessage().'</pre></small>');
				}
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
