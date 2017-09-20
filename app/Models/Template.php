<?php

namespace App\Models;

use App\Models\{Page, Field, Article};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsToMany};

class Template extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'templates';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

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
	public function pages() : HasMany
	{
		return $this->hasMany(Page::class);
	}
	
	/**
	 * Get the articles records associated with the template.
	 */
	public function articles() : HasMany
	{
		return $this->hasMany(Article::class);
	}
	
	/**
	 * Get the field records associated with the template.
	 */
	public function fields() : BelongsToMany
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
