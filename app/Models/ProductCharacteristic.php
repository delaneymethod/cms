<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Product, ProductAttribute};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class ProductCharacteristic extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_characteristics';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'product_attribute_id',
		'value',
		'commodity_code_representation',
	];
	
	/**
	 * Get the product records associated with the product characteristic.
	 */
	public function products() : BelongsToMany
	{
		return $this->belongsToMany(Product::class, 'product_attribute')->withPivot('product_attribute_id', 'product_characteristic_id', 'display_position')->orderBy('display_position');
	}
	
	/**
	 * Set products for the product characteristic.
	 *
	 * $param 	array 	$products
	 */
	public function setProducts(array $products)
	{
		return $this->products()->sync($products);
	}
	
	/**
	 * Get the product attribute records associated with the product characteristic.
	 */
	public function product_attribute() : BelongsTo
	{
		return $this->belongsTo(ProductAttribute::class);
	}
}
