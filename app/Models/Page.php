<?php
	
namespace App\Models;

use Baum\Node;
use App\Models\Status;
use App\Models\Content;
use App\Models\Template;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Page extends Node implements HasMediaConversions
{
	use HasMediaTrait;
	
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
	 * Get the content records associated with the page.
	 */
	public function contents()
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
	
	public function registerMediaConversions()
    {
		$this->addMediaConversion('thumbnail')
			 ->width(300)
			 ->height(200)
			 ->extractVideoFrameAtSecond(5) // If it's a video; grab the still frame from the 5th second in the video
			 ->sharpen(10);
    }
}
