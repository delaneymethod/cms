<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\Company;
use Illuminate\Support\Collection as SupportCollectionResponse;

trait CompanyTrait
{
	/**
	 * Get the specified company based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getCompany(int $id) : Company
	{
		return Company::findOrFail($id);
	}

	/**
	 * Get all the companies.
	 *
	 * @return 	Response
	 */
	public function getCompanies() : SupportCollectionResponse
	{
		return Company::orderBy('title')->get();
	}
	
	/**
	 * Get all the companies default location ids.
	 *
	 * @return 	Response
	 */
	public function getDefaultLocationIds() : array
	{
		$defaultLocationIds = [];
		
		$companies = $this->filterCompanies(Company::all());
			
		foreach ($companies as $company) {
			array_push($defaultLocationIds, $company->default_location_id);
		}
		
		return array_unique($defaultLocationIds);
	}
}
