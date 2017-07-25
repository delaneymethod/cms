<?php

namespace App\Models;

use App\User;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'user_id',
		'status_id',
	];

	/**
	 * Get the user record associated with the order.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the status record associated with the order.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
