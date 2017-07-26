<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'country_id',
		'title',
	];

	/**
	 * Get the location records associated with the county.
	 */
	public function locations()
	{
		return $this->hasMany(Location::class);
	}
	
	/**
	 * Get the country record associated with the county.
	 */
	public function country()
	{
		return $this->belongsTo(Country::class);
	}
}
