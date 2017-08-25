<?php

namespace App\Models;

use App\Models\Template;
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
		'options',
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
	 * Get the template records associated with the field.
	 */
	public function templates()
	{
		return $this->belongsToMany(Template::class, 'template_field')->withPivot('order')->orderBy('order');
	}
	
	/**
	 * Set templates for the field.
	 *
	 * $param 	array 	$templates
	 */
	public function setTemplates(array $templates)
	{
		return $this->templates()->sync($templates);
	}
}
