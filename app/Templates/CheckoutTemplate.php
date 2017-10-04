<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{PageTrait, CartTrait, ContentTrait, ShippingMethodTrait};

class CheckoutTemplate extends Template
{
	use PageTrait, CartTrait, ContentTrait, ShippingMethodTrait;
	
	protected $view = 'checkout';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$step = $parameters['step'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $this->setCartItems($parameters['cart']);
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$savedCarts = $this->getSavedCarts($currentUser->id);
		
		$locations = $currentUser->company->locations;
		
		$shippingMethods = $this->getShippingMethods();
		
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
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'savedCarts', 'locations', 'shippingMethods', 'step'));
	}
}
