<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Jobs;

use Log;
use App\Models\Order;
use App\Events\OrderPlaced;
use Illuminate\Bus\Queueable;
use GuzzleHttp\{Psr7, Client};
use App\Http\Traits\UserTrait;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{SerializesModels, InteractsWithQueue};

class ProcessOrder implements ShouldQueue
{
	use UserTrait, Queueable, Dispatchable, SerializesModels, InteractsWithQueue;
	
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
	 * Information about the order.
	 *
	 * @var string
	 */
	protected $order;
    
    /**
	 * Information about the api url.
	 *
	 * @var string
	 */
    protected $apiUrl;
    
	/**
	 * Information about the endpoint.
	 *
	 * @var string
	 */
    protected $endpoint;
    
    /**
	 * Information about the super admin.
	 *
	 * @var User
	 */
    protected $superAdmin;
    
    /**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order->load('user', 'status', 'location', 'order_type', 'shipping_method');
		
		$this->apiUrl = config('cms.api.url');
	
		$this->endpoint = config('cms.api.endpoints.orders.process');
		
		$this->superAdmin = $this->getUserById(1);
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		Log::info('');
		Log::info('---- Processing Order ----');
		Log::info('');
		Log::info('Order:');
		Log::info($this->order);
		Log::info('');
		
		try {
			// Send new order details to 3rd party API for processing.
			$client = new Client([
				'base_uri' => $this->apiUrl,
				'timeout' => 5, // Timeout if a server does not return a response 
				'connect_timeout' => 10, // Timeout if the client fails to connect to the server
			]);
			
			$response = $client->request('POST', $this->endpoint, [
				'order' => $this->order,
			]);
			
			Log::info('Status Code:');
			Log::info($response->getStatusCode());
			Log::info('');
			Log::info('Body:');
			Log::info($response->getBody());
			
			// Sends out an order placed event across the system. Listeners will pick up the event and send out notifications to the customer and super admin user
			event(new OrderPlaced($this->order, $this->order->user));
			
			//event(new OrderPlaced($this->order, $this->superAdmin));
		} catch (RequestException $exception) {
			Log::info('');
			Log::critical('Request Exception:');
			Log::critical(Psr7\str($exception->getRequest()));
			
			if ($exception->hasResponse()) {
				Log::critical(Psr7\str($exception->getResponse()));
			}
		}
	
		Log::info('');
	}
}
