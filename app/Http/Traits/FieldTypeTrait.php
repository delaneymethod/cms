<?php

namespace App\Http\Traits;

use App\Models\FieldType;

trait FieldTypeTrait
{
	/**
	 * Get the specified field type based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getFieldType(int $id)
	{
		return FieldType::findOrFail($id);
	}

	/**
	 * Get all the field types.
	 *
	 * @return 	Response
	 */
	public function getFieldTypes()
	{
		return FieldType::all();
	}
}
