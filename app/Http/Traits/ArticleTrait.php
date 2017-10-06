<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ArticleTrait
{
	/**
	 * Get the specified article based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getArticle(int $id) : Article
	{
		return Article::findOrFail($id);
	}
	
	/**
	 * Get the specified article based on slug.
	 *
	 * @param 	string 		$slug
	 * @return 	Object
	 */
	public function getArticleBySlug(string $slug) : Article
	{
		return Article::where('slug', $slug)->where('status_id', 4)->firstOrFail();
	}
	
	/**
	 * Get all the articles based on category slug.
	 *
	 * @param 	string 		$slug
	 * @return 	Object
	 */
	public function getArticlesByCategory(string $slug) : CollectionResponse
	{
		return Article::whereHas('article_categories', function ($query) use ($slug) {
			$query->where('slug', $slug);
		})->get();
	}
	
	/**
	 * Get the specified article based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getArticleOrFail(int $id) : Article
	{
		return Article::findOrFail($id);
	}

	/**
	 * Get all the articles.
	 *
	 * @return 	Response
	 */
	public function getArticles() : CollectionResponse
	{
		return Article::latest()->get();
	}
}
