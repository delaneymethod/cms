<?php

namespace App\Models;

use App\User;
use App\Models\Status;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'order_number',
		'user_id',
		'status_id',
		'count',
		'tax',
		'subtotal',
		'total',
	];

	/**
	 * Get the user record associated with the order.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the status record associated with the order.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Get the product records associated with the order.
	 */
	public function products()
	{
		return $this->belongsToMany(Product::class, 'order_product');
	}
}
