<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{PageTrait, CartTrait, ContentTrait, CarouselTrait, ShippingMethodTrait};

class CheckoutTemplate extends Template
{
	use PageTrait, CartTrait, ContentTrait, CarouselTrait, ShippingMethodTrait;
	
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
		
		// Check if page has slider
		if (!empty($page->carousel)) {
			$carousel = $this->getCarousel($page->carousel);
			
			if (!empty($carousel->data)) {
				$carousel = json_decode($carousel->data, true);
			
				$images = [];
			
				$contents = [];
			
				foreach ($carousel as $key => $value) {
					if (preg_match('/image/i', $key)) {
						$images[] = $value;
					}
					
					if (preg_match('/content/i', $key)) {
						$contents[] = $value;
					}
				}
				
				$carousel = [];
				
				foreach ($images as $key => $value) {
					array_push($carousel, [
						'image' => $images[$key],
						'content' => $contents[$key],
					]);
				}
	
				$page->carousel = collect($carousel);
			} else {
				$page->carousel = null;
			}
		} else {
			$page->carousel = null;
		}
		
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
