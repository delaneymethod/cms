<?php

namespace App\Http\Traits;

use App\Models\County;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait CountyTrait
{
	/**
	 * Get the specified county based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getCounty(int $id) : County
	{
		return County::findOrFail($id);
	}

	/**
	 * Get all the counties or the specified counties.
	 *
	 * Example:
	 * 	- $this->getCountyWhere([$field => $value])->first()
	 *
	 * @return 	Collection
	 */
	public function getCountiesWhere(array $params) : County
	{
		return County::where($params)->get()->first();
	}

	/**
	 * Get all the counties.
	 *
	 * @return 	Collection
	 */
	public function getCounties() : CollectionResponse
	{
		return County::all();
	}
}
