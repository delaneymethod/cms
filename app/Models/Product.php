<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use App\Models\{Order, ProductVatRate, ProductStandard, ProductCategory, ProductManufacturer};

class Product extends Model implements Buyable
{
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
		'title',
		'slug',
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
		'currency',
		'image_url',
	];
	
	/**
     * @var int|string
     */
    private $id;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var float
     */
    private $price;
    
    /**
     * BuyableProduct constructor.
     *
     * @param int|string 	$id
     * @param string     	$title
     * @param string     	$slug
     * @param float      	$price
     */
    public function __construct($id = 1, $name = 'Product Name', $price = 0.01)
    {
        $this->id = $id;
        
        $this->name = $name;
        
        $this->price = $price;
    }
	
	/**
	 * Get the identifier of the Buyable item.
	 *
	 * @return int|string
	 */
	public function getBuyableIdentifier($options = null) : string
	{
		return (string) $this->id;
	}
	
	/**
	 * Get the description or title of the Buyable item.
	 *
	 * @return string
	 */
	public function getBuyableDescription($options = null) : string
	{
		return $this->name;
	}
	
	/**
	 * Get the price of the Buyable item.
	 *
	 * @return float
	 */
	public function getBuyablePrice($options = null) : float
	{
		return $this->price;
	}
	
	/**
	 * Get the product record associated with the product.
	 */
	public function parent() : BelongsTo
	{
		return $this->belongsTo(Product::class, 'parent_id', 'id');
	}
	
	/**
	 * Gets product url.
	 *
	 * @return string
	 */
	public function getUrlAttribute() : string
	{
		$this->getProductSlug($this);
		
		// Add a blank segment to create first /
		array_push($this->segments, 'product');
		array_push($this->segments, 'browse');
		array_push($this->segments, '');
		
		$this->segments = array_reverse($this->segments);
		
		return implode('/', $this->segments);
	}
	
	/**
	 * Sets a product parents slug in the segments array, to build up a product url.
	 *
	 * @return void
	 */
	private function getProductSlug($product)
	{
		array_push($this->segments, $product->slug);
		
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
	 * Gets orders currency.
	 *
	 * @return string
	 */
	public function getCurrencyAttribute() : string
	{
		return '&pound;';
	}
	
	/**
	 * Gets the total formatted with 2 decimal places.
	 */
    public function getPriceAttribute($value) : float
    {
		if (!empty($value)) {
			return $this->format2decimals($value);
		} else {
			return 0.0;
		}
	}
	
	/**
	 * Get the order records associated with the product.
	 */
	public function orders() : BelongsToMany
	{
		return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity', 'tax_rate', 'price', 'price_tax');
	}
	
	/**
	 * Get the product category record associated with the product.
	 */
	public function product_category() : BelongsTo
	{
		return $this->hasMany(ProductCategory::class);
	}
	
	/**
	 * Get the product manufacturer record associated with the product.
	 */
	public function product_manufacturer() : BelongsTo
	{
		return $this->hasMany(ProductManufacturer::class);
	}
	
	/**
	 * Get the product var rate record associated with the product.
	 */
	public function product_vat_rate() : BelongsTo
	{
		return $this->hasMany(ProductVatRate::class);
	}
	
	/**
	 * Set orders for the product.
	 *
	 * $param 	array 	$orders
	 */
	public function setOrders(array $orders)
	{
		return $this->orders()->sync($orders);
	}
	
	/**
	 * Get the product standard records associated with the product.
	 */
	public function product_standards() : BelongsToMany
	{
		return $this->belongsToMany(ProductStandard::class, 'product_standard');
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
	 * Formats value to 2 decimal places.
	 */
	protected function format2decimals(float $value) : float
	{
		return number_format($value, 2, '.', ',');
	}
}
