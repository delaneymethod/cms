<?php

namespace App\Models;

use App\Models\Layout;
use App\Models\FieldType;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'handle',
		'field_type_id',
		'required',
		'instructions',
	];

	/**
	 * Get the field type record associated with the field.
	 */
	public function field_type()
	{
		return $this->belongsTo(FieldType::class);
	}
	
	/**
	 * Get the layout records associated with the field.
	 */
	public function layouts()
	{
		return $this->belongsToMany(Layout::class, 'layout_field')->orderBy('order');
	}
}
