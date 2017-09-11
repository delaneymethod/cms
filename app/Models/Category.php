<?php

namespace App\Models;

use App\Models\{Status, Article};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

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
	public function status() : BelongsTo
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the article records associated with the category.
	 */
	public function articles() : BelongsToMany
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
	public function isRetired() : bool
	{
		return $this->status_id == 2;
	}
	
	/**
	 * Checks if category is pending.
	 *
	 * @return bool
	 */
	public function isPending() : bool
	{
		return $this->status_id == 3;
	}
}
