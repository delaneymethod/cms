<?php

namespace App\Models;

use App\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsToMany};

class Role extends Model
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
	 * Get the user records associated with the role.
	 */
	public function users() : HasMany
	{
		return $this->hasMany(User::class);
	}
	
	/**
	 * Get the permissions records associated with the role.
	 */
	public function permissions() : BelongsToMany
	{
		return $this->belongsToMany(Permission::class, 'role_permission');
	}
	
	/**
	 * Set permissions for the role.
	 *
	 * $param 	array 	$permissions
	 */
	public function setPermissions(array $permissions)
	{
		return $this->permissions()->sync($permissions);
	}
}
