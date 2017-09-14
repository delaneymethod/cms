<?php

namespace App\Events;

use Log;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderUpdated implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;
	
	/**
	 * Information about the order update.
	 *
	 * @var string
	 */
	public $order;
	
	/**
	 * The name of the queue on which to place the event.
	 *
	 * @var string
	 */
	public $broadcastQueue = 'orders';

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}
	
	/**
	 * The event's broadcast name.
	 *
	 * @return string
	 */
	public function broadcastAs()
	{
		return 'order.updated';
	}
	
	/**
	 * Get the data to broadcast.
	 *
	 * @return array
	 */
	public function broadcastWith()
	{
		// Now pull in the orders related data since we'll be using this broadcast to update the UI's across the board
		return [
			'order' => $this->order->load('status', 'location', 'order_type', 'shipping_method'),
		];
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('orders.'.$this->order->id);
	}
}
