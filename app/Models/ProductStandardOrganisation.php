<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use App\Models\ProductStandard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductStandardOrganisation extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_standard_organisations';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'title',
		'website',
		'description',
		'timecheck',
	];
	
	/**
	 * Get the product standard records associated with the product standard organisation
	 */
	public function product_standards() : HasMany
	{
		return $this->hasMany(ProductStandard::class);
	}
}
