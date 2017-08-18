<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\CartTrait;

class CheckoutTemplate extends Template
{
	use CartTrait;
	
	protected $view = 'checkout';

	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $parameters['page'];
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$savedCarts = $this->getSavedCarts($currentUser->id);
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'savedCarts'));
	}
}
