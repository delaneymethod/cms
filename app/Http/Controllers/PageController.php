<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Models\{Page, Content};
use App\Http\Controllers\Controller;
use App\Http\Traits\{CartTrait, PageTrait, StatusTrait, ContentTrait, TemplateTrait};

class PageController extends Controller
{
	use CartTrait;
	use PageTrait;
	use StatusTrait;
	use ContentTrait;
	use TemplateTrait;
	
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
		
		if ($currentUser->hasPermission('view_pages')) {
			$title = 'Pages';
			
			$subTitle = '';
			
			$this->rebuildPages();
		
			return view('cp.pages.index', compact('currentUser', 'title', 'subTitle'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Get a pages view.
	 *
	 * @params	Request 	$request
	 * @params	string 		$slug
	 * @return 	Response
	 */
	public function show(Request $request, $slug = '/')
	{
		$currentUser = $this->getAuthenticatedUser();
		
		// Cart and Cart subpage access requires a logged in user
		if (str_contains($slug, 'cart') && $currentUser == null) {
			return redirect('/login');
		}
		
		// Get the URL segments
		if ($slug == '/') {
			$segments = collect([0 => '']);
		} else {
			$segments = collect(explode('/', $slug));
		}
		
		// Set slug based on the last segment
		$slug = $segments->last();
		
		// Get the requested page based on slug - if it doesnt exist, a 404 is thrown!
		$page = $this->getPageBySlug($slug);
		
		// Grab a cart instance	- available across all pages
		$cart = $this->getCartInstance('cart');
		
		// Grab any wishlist instances since user can add to cart and wishlist on products page
		$wishlistCart = $this->getCartInstance('wishlist');
		
		// Grab parameters
		$parameters = $request->route()->parameters();
		
		// Pass any global required data to the page template
		$parameters['currentUser'] = $currentUser;
		
		// Add the page to the parameters array - we want to pass the page model data to the template.
		$parameters['page'] = $page;
		
		$parameters['cart'] = $cart;
		
		$parameters['wishlistCart'] = $wishlistCart;
		
		// Selects the page template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
	
	/**
	 * Get menu view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function menu(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_pages')) {
			$title = 'Menu';
		
			$subTitle = 'Pages';
			
			$this->rebuildPages();
			
			$pagesHierarchy = $this->getPagesHierarchy();
			
			return view('cp.menu.index', compact('currentUser', 'title', 'subTitle', 'pagesHierarchy'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating a new page.
	 *
	 * @params	Request 	$request
	 * @param	int			$templateId
	 * @return 	Response
	 */
	public function create(Request $request, int $templateId)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('create_pages')) {
			$title = 'Create Page';
		
			$subTitle = 'Pages';
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Remove Active, Pending, Retired and Suspended keys
			$statuses->forget([0, 1, 2, 6]);
			
			// Used to set template_id
			$templates = $this->getTemplates();
			
			return view('cp.pages.create', compact('currentUser', 'title', 'subTitle', 'statuses', 'templates'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Creates a new page.
	 *
	 * @params Request 	$request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_pages')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedPage = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('page');
			
			if (!empty($cleanedPage['hide_from_nav'])) {
				$rules['hide_from_nav'] = 'nullable|integer';
			}
			
			// Grab template fields and create rules based on field type
			$rules = $this->setTemplateFieldRules($rules, $cleanedPage['templates']);
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedPage, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();
			
			try {
				// Create new model
				$page = new Page;
	
				// Set our field data
				$page->title = $cleanedPage['title'];
				$page->slug = $cleanedPage['slug'];
				$page->description = $cleanedPage['description'];
				$page->keywords = $this->commaSeparate($cleanedPage['keywords']);
				$page->template_id = $cleanedPage['template_id'];
				$page->status_id = $cleanedPage['status_id'];
				$page->parent_id = ($cleanedPage['parent_id'] == 0) ? null : $cleanedPage['parent_id'];
				$page->hide_from_nav = (isset($cleanedPage['hide_from_nav'])) ? $cleanedPage['hide_from_nav'] : 0;
								
				$page->save();
				
				$pageContents = [];
				
				// Create our new content entries
				foreach ($cleanedPage['templates'][$page->template_id] as $field_id => $data) {
					if (!empty($data)) {
						array_push($pageContents, [
							'field_id' => $field_id,
							'data' => $data,
						]);
					}
				}
				
				// So we can keep track of new content ids
				$contents = [];
				
				// Loop over each row and create new content entries
				foreach ($pageContents as $pageContent) {
					$content = new Content;
					
					$content->field_id = $pageContent['field_id'];
					$content->data = $pageContent['data'];
					
					$content->save();
					
					array_push($contents, $content->id);
				}
				
				$page->setContents($contents);
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

			flash('Page created successfully.', $level = 'success');

			return redirect('/cp/pages');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for editing a page.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @param	int			$templateId
	 * @return 	Response
	 */
	public function edit(Request $request, int $id, int $templateId)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_pages')) {
			$title = 'Edit Page';
			
			$subTitle = 'Pages';
			
			$page = $this->getPage($id);
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Remove Active, Pending, Retired and Suspended keys
			$statuses->forget([0, 1, 2, 6]);
			
			// Used to set template_id
			$templates = $this->getTemplates();
			
			$pageTemplate = $templates->first(function ($template) use ($templateId) {
				return $template->id == $templateId;
			});
		
			$pageTemplate = $this->mapFieldsToFieldTypes($pageTemplate);
			
			if ($page->contents->count() > 0) {
				// now get current page template field values and set defaults / values.
				$pageTemplate = $this->mapContentsToFields($pageTemplate, $page->contents);
			}
			
			return view('cp.pages.edit', compact('currentUser', 'title', 'subTitle', 'page', 'statuses', 'templates', 'pageTemplate'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Updates a specific page.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function update(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_pages')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedPage = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('page');
			
			$rules['slug'] = 'required|string|unique:pages,slug,'.$id.'|max:255';
			
			if (!empty($cleanedPage['hide_from_nav'])) {
				$rules['hide_from_nav'] = 'nullable|integer';
			}
			
			// Grab template fields and create rules based on field type
			$rules = $this->setTemplateFieldRules($rules, $cleanedPage['templates']);
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedPage, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// Get our model
				$page = $this->getPage($id);
				
				// Set our field data
				if ($page->id > 1) {
					$page->title = $cleanedPage['title'];
					$page->slug = $cleanedPage['slug'];
					$page->description = $cleanedPage['description'];
					$page->keywords = $this->commaSeparate($cleanedPage['keywords']);
					$page->template_id = $cleanedPage['template_id'];
					$page->status_id = $cleanedPage['status_id'];
					$page->parent_id = ($cleanedPage['parent_id'] == 0) ? null : $cleanedPage['parent_id'];
					$page->hide_from_nav = (isset($cleanedPage['hide_from_nav'])) ? $cleanedPage['hide_from_nav'] : 0;
				}
				
				$page->updated_at = $this->datetime;
				
				$page->save();
				
				// Loop over all current content entries and delete
				$pageContentIds = $page->contents->pluck('id');
				
				if (count($pageContentIds)) {
					foreach ($pageContentIds as $id) {
						$content = $this->getContent($id);
						
						$content->delete();
					}
				}
				
				$pageContents = [];
				
				// Create our new content entries
				foreach ($cleanedPage['templates'][$page->template_id] as $field_id => $data) {
					if (!empty($data)) {
						array_push($pageContents, [
							'field_id' => $field_id,
							'data' => $data,
						]);
					}
				}
				
				// So we can keep track of new content ids
				$contents = [];
				
				// Loop over each row and create new content entries
				foreach ($pageContents as $pageContent) {
					$content = new Content;
					
					$content->field_id = $pageContent['field_id'];
					$content->data = $pageContent['data'];
					
					$content->save();
					
					array_push($contents, $content->id);
				}
				
				$page->setContents($contents);
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

			flash('Page updated successfully.', $level = 'success');

			return redirect('/cp/pages');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Stores the page and then reloads with the specified template.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function reload(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_pages') || $currentUser->hasPermission('create_pages')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedPage = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('page');
			
			// If we've come from the create view, we wont have an page id yet so skip this rule
			if (!empty($cleanedPage['id'])) {
				$rules['slug'] = 'required|string|unique:pages,slug,'.$cleanedPage['id'].'|max:255';
			}
			
			if (!empty($cleanedPage['hide_from_nav'])) {
				$rules['hide_from_nav'] = 'nullable|integer';
			}
			
			// If we've come from the create view, we wont have an page id yet so skip this rule
			if (!empty($cleanedPage['id'])) {
				// Grab template fields and create rules based on field type
				$rules = $this->setTemplateFieldRules($rules, $cleanedPage['templates']);
			}
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedPage, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// If we've come from the create view, we wont have an page id yet so skip this block
				if (!empty($cleanedPage['id'])) {
					// Get our model
					$page = $this->getPage($cleanedPage['id']);
				
					// Set our field data
					if ($page->id > 1) {
						$page->title = $cleanedPage['title'];
						$page->slug = $cleanedPage['slug'];
						$page->description = $cleanedPage['description'];
						$page->keywords = $this->commaSeparate($cleanedPage['keywords']);
						$page->template_id = $cleanedPage['template_id'];
						$page->status_id = $cleanedPage['status_id'];
						$page->parent_id = ($cleanedPage['parent_id'] == 0) ? null : $cleanedPage['parent_id'];
						$page->hide_from_nav = (isset($cleanedPage['hide_from_nav'])) ? $cleanedPage['hide_from_nav'] : 0;
					}
				
					$page->updated_at = $this->datetime;
				} else {
					// Create our model
					$page = new Page;
					
					$page->title = $cleanedPage['title'];
					$page->slug = $cleanedPage['slug'];
					$page->description = $cleanedPage['description'];
					$page->keywords = $this->commaSeparate($cleanedPage['keywords']);
					$page->template_id = $cleanedPage['template_id'];
					$page->status_id = $cleanedPage['status_id'];
					$page->parent_id = ($cleanedPage['parent_id'] == 0) ? null : $cleanedPage['parent_id'];
					$page->hide_from_nav = (isset($cleanedPage['hide_from_nav'])) ? $cleanedPage['hide_from_nav'] : 0;
				}
				
				$page->save();
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
			
			/**
			 * If the user started off creating a new page and picked a the template as their first action, 
			 * the validation stage above would have stopped the user as the required fields would have or should have been empty. 
			 *
			 * However, because we got as far as here, the page has been saved so instead of returning back to the create view, 
			 * just load the edit view.
			 */
			 
			return redirect('/cp/pages/'.$page->id.'/edit/'.$cleanedPage['template_id']);
		}
		
		abort(403, 'Unauthorised action');
	}	
	
	/**
	 * Updates the pages tree hierarchy.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function tree(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_pages')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedTree = $this->sanitizerInput($request->all());

			$rules['tree'] = 'required|string';

			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedTree, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// https://github.com/etrepat/baum/wiki/Example:-Presenting-a-hierarchy
				$tree = json_decode($cleanedTree['tree'], true);
				
				array_shift($tree);
			
				foreach ($tree as $leaf) {
					$page = $this->getPage($leaf['id']);
				
					$page->parent_id = $leaf['parent_id'];
					$page->depth = $leaf['depth'];
					$page->lft = $leaf['left'];
					$page->rgt = $leaf['right'];
					
					$page->save();
				}
				
				$this->rebuildPages();
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

			flash('Changes saved successfully.', $level = 'success');

			return redirect('/cp/menu');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting a page.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_pages')) {
			$page = $this->getPage($id);
			
			if ($page->id == $id && $id == 1) {
				flash('You cannot delete the '.$page->title.' page.', $level = 'warning');
	
				return redirect('/cp/pages');
			}
			
			if ($page->children()->count() > 0) {
				$title = 'Pages';
			
				$subTitle = '';
			
				flash('You must delete the '.$page->title.' subpages first.', $level = 'warning');
				
				return redirect('/cp/pages');
			} else {
				$title = 'Delete Page';
			
				$subTitle = 'Pages';
			
				return view('cp.pages.delete', compact('currentUser', 'title', 'subTitle', 'page'));
			}
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific page.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_pages')) {
			$page = $this->getPage($id);
		
			if ($page->id == $id && $id == 1) {
				flash('You cannot delete the '.$page->title.' page.', $level = 'warning');

				return redirect('/cp/pages');
			}
		
			DB::beginTransaction();

			try {
				// Loop over all current content entries and delete
				$pageContentIds = $page->contents->pluck('id');
				
				if (count($pageContentIds)) {
					foreach ($pageContentIds as $id) {
						$content = $this->getContent($id);
						
						$content->delete();
					}
				}
				
				$page->delete();
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

			flash('Page deleted successfully.', $level = 'info');

			return redirect('/cp/pages');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushPagesCache() 
	{
		$this->flushCache('pages');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushPageCache($page) 
	{
		$this->flushCache('pages:id:'.$page->id);
	}
}
