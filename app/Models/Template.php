<?php

namespace App\Models;

use App\Models\Page;
use App\Models\Layout;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'filename',
		'layout_id',
	];

	/**
	 * Get the pages records associated with the template.
	 */
	public function pages()
	{
		return $this->hasMany(Page::class);
	}
	
	/**
	 * Get the articles records associated with the template.
	 */
	public function articles()
	{
		return $this->hasMany(Article::class);
	}
	
	/**
	 * Get the layout record associated with the template.
	 */
	public function layout()
	{
		return $this->belongsTo(Layout::class);
	}
}
