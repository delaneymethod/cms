<?php
/**
 * @link	  https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license	  https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use Laravel\Scout\Searchable;
use App\Http\Traits\CartTrait;
use App\Models\{Order, Product};
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class ProductCommodity extends Model implements Buyable
{
	use CartTrait, Searchable;
	
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'product_commodities';
	
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
	
	private $defaultPrice = 1;
	
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
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'title',
		'is_dirty',
		'weight',
		'weight_per',
		'internal_part_number',
		'timecheck',
		'code',
		'created_user_id',
		'created_time',
		'approval_employee_id',
		'approval_date',
		'retire_date',
		'retire_employee_id`',
		'short_description',
		'product_id',
		'legacy_matched',
		'quantity_available',
		'price_band_id',
		'pack_quantity',
		'country_of_origin_id',
	];
	
	/**
	 * Attributes that get appended on serialization
	 *
	 * @var array
	 */
	protected $appends = [
		'currency',
	];
	
	/**
	 * BuyableProduct constructor.
	 *
	 * @param int|string 	$id
	 * @param string	 	$title
	 * @param string	 	$slug
	 * @param float		 	$price
	 */
	public function __construct($id = 1, $name = 'Product Commodity', $price = 1)
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
	public function getBuyableIdentifier($options = null) : int
	{
		return $this->id;
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
	 * Get the indexable data array for the model.
	 *
	 * @return array
	 */
	public function toSearchableArray() : array
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'weight' => $this->weight,
			'weight_per' => $this->weight_per,
			'code' => $this->code,
			'short_description' => $this->short_description,
		];
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
			return $this->price;
		}
	}
	
	/**
	 * Formats value to 2 decimal places.
	 */
	protected function format2decimals(float $value) : float
	{
		return number_format($value, 2, '.', ',');
	}
	
	/**
	 * Get the product record associated with the product commodity.
	 */
	public function product() : BelongsTo
	{
		return $this->belongsTo(Product::class);
	}
	
	/**
	 * Get the order records associated with the product commodities.
	 */
	public function orders() : BelongsToMany
	{
		return $this->belongsToMany(Order::class, 'order_product_commodity')->withPivot('quantity', 'tax_rate', 'price', 'price_tax');
	}
	
	/**
	 * Set orders for the product commodities.
	 *
	 * $param 	array 	$orders
	 */
	public function setOrders(array $orders)
	{
		return $this->orders()->sync($orders);
	}
}
