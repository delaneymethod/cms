<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ProductCommodity;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductCommodityTrait
{
	/**
	 * Get the specified product commodity based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProductCommodity(int $id) : ProductCommodity
	{
		return ProductCommodity::findOrFail($id);
	}
	
	/**
	 * Get all the product commodities.
	 *
	 * @return 	Response
	 */
	public function getProductCommodities() : CollectionResponse
	{
		return ProductCommodity::all();
	}
	
	/**
	 * Get the total product commodity count
	 *
	 * @return 	int
	 */
	public function getProductCommodityCount() : int
	{
		return ProductCommodity::count();
	}
}
