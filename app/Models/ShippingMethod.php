<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
	];

	/**
	 * Get the order records associated with the shipping method.
	 */
	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
