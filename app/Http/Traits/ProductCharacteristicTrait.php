<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ProductCharacteristic;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductCharacteristicTrait
{
	/**
	 * Get the specified product characteristic based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProductCharacteristic(int $id) : ProductCharacteristic
	{
		return ProductCharacteristic::findOrFail($id);
	}
	
	/**
	 * Get all the product characteristics.
	 *
	 * @return 	Response
	 */
	public function getProductCharacteristics() : CollectionResponse
	{
		return ProductCharacteristic::all();
	}
}
