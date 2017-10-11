<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\Keyword;
use Illuminate\Database\Eloquent\Collection;

trait KeywordTrait
{
	/**
	 * Get all the keywords.
	 *
	 * @return 	Collection
	 */
	public function getKeywords() : Collection
	{
		return Keyword::all();
	}
}
