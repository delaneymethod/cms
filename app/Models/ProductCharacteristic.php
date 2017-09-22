<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
		'product_attribute_id',
		'value',
		'commodity_code_representation',
	];
	
	/**
	 * Get the product attribute records associated with the product characteristic.
	 */
	public function product_attribute() : BelongsTo
	{
		return $this->belongsTo(ProductAttribute::class);
	}
}
