<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use App\Models\{Page, Field, Article};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Content extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contents';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

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
