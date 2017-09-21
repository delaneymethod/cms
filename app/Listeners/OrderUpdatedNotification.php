<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\OrderUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\OrderUpdated as OrderUpdateNotification;

class OrderUpdatedNotification implements ShouldQueue
{
	/**
	 * The name of the queue the job should be sent to.
	 *
	 * @var string|null
	 */
	public $queue = 'orders';
	
	/**
     * The number of minutes the job is delayed.
     *
     * @var int
     */
    protected $minutes;
    
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->minutes = config('cms.delays.notifications');
	}

	/**
	 * Handle the event.
	 *
	 * @param	OrderUpdated	 $event
	 * @return void
	 */
	public function handle(OrderUpdated $event)
	{
		// We could send out a notification here that sends an email, saved to database, updates slack, send a text message etc etc
		$time = Carbon::now()->addMinutes($this->minutes);
			
		// User - Sends an order updated notification to the user. Stick the notification in the "orders" queue to run in 5 minutes.
		$event->order->user->notify(new OrderUpdateNotification($event->order));
		
		// $event->order->user->notify((new OrderUpdateNotification($event->order))->delay($time));
	}
}
