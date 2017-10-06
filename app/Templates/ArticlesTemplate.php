<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Templates;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Http\Traits\{ArticleTrait, ContentTrait, ArticleCategoryTrait};

class ArticlesTemplate extends Template
{
	use ArticleTrait, ContentTrait, ArticleCategoryTrait;
	
	protected $view = 'articles';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$articleCategory = $parameters['articleCategory'];
		
		if (!empty($articleCategory)) {
			$articles = $this->getArticlesByCategory($articleCategory);
			
			$articleCategory = $this->getArticleCategoryBySlug($articleCategory);
			
			$page->bannerContent = '<h2>Articles</h2><h4>'.$articleCategory->title.'</h4>';
		} else {
			$articles = $this->getArticles();
		}
		
		// Filter out any articles with publish date in the future
		$articles = $articles->filter(function ($article) {
			return $article->published_at <= Carbon::now();
		});
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'slug' => $page->slug,
			'url' => $page->url,
		]);
		
		if (!empty($articleCategory)) {
			$page->breadcrumbs->push([
				'title' => $articleCategory->title,
				'slug' => $articleCategory->slug,
				'url' => '/articles/category/'.$articleCategory->slug,
			]);
		}
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'articles', 'articleCategory'));
	}
}
