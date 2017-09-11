<?php

namespace App\Mail;

use App\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlaced extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;
	
	public $user;
	
	public $order;
	
	public $appName;
	
	public $appUrl;
	
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, Order $order)
	{
		$this->appName = config('cms.site.name');
		
		$this->appUrl = config('cms.site.url');
		
		$this->user = $user;
		
		$this->order = $order;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.orders.placed');
	}
}
