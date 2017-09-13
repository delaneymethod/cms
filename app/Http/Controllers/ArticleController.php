<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\{Article, Content};
use App\Http\Controllers\Controller;
use App\Http\Traits\{CartTrait, UserTrait, PageTrait, StatusTrait, ContentTrait, ArticleTrait, CategoryTrait, TemplateTrait};

class ArticleController extends Controller
{
	use CartTrait, UserTrait, PageTrait, StatusTrait, ArticleTrait, ContentTrait, CategoryTrait, TemplateTrait;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth', [
			'except' => [
				'show'
			]
		]);
		
		$this->cacheKey = 'articles';
	}

	/**
	 * Get pages view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request) : View
	{
		$currentUser = $this->getAuthenticatedUser();
		
		$title = 'Articles';
		
		$subTitle = '';
		
		$articles = $this->getCache($this->cacheKey);
			
		if (is_null($articles)) {
			$articles = $this->getArticles();
			
			$this->setCache($this->cacheKey, $articles);
		}
		
		return view('cp.articles.index', compact('currentUser', 'title', 'subTitle', 'articles'));
	}
	
	/**
	 * Gets a article view (Front-end use only).
	 *
	 * @params	Request 	$request
	 * @params	string 		$slug
	 * @return 	Response
	 */
   	public function show(Request $request, string $slug) : View
	{
		$currentUser = $this->getAuthenticatedUser();
		
		// Get the requested article based on slug - if it doesnt exist, a 404 is thrown!
		$article = $this->getArticleBySlug($slug);
		
		// Throw a 404 if the articles publish date is in the future
		if ($article->published_at > Carbon::now()) {
			abort(404);
		}
		
		// We're going to use the articles page as our page - it is the articles parent after all...
		$page = $this->getPageBySlug('articles');
		
		// Grab a cart instance	- available across all pages
		$cart = $this->getCartInstance('cart');
		
		// Grab any wishlist instances since user can add to cart and wishlist on products page
		$wishlistCart = $this->getCartInstance('wishlist');
		
		// Grab parameters
		$parameters = $request->route()->parameters();
		
		// Pass any global required data to the page template
		$parameters['currentUser'] = $currentUser;
		
		$parameters['page'] = $page;
		
		$parameters['cart'] = $cart;
		
		$parameters['wishlistCart'] = $wishlistCart;
		
		$parameters['article'] = $article;
		
		// Selects the page template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'cart', 'wishlistCart'));
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
			
			$subTitle = 'Articles';
			
			// Used to set user_id
			$users = $this->getData('getUsers', 'users');
			
			// Used to set status_id
			$statuses = $this->getData('getStatuses', 'statuses');
			
			// Remove Active, Pending, Retired, Suspended keys
			$statuses->forget([0, 1, 2, 6]);
			
			// Used to set categories_ids
			$categories = $this->getData('getCategories', 'categories');
			
			// 9 = Article
			$articleTemplate = $this->getTemplate(9);
			
			$articleTemplate = $this->mapFieldsToFieldTypes($articleTemplate);
			
			return view('cp.articles.create', compact('currentUser', 'title', 'subTitle', 'users', 'statuses', 'categories', 'articleTemplate'));
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
			
			// Grab template fields and create rules based on field type
			$rules = $this->setTemplateFieldRules($rules, $cleanedArticle['templates']);
			
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
				$article->keywords = $this->commaSeparate($cleanedArticle['keywords']);
				$article->template_id = $cleanedArticle['template_id'];
				$article->user_id = $cleanedArticle['user_id'];
				$article->status_id = $cleanedArticle['status_id'];
				$article->published_at = $cleanedArticle['published_at'];
				
				$article->save();
				
				$article->setCategories($cleanedArticle['category_ids']);
				
				$articleContents = [];
				
				// Create our new content entries
				foreach ($cleanedArticle['templates'][$article->template_id] as $field_id => $data) {
					if (!empty($data)) {
						array_push($articleContents, [
							'field_id' => $field_id,
							'data' => $data,
						]);
					}
				}
				
				// So we can keep track of new content ids
				$contents = [];
				
				// Loop over each row and create new content entries
				foreach ($articleContents as $articleContent) {
					$content = new Content;
					
					$content->field_id = $articleContent['field_id'];
					$content->data = $articleContent['data'];
					
					$content->save();
					
					array_push($contents, $content->id);
				}
				
				$article->setContents($contents);
				
				$this->setCache($this->cacheKey, $this->getArticles());
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

			return redirect('/cp/articles/all');
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
		
			$subTitle = 'Articles';
			
			$article = $this->getArticle($id);
			
			// Used to set user_id
			$users = $this->getData('getUsers', 'users');
			
			// Used to set status_id
			$statuses = $this->getData('getStatuses', 'statuses');
			
			// Remove Active, Pending, Retired, Suspended keys
			$statuses->forget([0, 1, 2, 6]);
			
			// Used to set categories_ids
			$categories = $this->getData('getCategories', 'categories');
			
			// 9 = Article but we still use whats stored in the model
			$articleTemplate = $this->getTemplate($article->template_id);
			
			$articleTemplate = $this->mapFieldsToFieldTypes($articleTemplate);
			
			if ($article->contents->count() > 0) {
				// now get article template field values and set defaults / values.
				$articleTemplate = $this->mapContentsToFields($articleTemplate, $article->contents);
			}
			
			return view('cp.articles.edit', compact('currentUser', 'title', 'subTitle', 'article', 'users', 'statuses', 'categories', 'articleTemplate'));
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
			
			// Grab template fields and create rules based on field type
			$rules = $this->setTemplateFieldRules($rules, $cleanedArticle['templates']);
			
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
				$article->keywords = $this->commaSeparate($cleanedArticle['keywords']);
				$article->template_id = $cleanedArticle['template_id'];
				$article->user_id = $cleanedArticle['user_id'];
				$article->status_id = $cleanedArticle['status_id'];
				$article->published_at = $cleanedArticle['published_at'];
				$article->updated_at = $this->datetime;
				
				$article->save();
				
				$article->setCategories($cleanedArticle['category_ids']);
				
				// Loop over all current content entries and delete
				$articleContentIds = $article->contents->pluck('id');
				
				if (count($articleContentIds)) {
					foreach ($articleContentIds as $id) {
						$content = $this->getContent($id);
						
						$content->delete();
					}
				}
				
				$articleContents = [];
				
				// Create our new content entries
				foreach ($cleanedArticle['templates'][$article->template_id] as $field_id => $data) {
					if (!empty($data)) {
						array_push($articleContents, [
							'field_id' => $field_id,
							'data' => $data,
						]);
					}
				}
				
				// So we can keep track of new content ids
				$contents = [];
				
				// Loop over each row and create new content entries
				foreach ($articleContents as $articleContent) {
					$content = new Content;
					
					$content->field_id = $articleContent['field_id'];
					$content->data = $articleContent['data'];
					
					$content->save();
					
					array_push($contents, $content->id);
				}
				
				$article->setContents($contents);
				
				$this->setCache($this->cacheKey, $this->getArticles());
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

			return redirect('/cp/articles/all');
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
			
			$subTitle = 'Articles';
			
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
				// Loop over all current content entries and delete
				$articleContentIds = $article->contents->pluck('id');
				
				if (count($articleContentIds)) {
					foreach ($articleContentIds as $id) {
						$content = $this->getContent($id);
						
						$content->delete();
					}
				}
				
				$article->delete();
				
				$this->setCache($this->cacheKey, $this->getArticles());
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

			return redirect('/cp/articles/all');
		}

		abort(403, 'Unauthorised action');
	}	
}
