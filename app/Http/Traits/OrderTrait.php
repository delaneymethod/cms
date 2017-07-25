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
		$order = Order::findOrFail($id);
	
		return $this->filterOrders([$order])->first();
	}

	/**
	 * Get all the orders.
	 *
	 * @return 	Response
	 */
	public function getOrders()
	{
		$orders = $this->filterOrders(Order::all());
		
		$limit = $this->getLimit();

		return $this->paginateCollection($orders, $limit);
	}
}
