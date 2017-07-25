<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Company;
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
		'company_id',
		'status_id',
	];

	/**
	 * Get the company record associated with the location.
	 */
	public function company()
	{
		return $this->belongsTo(Company::class);
	}
	
	/**
	 * Get the status record associated with the location.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
