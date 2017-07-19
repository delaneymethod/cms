<?php

namespace App\Http\Traits;

use App\Models\Country;

trait CountryTrait
{
	/**
	 * Get the specified country based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getCountry(int $id)
	{
		return Country::findOrFail($id);
	}

	/**
	 * Get all the countries.
	 *
	 * @return 	Collection
	 */
	public function getCountries()
	{
		$limit = $this->getLimit();

		return $this->paginateCollection(Country::all(), $limit);
	}
}
