<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carts';
   
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
