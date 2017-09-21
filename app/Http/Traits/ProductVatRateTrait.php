<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ProductVatRate;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductVatRateTrait
{
	/**
	 * Get the specified product vat rates based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProductVatRate(int $id) : ProductVatRate
	{
		return ProductVatRate::findOrFail($id);
	}
	
	/**
	 * Get all the product vat rates.
	 *
	 * @return 	Response
	 */
	public function getProductVatRates() : CollectionResponse
	{
		return ProductVatRate::all();
	}
}
