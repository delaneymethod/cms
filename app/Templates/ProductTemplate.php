<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ContentTrait;

class ProductTemplate extends Template
{
	use ContentTrait;
	
	protected $view = 'product';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$product = $parameters['product'];
		
		$page->title = $product->title.' - '.$page->title;
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'product'));
	}
}
