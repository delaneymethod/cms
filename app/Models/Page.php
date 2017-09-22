<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use Baum\Node;
use App\Models\{Status, Content, Template};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Page extends Node
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

	private $segments = [];
	
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
		'template_id',
		'status_id',
		'parent_id',
		'lft',
		'rgt',
		'depth',
		'hide_from_nav',
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
	 * Get the template record associated with the page.
	 */
	public function template() : BelongsTo
	{
		return $this->belongsTo(Template::class);
	}
	
	/**
	 * Get the status record associated with the page.
	 */
	public function status() : BelongsTo
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the page record associated with the page.
	 */
	public function parent() : BelongsTo
	{
		return $this->belongsTo(Page::class, 'parent_id', 'id');
	}
	
	/**
	 * Get the content records associated with the page.
	 */
	public function contents() : BelongsToMany
	{
		return $this->belongsToMany(Content::class, 'page_content');
	}
	
	/**
	 * Set contents for the page.
	 *
	 * $param 	array 	$contents
	 */
	public function setContents(array $contents)
	{
		return $this->contents()->sync($contents);
	}
	
	/**
	 * Gets page url.
	 *
	 * @return string
	 */
	public function getUrlAttribute() : string
	{
		$this->getPageSlug($this);
		
		// Add a blank segment to create first /
		array_push($this->segments, '');
		
		$this->segments = array_reverse($this->segments);
		
		return implode(DIRECTORY_SEPARATOR, $this->segments);
	}
	
	/**
	 * Sets a page's parents slug in the segments array, to build up a pages url.
	 *
	 * @return void
	 */
	private function getPageSlug($page)
	{
		array_push($this->segments, $page->slug);
		
		// If page has a parent, then get the parent
		if (!empty($page->parent_id)) {
			$this->getPageSlug($page->parent);
		}
	}
	
	/**
	 * Checks if page is published
	 *
	 * @return bool
	 */
	public function isPublished() : bool
	{
		return $this->status_id == 4;
	}
	
	/**
	 * Checks if page is private
	 *
	 * @return bool
	 */
	public function isPrivate() : bool
	{
		return $this->status_id == 5;
	}
	
	/**
	 * Checks if page is draft
	 *
	 * @return bool
	 */
	public function isDraft() : bool
	{
		return $this->status_id == 6;
	}
	
	/**
	 * Checks if page is hidden from nav
	 *
	 * @return bool
	 */
	public function isHiddenFromNav() : bool
	{
		return $this->hide_from_nav == 1;
	}
}
