<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductManufacturer extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_manufacturers';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
	
	protected $cloudfrontUrl = 'http://d1g9f3g06ezg82.cloudfront.net/catimg/manufacturers/';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'title',
		'website',
		'logo_image',
		'cms_page_name',
	];
	
	/**
     * Attributes that get appended on serialization
     *
     * @var array
     */
	protected $appends = [
		'image_url',
	];
	
	/**
	 * Gets full image url.
	 *
	 * @return string
	 */
	public function getImageUrlAttribute() : string
	{
		return $this->cloudfrontUrl.$this->logo_image;
	}
	
	/**
	 * Get the product records associated with the product manufacturer.
	 */
	public function products() : HasMany
	{
		return $this->hasMany(Product::class);
	}
}
