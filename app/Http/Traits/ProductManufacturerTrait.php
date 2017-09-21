<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ProductManufacturer;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductManufacturerTrait
{
	/**
	 * Get the specified product manufacturer based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProductManufacturer(int $id) : ProductManufacturer
	{
		return ProductManufacturer::findOrFail($id);
	}
	
	/**
	 * Get all the product manufacturers.
	 *
	 * @return 	Response
	 */
	public function getProductManufacturers() : CollectionResponse
	{
		return ProductManufacturer::all();
	}
}
