<?php

namespace App\Http\Traits;

use App\Models\Asset;
use Illuminate\Support\Facades\File;

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
	 * Get the specified asset based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getAssetByOriginalName(string $originalName)
	{
		return Asset::where('original_name', $originalName)->first();
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function getFileSize($bytes) 
	{
		$i = floor(log($bytes, 1024));
		
		return round($bytes / pow(1024, $i), [0,0,2,2,3][$i]).['B','kB','MB','GB','TB'][$i];
	}
}
