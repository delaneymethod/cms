<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'identifier',
		'instance',
		'content',
	];
}
