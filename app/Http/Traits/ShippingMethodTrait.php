<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ShippingMethodTrait
{
	/**
	 * Get the specified shipping method based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getShippingMethod(int $id) : ShippingMethod
	{
		return ShippingMethod::findOrFail($id);
	}

	/**
	 * Get all the shipping methods.
	 *
	 * @return 	Response
	 */
	public function getShippingMethods() : CollectionResponse
	{
		return ShippingMethod::all();
	}
}
