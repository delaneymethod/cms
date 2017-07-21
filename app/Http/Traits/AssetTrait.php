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
	 * Read folder contents from the public storage directory.
	 *
	 * @param	String 		$path
	 * @return 	Collection/Array
	 */
	public function readDirectory(string $path)
	{
		// Set where we want to save the file
		$directory = config('filesystems.disks.public.root').'/'.$path;

		return File::allFiles($directory);
	}
}
