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
		'parent_id',
		'lft',
		'rgt',
		'depth',
		'status_id',
	];
	
	/**
	 * Get the user records associated with the status.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
