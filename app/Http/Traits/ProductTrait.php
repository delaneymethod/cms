<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductTrait
{
	/**
	 * Get the specified product based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProduct(int $id) : Product
	{
		return Product::findOrFail($id);
	}
	
	/**
	 * Get the specified product based on slug.
	 *
	 * @param 	string 		$slug
	 * @return 	Object
	 */
	public function getProductBySlug(string $slug) : Product
	{
		return Product::where('slug', $slug)->firstOrFail();
	}
	
	/**
	 * Get all products based on product category id.
	 *
	 * @param 	int 		$productCategoryId
	 * @return 	Object
	 */
	public function getProductsByProductCategory(int $productCategoryId) : CollectionResponse
	{
		return Product::where('product_category_id', $productCategoryId)->get();
	}
	
	/**
	 * Get all the products.
	 *
	 * @return 	Response
	 */
	public function getProducts() : CollectionResponse
	{
		return Product::all();
	}
	
	/**
	 * Get the total product count
	 *
	 * @return 	int
	 */
	public function getProductCount() : int
	{
		return Product::count();
	}
}
