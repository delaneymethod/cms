<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Templates;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
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
		
		$cachingEnabled = config('cache.enabled');
		
		if ($cachingEnabled) {
			$articles = Cache::get('articles');
			
			if (is_null($articles)) {
				$articles = $this->getArticles();
				
				$minutes = config('cache.expiry_in_minutes');
				
				Cache::put('articles', $articles, $minutes);
			}
		} else {
			$articles = $this->getArticles();
		}
		
		// Filter out any articles with publish date in the future
		$articles = $articles->filter(function ($article) {
			return $article->published_at <= Carbon::now();
		});
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'articles'));
	}
}
