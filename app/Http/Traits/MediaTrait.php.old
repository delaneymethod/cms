<?php

namespace App\Http\Traits;

use Spatie\MediaLibrary\Media;

trait MediaTrait
{
	/**
	 * Get the specified media based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getMedia(int $id)
	{
		$media = Media::findOrFail($id);
		
		if (starts_with($media->mime_type, 'image')) {
			list($width, $height) = getimagesize($media->getPath());
		
			$media->width = $width;
		
			$media->height = $height;
		}
		
		$media->directory = $media->disk;
		
		return $media;
	}
	
	/**
	 * Get the specified media based on filename
	 *
	 * @param 	string 		$filename
	 * @return 	Object
	 */
	public function getMediaByFileName(string $filename)
	{
		$media = Media::where('file_name', $filename)->firstOrFail();
		
		if (starts_with($media->mime_type, 'image')) {
			list($width, $height) = getimagesize($media->getPath());
		
			$media->width = $width;
		
			$media->height = $height;
		}
		
		$media->directory = $media->disk;
		
		return $media;
	}

	/**
	 * Get all media.
	 *
	 * @return 	Response
	 */
	public function getMedias()
	{
		$medias = Media::all();
		
		foreach ($medias as $media) {
			if (starts_with($media->mime_type, 'image')) {
				list($width, $height) = getimagesize($media->getPath());
			
				$media->width = $width;
			
				$media->height = $height;
			}
			
			$media->directory = $media->disk;
		}
		
		return $medias;
	}
}
