<?php

namespace App\Models;

use App\Models\Page;
use App\Models\Field;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

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
	public function pages()
	{
		return $this->belongsToMany(Page::class, 'page_content');
	}
	
	/**
	 * Get the article records associated with the content.
	 */
	public function articles()
	{
		return $this->belongsToMany(Article::class, 'article_content');
	}
	
	/**
	 * Get the field record associated with the content.
	 */
	public function field()
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
