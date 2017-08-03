<?php

namespace App\Models;

use App\Models\Page;
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
	];

	/**
	 * Get the user records associated with the status.
	 */
	public function pages()
	{
		return $this->hasMany(Page::class);
	}
}
