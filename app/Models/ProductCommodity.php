<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCommodity extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_commodities';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'is_dirty',
		'weight',
		'weight_per',
		'internal_part_number',
		'timecheck',
		'code',
		'created_user_id',
		'created_time',
		'approval_employee_id',
		'approval_date',
		'retire_date',
		'retire_employee_id`',
		'short_description',
		'product_id',
		'legacy_matched',
		'quantity_available',
		'price_band_id',
		'pack_quantity',
		'country_of_origin_id',
	];
	
	/**
	 * Get the product record associated with the product commodity.
	 */
	public function product() : BelongsTo
	{
		return $this->belongsTo(Product::class);
	}
}
