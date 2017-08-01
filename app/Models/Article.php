<?php

namespace App\Models;

use App\User;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'slug',
		'user_id',
		'status_id',
		'content',
	];

	/**
	 * Get the user record associated with the article.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the status record associated with the article.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
