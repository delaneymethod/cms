<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ContentTrait;

class ArticleTemplate extends Template
{
	use ContentTrait;
	
	protected $view = 'article';
	
	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$article = $this->getArticleContent($parameters['article']);
		
		$page->title = $article->title.' - '.$page->title;
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'article'));
	}
}