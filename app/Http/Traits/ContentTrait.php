<?php

namespace App\Http\Traits;

use App\Models\Content;

trait ContentTrait
{
	/**
	 * Get the specified content based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getContent(int $id)
	{
		return Content::findOrFail($id);
	}
	
	/**
	 * Get the specified content based on page id.
	 *
	 * @param 	int		$fieldId
	 * @return 	Object
	 */
	public function getContentByField(int $fieldId)
	{
		return Content::where('field_id', $fieldId)->firstOrFail();
	}

	/**
	 * Get all the contents.
	 *
	 * @return 	Response
	 */
	public function getContents()
	{
		return Content::all();
	}
}
