<?php

namespace App\Http\Traits;

use App\Models\Group;

trait GroupTrait
{
	/**
	 * Get the specified group based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getGroup(int $id)
	{
		return Group::findOrFail($id);
	}

	/**
	 * Get all the groups.
	 *
	 * @return 	Response
	 */
	public function getGroups()
	{
		return Group::all();
	}
}
