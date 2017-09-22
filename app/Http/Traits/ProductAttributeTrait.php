<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductAttributeTrait
{
	/**
	 * Get the specified product attribute based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProductAttribute(int $id) : ProductAttribute
	{
		return ProductAttribute::findOrFail($id);
	}
	
	/**
	 * Get all the product attributes.
	 *
	 * @return 	Response
	 */
	public function getProductAttributes() : CollectionResponse
	{
		return ProductAttribute::all();
	}
}
