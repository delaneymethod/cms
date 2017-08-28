<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ArticleTrait;
use App\Http\Traits\ContentTrait;

class ArticlesTemplate extends Template
{
	use ArticleTrait;
	use ContentTrait;
	
	protected $view = 'articles';
	
	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$articles = $this->getArticles();
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'articles'));
	}
}
