<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Events;

use App\Models\ProductAttribute;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductAttributeAddedEvent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;
	
	/**
	 * Information about the product update.
	 *
	 * @var string
	 */
	public $productAttribute;
	
	/**
	 * The name of the queue on which to place the event.
	 *
	 * @var string
	 */
	public $broadcastQueue = 'products';

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(ProductAttribute $productAttribute)
	{
		$this->productAttribute = $productAttribute;
	}
	
	/**
	 * The event's broadcast name.
	 *
	 * @return string
	 */
	public function broadcastAs() : string
	{
		return 'product_attribute.added';
	}
	
	/**
	 * Get the data to broadcast.
	 *
	 * @return array
	 */
	public function broadcastWith() : array
	{
		return [
			'product_attribute' => $this->productAttribute,
		];
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn() : Channel
	{
		return new Channel('product_attributes.'.$this->productAttribute->id);
	}
}
