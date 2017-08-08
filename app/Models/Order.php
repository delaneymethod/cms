<?php

namespace App\Models;

use App\User;
use App\Models\Status;
use App\Models\Product;
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
