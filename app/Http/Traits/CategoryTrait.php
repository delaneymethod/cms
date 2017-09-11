<?php

namespace App\Http\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait CategoryTrait
{
	/**
	 * Get the specified category based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getCategory(int $id) : Category
	{
		return Category::findOrFail($id);
	}
	
	/**
	 * Get all the categories.
	 *
	 * @return 	Collection
	 */
	public function getCategories() : CollectionResponse
	{
		return Category::all();
	}
}
