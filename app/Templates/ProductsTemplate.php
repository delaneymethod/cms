<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ProductTrait;
use App\Http\Traits\ContentTrait;

class ProductsTemplate extends Template
{
	use ProductTrait;
	use ContentTrait;
	
	protected $view = 'products';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$products = $this->getProducts();
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'products'));
	}
}
