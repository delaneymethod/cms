<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Standard extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'standards';
    
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
	 * Get the product records associated with the standard.
	 */
	public function products() : BelongsToMany
	{
		return $this->belongsToMany(Product::class, 'product_standard');
	}
	
	/**
	 * Set products for the standard.
	 *
	 * $param 	array 	$products
	 */
	public function setProducts(array $products)
	{
		return $this->products()->sync($products);
	}
}
