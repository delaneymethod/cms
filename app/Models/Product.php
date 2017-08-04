<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;

class Product extends Model implements Buyable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'slug',
		'price',
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
	public function getBuyableIdentifier($options = null)
	{
		return $this->id;
	}
	
	/**
	 * Get the description or title of the Buyable item.
	 *
	 * @return string
	 */
	public function getBuyableDescription($options = null)
	{
		return $this->name;
	}
	
	/**
	 * Get the price of the Buyable item.
	 *
	 * @return float
	 */
	public function getBuyablePrice($options = null)
	{
		return $this->price;
	}
	
	/**
	 * Get the order records associated with the product.
	 */
	public function orders()
	{
		return $this->belongsToMany(Order::class, 'order_product');
	}
}
