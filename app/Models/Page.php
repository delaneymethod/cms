<?php
	
namespace App\Models;

use Baum\Node;
use App\Models\Status;

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
		'status_id',
		'content',
		'parent_id',
		'lft',
		'rgt',
		'depth',
	];
	
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
