<?php

namespace App\Models;

use Spatie\Image\Manipulations;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Asset extends Model implements HasMediaConversions
{
	use HasMediaTrait;
	
	protected $table = 'assets';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	];
	
	/**
     * Is this asset an audio file?
     *
     * @return bool
     */
    public function isAudio()
    {
        return $this->extensionIsOneOf(['aac', 'flac', 'm4a', 'mp3', 'ogg', 'wav']);
    }

    /**
     * Is this asset a Google Docs previewable file?
     * https://gist.github.com/izazueta/4961650
     *
     * @return bool
     */
    public function isPreviewable()
    {
        return $this->extensionIsOneOf([
            'doc', 'docx', 'pages', 'txt',
            'ai', 'psd', 'eps', 'ps',
            'css', 'html', 'php', 'c', 'cpp', 'h', 'hpp', 'js',
            'ppt', 'pptx',
            'flv',
            'tiff',
            'ttf',
            'dxf', 'xps',
            'zip', 'rar',
            'xls', 'xlsx'
        ]);
    }

    /**
     * Is this asset an image?
     *
     * @return bool
     */
    public function isImage()
    {
        return $this->extensionIsOneOf(['jpg', 'jpeg', 'png', 'gif']);
    }

    /**
     * Is this asset a video file?
     *
     * @return bool
     */
    public function isVideo()
    {
        return $this->extensionIsOneOf(['h264', 'mp4', 'm4v', 'ogv', 'webm']);
    }
    
    /**
     * Check if asset's file extension is one of a given list
     *
     * @return bool
     */
    public function extensionIsOneOf($filetypes = [])
    {
        return (in_array(strtolower($this->extension()), $filetypes));
    }
    
    public function registerMediaConversions()
    {
	    $this->addMediaConversion('redactor')->fit(Manipulations::FIT_CROP, 100, 75)->apply()->extractVideoFrameAtSecond(5);
	    
		$this->addMediaConversion('grid')->fit(Manipulations::FIT_CROP, 100, 100)->apply()->extractVideoFrameAtSecond(5);

		$this->addMediaConversion('modal')->width(450)->height(300)->extractVideoFrameAtSecond(5);
    }
}
