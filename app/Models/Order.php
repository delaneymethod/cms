<?php

namespace App\Models;

use App\User;
use App\Models\Status;
use App\Models\Product;
use App\Models\OrderType;
use App\Models\DeliveryMethod;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'order_number',
		'po_number',
		'notes',
		'order_type_id',
		'delivery_method_id',
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
	public function getCurrencyAttribute()
	{
		return '&pound;';
	}
	
	/**
	 * Gets orders currency.
	 *
	 * @return string
	 */
	public function getPostalAddressAttribute()
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
	public function getTaxAttribute($value)
    {
        return $this->format2decimals($value);
    }
    
    /**
	 * Gets the subtotal formatted with 2 decimal places.
	 */
    public function getSubtotalAttribute($value)
    {
        return $this->format2decimals($value);
    }
    
    /**
	 * Gets the total formatted with 2 decimal places.
	 */
    public function getTotalAttribute($value)
    {
        return $this->format2decimals($value);
    }
    
	/**
	 * Get the order type record associated with the order.
	 */
	public function order_type()
	{
		return $this->belongsTo(OrderType::class);
	}
	
	/**
	 * Get the delivery method record associated with the order.
	 */
	public function delivery_method()
	{
		return $this->belongsTo(DeliveryMethod::class);
	}

	/**
	 * Get the user record associated with the order.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the status record associated with the order.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the product records associated with the order.
	 */
	public function products()
	{
		return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity', 'tax_rate', 'price', 'price_tax');;
	}
	
	/**
	 * Set products for the order.
	 *
	 * $param 	array 	$products
	 */
	public function setProducts(array $products)
	{
		return $this->products()->sync($products);
	}
	
	/**
	 * Formats value to 2 decimal places.
	 */
	protected function format2decimals(float $value)
	{
		return number_format($value, 2, '.', ',');
	}
}
