<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{ContentTrait, ArticleCategoryTrait};

class ArticleTemplate extends Template
{
	use ContentTrait,  ArticleCategoryTrait;
	
	protected $view = 'article';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		// Convert to collect.
		$articles = collect([$parameters['article']]);
		
		// Filter and do any other house keeping.
		$articles = $this->getFilterPublishContentArticles($articles);
		
		// Convert it back.
		$article = $articles->first();
			
		// Grab all article categories
		$articleCategories = $this->getArticleCategories();
		
		// Remove the All categories
		$articleCategories->forget(0);
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'slug' => $page->slug,
			'url' => $page->url,
		]);
		
		// Add article itself to the list
		$page->breadcrumbs->push([
			'title' => $article->title,
			'slug' => $article->slug,
			'url' => $article->url,
		]);
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->title = $article->title.' - '.$page->title;
		
		$page->bannerContent = '<h2>'.$article->title.'</h2>';
		
		// If the article has a banner image use this instead.
		if (!empty($article->bannerImage)) {
			$page->bannerImage = $article->bannerImage;
		}
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'article', 'articleCategories'));
	}
}
