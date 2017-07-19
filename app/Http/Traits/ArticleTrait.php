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
	 * Get all the articles.
	 *
	 * @return 	Response
	 */
	public function getArticles()
	{
		return Article::all();
	}
}
