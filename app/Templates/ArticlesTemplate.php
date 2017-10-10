<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{UserTrait, ArticleTrait, ContentTrait, ArticleCategoryTrait};

class ArticlesTemplate extends Template
{
	use UserTrait, ArticleTrait, ContentTrait, ArticleCategoryTrait;
	
	protected $view = 'articles';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$articleAuthor = $parameters['articleAuthor'];
		
		$articleCategory = $parameters['articleCategory'];
		
		if (!empty($articleAuthor)) {
			$articles = $this->getArticlesByAuthor($articleAuthor);
			
			$articles = $this->getFilterPublishContentArticles($articles);
			
			// Get recent articles to add extra template content
			$recentArticles = $this->getArticles();
			
			// We only want 5 though
			$recentArticles = $recentArticles->slice(0, 5);
			
			$recentArticles = $this->getFilterPublishContentArticles($recentArticles);
		
			$articleAuthor = $this->getUserBySlug($articleAuthor);
			
			$page->bannerContent = '<h2>Articles</h2><h4>'.$articleAuthor->first_name.' '.$articleAuthor->last_name.'</h4>';
		} else if (!empty($articleCategory)) {
			$articles = $this->getArticlesByCategory($articleCategory);
			
			$articles = $this->getFilterPublishContentArticles($articles);
			
			// Get recent articles to add extra template content
			$recentArticles = $this->getArticles();
			
			// We only want 5 though
			$recentArticles = $recentArticles->slice(0, 5);
			
			$recentArticles = $this->getFilterPublishContentArticles($recentArticles);
		
			$articleCategory = $this->getArticleCategoryBySlug($articleCategory);
			
			$page->bannerContent = '<h2>Articles</h2><h4>'.$articleCategory->title.'</h4>';
		} else {
			$recentArticles = collect([]);
		
			$articles = $this->getArticles();
			
			$articles = $this->getFilterPublishContentArticles($articles);
		}
		
		// Grab all article authors
		$articleAuthors = $this->getArticles()->pluck('user')->unique();
		
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
		
		if (!empty($articleCategory)) {
			$page->breadcrumbs->push([
				'title' => $articleCategory->title,
				'slug' => $articleCategory->slug,
				'url' => '/articles/category/'.$articleCategory->slug,
			]);
		}
		
		if (!empty($articleAuthor)) {
			$page->breadcrumbs->push([
				'title' => $articleAuthor->first_name.' '.$articleAuthor->last_name,
				'slug' => $articleAuthor->slug,
				'url' => '/articles/author/'.$articleAuthor->slug,
			]);
		}
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'articles', 'recentArticles', 'articleAuthor', 'articleAuthors', 'articleCategory', 'articleCategories'));
	}
}
