<?php

namespace App\Models;

use App\Models\Page;
use App\Models\Field;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'filename',
	];

	/**
	 * Get the pages records associated with the template.
	 */
	public function pages()
	{
		return $this->hasMany(Page::class);
	}
	
	/**
	 * Get the articles records associated with the template.
	 */
	public function articles()
	{
		return $this->hasMany(Article::class);
	}
	
	/**
	 * Get the field records associated with the template.
	 */
	public function fields()
	{
		return $this->belongsToMany(Field::class, 'template_field')->withPivot('order')->orderBy('order');
	}
	
	/**
	 * Set fields for the template.
	 *
	 * $param 	array 	$fields
	 */
	public function setFields(array $fields)
	{
		return $this->fields()->sync($fields);
	}
}
