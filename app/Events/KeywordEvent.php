<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class KeywordEvent
{
	use Dispatchable;
	
	/**
	 * Information about the keywords.
	 *
	 * @var string
	 */
	public $keywords;
	
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(string $keywords)
	{
		$this->keywords = $keywords;
	}
}
