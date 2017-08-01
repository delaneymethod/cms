<?php

namespace App\Models;

use App\Models\Status;
use App\Models\County;
use App\Models\Country;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'unit',
		'building',
		'street_address_1',
		'street_address_2',
		'street_address_3',
		'street_address_4',
		'town_city',
		'postal_code',
		'telephone',
		'county_id',
		'country_id',
		'company_id',
		'status_id',
	];
	
	/**
     * Attributes that get appended on serialization
     *
     * @var array
     */
	protected $appends = [
		'postal_address',
	];
	
	/**
	 * Get the locations postal address
	 *
	 * @param  	int  	$value
	 * @return 	void
	 */
	public function getPostalAddressAttribute()
	{
		$address = [
			$this->unit,
			$this->building,
			$this->street_address_1,
			$this->street_address_2,
			$this->street_address_3,
			$this->street_address_4,
			$this->town_city,
			$this->postal_code,
			$this->county->title,
			$this->country->title
		];
		
		$address = array_unique($address);
		
		$address = array_filter($address);
		
		$address = array_values($address);
		
		return implode(', ', $address);
	}

	/**
	 * Get the county record associated with the location.
	 */
	public function county()
	{
		return $this->belongsTo(County::class);
	}
	
	/**
	 * Get the country record associated with the location.
	 */
	public function country()
	{
		return $this->belongsTo(Country::class);
	}
	
	/**
	 * Get the company record associated with the location.
	 */
	public function company()
	{
		return $this->belongsTo(Company::class);
	}
	
	/**
	 * Get the status record associated with the location.
	 */
	public function status()
	{
		return $this->belongsTo(Status::class);
	}
}
