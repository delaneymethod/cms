<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Listeners;

use App\Models\Keyword;
use App\Events\KeywordEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class KeywordListener implements ShouldQueue
{	
	/**
	 * The name of the queue the job should be sent to.
	 *
	 * @var string|null
	 */
	public $queue = 'keywords';
    
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Handle the event.
	 *
	 * @param 	KeywordEvent 	$event
	 * @return	void
	 */
	public function handle(KeywordEvent $event)
	{
		$keyword = new Keyword;
		
		$keyword->title = $event->keywords;
		
		$keyword->save();
	}
}
