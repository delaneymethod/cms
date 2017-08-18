<?php
namespace App\Templates;

use Illuminate\View\View;

class PageTemplate extends Template
{
	protected $view = 'page';

	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $parameters['page'];
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
}
