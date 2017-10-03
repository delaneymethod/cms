<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{PageTrait, ContentTrait};

class PageTemplate extends Template
{
	use PageTrait, ContentTrait;
	
	protected $view = 'page';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		// Try to get all pages based on current pages url.
		$slugs = explode(DIRECTORY_SEPARATOR, $page->url);
		
		$slugs = collect($slugs);
		
		// Remove ""
		unset($slugs[0]);
		
		$page->breadcrumbs = collect([]);
		
		collect($slugs)->each(function ($slug) use ($page) {
			$parent = $this->getPageBySlug($slug);
			
			// Add each slug
			$page->breadcrumbs->push([
				'title' => $parent->title,
				'slug' => $parent->slug,
				'url' => $parent->url,
			]);
		});
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
}
