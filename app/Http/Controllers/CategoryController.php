<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\{StatusTrait, CategoryTrait};

class CategoryController extends Controller
{
	use StatusTrait;
	use CategoryTrait;

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
	 * Get categories view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_categories')) {
			$title = 'Categories';
		
			$subTitle = '';
		
			$categories = $this->getCategories();
			
			$statuses = $this->getStatuses();
			
			return view('cp.articles.categories.index', compact('currentUser', 'title', 'subTitle', 'categories', 'statues'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating a new category.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_categories')) {
			$title = 'Create Category';
			
			$subTitle = 'Categories';
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Remove Pubished, Private, Draft and Suspended keys
			$statuses->forget([3, 4, 5, 6]);
			
			return view('cp.articles.categories.create', compact('currentUser', 'title', 'subTitle', 'statuses'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates a new category.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_categories')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedCategory = $this->sanitizerInput($request->all());

			$rules = $this->getRules('category');
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedCategory, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// Create new model
				$category = new Category;
	
				// Set our field data
				$category->title = $cleanedCategory['title'];
				$category->slug = $cleanedCategory['slug'];
				$category->status_id = $cleanedCategory['status_id'];
				
				$category->save();
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

			flash('Category created successfully.', $level = 'success');

			return redirect('/cp/articles/categories');
		}

		abort(403, 'Unauthorised action');
    }
    
    /**
	 * Shows a form for editing a category.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function edit(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_categories')) {
			$title = 'Edit Category';
		
			$subTitle = 'Categories';
			
			$category = $this->getCategory($id);
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Remove Pubished, Private, Draft and Suspended keys
			$statuses->forget([3, 4, 5, 6]);
			
			return view('cp.articles.categories.edit', compact('currentUser', 'title', 'subTitle', 'category', 'statuses'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Updates a specific category.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function update(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_categories')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedCategory = $this->sanitizerInput($request->all());

			$rules = $this->getRules('category');
			
			$rules['slug'] = 'required|string|unique:categories,slug,'.$id.'|max:255';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedCategory, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			DB::beginTransaction();

			try {
				// Create new model
				$category = $this->getCategory($id);
				
				// Set our field data
				$category->title = $cleanedCategory['title'];
				$category->slug = $cleanedCategory['slug'];
				$category->status_id = $cleanedCategory['status_id'];
				$category->updated_at = $this->datetime;
				
				$category->save();
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

			flash('Category updated successfully.', $level = 'success');

			return redirect('/cp/articles/categories');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting a category.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_categories')) {
			$category = $this->getCategory($id);
			
			if ($category->id == $id && $id == 1) {
				flash('You cannot delete the '.$category->title.' category.', $level = 'warning');
	
				return redirect('/cp/articles/categories');
			}
			
			$title = 'Delete Category';
			
			$subTitle = 'Categories';
			
			return view('cp.articles.categories.delete', compact('currentUser', 'title', 'subTitle', 'category'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific category.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_categories')) {
			$category = $this->getCategory($id);
			
			if ($category->id == $id && $id == 1) {
				flash('You cannot delete the '.$category->title.' category.', $level = 'warning');
	
				return redirect('/cp/articles/categories');
			}
			
			DB::beginTransaction();

			try {
				$category->delete();
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

			flash('Category deleted successfully.', $level = 'info');

			return redirect('/cp/articles/categories');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushCategoriesCache()
	{
		$this->flushCache('categories');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushCategoryCache($category)
	{
		$this->flushCache('categories:id:'.$category->id);
	}
}
