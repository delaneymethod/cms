<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ArticleTrait;

class ArticlesTemplate extends Template
{
	use ArticleTrait;
	
	protected $view = 'articles';
	
	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $parameters['page'];
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$articles = $this->getArticles();
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'articles'));
	}
}
