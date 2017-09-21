<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\ProductStandardOrganisation;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait ProductStandardOrganisationTrait
{
	/**
	 * Get the specified product standard organisation based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getProductStandardOrganisation(int $id) : ProductStandardOrganisation
	{
		return ProductStandardOrganisation::findOrFail($id);
	}
	
	/**
	 * Get all the product standard organisations.
	 *
	 * @return 	Response
	 */
	public function getProductStandardOrganisations() : CollectionResponse
	{
		return ProductStandardOrganisation::all();
	}
}
