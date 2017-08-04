<?php
	
namespace App\Models;

use Baum\Node;
use App\Models\Status;
use App\Models\Template;

class Page extends Node
{
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
		'content',
		'parent_id',
		'lft',
		'rgt',
		'depth',
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
	public function template()
	{
		return $this->belongsTo(Template::class);
	}
	
	/**
	 * Get the status record associated with the page.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the page record associated with the page.
	 */
	public function parent()
	{
		return $this->belongsTo(Page::class, 'parent_id', 'id');
	}
	
	/**
	 * Gets page url.
	 *
	 * @return string
	 */
	public function getUrlAttribute()
	{
		$this->getPageSlug($this);
		
		// Add a blank segment to create first /
		array_push($this->segments, '');
		
		$this->segments = array_reverse($this->segments);
		
		return implode('/', $this->segments);
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
}
