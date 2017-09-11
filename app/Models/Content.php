<?php

namespace App\Models;

use App\Models\{Page, Field, Article};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Content extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'field_id',
		'data',
	];

	/**
	 * Get the page records associated with the content.
	 */
	public function pages() : BelongsToMany
	{
		return $this->belongsToMany(Page::class, 'page_content');
	}
	
	/**
	 * Get the article records associated with the content.
	 */
	public function articles() : BelongsToMany
	{
		return $this->belongsToMany(Article::class, 'article_content');
	}
	
	/**
	 * Get the field record associated with the content.
	 */
	public function field() : BelongsTo
	{
		return $this->belongsTo(Field::class);
	}
	
	/**
	 * Set pages for the content.
	 *
	 * $param 	array 	$pages
	 */
	public function setPages(array $pages)
	{
		return $this->pages()->sync($pages);
	}
	
	/**
	 * Set articles for the content.
	 *
	 * $param 	array 	$articles
	 */
	public function setArticles(array $articles)
	{
		return $this->articles()->sync($articles);
	}
}
