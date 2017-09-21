<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class ProductCategory extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
	
	protected $cloudfrontUrl = 'http://d1g9f3g06ezg82.cloudfront.net/catimg/categories/';
	
	private $segments = [];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'slug',
		'description',
		'parent_id',
		'sort_order',
		'import_id',
		'image_uri',
		'publish_to_web',
	];
	
	/**
     * Attributes that get appended on serialization
     *
     * @var array
     */
	protected $appends = [
		'url',
		'image_url',
	];
	
	/**
	 * Get the product category record associated with the product category.
	 */
	public function parent() : BelongsTo
	{
		return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
	}
	
	/**
	 * Gets product category url.
	 *
	 * @return string
	 */
	public function getUrlAttribute() : string
	{
		$this->getProductCategorySlug($this);
		
		// Add a blank segment to create first /
		array_push($this->segments, 'category');
		array_push($this->segments, 'browse');
		array_push($this->segments, '');
		
		$this->segments = array_reverse($this->segments);
		
		return implode('/', $this->segments);
	}
	
	/**
	 * Sets a product categories parents slug in the segments array, to build up a product category url.
	 *
	 * @return void
	 */
	private function getProductCategorySlug($productCategory)
	{
		array_push($this->segments, $productCategory->slug);
		
		// If product category has a parent, then get the parent
		if (!empty($productCategory->parent_id)) {
			$this->getProductCategorySlug($productCategory->parent);
		}
	}
	
	/**
	 * Gets full image url.
	 *
	 * @return string
	 */
	public function getImageUrlAttribute() : string
	{
		return $this->cloudfrontUrl.$this->image_uri;
	}
	
	/**
	 * Get the product records associated with the product category.
	 */
	public function products() : HasMany
	{
		return $this->hasMany(Product::class);
	}
}
