<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use DB;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Collection as SupportCollectionResponse;

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
		return Order::findOrFail($id);
	}

	/**
	 * Get all the orders.
	 *
	 * @return 	Response
	 */
	public function getOrders() : SupportCollectionResponse
	{
		return Order::orderBy('created_at', 'desc')->get();
	}
	
	/**
	 * Get all the orders for a specific month.
	 *
	 * @param 	int			$month
	 * @return 	Response
	 */
	public function getOrdersByMonth(int $month) : SupportCollectionResponse
	{
		return Order::where(DB::raw('MONTH(created_at)'), '=', $month)->get();
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
		return Order::where(DB::raw('MONTH(created_at)'), '=', $month)->where('status_id', $statusId)->get();
	}
}
