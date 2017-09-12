<?php

namespace App\Models;

use App\Models\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldType extends Model
{
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'type',
	];

	/**
	 * Get the field records associated with the field type.
	 */
	public function fields() : HasMany
	{
		return $this->hasMany(Field::class);
	}
}
