<?php
/**
 * @link	  https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license	  https://www.delaneymethod.com/cms/license
 */
 
namespace App\Http\Requests;

use App\Rules\ReCaptchaRule;
use Illuminate\Foundation\Http\FormRequest;

class ReCaptchataFormRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'g-recaptcha-response' => [
				'required', 
				new ReCaptchaRule
			]
		];
	}
}
