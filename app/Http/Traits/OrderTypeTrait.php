<?php

namespace App\Http\Traits;

use App\Models\OrderType;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait OrderTypeTrait
{
	/**
	 * Get the specified order type based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getOrderType(int $id) : OrderType
	{
		return OrderType::findOrFail($id);
	}
	
	/**
	 * Get the specified order type based on slug.
	 *
	 * @param 	string 		$slug
	 * @return 	Object
	 */
	public function getOrderTypeBySlug(string $slug) : OrderType
	{
		return OrderType::where('slug', $slug)->firstOrFail();
	}
	
	/**
	 * Get all the order types.
	 *
	 * @return 	Response
	 */
	public function getOrderTypes() : CollectionResponse
	{
		return OrderType::all();
	}
}
