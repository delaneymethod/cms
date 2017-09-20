<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use App\Http\Traits\{StatusTrait, ArticleCategoryTrait};

class ArticleCategoryController extends Controller
{
	use StatusTrait, ArticleCategoryTrait;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
		
		$this->cacheKey = 'article_categories';
	}
	
	/**
	 * Get article categories view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_article_categories')) {
			$title = 'Article Categories';
		
			$subTitle = '';
		
			$this->cacheKey = 'statuses';
			
			$statuses = $this->getCache($this->cacheKey);
			
			if (is_null($statuses)) {
				$statuses = $this->getStatuses();
				
				$this->setCache($this->cacheKey, $statuses);
			}
			
			$this->cacheKey = 'article_categories';
			
			$articleCategories = $this->getCache($this->cacheKey);
			
			if (is_null($articleCategories)) {
				$articleCategories = $this->getArticleCategories();
				
				$this->setCache($this->cacheKey, $articleCategories);
			}
			
			return view('cp.articles.categories.index', compact('currentUser', 'title', 'subTitle', 'articleCategories', 'statues'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating a new article category.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_article_categories')) {
			$title = 'Create Article Category';
			
			$subTitle = 'Article Categories';
			
			// Used to set status_id
			$statuses = $this->getData('getStatuses', 'statuses');
			
			// Remove Pubished, Private, Draft, Suspended, Shipped and Delivered keys
			$statuses->forget([3, 4, 5, 6, 7, 8]);
			
			return view('cp.articles.categories.create', compact('currentUser', 'title', 'subTitle', 'statuses'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates a new article category.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_article_categories')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedArticleCategory = $this->sanitizerInput($request->all());

			$rules = $this->getRules('article_category');
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedArticleCategory, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// Create new model
				$articleCategory = new ArticleCategory;
	
				// Set our field data
				$articleCategory->title = $cleanedArticleCategory['title'];
				$articleCategory->slug = $cleanedArticleCategory['slug'];
				$articleCategory->status_id = $cleanedArticleCategory['status_id'];
				
				$articleCategory->save();
				
				$this->setCache($this->cacheKey, $this->getArticleCategories());
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

			flash('Article Category created successfully.', $level = 'success');

			return redirect('/cp/articles/categories');
		}

		abort(403, 'Unauthorised action');
    }
    
    /**
	 * Shows a form for editing a article category.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function edit(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_article_categories')) {
			$title = 'Edit Article Category';
		
			$subTitle = 'Article Categories';
			
			$articleCategory = $this->getArticleCategory($id);
			
			// Used to set status_id
			$statuses = $this->getData('getStatuses', 'statuses');
			
			// Remove Pubished, Private, Draft, Suspended, Shipped and Delivered keys
			$statuses->forget([3, 4, 5, 6, 7, 8]);
			
			return view('cp.articles.categories.edit', compact('currentUser', 'title', 'subTitle', 'articleCategory', 'statuses'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Updates a specific article category.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function update(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_article_categories')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedArticleCategory = $this->sanitizerInput($request->all());

			$rules = $this->getRules('article_category');
			
			$rules['slug'] = 'required|string|unique:article_categories,slug,'.$id.'|max:255';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedArticleCategory, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			DB::beginTransaction();

			try {
				// Create new model
				$articleCategory = $this->getArticleCategory($id);
				
				// Set our field data
				$articleCategory->title = $cleanedArticleCategory['title'];
				$articleCategory->slug = $cleanedArticleCategory['slug'];
				$articleCategory->status_id = $cleanedArticleCategory['status_id'];
				$articleCategory->updated_at = $this->datetime;
				
				$articleCategory->save();
				
				$this->setCache($this->cacheKey, $this->getArticleCategories());
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

			flash('Article Category updated successfully.', $level = 'success');

			return redirect('/cp/articles/categories');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting a article category.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_article_categories')) {
			$articleCategory = $this->getArticleCategory($id);
			
			if ($articleCategory->id == $id && $id == 1) {
				flash('You cannot delete the '.$articleCategory->title.' article category.', $level = 'warning');
	
				return redirect('/cp/articles/categories');
			}
			
			$title = 'Delete Article Category';
			
			$subTitle = 'Article Categories';
			
			return view('cp.articles.categories.delete', compact('currentUser', 'title', 'subTitle', 'articleCategory'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific article category.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_article_categories')) {
			$articleCategory = $this->getArticleCategory($id);
			
			if ($articleCategory->id == $id && $id == 1) {
				flash('You cannot delete the '.$articleCategory->title.' article category.', $level = 'warning');
	
				return redirect('/cp/articles/categories');
			}
			
			DB::beginTransaction();

			try {
				$articleCategory->delete();
				
				$this->setCache($this->cacheKey, $this->getArticleCategories());
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

			flash('Article Category deleted successfully.', $level = 'info');

			return redirect('/cp/articles/categories');
		}

		abort(403, 'Unauthorised action');
	}
}
