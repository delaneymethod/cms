<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Jobs;

use Log;
use App\User;
use Notification;
use Carbon\Carbon;
use GuzzleHttp\Psr7;
use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use App\Notifications\OrderPlaced;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{SerializesModels, InteractsWithQueue};

class ProcessOrder implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
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
     * The number of minutes the job is delayed.
     *
     * @var int
     */
    protected $minutes;
    
    /**
	 * Information about the supplier.
	 *
	 * @var string
	 */
    protected $supplierEmail;
    
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
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, Order $order)
	{
		$this->user = $user;
		
		$this->order = $order->load('status', 'location', 'order_type', 'shipping_method');
		
		$this->minutes = config('cms.delays.notifications');
		
		$this->supplierEmail = config('cms.site.email');
		
		$this->apiUrl = config('cms.api.url');
	
		$this->endpoint = config('cms.api.endpoints.orders.process');
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
		Log::info('User:');
		Log::info($this->user);
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
				'user' => $this->user,
				'order' => $this->order,
			]);
			
			Log::info('Status Code:');
			Log::info($response->getStatusCode());
			Log::info('');
			Log::info('Body:');
			Log::info($response->getBody());
			
			// Now that the order has been sent to the API, send out new notifications to the supplier and the user.
			$time = Carbon::now()->addMinutes($this->minutes);
			
			// User - Sends an order placed notification to the user. Stick the notification in the "orders" queue to run in 5 minutes.
			$this->user->notify((new OrderPlaced($this->user, $this->order))->delay($time));
			
			// Supplier - Sends an order placed notification to the supplier. Stick the notification in the "orders" queue to run in 5 minutes.
			Notification::route('mail', $this->supplierEmail)->notify((new OrderPlaced($this->user, $this->order))->delay($time));
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
