<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
	];

	/**
	 * Get users with a certain permission
	 */
	public function users()
	{
		return $this->belongsToMany(User::class, 'users_permissions');
	}
}
