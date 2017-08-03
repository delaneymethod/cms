<?php

namespace App\Http\Traits;

use App\Models\Product;

trait ProductTrait
{
	/**
	 * Get the specified product based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProduct(int $id)
	{
		return Product::findOrFail($id);
	}

	/**
	 * Get all the products.
	 *
	 * @return 	Response
	 */
	public function getProducts()
	{
		return Product::all();
	}
}
