<?php

namespace App\Http\Traits;

use DB;
use Carbon\Carbon;
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
	
	/**
	 * Get all the orders for a specific month.
	 *
	 * @param 	int			$month
	 * @return 	Response
	 */
	public function getOrdersByMonth(int $month)
	{
		return $this->filterOrders(Order::where(DB::raw('MONTH(created_at)'), '=', $month)->get());
	}
	
	/**
	 * Get all the orders for a specific month and status.
	 *
	 * @param 	int			$month
	 * @param 	int			$status_id 
	 * @return 	Response
	 */
	public function getOrdersByMonthStatus(int $month, int $statusId)
	{
		return $this->filterOrders(Order::where(DB::raw('MONTH(created_at)'), '=', $month)->where('status_id', $statusId)->get());
	}
}
