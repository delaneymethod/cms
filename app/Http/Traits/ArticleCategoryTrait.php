<?php

namespace App\Http\Traits;

use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ArticleCategoryTrait
{
	/**
	 * Get the specified article category based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getArticleCategory(int $id) : ArticleCategory
	{
		return ArticleCategory::findOrFail($id);
	}
	
	/**
	 * Get all the article categories.
	 *
	 * @return 	Collection
	 */
	public function getArticleCategories() : CollectionResponse
	{
		return ArticleCategory::orderBy('title')->get();
	}
}
