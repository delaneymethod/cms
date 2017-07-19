<?php

namespace App\Http\Traits;

use App\Models\Status;

trait StatusTrait
{
	/**
	 * Get the specified status based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getStatus(int $id)
	{
		return Status::findOrFail($id);
	}

	/**
	 * Get all the statuses.
	 *
	 * @return 	Response
	 */
	public function getStatuses()
	{
		return Status::all();
	}
}
