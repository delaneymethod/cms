<?php

namespace App\Http\Traits;

use App\Models\Order;

trait OrderTrait
{
	/**
	 * Get the specified order based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getOrder(int $id)
	{
		return Order::findOrFail($id);
	}

	/**
	 * Get all the orders.
	 *
	 * @return 	Response
	 */
	public function getOrders()
	{
		return Order::all();
	}
}
