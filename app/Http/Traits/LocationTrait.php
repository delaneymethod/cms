<?php

namespace App\Http\Traits;

use App\Models\Location;

trait LocationTrait
{
	/**
	 * Get the specified location based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getLocation(int $id)
	{
		$location = Location::findOrFail($id);
		
		return $this->filterLocations([$location])->first();
	}

	/**
	 * Get all the locations.
	 *
	 * @return 	Response
	 */
	public function getLocations()
	{
		$locations = $this->filterLocations(Location::all());
		
		$limit = $this->getLimit();

		return $this->paginateCollection($locations, $limit);
	}
}
