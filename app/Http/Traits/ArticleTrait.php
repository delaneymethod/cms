<?php

namespace App\Http\Traits;

use App\Models\Article;

trait ArticleTrait
{
	/**
	 * Get the specified article based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getArticle(int $id)
	{
		return Article::findOrFail($id);
	}
	
	/**
	 * Get the specified article based on slug.
	 *
	 * @param 	string 		$slug
	 * @return 	Object
	 */
	public function getArticleBySlug(string $slug)
	{
		return Article::where('slug', $slug)->where('status_id', 4)->firstOrFail();
	}
	
	/**
	 * Get the specified article based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getArticleOrFail(int $id)
	{
		return Article::findOrFail($id);
	}

	/**
	 * Get all the articles.
	 *
	 * @return 	Response
	 */
	public function getArticles()
	{
		return Article::all();
	}
}
