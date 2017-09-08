<?php

namespace App\Http\Traits;

use App\Models\ShippingMethod;

trait ShippingMethodTrait
{
	/**
	 * Get the specified shipping method based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getShippingMethod(int $id)
	{
		return ShippingMethod::findOrFail($id);
	}

	/**
	 * Get all the shipping methods.
	 *
	 * @return 	Response
	 */
	public function getShippingMethods()
	{
		return ShippingMethod::all();
	}
}
