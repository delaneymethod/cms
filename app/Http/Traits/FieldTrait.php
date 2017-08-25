<?php

namespace App\Http\Traits;

use App\Models\Field;

trait FieldTrait
{
	/**
	 * Get the specified field based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getField(int $id)
	{
		return Field::findOrFail($id);
	}

	/**
	 * Get all the field types.
	 *
	 * @return 	Response
	 */
	public function getFields()
	{
		return Field::all();
	}
}
