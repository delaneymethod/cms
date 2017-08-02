<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Http\Traits\StatusTrait;
use App\Http\Traits\ArticleTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
	use UserTrait;
	use StatusTrait;
	use ArticleTrait;
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
	 * Get pages view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		$title = 'Articles';
		
		$subTitle = '';
		
		$articles = $this->getArticles();
		
		return view('cp.articles.index', compact('currentUser', 'title', 'subTitle', 'articles'));
	}
	
	/**
	 * Shows a form for creating a new article.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_articles')) {
			$title = 'Create Article';
			
			$subTitle = '';
			
			// Used to set user_id
			$users = $this->getUsers();
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Used to set categories_ids
			$categories = $this->getCategories();
			
			return view('cp.articles.create', compact('currentUser', 'title', 'subTitle', 'users', 'statuses', 'categories'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates a new article.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_articles')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedArticle = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('article');
			
			if (!empty($cleanedArticle['category_ids'])) {
				$categoryIds = count($cleanedArticle['category_ids']) - 1;
			
				foreach (range(0, $categoryIds) as $index) {
					$rules['category_ids.'.$index] = 'integer';
				}
			}
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedArticle, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// Create new model
				$article = new Article;
	
				// Set our field data
				$article->title = $cleanedArticle['title'];
				$article->slug = $cleanedArticle['slug'];
				$article->description = $cleanedArticle['description'];
				$article->keywords = $cleanedArticle['keywords'];
				$article->user_id = $cleanedArticle['user_id'];
				$article->status_id = $cleanedArticle['status_id'];
				$article->content = $cleanedArticle['content'];
				$article->published_at = $cleanedArticle['published_at'];
				
				$article->save();
				
				$article->setCategories($cleanedArticle['category_ids']);
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

			flash('Article created successfully.', $level = 'success');

			return redirect('/cp/articles');
		}

		abort(403, 'Unauthorised action');
    }
    
    /**
	 * Shows a form for editing a article.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function edit(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_articles')) {
			$title = 'Edit Article';
		
			$subTitle = '';
			
			$article = $this->getArticle($id);
			
			// Used to set user_id
			$users = $this->getUsers();
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Used to set categories_ids
			$categories = $this->getCategories();
			
			return view('cp.articles.edit', compact('currentUser', 'title', 'subTitle', 'article', 'users', 'statuses', 'categories'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Updates a specific article.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function update(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_articles')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedArticle = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('article');
			
			if (!empty($cleanedArticle['category_ids'])) {
				$categoryIds = count($cleanedArticle['category_ids']) - 1;
			
				foreach (range(0, $categoryIds) as $index) {
					$rules['category_ids.'.$index] = 'integer';
				}
			}
			
			$rules['slug'] = 'required|string|unique:articles,slug,'.$id.'|max:255';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedArticle, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			DB::beginTransaction();

			try {
				// Create new model
				$article = $this->getArticle($id);
				
				// Set our field data
				$article->title = $cleanedArticle['title'];
				$article->slug = $cleanedArticle['slug'];
				$article->description = $cleanedArticle['description'];
				$article->keywords = $cleanedArticle['keywords'];
				$article->user_id = $cleanedArticle['user_id'];
				$article->status_id = $cleanedArticle['status_id'];
				$article->content = $cleanedArticle['content'];
				$article->published_at = $cleanedArticle['published_at'];
				$article->updated_at = $this->datetime;
				
				$article->save();
				
				$article->setCategories($cleanedArticle['category_ids']);
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

			flash('Article updated successfully.', $level = 'success');

			return redirect('/cp/articles');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting a article.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_articles')) {
			$article = $this->getArticle($id);
		
			$title = 'Delete Article';
			
			$subTitle = '';
			
			return view('cp.articles.delete', compact('currentUser', 'title', 'subTitle', 'article'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific article.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_articles')) {
			$article = $this->getArticle($id);
			
			DB::beginTransaction();

			try {
				$article->delete();
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

			flash('Article deleted successfully.', $level = 'info');

			return redirect('/cp/articles');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushArticlesCache() 
	{
		$this->flushCache('articles');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushArticleCache($article) 
	{
		$this->flushCache('articles:id:'.$article->id);
	}
}
