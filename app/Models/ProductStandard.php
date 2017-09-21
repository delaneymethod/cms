<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductStandard extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_standards';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'code',
		'further_details',
		'product_standard_organisation_id',
	];
	
	/**
	 * Get the product records associated with the product standard.
	 */
	public function products() : BelongsToMany
	{
		return $this->belongsToMany(Product::class, 'product_standard');
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
}
