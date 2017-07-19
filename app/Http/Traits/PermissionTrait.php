<?php

namespace App\Http\Traits;

use App\Models\Permission;

trait PermissionTrait
{
	/**
	 * Get the specified permission based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getPermission(int $id)
	{
		return Permission::findOrFail($id);
	}

	/**
	 * Get all the permissions.
	 *
	 * @return 	Response
	 */
	public function getPermissions()
	{
		return Permission::all();
	}
}
