<?php
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{ArticleTrait, ContentTrait};

class ArticlesTemplate extends Template
{
	use ArticleTrait, ContentTrait;
	
	protected $view = 'articles';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$articles = $this->getArticles();
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'articles'));
	}
}
