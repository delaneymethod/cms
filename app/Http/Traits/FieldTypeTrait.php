<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\FieldType;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait FieldTypeTrait
{
	/**
	 * Get the specified field type based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getFieldType(int $id) : FieldType
	{
		return FieldType::findOrFail($id);
	}

	/**
	 * Get all the field types.
	 *
	 * @return 	Response
	 */
	public function getFieldTypes() : CollectionResponse
	{
		return FieldType::all();
	}
}
