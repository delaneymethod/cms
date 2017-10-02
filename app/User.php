<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\SetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsTo};
use App\Models\{Role, Cart, Order, Status, Session, Company, Article, Location};

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
     * Attributes that get appended on serialization
     *
     * @var array
     */
	protected $appends = [
		'location_postal_address',
	];
	
	/**
	 * Get the location postal address
	 *
	 * @return 	string
	 */
	public function getLocationPostalAddressAttribute() : string
	{
		$locationPostalAddress = explode(',', $this->location->postal_address);
		
		$locationPostalAddress = array_map('trim', $locationPostalAddress);
		
		$locationPostalAddress = array_merge([], [$this->location->title], $locationPostalAddress);
		
		return implode('<br>', $locationPostalAddress);
	}
	
	/**
	 * Get the role record associated with the user.
	 */
	public function role() : BelongsTo
	{
		return $this->belongsTo(Role::class);
	}
	
	/**
	 * Get the status record associated with the user.
	 */
	public function status() : BelongsTo
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the company record associated with the user.
	 */
	public function company() : BelongsTo
	{
		return $this->belongsTo(Company::class);
	}
	
	/**
	 * Get the location record associated with the user.
	 */
	public function location() : BelongsTo
	{
		return $this->belongsTo(Location::class);
	}
	
	/**
	 * Get the orders records associated with the user.
	 */
	public function orders() : HasMany
	{
		return $this->hasMany(Order::class);
	}
	
	/**
	 * Get the carts records associated with the user.
	 */
	public function carts() : HasMany
	{
		return $this->hasMany(Cart::class);
	}
	
	/**
	 * Get the articles records associated with the user.
	 */
	public function articles() : HasMany
	{
		return $this->hasMany(Article::class);
	}
	
	/**
	 * Get the sessions records associated with the user.
	 */
	public function sessions() : HasMany
	{
		return $this->hasMany(Session::class);
	}
	
	/**
	 * Find out if user has a specific permission
	 *
	 * $param 	string 		$permission
	 * $return 	boolean
	 */
	public function hasPermission(string $permission) : bool
	{
		return in_array($permission, $this->role->permissions->pluck('title')->toArray());
	}
	
	/**
	 * Checks if user is a super admin.
	 *
	 * @return bool
	 */
	public function isSuperAdmin() : bool
	{
		return $this->role_id == 1;
	}
	
	/**
	 * Checks if user is a admin.
	 *
	 * @return bool
	 */
	public function isAdmin() : bool
	{
		return $this->role_id == 2;
	}
	
	/**
	 * Checks if user is an end user.
	 *
	 * @return bool
	 */
	public function isEndUser() : bool
	{
		return $this->role_id == 3;
	}
	
	/**
	 * Checks if user is retired.
	 *
	 * @return bool
	 */
	public function isRetired() : bool
	{
		return $this->status_id == 3;
	}
	
	/**
	 * Checks if user is pending.
	 *
	 * @return bool
	 */
	public function isPending() : bool
	{
		return $this->status_id == 2;
	}
	
	/**
	 * Checks if user location is suspended.
	 *
	 * @return bool
	 */
	public function isLocationSuspended()
	{
		return optional($this->location)->status_id == 7;
	}
	
	/**
	 * Route notifications for the mail channel.
	 *
	 * @return string
	 */
	public function routeNotificationForMail() : string
	{
		return $this->email;
	}
	
	/**
	 * The channels the user receives notification broadcasts on.
	 *
	 * @return string
	 */
	public function receivesBroadcastNotificationsOn()
	{
		return 'users.'.$this->id;
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
