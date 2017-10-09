<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class Template
{
	protected $view;
	
	public abstract function prepare(View $view, array $parameters);
	
	public function getView() : string
	{
		return $this->view;
	}
	
	public function getFilterPublishContentArticles(SupportCollection $articles) : SupportCollection
	{
		// Filter out any articles with publish date in the future
		$articles = $articles->filter(function ($article) {
			return $article->published_at <= Carbon::now();
		});
		
		// Only show published articles
		$articles = $articles->filter(function ($article) {
			return $article->isPublished();
		});
		
		// Now get each articles content
		$articles = $articles->map(function ($article) {
			return $this->getArticleContent($article);
		});
		
		return $articles;
	}
}
