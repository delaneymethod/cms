<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Notifications;

use App\User;
use App\Models\Order;
use App\Mail\OrderPlaced;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

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
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, Order $order, string $subject = 'Order Placed')
	{
		$this->user = $user;
		
		$this->order = $order->load('status', 'location', 'order_type', 'shipping_method');
		
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
		return (new OrderPlaced($this->user, $this->order))->to($this->user->email)->subject($this->subject);
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
			'order' => $this->order->load('status', 'location', 'order_type', 'shipping_method'),
		];
		
		return (new BroadcastMessage($data))->onQueue('orders');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param	mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable) : array
	{
		return [
			'order' => $this->order->load('status', 'location', 'order_type', 'shipping_method'),
		];
	}
}
