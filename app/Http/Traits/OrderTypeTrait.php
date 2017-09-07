<?php

namespace App\Http\Traits;

use App\Models\OrderType;

trait OrderTypeTrait
{
	/**
	 * Get the specified order type based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getOrderType(int $id)
	{
		return OrderType::findOrFail($id);
	}
	
	/**
	 * Get the specified order type based on slug.
	 *
	 * @param 	string 		$slug
	 * @return 	Object
	 */
	public function getOrderTypeBySlug(string $slug)
	{
		return OrderType::where('slug', $slug)->firstOrFail();
	}
	
	/**
	 * Get all the order types.
	 *
	 * @return 	Response
	 */
	public function getOrderTypes()
	{
		return OrderType::all();
	}
}
