<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderUpdatedNotification implements ShouldQueue
{
	/**
	 * The name of the queue the job should be sent to.
	 *
	 * @var string|null
	 */
	public $queue = 'orders';
	
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param	OrderUpdated	 $event
	 * @return void
	 */
	public function handle(OrderUpdated $event)
	{
		//
	}
}
