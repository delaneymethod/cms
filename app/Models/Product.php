<?php

namespace App\Models;

use App\Models\{Order, Standard};
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
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
        return $this->format2decimals($value);
    }
	
	/**
	 * Get the order records associated with the product.
	 */
	public function orders() : BelongsToMany
	{
		return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity', 'tax_rate', 'price', 'price_tax');
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
	 * Get the standard records associated with the product.
	 */
	public function standards() : BelongsToMany
	{
		return $this->belongsToMany(Standard::class, 'product_standard');
	}
	
	/**
	 * Set standards for the product.
	 *
	 * $param 	array 	$standards
	 */
	public function setStandard(array $standards)
	{
		return $this->standards()->sync($standards);
	}
	
	/**
	 * Formats value to 2 decimal places.
	 */
	protected function format2decimals(float $value) : float
	{
		return number_format($value, 2, '.', ',');
	}
}
