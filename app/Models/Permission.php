<?php

namespace App\Models;

use App\User;
use App\Models\{Role, Group};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Permission extends Model
{
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'group_id',
	];
	
	/**
	 * Get the group record associated with the permission.
	 */
	public function group() : BelongsTo
	{
		return $this->belongsTo(Group::class);
	}

	/**
	 * Get the role records associated with the permission.
	 */
	public function roles() : BelongsToMany
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
