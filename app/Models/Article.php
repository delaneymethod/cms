<?php

namespace App\Models;

use App\User;
use App\Models\Status;
use App\Models\Category;
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
		'description',
		'keywords',
		'excerpt',
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
	
	/**
	 * Get the category records associated with the article.
	 */
	public function categories()
	{
		return $this->belongsToMany(Category::class, 'article_category');
	}
	
	/**
	 * Set categories for the article.
	 *
	 * $param 	array 	$categories
	 */
	public function setCategories(array $categories)
	{
		return $this->categories()->sync($categories);
	}
}
