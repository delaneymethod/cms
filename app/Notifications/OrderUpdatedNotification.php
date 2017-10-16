<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Notifications;

use App\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderUpdatedNotification extends Notification implements ShouldQueue
{
	use Queueable;
	
	/**
	 * Information about the user.
	 *
	 * @var string
	 */
	protected $user;
	
	/**
	 * Information about the order.
	 *
	 * @var string
	 */
	protected $order;
	
	/**
	 * Information about the site name.
	 *
	 * @var string
	 */
	protected $siteName;
	
	/**
	 * Information about the site logo.
	 *
	 * @var string
	 */
	protected $siteLogo;
	
	/**
	 * Information about the subject.
	 *
	 * @var string
	 */
	protected $subject;
	
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order, User $user, string $subject = 'Order Updated')
	{
		$this->order = $order;
		
		$this->user = $user;
		
		$global = $this->getGlobal(1);
		
		$this->siteName = $global->data;
		
		$global = $this->getGlobal(2);
		
		$this->siteLogo = $global->data;
		
		$this->subject = $subject;
		
		$this->subject = $subject;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param	mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) : array
	{
		return ['mail', 'database', 'broadcast'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param	mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		// We dont want to send out any new email regardless - I think the "Solution" will do this.
		return false;
		
		if ($this->user->canReceiveEmails()) {
			// See above
		} else {
			return false;	
		}
	}
	
	/**
	 * Get the broadcastable representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return BroadcastMessage
	 */
	public function toBroadcast($notifiable)
	{
		if ($this->user->canReceiveNotifications()) {
			$data = [
				'order' => $this->order->load('user', 'status', 'location', 'order_type', 'shipping_method'),
			];
		
			// Note, if we dont stick this broadcast on a queue, it gets added to the default queue - unless you are listenings on default queue, this will never get processed.
			return (new BroadcastMessage($data))->onQueue('orders.broadcasts');
		} else {
			return false;
		}
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param 	mixed 	$notifiable
	 * @return 	array
	 */
	public function toDatabase($notifiable)
	{	
		if ($this->user->canReceiveNotifications()) {
			return [
				'order' => $this->order,
			];
		} else {
			return false;
		}
	}
}
