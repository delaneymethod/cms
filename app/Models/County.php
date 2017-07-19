<?php

namespace App\Models;

use App\Models\Country;
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
	 * Get the country record associated with the booking.
	 */
	public function country()
	{
		return $this->belongsTo(Country::class);
	}
}
