<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{CartTrait, ContentTrait};

class CartTemplate extends Template
{
	use CartTrait, ContentTrait;
	
	protected $view = 'cart';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		// Restructre the data so its grouped by product.
		$cartItems = $cart->product_commodities;
		
		$cart->cartTotalItems = count($cartItems);
		
		$cart->cartItems = $this->groupCartItemsByProduct($cartItems);
				
		$wishlistCart = $parameters['wishlistCart'];
		
		$savedCarts = $this->getSavedCarts($currentUser->id);
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'savedCarts'));
	}
}
