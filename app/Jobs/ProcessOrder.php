<?php

namespace App\Jobs;

use Log;
use App\User;
use GuzzleHttp\Psr7;
use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{SerializesModels, InteractsWithQueue};

class ProcessOrder implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $user;
	
	protected $order;
	
	/**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;
    
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 30;
    
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
		$apiUrl = config('cms.api.url');
	
		$endpoint = config('cms.api.endpoints.orders.process');
		
		Log::info('');
		Log::info('---- Processing Order ----');
		Log::info('');
		Log::info('User:');
		Log::info($this->user);
		Log::info('');
		Log::info('Order:');
		Log::info($this->order);
		Log::info('');
		
		try {
			$client = new Client([
				'base_uri' => $apiUrl,
				'timeout' => 5, // Timeout if a server does not return a response 
				'connect_timeout' => 10, // Timeout if the client fails to connect to the server
			]);
			
			$response = $client->request('POST', $endpoint, [
				'user' => $this->user,
				'order' => $this->order,
			]);
			
			Log::info('Status Code:');
			Log::info($response->getStatusCode());
			Log::info('');
			Log::info('Body:');
			Log::info($response->getBody());
			
			// TODO - send new notification to supplier
			
		} catch (RequestException $exception) {
			Log::info('');
			Log::critical('RequestException:');
			Log::critical(Psr7\str($exception->getRequest()));
			
			if ($exception->hasResponse()) {
				Log::critical(Psr7\str($exception->getResponse()));
			}
		}
	
		Log::info('');
	}
}
