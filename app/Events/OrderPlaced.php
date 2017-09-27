<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Events;

use App\User;
use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderPlaced implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;
	
	/**
	 * Information about the user.
	 *
	 * @var string
	 */
	public $user;
	
	/**
	 * Information about the order.
	 *
	 * @var string
	 */
	public $order;
	
	/**
	 * The name of the queue on which to place the event.
	 *
	 * @var string
	 */
	public $broadcastQueue = 'orders.events';

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order, User $user)
	{
		$this->order = $order;
		
		$this->user = $user;
	}
	
	/**
	 * The event's broadcast name.
	 *
	 * @return string
	 */
	public function broadcastAs() : string
	{
		return 'order.placed';
	}
	
	/**
	 * Get the data to broadcast.
	 *
	 * @return array
	 */
	public function broadcastWith() : array
	{
		// Now pull in the orders related data since we'll be using this broadcast to update the UI's across the board
		return [
			'order' => $this->order->load('user', 'status', 'location', 'order_type', 'shipping_method'),
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
