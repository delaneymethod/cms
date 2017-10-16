<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Mail;

use App\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreatedMailCustomer extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;
	
	/**
	 * Information about the site name.
	 *
	 * @var string
	 */
	public $siteName;
	
	/**
	 * Information about the site logo.
	 *
	 * @var string
	 */
	public $siteLogo;
	
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
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order, User $user, string $siteName, string $siteLogo)
	{
		$this->order = $order;
		
		$this->user = $user;
		
		$this->siteName = $siteName;
		
		$this->siteLogo = $siteLogo;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.orders.created.customer');
	}
}
