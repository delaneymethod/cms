<?php
namespace App\Templates;

use Illuminate\View\View;

class ProductTemplate extends Template
{
	protected $view = 'product';
	
	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $parameters['page'];
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$product = $parameters['product'];
		
		$page->title = $product->title.' - '.$page->title;
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'product'));
	}
}
