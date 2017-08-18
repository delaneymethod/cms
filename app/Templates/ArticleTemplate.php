<?php
namespace App\Templates;

use Illuminate\View\View;

class ArticleTemplate extends Template
{
	protected $view = 'article';
	
	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $parameters['page'];
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$article = $parameters['article'];
		
		$page->title = $article->title.' - '.$page->title;
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'article'));
	}
}
