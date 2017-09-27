<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\OrderPlaced;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\OrderPlaced as OrderPlaceNotification;

class OrderPlacedNotification implements ShouldQueue
{
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
	 * @param	OrderPlaced	 $event
	 * @return void
	 */
	public function handle(OrderPlaced $event)
	{
		// We could send out a notification here that sends an email, saved to database, updates slack, send a text message etc etc
		$time = Carbon::now()->addMinutes($this->minutes);
			
		// User - Sends an order placed notification to the user. Stick the notification in the "orders" queue to run in 5 minutes.
		$event->user->notify((new OrderPlaceNotification($event->order, $event->user))->delay($time)->onQueue('orders.notifications'));
	}
}
