<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Jobs;

use Log;
use Exception;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use GuzzleHttp\{Psr7, Client};
use App\Http\Traits\UserTrait;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\FailedJobNotification;
use Illuminate\Queue\{SerializesModels, InteractsWithQueue};

class ProcessCompanyJob implements ShouldQueue
{
	use UserTrait, Queueable, Dispatchable, SerializesModels, InteractsWithQueue;
	
	/**
     * The number of times the job may be attempted before it fails.
     *
     * @var int
     */
    public $tries = 5;
    
	/**
	 * Information about the company.
	 *
	 * @var string
	 */
	protected $company;
	
	/**
	 * Information about the event.
	 *
	 * @var string
	 */
	protected $event;
    
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
	public function __construct(Company $company, string $event)
	{
		$this->company = $company;
		
		$this->event = $event;
		
		$this->apiUrl = config('cms.api.url');
		
		$this->endpoint = config('cms.api.endpoints.companies');
		
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
		Log::info('---- Processing Company ----');
		Log::info('');
		Log::info('Company:');
		Log::info($this->company);
		Log::info('');
		
		try {
			// Send company details to 3rd party API for processing.
			$client = new Client([
				'base_uri' => $this->apiUrl,
				'timeout' => 5, // Timeout if a server does not return a response 
				'connect_timeout' => 10, // Timeout if the client fails to connect to the server
			]);
			
			$response = $client->request('POST', $this->endpoint, [
				'event_id' => uniqid(),
				'event_type' => $this->event,
				'data' => [
					$this->company
				],
			]);
			
			Log::info('Status Code:');
			Log::info($response->getStatusCode());
			Log::info('');
			Log::info('Body:');
			Log::info($response->getBody());
			
			// No need to send out an company event across the system since nothing is depending on the event.
			
		} catch (RequestException $exception) {
			Log::critical('');
			Log::critical('################################');
			Log::critical('#      API REQUEST FAILED      #');
			Log::critical('################################');
			Log::critical('');
			Log::critical('Request: ');
			Log::critical(Psr7\str($exception->getRequest()));
			Log::critical('');
			
			throw new Exception($exception);
		}
	
		Log::info('');
	}
	
	/**
	 * The job failed to process.
	 *
	 * @param  Exception  $exception
	 * @return void
	 */
	public function failed(Exception $exception)
	{
		Log::critical('');
		Log::critical('################################');
		Log::critical('#          JOB FAILED          #');
		Log::critical('################################');
		Log::critical('');
		Log::critical('Exception: '.$exception);
		Log::critical('');
		Log::critical('Message: '.$exception->getMessage());
		Log::critical('File: '.$exception->getFile());
		Log::critical('Line: '.$exception->getLine());
		Log::critical('Trace: '.$exception->getTraceAsString());
		Log::critical('');
		
		// Send notification of failure, setting the message
		$this->superAdmin->notify(new FailedJobNotification('Process Company Job Failed'));
	}
}
