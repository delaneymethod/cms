<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{UserTrait, ArticleTrait, ContentTrait, CarouselTrait, ArticleCategoryTrait};

class ArticleTemplate extends Template
{
	use UserTrait, ArticleTrait, ContentTrait, CarouselTrait, ArticleCategoryTrait;
	
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
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'article', 'articleAuthors', 'articleCategories'));
	}
}
