<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ProductStandard;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductStandardTrait
{
	/**
	 * Get the specified product standard based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProductStandard(int $id) : ProductStandard
	{
		return ProductStandard::findOrFail($id);
	}
	
	/**
	 * Get all the product standards.
	 *
	 * @return 	Response
	 */
	public function getProductStandards() : CollectionResponse
	{
		return ProductStandard::all();
	}
}
