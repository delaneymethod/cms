<?php

namespace App\Http\Traits;

use App\Models\Category;

trait CategoryTrait
{
	/**
	 * Get the specified category based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getCategory(int $id)
	{
		return Category::findOrFail($id);
	}
	
	/**
	 * Get all the categories.
	 *
	 * @return 	Collection
	 */
	public function getCategories()
	{
		return Category::all();
	}
}
