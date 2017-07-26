<?php

namespace App\Http\Traits;

use App\Models\Company;

trait CompanyTrait
{
	/**
	 * Get the specified company based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getCompany(int $id)
	{
		$company = Company::findOrFail($id);
		
		return $this->filterCompanies([$company])->first();
	}

	/**
	 * Get all the companies.
	 *
	 * @return 	Response
	 */
	public function getCompanies()
	{
		$companies = $this->filterCompanies(Company::all());
		
		$limit = $this->getLimit();

		return $this->paginateCollection($companies, $limit);
	}
	
	/**
	 * Get all the companies default location ids.
	 *
	 * @return 	Response
	 */
	public function getDefaultLocationIds()
	{
		$defaultLocationIds = [];
		
		$companies = $this->filterCompanies(Company::all());
			
		foreach ($companies as $company) {
			array_push($defaultLocationIds, $company->default_location_id);
		}
		
		return array_unique($defaultLocationIds);
	}
}
