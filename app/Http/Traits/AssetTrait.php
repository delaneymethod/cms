<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait AssetTrait
{
	protected $disk = 'uploads';
	
	/**
	 * Get the specified asset based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getAsset(int $id) : Asset
	{
		$asset = Asset::findOrFail($id);
		
		$asset->filesize = $this->getSize($asset->size);
			
		if (starts_with($asset->mime_type, 'image')) {
			$path = $this->getPath($asset);
			
			list($width, $height) = getimagesize($path);
			
			$asset->width = $width;
			
			$asset->height = $height;
		}
		
		return $asset;
	}
	
	/**
	 * Get the specified asset based on filename.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getAssetByFilename(string $filename)
	{
		$asset = Asset::where('filename', $filename)->first();
		
		if (!empty($asset)) {
			$asset->filesize = $this->getSize($asset->size);
			
			if (starts_with($asset->mime_type, 'image')) {
				$path = $this->getPath($asset);
				
				list($width, $height) = getimagesize($path);
				
				$asset->width = $width;
				
				$asset->height = $height;
			}
		}
		
		return $asset;
	}
	
	/**
	 * Get all the assets.
	 *
	 * @return 	Response
	 */
	public function getAssets() : CollectionResponse
	{
		$assets = Asset::all();
		
		foreach ($assets as $asset) {
			$asset->filesize = $this->getSize($asset->size);
			
			if (starts_with($asset->mime_type, 'image')) {
				$path = $this->getPath($asset);
				
				list($width, $height) = getimagesize($path);
				
				$asset->width = $width;
				
				$asset->height = $height;
			}
		}
		
		return $assets;
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function getSize($bytes) : string
	{
		$i = floor(log($bytes, 1024));
		
		return round($bytes / pow(1024, $i), [0,0,2,2,3][$i]).['B','kB','MB','GB','TB'][$i];
	}
	
	/**
	 * Does what it says on the tin!
	 */
	protected function getPath(Asset $asset) : string
	{
		return public_path($this->disk).str_replace('/'.$this->disk, '', $asset->path);
	}
}
