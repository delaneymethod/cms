<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipping_methods';
    
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
		'free_threshold',
	];

	/**
	 * Get the order records associated with the shipping method.
	 */
	public function orders() : HasMany
	{
		return $this->hasMany(Order::class);
	}
}
