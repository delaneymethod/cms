<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{CartTrait, ContentTrait, ShippingMethodTrait};

class CheckoutTemplate extends Template
{
	use CartTrait, ContentTrait, ShippingMethodTrait;
	
	protected $view = 'checkout';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $this->setCartItems($parameters['cart']);
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$savedCarts = $this->getSavedCarts($currentUser->id);
		
		$locations = $currentUser->company->locations;
		
		$shippingMethods = $this->getShippingMethods();
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'savedCarts', 'locations', 'shippingMethods'));
	}
}
