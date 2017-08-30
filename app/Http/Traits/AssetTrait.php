<?php

namespace App\Http\Traits;

use App\Models\Asset;

trait AssetTrait
{
	/**
	 * Get the specified asset based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getAsset(int $id)
	{
		$asset = Asset::findOrFail($id);
		
		$asset->media = $asset->getMedia('assets')->first();
		
		if (!empty($asset->media)) {
			if (starts_with($asset->media->mime_type, 'image')) {
				list($width, $height) = getimagesize($asset->media->getPath());
			
				$asset->media->width = $width;
			
				$asset->media->height = $height;
			}
		
			$asset->media->directory = $asset->media->disk;
		}
		
		return $asset;
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
			$asset->media = $asset->getMedia('assets')->first();
			
			if (!empty($asset->media)) { 
				if (starts_with($asset->media->mime_type, 'image')) {
					list($width, $height) = getimagesize($asset->media->getPath());
				
					$asset->media->width = $width;
				
					$asset->media->height = $height;
				}
				
				$asset->media->directory = $asset->media->disk;
			}
		}
		
		return $assets;
	}
	
	/**
	 * Does what it says on the tin!
	 */
	/*
	public function getFileSize($bytes) 
	{
		$i = floor(log($bytes, 1024));
		
		return round($bytes / pow(1024, $i), [0,0,2,2,3][$i]).['B','kB','MB','GB','TB'][$i];
	}
	*/
}
