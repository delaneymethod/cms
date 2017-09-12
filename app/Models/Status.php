<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Order, Article, Location};
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
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
		'description',
	];

	/**
	 * Get the user records associated with the status.
	 */
	public function users() : HasMany
	{
		return $this->hasMany(User::class);
	}
	
	/**
	 * Get the order records associated with the status.
	 */
	public function orders() : HasMany
	{
		return $this->hasMany(Order::class);
	}
	
	/**
	 * Get the article records associated with the status.
	 */
	public function articles() : HasMany
	{
		return $this->hasMany(Article::class);
	}
	
	/**
	 * Get the location records associated with the status.
	 */
	public function locations() : HasMany
	{
		return $this->hasMany(Location::class);
	}
}
