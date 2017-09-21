<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait LocationTrait
{
	/**
	 * Get the specified location based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getLocation(int $id) : Location
	{
		$location = Location::findOrFail($id);
		
		return $this->filterLocations([$location])->first();
	}

	/**
	 * Get all the locations.
	 *
	 * @return 	Response
	 */
	public function getLocations() : CollectionResponse
	{
		return Location::orderBy('title')->get();
	}
}
