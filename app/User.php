<?php

namespace App;

use App\Models\Role;
use App\Models\Order;
use App\Models\Status;
use App\Models\Company;
use App\Models\Article;
use App\Models\Location;
use App\Models\Permission;
use App\Http\Traits\RoleTrait;
use App\Http\Traits\PermissionTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use RoleTrait;
	use Notifiable;
	use PermissionTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'job_title',
		'telephone',
		'mobile',
		'company_id',
		'location_id',
		'status_id',
		'role_id',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 
		'remember_token',
	];
	
	/**
	 * Get the role record associated with the user.
	 */
	public function role()
	{
		return $this->belongsTo(Role::class);
	}
	
	/**
	 * Get the status record associated with the user.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the company record associated with the user.
	 */
	public function company()
	{
		return $this->belongsTo(Company::class);
	}
	
	/**
	 * Get the location record associated with the user.
	 */
	public function location()
	{
		return $this->belongsTo(Location::class);
	}
	
	/**
	 * Get the orders records associated with the user.
	 */
	public function orders()
	{
		return $this->hasMany(Order::class);
	}
	
	/**
	 * Get the articles records associated with the user.
	 */
	public function articles()
	{
		return $this->hasMany(Article::class);
	}
	
	/**
	 * Get the permissions records associated with the user.
	 */
	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'permission_user');
	}

	/**
	 * Find out if user has permissions, based on if has any permissions
	 *
	 * @return boolean
	 */
	public function hasPermissions()
	{
		return !empty($this->permissions->toArray());
	}

	/**
	 * Find out if user has a specific permission
	 *
	 * $param 	string 		$permission
	 * $return 	boolean
	 */
	public function hasPermission(string $permission)
	{
		return in_array($permission, $this->permissions->pluck('title')->toArray());
	}
	
	/**
	 * Set permissions for the user based on a role.
	 *
	 * $param 	int 		$roleId
	 */
	public function setRole(int $roleId)
	{
		$assignedPermissions = array();

		// Quick cross check to to make sure role exists
		$role = $this->getRole($roleId);

		$permissions = $this->getPermissions();

		switch ($role->title) {
			case 'Super Administrator':
				// Add all permissions
				$assignedPermissions = $permissions->pluck('id')->toArray();
			break;
			
			case 'Administrator':
				// TODO - Assign more permissions to admins
				array_push($assignedPermissions, $this->_getIdFromCollection($permissions, 'view_users'));
				
				// cannot select super admin status
				// cannot edit roles, statuses, pages, menu, articles
				
			break;
			
			case 'End User':
				// TODO - Assign more permissions to end users
				array_push($assignedPermissions, $this->_getIdFromCollection($permissions, 'view_orders'));
			
				// can only view stuff and edit own account
			break;
		}
		
		if (count($assignedPermissions) === 0) {
			abort(500, 'The user has no permissions!');
		}

		// See "Syncing Associations" under Eloquent Relationships in the Laravel docs!
		return $this->permissions()->sync($assignedPermissions);
	}
	
	/**
	 * Checks if user is a super admin.
	 *
	 * @return bool
	 */
	public function isSuperAdmin()
	{
		return $this->role_id == 1;
	}
	
	/**
	 * Checks if user is a admin.
	 *
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->role_id == 2;
	}
	
	/**
	 * Checks if user is an end user.
	 *
	 * @return bool
	 */
	public function isEndUser()
	{
		return $this->role_id == 3;
	}
	
	/**
	 * Route notifications for the mail channel.
	 *
	 * @return string
	 */
	public function routeNotificationForMail()
	{
		return $this->email;
	}

	/**
	 * Get id from collection where corresponding value
	 *
	 * $param 	collection 	$collection
	 * $param 	string 		$permission
	 * @return 	int
	 */
	private function _getIdFromCollection(Collection $collection, string $permission)
	{
		return $collection->where('title', $permission)->first()->id;
	}
}
