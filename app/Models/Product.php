<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\ProductCategoryTrait;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsTo, BelongsToMany};
use App\Models\{ProductVatRate, ProductStandard, ProductCategory, ProductCommodity, ProductAttribute, ProductManufacturer, ProductCharacteristic};

class Product extends Model
{
	use Searchable, ProductCategoryTrait;
	
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
	
	protected $cloudfrontUrl = 'http://d1g9f3g06ezg82.cloudfront.net/catimg/products/';
	
	private $segments = [];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'title',
		'slug',
		'import_id',
		'sort_order',
		'product_category_id',
		'product_manufacturer_id',
		'harmonised_code_id',
		'supplier_id',
		'product_vat_rate_id',
		'limited_life',
		'test_certificates_required',
		'commodity_name_protocol',
		'commodity_code_protocol',
		'commodity_short_description_protocol',
		'retire_date',
		'retire_employee_id',
		'description',
		'short_name',
		'image_uri',
	];
	
	/**
     * Attributes that get appended on serialization
     *
     * @var array
     */
	protected $appends = [
		'url',
		'image_url',
		'attributes_characteristics',
	];
	
	/**
	 * Get the indexable data array for the model.
	 *
	 * @return array
	 */
	public function toSearchableArray() : array
	{
		$description = '';
		
		$descriptions = [];
		
		if (!empty($this->description)) {
			$pattern = '/<p(.*?)>((.*?)+)\<\/p>/';
			
			$replacement = '${2} ';
		
			$subject = $this->description;
		
			$description = preg_replace($pattern, $replacement, $subject);
			
			array_push($descriptions, trim($description));
		}
		
		if (!empty($this->product_category)) {
			array_push($descriptions, trim($this->product_category->title));
			
			if (!empty($this->product_category->description)) {
				array_push($descriptions, trim($this->product_category->description));
			}
		}
		
		if (!empty($this->product_manufacturer)) {
			array_push($descriptions, trim($this->product_manufacturer->title));
		}
		
		if (count($descriptions) > 0) {
			$description = implode(', ', $descriptions);
		}
		
		return [
			'id' => $this->id,
			'title' => $this->title,
			'description' => $description,
		];
	}
	
	/**
	 * Get the product record associated with the product.
	 */
	public function parent() : BelongsTo
	{
		return $this->belongsTo(Product::class, 'parent_id', 'id');
	}
	
	/**
	 * Gets product attributes characteristics.
	 *
	 * @return array
	 */
	public function getAttributesCharacteristicsAttribute() : array
	{
		// Build up the product attributes and characteristics
		$productAattributesCharacteristics = [];
		
		foreach ($this->product_characteristics as $productCharacteristic) {
			$productAattributesCharacteristics[$productCharacteristic->product_attribute->id] = [
				'title' => $productCharacteristic->product_attribute->title,
				'value' => $productCharacteristic->value,
			];
		}
		
		return $productAattributesCharacteristics;
	}
	
	/**
	 * Gets product description but pretty.
	 *
	 * @return mixed
	 */
	public function getDescriptionAttribute($description)
	{
		if (!empty($description)) {
			// Fix up the description
			$description = str_replace(["\r\n", "\r", "\n"], '<br>', $description);
			
			// Split into paragraphs
			$descriptions = explode('<br>', $description); 
			
			// Remove empty or null paragraphs 
			$descriptions = array_filter($descriptions, 'strlen');
			
			// Fixes keys - not needed but I have OCD
			$descriptions = array_values($descriptions);
			
			foreach ($descriptions as &$description) {
				$description = '<p>'.$description.'</p>';
			}
			
			return implode('', $descriptions);
		}
		
		return $description;
	}
	
	/**
	 * Gets product url.
	 *
	 * @return string
	 */
	public function getUrlAttribute() : string
	{
		$this->segments = [];
		
		$this->getProductSlug($this);
		
		// Incase the product is loaded directly
		if (empty($this->product_category_id)) {
			// Add a blank segment to create first /
			array_push($this->segments, 'products');
			array_push($this->segments, '');
		}
		
		$this->segments = array_reverse($this->segments);
		
		return implode(DIRECTORY_SEPARATOR, $this->segments);
	}
	
	/**
	 * Sets a product parents slug in the segments array, to build up a product url.
	 *
	 * @return void
	 */
	private function getProductSlug($product)
	{
		if (!empty($product->product_category_id)) {
			// First grab the product category url (which will include all parents, child etc etc - right back up to the root level)
			$productCatgeory = $this->getProductCategory($product->product_category_id);
			
			array_push($this->segments, $productCatgeory->url.DIRECTORY_SEPARATOR.$product->slug);
		} else {
			array_push($this->segments, $product->slug);
		}
		
		// If product has a parent, then get the parent
		if (!empty($product->parent_id)) {
			$this->getProductSlug($product->parent);
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
	 * Get the product category record associated with the product.
	 */
	public function product_category() : BelongsTo
	{
		return $this->belongsTo(ProductCategory::class);
	}
	
	/**
	 * Get the product manufacturer record associated with the product.
	 */
	public function product_manufacturer() : BelongsTo
	{
		return $this->belongsTo(ProductManufacturer::class);
	}
	
	/**
	 * Get the product var rate record associated with the product.
	 */
	public function product_vat_rate() : BelongsTo
	{
		return $this->belongsTo(ProductVatRate::class);
	}
	
	/**
	 * Set product standards for the product.
	 *
	 * $param 	array 	$productStandards
	 */
	public function setProductStandards(array $productStandards)
	{
		return $this->product_standards()->sync($productStandards);
	}
	
	/**
	 * Get the product standard records associated with the product.
	 */
	public function product_standards() : BelongsToMany
	{
		return $this->belongsToMany(ProductStandard::class, 'product_standard');
	}
	
	/**
	 * Get the product attribute records associated with the product.
	 */
	public function product_attributes() : BelongsToMany
	{
		return $this->belongsToMany(ProductAttribute::class, 'product_attribute')->withPivot('product_attribute_id', 'product_characteristic_id', 'display_position')->orderBy('display_position');
	}
	
	/**
	 * Set product attributes for the product.
	 *
	 * $param 	array 	$productAttributes
	 */
	public function setProductAttributes(array $productAttributes)
	{
		return $this->product_attributes()->sync($productAttributes);
	}
	
	/**
	 * Get the product characteristic records associated with the product.
	 */
	public function product_characteristics() : BelongsToMany
	{
		return $this->belongsToMany(ProductCharacteristic::class, 'product_attribute')->withPivot('product_attribute_id', 'product_characteristic_id', 'display_position')->orderBy('display_position');
	}
	
	/**
	 * Set product characteristics for the product.
	 *
	 * $param 	array 	$productCharacteristics
	 */
	public function setProductCharacteristics(array $productCharacteristics)
	{
		return $this->product_characteristics()->sync($productCharacteristics);
	}
	
	/**
	 * Get the product commodity records associated with the product.
	 */
	public function product_commodities() : HasMany
	{
		return $this->hasMany(ProductCommodity::class);
	}
}
