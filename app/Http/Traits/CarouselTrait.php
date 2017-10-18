<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\Carousel;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

trait CarouselTrait
{
	/**
	 * Get the specified carousel based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getCarousel(int $id)
	{
		return Carousel::find($id);
	}
	
	/**
	 * Get all the carousels.
	 *
	 * @return 	Collection
	 */
	public function getCarousels() : CollectionResponse
	{
		return Carousel::all();
	}
}
