<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\{StatusTrait, CountyTrait, CountryTrait, CompanyTrait, LocationTrait};

class LocationController extends Controller
{
	use StatusTrait, CountyTrait, CountryTrait, CompanyTrait, LocationTrait;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
	}
	
	/**
	 * Get locations view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_locations')) {
			$title = 'Locations';
		
			$subTitle = $currentUser->company->title;
		
			$locations = $this->getLocations();
			
			$defaultLocationIds = $this->getDefaultLocationIds();
			
			return view('cp.locations.index', compact('currentUser', 'title', 'subTitle', 'locations', 'defaultLocationIds'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating a new location.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_locations')) {
			$title = 'Create Location';
			
			$subTitle = $currentUser->company->title;
			
			// Used to set county_id
			$counties = $this->getCounties();
			
			// Used to set country_id
			$countries = $this->getCountries();
			
			// Used to set company_id
			$companies = $this->getCompanies();
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Remove Pubished, Private and Draft keys
			$statuses->forget([3, 4, 5]);
			
			return view('cp.locations.create', compact('currentUser', 'title', 'subTitle', 'counties', 'countries', 'companies', 'statuses'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates a new location.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_locations')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedLocation = $this->sanitizerInput($request->all());

			$rules = $this->getRules('location');
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedLocation, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// Create new model
				$location = new Location;
	
				// Set our field data
				$location->title = $cleanedLocation['title'];
				$location->unit = $cleanedLocation['unit'];
				$location->building = $cleanedLocation['building'];
				$location->street_address_1 = $cleanedLocation['street_address_1'];
				$location->street_address_2 = $cleanedLocation['street_address_2'];
				$location->street_address_3 = $cleanedLocation['street_address_3'];
				$location->street_address_4 = $cleanedLocation['street_address_4'];
				$location->town_city = $cleanedLocation['town_city'];
				$location->postal_code = $cleanedLocation['postal_code'];
				$location->county_id = $cleanedLocation['county_id'];
				$location->country_id = $cleanedLocation['country_id'];
				$location->telephone = $cleanedLocation['telephone'];
				$location->company_id = $cleanedLocation['company_id'];
				$location->status_id = $cleanedLocation['status_id'];
				
				$location->save();
			} catch (QueryException $queryException) {
				DB::rollback();
			
				Log::info('SQL: '.$queryException->getSql());

				Log::info('Bindings: '.implode(', ', $queryException->getBindings()));

				abort(500, $queryException);
			} catch (Exception $exception) {
				DB::rollback();

				abort(500, $exception);
			}

			DB::commit();

			flash('Location created successfully.', $level = 'success');

			return redirect('/cp/locations');
		}

		abort(403, 'Unauthorised action');
    }
    
    /**
	 * Shows a form for editing a location.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function edit(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_locations')) {
			$title = 'Edit Location';
		
			$subTitle = $currentUser->company->title;
			
			$location = $this->getLocation($id);
			
			$this->authorize('userOwnsThis', $location);
			
			// Used to set county_id
			$counties = $this->getCounties();
			
			// Used to set country_id
			$countries = $this->getCountries();
			
			// Used to set company_id
			$companies = $this->getCompanies();
		
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Remove Pubished, Private and Draft keys
			$statuses->forget([3, 4, 5]);
			
			$defaultLocationIds = $this->getDefaultLocationIds();
		
			return view('cp.locations.edit', compact('currentUser', 'title', 'subTitle', 'location', 'counties', 'countries', 'companies', 'statuses', 'defaultLocationIds'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Updates a specific location.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function update(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_locations')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedLocation = $this->sanitizerInput($request->all());

			$rules = $this->getRules('location');
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedLocation, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			DB::beginTransaction();

			try {
				// Create new model
				$location = $this->getLocation($id);
				
				$this->authorize('userOwnsThis', $location);
		
				// Set our field data
				$location->title = $cleanedLocation['title'];
				$location->unit = $cleanedLocation['unit'];
				$location->building = $cleanedLocation['building'];
				$location->street_address_1 = $cleanedLocation['street_address_1'];
				$location->street_address_2 = $cleanedLocation['street_address_2'];
				$location->street_address_3 = $cleanedLocation['street_address_3'];
				$location->street_address_4 = $cleanedLocation['street_address_4'];
				$location->town_city = $cleanedLocation['town_city'];
				$location->postal_code = $cleanedLocation['postal_code'];
				$location->telephone = $cleanedLocation['telephone'];
				$location->county_id = $cleanedLocation['county_id'];
				$location->country_id = $cleanedLocation['country_id'];
				$location->telephone = $cleanedLocation['telephone'];
				$location->company_id = $cleanedLocation['company_id'];
				$location->status_id = $cleanedLocation['status_id'];
				$location->updated_at = $this->datetime;
				
				$location->save();
			} catch (QueryException $queryException) {
				DB::rollback();
			
				Log::info('SQL: '.$queryException->getSql());

				Log::info('Bindings: '.implode(', ', $queryException->getBindings()));

				abort(500, $queryException);
			} catch (Exception $exception) {
				DB::rollback();

				abort(500, $exception);
			}

			DB::commit();

			flash('Location updated successfully.', $level = 'success');

			return redirect('/cp/locations');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Retires a specific location.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function retire(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('retire_locations')) {
			$location = $this->getLocation($id);
				
			$this->authorize('userOwnsThis', $location);
			
			$defaultLocationIds = $this->getDefaultLocationIds();
			
			if (in_array($location->id, $defaultLocationIds)) {
				flash('You cannot retire a default location.', $level = 'warning');

				return redirect('/cp/locations');
			}
		
			DB::beginTransaction();

			try {
				$status = $this->getStatusByTitle('Retired');
				
				$location->status_id = $status->id;
				$location->updated_at = $this->datetime;
				
				$location->save();
			} catch (QueryException $queryException) {
				DB::rollback();
			
				Log::info('SQL: '.$queryException->getSql());

				Log::info('Bindings: '.implode(', ', $queryException->getBindings()));

				abort(500, $queryException);
			} catch (Exception $exception) {
				DB::rollback();

				abort(500, $exception);
			}

			DB::commit();

			flash('Location retired successfully.', $level = 'info');

			return redirect('/cp/locations');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Suspends a specific location.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function suspend(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('suspend_locations')) {
			$location = $this->getLocation($id);
				
			$this->authorize('userOwnsThis', $location);
			
			DB::beginTransaction();

			try {
				$status = $this->getStatusByTitle('Suspended');
				
				$location->status_id = $status->id;
				$location->updated_at = $this->datetime;
				
				$location->save();
			} catch (QueryException $queryException) {
				DB::rollback();
			
				Log::info('SQL: '.$queryException->getSql());

				Log::info('Bindings: '.implode(', ', $queryException->getBindings()));

				abort(500, $queryException);
			} catch (Exception $exception) {
				DB::rollback();

				abort(500, $exception);
			}

			DB::commit();

			flash('Location suspended successfully.', $level = 'info');

			return redirect('/cp/locations');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting a location.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_locations')) {
			$location = $this->getLocation($id);
		
			$this->authorize('userOwnsThis', $location);
			
			$defaultLocationIds = $this->getDefaultLocationIds();
			
			if (in_array($location->id, $defaultLocationIds)) {
				flash('You cannot delete a default location.', $level = 'warning');

				return redirect('/cp/locations');
			}
			
			$title = 'Delete Location';
			
			$subTitle = $currentUser->company->title;
			
			return view('cp.locations.delete', compact('currentUser', 'title', 'subTitle', 'location'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific location.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_locations')) {
			$location = $this->getLocation($id);
			
			$this->authorize('userOwnsThis', $location);
			
			$defaultLocationIds = $this->getDefaultLocationIds();
			
			if (in_array($location->id, $defaultLocationIds)) {
				flash('You cannot delete a default location.', $level = 'warning');

				return redirect('/cp/locations');
			}
		
			DB::beginTransaction();

			try {
				$location->delete();
			} catch (QueryException $queryException) {
				DB::rollback();
			
				Log::info('SQL: '.$queryException->getSql());

				Log::info('Bindings: '.implode(', ', $queryException->getBindings()));

				abort(500, $queryException);
			} catch (Exception $exception) {
				DB::rollback();

				abort(500, $exception);
			}

			DB::commit();

			flash('Location deleted successfully.', $level = 'info');

			return redirect('/cp/locations');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushLocationsCache()
	{
		$this->flushCache('locations');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushLocationCache($location)
	{
		$this->flushCache('locations:id:'.$location->id);
	}
}
