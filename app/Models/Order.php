<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use App\Models\{Status, Location, OrderType, ShippingMethod, ProductCommodity};

class Order extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'solution_id',
		'order_number',
		'po_number',
		'notes',
		'order_type_id',
		'shipping_method_id',
		'user_id',
		'status_id',
		'count',
		'tax',
		'subtotal',
		'total',
	];
	
	/**
     * Attributes that get appended on serialization
     *
     * @var array
     */
	protected $appends = [
		'currency',
		'postal_address',
	];
	
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
	 * Gets orders currency.
	 *
	 * @return string
	 */
	public function getPostalAddressAttribute() : string
	{
		$locationPostalAddress = explode(',', $this->user->location->postal_address);
		
		$locationPostalAddress = array_map('trim', $locationPostalAddress);

		$locationPostalAddress = array_merge([], [$this->user->location->title], $locationPostalAddress);
		
		$locationPostalAddress = implode('<br>', $locationPostalAddress);
		
		return $locationPostalAddress;
	}
	
	/**
	 * Gets the tax formatted with 2 decimal places.
	 */
	public function getTaxAttribute($value) : float
    {
        return $this->format2decimals($value);
    }
    
    /**
	 * Gets the subtotal formatted with 2 decimal places.
	 */
    public function getSubtotalAttribute($value) : float
    {
        return $this->format2decimals($value);
    }
    
    /**
	 * Gets the total formatted with 2 decimal places.
	 */
    public function getTotalAttribute($value) : float
    {
        return $this->format2decimals($value);
    }
    
	/**
	 * Get the order type record associated with the order.
	 */
	public function order_type() : BelongsTo
	{
		return $this->belongsTo(OrderType::class);
	}
	
	/**
	 * Get the shipping method record associated with the order.
	 */
	public function shipping_method() : BelongsTo
	{
		return $this->belongsTo(ShippingMethod::class);
	}

	/**
	 * Get the user record associated with the order.
	 */
	public function user() : BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the location record associated with the order.
	 */
	public function location() : BelongsTo
	{
		return $this->belongsTo(Location::class);
	}
	
	/**
	 * Get the status record associated with the order.
	 */
	public function status() : BelongsTo
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the product commodities records associated with the order.
	 */
	public function product_commodities() : BelongsToMany
	{
		return $this->belongsToMany(ProductCommodity::class, 'order_product_commodity')->withPivot('quantity', 'tax_rate', 'price', 'price_tax');;
	}
	
	/**
	 * Set product commodities for the order.
	 *
	 * $param 	array 	$productCommodities
	 */
	public function setProductCommodities(array $productCommodities)
	{
		return $this->product_commodities()->sync($productCommodities);
	}
	
	/**
	 * Formats value to 2 decimal places.
	 */
	protected function format2decimals(float $value) : float
	{
		return number_format($value, 2, '.', ',');
	}
	
	/**
	 * Checks if order is active.
	 *
	 * @return bool
	 */
	public function isActive() : bool
	{
		return $this->status_id == 1;
	}
	
	/**
	 * Checks if order is pending.
	 *
	 * @return bool
	 */
	public function isPending() : bool
	{
		return $this->status_id == 2;
	}
}
