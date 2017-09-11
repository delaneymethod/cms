<?php

namespace App\Http\Traits;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait GroupTrait
{
	/**
	 * Get the specified group based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getGroup(int $id) : Group
	{
		return Group::findOrFail($id);
	}

	/**
	 * Get all the groups.
	 *
	 * @return 	Response
	 */
	public function getGroups() : CollectionResponse
	{
		return Group::all();
	}
}
