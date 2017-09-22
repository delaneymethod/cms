<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Product, ProductCharacteristic};
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsToMany};

class ProductAttribute extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_attributes';
    
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
	 * Get the product records associated with the product attribute.
	 */
	public function products() : BelongsToMany
	{
		return $this->belongsToMany(Product::class, 'product_attribute');
	}
	
	/**
	 * Set products for the product standard.
	 *
	 * $param 	array 	$products
	 */
	public function setProducts(array $products)
	{
		return $this->products()->sync($products);
	}
	
	/**
	 * Get the product characteristics associated with the product attribute.
	 */
	public function product_characteristics() : HasMany
	{
		return $this->hasMany(ProductCharacteristic::class);
	}
}
