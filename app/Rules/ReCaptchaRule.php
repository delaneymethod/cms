<?php

namespace App\Rules;

use GuzzleHttp\{Psr7, Client};
use Illuminate\Contracts\Validation\Rule;

class ReCaptchaRule implements Rule
{
	/**
	 * Information about the secret.
	 *
	 * @var string
	 */
	private $secret;
	
	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->secret = config('services.google.recaptcha.secret');
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param	string	$attribute
	 * @param	mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		try {
			// Send new order details to 3rd party API for processing.
			$client = new Client([
				'timeout' => 5, // Timeout if a server does not return a response 
				'connect_timeout' => 10, // Timeout if the client fails to connect to the server
			]);
			
			$response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
				'form_params' => [
					'secret' => $this->secret,
					'response' => $value
				],
			]);
			
			$body = json_decode($response->getBody());
		
			return $body->success;
		} catch (RequestException $exception) {
			throw new Exception($exception);
		}
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return trans('validation.recaptcha');
	}
}
