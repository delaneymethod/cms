<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVatRate extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_vat_rates';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'code',
		'description',
		'rate',
		'rate_display',
	];
	
	/**
	 * Get the product records associated with the product vat rate.
	 */
	public function products() : HasMany
	{
		return $this->hasMany(Product::class);
	}
}
