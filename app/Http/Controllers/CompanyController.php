<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Traits\CompanyTrait;
use App\Http\Traits\LocationTrait;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
	use CompanyTrait;
	use LocationTrait;
		
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
	 * Get companies view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('view_companies')) {
			$title = 'Companies';
		
			$subTitle = '';
			
			$companies = $this->getCompanies();
			
			return view('cp.companies.index', compact('title', 'subTitle', 'companies'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating a new company.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_companies')) {
			$title = 'Create Company';
		
			$subTitle = 'Companies';
			
			// Used to set location_id
			$locations = $this->getLocations();
			
			return view('cp.companies.create', compact('title', 'subTitle', 'locations'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates a new company.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_companies')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedCompany = $this->sanitizerInput($request->all());

			$rules = $this->getRules('company');
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedCompany, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// Create new model
				$company = new Company;
	
				// Set our field data
				$company->title = $cleanedCompany['title'];
				$company->default_location_id = $cleanedCompany['default_location_id'];
				
				$company->save();
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

			flash('Company created successfully.', $level = 'success');

			return redirect('/cp/companies');
		}

		abort(403, 'Unauthorised action');
    }
    
    /**
	 * Shows a form for editing a company.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function edit(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_companies')) {
			$title = 'Edit Company';
		
			$subTitle = 'Companies';
			
			$company = $this->getCompany($id);
			
			$this->authorize('userOwnsThis', $company);
			
			// Used to set location_id
			$locations = $this->getLocations();
			
			return view('cp.companies.edit', compact('title', 'subTitle', 'company', 'locations'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Updates a specific company.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function update(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_companies')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedCompany = $this->sanitizerInput($request->all());

			$rules = $this->getRules('company');
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedCompany, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			DB::beginTransaction();

			try {
				// Create new model
				$company = $this->getCompany($id);
				
				$this->authorize('userOwnsThis', $company);
				
				// Set our field data
				$company->title = $cleanedCompany['title'];
				$company->default_location_id = $cleanedCompany['default_location_id'];
				$company->updated_at = $this->datetime;
				
				$company->save();
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

			flash('Company updated successfully.', $level = 'success');

			return redirect('/cp/companies');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting a company.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_companies')) {
			$currentUser = $this->getAuthenticatedUser();
		
			$company = $this->getCompany($id);
			
			$this->authorize('userOwnsThis', $company);
			
			if ($currentUser->company_id == $id) {
				flash('You cannot delete the '.$company->title.' company.', $level = 'warning');
	
				return redirect('/cp/companies');
			}
			
			$title = 'Delete Company';
			
			$subTitle = $currentUser->company->title;
		
			return view('cp.companies.delete', compact('title', 'subTitle', 'company'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific company.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_companies')) {
			$company = $this->getCompany($id);
		
			$this->authorize('userOwnsThis', $company);
		
			if ($currentUser->company_id == $id) {
				flash('You cannot delete the '.$company->title.' company.', $level = 'warning');

				return redirect('/cp/companies');
			}
			
			DB::beginTransaction();

			try {
				$company->delete();
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

			flash('Company deleted successfully.', $level = 'info');

			return redirect('/cp/companies');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushCompaniesCache() 
	{
		$this->flushCache('companies');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushCompanyCache($company) 
	{
		$this->flushCache('companies:id:'.$company->id);
	}
}
