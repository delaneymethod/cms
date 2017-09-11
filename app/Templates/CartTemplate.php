<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{CartTrait, ContentTrait};

class CartTemplate extends Template
{
	use CartTrait;
	use ContentTrait;
	
	protected $view = 'cart';
	
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
