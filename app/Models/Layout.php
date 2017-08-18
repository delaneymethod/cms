<?php

namespace App\Models;

use App\Models\Field;
use App\Models\Template;
use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	];

	/**
	 * Get the template records associated with the layout.
	 */
	public function templates()
	{
		return $this->hasMany(Template::class);
	}
		
	/**
	 * Get the field records associated with the layout.
	 */
	public function fields()
	{
		return $this->belongsToMany(Field::class, 'layout_field')->orderBy('order');
	}
}
