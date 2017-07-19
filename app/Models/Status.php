<?php

namespace App\Models;

use App\User;
use App\Models\Order;
use App\Models\Article;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
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
	public function users()
	{
		return $this->hasMany(User::class);
	}
	
	/**
	 * Get the order records associated with the status.
	 */
	public function orders()
	{
		return $this->hasMany(Order::class);
	}
	
	/**
	 * Get the article records associated with the status.
	 */
	public function articles()
	{
		return $this->hasMany(Article::class);
	}
	
	/**
	 * Get the article records associated with the status.
	 */
	public function locations()
	{
		return $this->hasMany(Location::class);
	}
}
