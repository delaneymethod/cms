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
		return Location::findOrFail($id);
	}

	/**
	 * Get all the locations.
	 *
	 * @return 	Response
	 */
	public function getLocations()
	{
		$limit = $this->getLimit();
		
		return $this->paginateCollection(Location::all(), $limit);
	}
}
