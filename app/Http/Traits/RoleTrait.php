<?php

namespace App\Http\Traits;

use App\Models\Role;

trait RoleTrait
{
	/**
	 * Get the specified role based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getRole(int $id)
	{
		return Role::findOrFail($id);
	}

	/**
	 * Get all the roles.
	 *
	 * @return 	Response
	 */
	public function getRoles()
	{
		return Role::all();
	}
}
