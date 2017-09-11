<?php

namespace App\Http\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection as CollectionResponse;

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
		$company = Company::findOrFail($id);
		
		return $this->filterCompanies([$company])->first();
	}

	/**
	 * Get all the companies.
	 *
	 * @return 	Response
	 */
	public function getCompanies() : CollectionResponse
	{
		return Company::all();
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
