<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\Field;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait FieldTrait
{
	/**
	 * Get the specified field based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getField(int $id) : Field
	{
		return Field::findOrFail($id);
	}

	/**
	 * Get all the field types.
	 *
	 * @return 	Response
	 */
	public function getFields() : CollectionResponse
	{
		return Field::all();
	}
}
