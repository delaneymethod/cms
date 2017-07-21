<?php

namespace App\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
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
	 * Get the status record associated with the location.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
