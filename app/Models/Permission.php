<?php

namespace App\Models;

use App\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
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
	 * Get the role records associated with the permission.
	 */
	public function roles()
	{
		return $this->belongsToMany(Role::class, 'role_permission');
	}
	
	/**
	 * Set roles for the permission.
	 *
	 * $param 	array 	$roles
	 */
	public function setRoles(array $roles)
	{
		return $this->roles()->sync($roles);
	}
}
