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
use App\Mail\{OrderCreatedMailCustomer, OrderCreatedMailSuperAdmin};

class OrderCreatedNotification extends Notification implements ShouldQueue
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
	 * Information about the order created email template.
	 *
	 * @var mixed
	 */
	protected $orderCreatedMail;
	
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order, User $user, string $subject = 'Order Created')
	{
		$this->order = $order;
		
		$this->user = $user;
		
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
		$this->orderCreatedMail = new OrderCreatedMailCustomer($this->order, $this->user);
		
		if ($this->user->isSuperAdmin()) {
			$this->orderCreatedMail = new OrderCreatedMailSuperAdmin($this->order, $this->user);
		}
			
		return ($this->orderCreatedMail)->to($this->user->email)->subject($this->subject);
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
			'order' => $this->order->load('user', 'status', 'location', 'order_type', 'shipping_method'),
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
			'order' => $this->order,
		];
	}
}
