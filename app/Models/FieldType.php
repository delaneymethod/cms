<?php

namespace App\Models;

use App\Models\Field;
use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
	];

	/**
	 * Get the field records associated with the field type.
	 */
	public function fields()
	{
		return $this->hasMany(Field::class);
	}
}
