<?php

namespace App\Http\Traits;

use App\Models\DeliveryMethod;

trait DeliveryMethodTrait
{
	/**
	 * Get the specified delivery method based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getDeliveryMethod(int $id)
	{
		return DeliveryMethod::findOrFail($id);
	}

	/**
	 * Get all the delivery methods.
	 *
	 * @return 	Response
	 */
	public function getDeliveryMethods()
	{
		return DeliveryMethod::all();
	}
}
