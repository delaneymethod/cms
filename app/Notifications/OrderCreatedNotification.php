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
use App\Http\Traits\GlobalTrait;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Mail\{OrderCreatedMailCustomer, OrderCreatedMailSuperAdmin};

class OrderCreatedNotification extends Notification implements ShouldQueue
{
	use Queueable, GlobalTrait;
	
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
		
		$global = $this->getGlobal(1);
		
		$this->siteName = $global->data;
		
		$global = $this->getGlobal(2);
		
		$this->siteLogo = $global->data;
		
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
		if ($this->user->isSuperAdmin()) {
			$this->orderCreatedMail = new OrderCreatedMailSuperAdmin($this->order, $this->user, $this->siteName, $this->siteLogo);
			
			return ($this->orderCreatedMail)->to($this->user->email)->subject($this->subject);
		}
			
		if ($this->user->canReceiveEmails()) {
			$this->orderCreatedMail = new OrderCreatedMailCustomer($this->order, $this->user, $this->siteName, $this->siteLogo);
		
			return ($this->orderCreatedMail)->to($this->user->email)->subject($this->subject);
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
