<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'slug',
		'status_id',
	];
	
	/**
	 * Get the status record associated with the location.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the article records associated with the category.
	 */
	public function articles()
	{
		return $this->belongsToMany(Article::class, 'article_category');
	}
	
	/**
	 * Set articles for the category.
	 *
	 * $param 	array 	$roles
	 */
	public function setArticles(array $articles)
	{
		return $this->articles()->sync($articles);
	}
	
	/**
	 * Checks if category is retired.
	 *
	 * @return bool
	 */
	public function isRetired()
	{
		return $this->status_id == 2;
	}
	
	/**
	 * Checks if category is pending.
	 *
	 * @return bool
	 */
	public function isPending()
	{
		return $this->status_id == 3;
	}
}
