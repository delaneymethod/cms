<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class KeywordEvent
{
	use Dispatchable, InteractsWithSockets, SerializesModels;
	
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
