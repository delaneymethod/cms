<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Status, County, Country, Company};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';
    
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;

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
	 * @return 	string
	 */
	public function getPostalAddressAttribute() : string
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
	public function county() : BelongsTo
	{
		return $this->belongsTo(County::class);
	}
	
	/**
	 * Get the country record associated with the location.
	 */
	public function country() : BelongsTo
	{
		return $this->belongsTo(Country::class);
	}
	
	/**
	 * Get the company record associated with the location.
	 */
	public function company() : BelongsTo
	{
		return $this->belongsTo(Company::class);
	}
	
	/**
	 * Get the status record associated with the location.
	 */
	public function status() : BelongsTo
	{
		return $this->belongsTo(Status::class);
	}
	
	/**
	 * Checks if location is pending.
	 *
	 * @return bool
	 */
	public function isPending() : bool
	{
		return $this->status_id == 2;
	}
	
	/**
	 * Checks if location is retired.
	 *
	 * @return bool
	 */
	public function isRetired() : bool
	{
		return $this->status_id == 3;
	}
	
	/**
	 * Checks if location is suspened.
	 *
	 * @return bool
	 */
	public function isSuspended() : bool
	{
		return $this->status_id == 7;
	}
}
