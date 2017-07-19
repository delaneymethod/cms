<?php

namespace App\Models;

use App\Models\County;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
	 * Get the county records associated with the country.
	 */
	public function counties()
	{
		return $this->hasMany(County::class);
	}
}
