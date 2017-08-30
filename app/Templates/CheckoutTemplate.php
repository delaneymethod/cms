<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\CartTrait;
use App\Http\Traits\ContentTrait;

class CheckoutTemplate extends Template
{
	use CartTrait;
	use ContentTrait;
	
	protected $view = 'checkout';

	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$savedCarts = $this->getSavedCarts($currentUser->id);
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'savedCarts'));
	}
}
