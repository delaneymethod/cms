<?php

namespace App\Http\Traits;

use App\Models\Asset;
//use Plank\Mediable\Mediable;
use Illuminate\Support\Facades\File;

trait AssetTrait
{
	//use Mediable { media as _oldMedia };
	
	/**
	 * Get the specified asset based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getAsset(int $id)
	{
		return Asset::findOrFail($id);
	}

	/**
	 * Get all the assets.
	 *
	 * @return 	Response
	 */
	public function getAssets()
	{
		$assets = Asset::all();
		
		foreach ($assets as $asset) {
			$asset->filesize = $this->getFileSize($asset->size);
		}
		
		return $assets;
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function getFileSize($bytes) 
	{
		$i = floor(log($bytes, 1024));
		
		return round($bytes / pow(1024, $i), [0,0,2,2,3][$i]).['B','kB','MB','GB','TB'][$i];
	}
	
	/*
	public function media()
	{
		return $this->morphToMany(config('mediable.model'), 'mediables')->withPivot('tag', 'order')->orderBy('order');
	}
	*/
}
