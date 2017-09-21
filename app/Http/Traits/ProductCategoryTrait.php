<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductCategoryTrait
{
	/**
	 * Get the specified product category based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProductCategory(int $id) : ProductCategory
	{
		return ProductCategory::findOrFail($id);
	}
	
	/**
	 * Get the specified product category based on slug.
	 *
	 * @param 	string 		$slug
	 * @return 	Object
	 */
	public function getProductCategoryBySlug(string $slug) : ProductCategory
	{
		return ProductCategory::where('slug', $slug)->firstOrFail();
	}
	
	/**
	 * Get the specified product category based on parent id.
	 *
	 * @param 	int 		$parentId
	 * @return 	Response
	 */
	public function getProductCategoriesByParent(int $parentId) : CollectionResponse
	{
		return ProductCategory::where('parent_id', $parentId)->get();
	}
	
	/**
	 * Get all the product categories.
	 *
	 * @return 	Response
	 */
	public function getProductCategories() : CollectionResponse
	{
		return ProductCategory::all();
	}
}
