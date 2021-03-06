<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use App\User;
use App\Http\Traits\PageTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Status, Content, Template, ArticleCategory};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Article extends Model
{
	use PageTrait;
	
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'title',
		'slug',
		'description',
		'keywords',
		'template_id',
		'user_id',
		'status_id',
		'published_at',
	];
	
	/**
     * Attributes that get appended on serialization
     *
     * @var array
     */
	protected $appends = [
		'url',
	];
	
	/**
	 * Get the template record associated with the article.
	 */
	public function template() : BelongsTo
	{
		return $this->belongsTo(Template::class);
	}
	
	/**
	 * Get the user record associated with the article.
	 */
	public function user() : BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the status record associated with the article.
	 */
	public function status() : BelongsTo
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the content records associated with the article.
	 */
	public function contents() : BelongsToMany
	{
		return $this->belongsToMany(Content::class, 'article_content');
	}
	
	/**
	 * Set contents for the article.
	 *
	 * $param 	array 	$contents
	 */
	public function setContents(array $contents)
	{
		return $this->contents()->sync($contents);
	}
	
	/**
	 * Get the article category records associated with the article.
	 */
	public function article_categories() : BelongsToMany
	{
		return $this->belongsToMany(ArticleCategory::class, 'article_category');
	}
	
	/**
	 * Set article categories for the article.
	 *
	 * $param 	array 	$categories
	 */
	public function setArticleCategories(array $articleCategories)
	{
		return $this->article_categories()->sync($articleCategories);
	}
	
	/**
	 * Gets article url.
	 *
	 * @return string
	 */
	public function getUrlAttribute() : string
	{
		// Grab articles page
		$page = $this->getPage(8);
		
		return $page->url.DIRECTORY_SEPARATOR.$this->slug;
	}
	
	/**
	 * Checks if article is published
	 *
	 * @return bool
	 */
	public function isPublished() : bool
	{
		return $this->status_id == 4;
	}
	
	/**
	 * Checks if article is private
	 *
	 * @return bool
	 */
	public function isPrivate() : bool
	{
		return $this->status_id == 5;
	}
	
	/**
	 * Checks if article is draft
	 *
	 * @return bool
	 */
	public function isDraft() : bool
	{
		return $this->status_id == 6;
	}
}
