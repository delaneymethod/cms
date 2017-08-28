<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
	protected $headers;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('guest');
		
		$this->headers = [];
	}

	/**
	 * Get api view.
	 *
	 * @return 	Response
	 */
   	public function index(Request $request)
	{	
		return response()->json(['message' => 'Welcome to our API.'], 200, $this->headers);
	}

	/**
	 * Return data for an api response.
	 *
	 * @param 	array 		$data
	 * @param 	array 		$headers
	 * @return 	Response
	 */
	public function respondWithData($data, array $headers = [])
	{
		$headers = array_merge($headers, $this->headers);
		
		$httpStatusCode = $this->getStatusCode();
		
		// If an array / collection, return as an envelope, keeping all responses consistent.
		if (is_a($data, 'Illuminate\Support\Collection') || is_array($data)) {
			// Add a few extra attributes to help.
			$url = '/'.request()->path();
			
			$object = 'list';
			
			$total_count = count($data);
			
			return response()->json(compact('url', 'object', 'total_count', 'data'), $httpStatusCode, $headers);
		}
		
		return response()->json($data, $httpStatusCode, $headers);
	}

	/**
	 * Return no content for an api response.
	 *
	 * @param 	string 		$message
	 * @param 	array 		$headers
	 * @return 	Response
	 */
	public function respondWithNoContent(string $message, array $headers = [])
	{
		$headers = array_merge($headers, $this->headers);
		
		$httpStatusCode = $this->getStatusCode();

		return response()->json(compact('message'), $httpStatusCode, $headers);
	}

	/**
	 * Return error for an api response.
	 *
	 * Examples:
	 *  return $this->setStatusCode(204)->respondWithNoContent('The resource was deleted successfully!');
	 *	return $this->setStatusCode(400)->respondWithError(['summary': 'Resource status_id missing']);
	 *	return $this->setStatusCode(500)->respondWithError();
     *
     * @param 	array 		$messages
	 * @param 	array 		$headers
	 * @return 	Response
	 */
	public function respondWithError(array $messages = [], array $headers = [])
	{
		$headers = array_merge($headers, $this->headers);
		
		$httpStatusCode = $this->getStatusCode();

		$errorMessages = $this->_getErrorMessages();

		// Get our error messages to build up our error response
		$message = $errorMessages[$httpStatusCode];
		
		$summary = '';
		
		// Add the validator check error messages
		if (count($messages) > 0) {
			// If specific messages are passed, append to the message.
			foreach ($messages as $key => $value) {
				if (is_array($value)) {
					$summary .= $value[0].' ';
				} else {
					$summary .= $value.' ';
				}
			}
			
			$message['error']['summary'] = trim($summary);
		}
		
		return response()->json($message, $httpStatusCode, $headers);
	}

	/**
	 * Return error for invalid limit for an api response.
	 *
	 * @return 	Response
	 */
	public function respondWithInvalidLimit()
	{
		return $this->respondWithError(['error' => 'Limit must be a valid integer.']);
	}

	/**
	 * Get the error messages that apply to all API requests.
	 *
	 * @return array
	 */
	private function _getErrorMessages()
	{
		return config('cms.api_error_messages');
	}
}
