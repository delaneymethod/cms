<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'hash_name',
		'original_name',
		'mime_type',
		'extension',
		'path',
		'size',
	];
	
	/**
	 * Set the assets filesize in human readable format.
	 *
	 * @param  int  $value
	 * @return void
	 */
	public function setFilesizeAttribute($size)
	{
		$this->attributes['filesize'] = $size;
	}
}
