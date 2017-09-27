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
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Mail\{OrderPlacedMailCustomer, OrderPlacedMailSuperAdmin};

class OrderPlaced extends Notification implements ShouldQueue
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
	 * Information about the subject.
	 *
	 * @var string
	 */
	protected $subject;
	
	/**
	 * Information about the delivery methods.
	 *
	 * @var array
	 */
	protected $deliveryMethods;
	
	/**
	 * Information about the order placed email template.
	 *
	 * @var mixed
	 */
	protected $orderPlacedMail;
	
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order, User $user, string $subject = 'Order Placed')
	{
		$this->order = $order;
		
		$this->user = $user;
		
		$this->subject = $subject;
		
		$this->deliveryMethods = ['mail', 'database', 'broadcast'];
		
		// If user is the super admin (aka site owner), we dont want to 'database' or 'broadcast' as delivery methods. We only want mail.
		if ($this->user->isSuperAdmin()) {
			$this->deliveryMethods = $this->deliveryMethods[0];
		}
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param	mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) : array
	{
		return $this->deliveryMethods;
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param	mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$this->orderPlacedMail = new OrderPlacedMailCustomer($this->order, $this->user);
		
		if ($this->user->isSuperAdmin()) {
			$this->orderPlacedMail = new OrderPlacedMailSuperAdmin($this->order, $this->user);
		}
			
		return ($this->orderPlacedMail)->to($this->user->email)->subject($this->subject);
	}
	
	/**
	 * Get the broadcastable representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return BroadcastMessage
	 */
	public function toBroadcast($notifiable)
	{
		$data = [
			'order' => $this->order->load('user', 'status', 'location', 'order_type', 'shipping_method')
		];
		
		// Note, if we dont stick this broadcast on a queue, it gets added to the default queue - unless you are listenings on default queue, this will never get processed.
		return (new BroadcastMessage($data))->onQueue('orders.broadcasts');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param 	mixed 	$notifiable
	 * @return 	array
	 */
	public function toDatabase($notifiable) : array
	{
		return [
			'order' => $this->order
		];
	}
}
