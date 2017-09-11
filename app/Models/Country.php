<?php

namespace App\Models;

use App\Models\{County, Location};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
	 * Get the location records associated with the country.
	 */
	public function locations() : HasMany
	{
		return $this->hasMany(Location::class);
	}
	
	/**
	 * Get the county records associated with the country.
	 */
	public function counties() : HasMany
	{
		return $this->hasMany(County::class);
	}
}
