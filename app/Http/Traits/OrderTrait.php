<?php

namespace App\Http\Traits;

use DB;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Collection as SupportCollectionResponse;
use Illuminate\Database\Eloquent\Collection as EloquentCollectionResponse;

trait OrderTrait
{
	/**
	 * Get the specified order based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getOrder(int $id) : Order
	{
		$order = Order::findOrFail($id);
	
		return $this->filterOrders([$order])->first();
	}

	/**
	 * Get all the orders.
	 *
	 * @return 	Response
	 */
	public function getOrders() : EloquentCollectionResponse
	{
		return Order::all();
	}
	
	/**
	 * Get all the orders for a specific month.
	 *
	 * @param 	int			$month
	 * @return 	Response
	 */
	public function getOrdersByMonth(int $month) : SupportCollectionResponse
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
	public function getOrdersByMonthStatus(int $month, int $statusId) : SupportCollectionResponse
	{
		return $this->filterOrders(Order::where(DB::raw('MONTH(created_at)'), '=', $month)->where('status_id', $statusId)->get());
	}
}
