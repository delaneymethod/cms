<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{UserTrait, ArticleTrait, ContentTrait, CarouselTrait, ArticleCategoryTrait};

class ArticlesTemplate extends Template
{
	use UserTrait, ArticleTrait, ContentTrait, CarouselTrait, ArticleCategoryTrait;
	
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
		
		// Check if page has slider
		if (!empty($page->carousel)) {
			$carousel = $this->getCarousel($page->carousel);
			
			if (!empty($carousel->data)) {
				$carousel = json_decode($carousel->data, true);
			
				$images = [];
			
				$contents = [];
			
				foreach ($carousel as $key => $value) {
					if (preg_match('/image/i', $key)) {
						$images[] = $value;
					}
					
					if (preg_match('/content/i', $key)) {
						$contents[] = $value;
					}
				}
				
				$carousel = [];
				
				foreach ($images as $key => $value) {
					array_push($carousel, [
						'image' => $images[$key],
						'content' => $contents[$key],
					]);
				}
	
				$page->carousel = collect($carousel);
			} else {
				$page->carousel = null;
			}
		} else {
			$page->carousel = null;
		}

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
