<?php

namespace App;

use App\Models\Role;
use App\Models\Order;
use App\Models\Status;
use App\Models\Company;
use App\Models\Article;
use App\Models\Location;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\SetPassword as SetPasswordNotification;

class User extends Authenticatable
{
	use Notifiable;

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
	 * Find out if user has a specific permission
	 *
	 * $param 	string 		$permission
	 * $return 	boolean
	 */
	public function hasPermission(string $permission)
	{
		return in_array($permission, $this->role->permissions->pluck('title')->toArray());
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
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new SetPasswordNotification($token, $this->first_name));
	}
}
