<?php

namespace App\Jobs;

use Log;
use App\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{SerializesModels, InteractsWithQueue};

class ProcessOrder implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $user;
	
	protected $order;
	
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, Order $order)
	{
		$this->user = $user;
		
		$this->order = $order;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		// TODO - PING THE API ENDPOINT TO HANDLE THE ORDER
		
		Log::info('---- Process Order ----');
		Log::info($this->user);
		Log::info($this->order);
	}
}
