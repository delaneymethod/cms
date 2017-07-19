<?php

namespace App\Models;

use App\User;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
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
	 * Get the user records associated with the status.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the status record associated with the user.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
