<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ProductTrait;

class ProductsTemplate extends Template
{
	use ProductTrait;
	
	protected $view = 'products';
	
	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $parameters['page'];
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$products = $this->getProducts();
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'products'));
	}
}
