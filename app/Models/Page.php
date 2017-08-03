<?php
	
namespace App\Models;

use Baum\Node;
use App\Models\Status;
use App\Models\Template;

class Page extends Node
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
		'template_id',
		'status_id',
		'content',
		'parent_id',
		'lft',
		'rgt',
		'depth',
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
}
