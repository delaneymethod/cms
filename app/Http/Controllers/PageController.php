<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Traits\CartTrait;
use App\Http\Traits\PageTrait;
use App\Http\Traits\StatusTrait;
use App\Http\Traits\TemplateTrait;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
	use CartTrait;
	use PageTrait;
	use StatusTrait;
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
				'page'
			]
		]);
	}
	
	/**
	 * Get a pages view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function page(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		$path = $request->path();
		
		// Cart access requires logged in user
		if ($path == 'cart' && $currentUser == null) {
			return redirect('/login');
		}
		
		// Get the URL segments
		if ($path == '/') {
			$segments = collect([0 => '']);
		} else {
			$segments = collect(explode('/', $request->path()));
		}
		
		// Set slug based on the last segment
		$slug = $segments->last();
		
		// Get the requested page based on slug - if it doesnt exist, a 404 is thrown!
		$page = $this->getPageBySlug($slug);
		
		// Since the requested page was found, then grab all the other pages - builds our navigation and available across all pages
		$pages = $this->getPages();
		
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
		
		// Selects the pages template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'pages', 'cart', 'wishlistCart'));
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
		
			$pages = $this->getPages();
			
			return view('cp.pages.index', compact('currentUser', 'title', 'subTitle', 'pages'));
		}

		abort(403, 'Unauthorised action');
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
			
			$pages = $this->getPagesHierarchy();
			
			return view('cp.menu.index', compact('currentUser', 'title', 'subTitle', 'pages'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating a new page.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function create(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('create_pages')) {
			$title = 'Create Page';
		
			$subTitle = 'Pages';
			
			// Used to set parent_id
			$pages = $this->getPages();
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Remove Active, Pending and Retired keys
			$statuses->forget([0, 1, 2]);
			
			// Used to set template_id
			$templates = $this->getTemplates();
			
			return view('cp.pages.create', compact('currentUser', 'title', 'subTitle', 'pages', 'statuses', 'templates'));
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
			
			// TODO - Grab template layout fields
			
			dd($cleanedPage);
			
			if (!empty($cleanedPage['hide_from_nav'])) {
				$rules['hide_from_nav'] = 'nullable|integer';
			}
			
			$rules = $this->getRules('page');
			
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
	 * @return 	Response
	 */
	public function edit(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_pages')) {
			$title = 'Edit Page';
			
			$subTitle = 'Pages';
			
			$page = $this->getPage($id);
			
			// Used to set parent_id
			$pages = $this->getPages();
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Remove Active, Pending and Retired keys
			$statuses->forget([0, 1, 2]);
			
			// Used to set template_id
			$templates = $this->getTemplates();
			
			return view('cp.pages.edit', compact('currentUser', 'title', 'subTitle', 'page', 'pages', 'statuses', 'templates'));
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
			
			// TODO - Grab template layout fields
			
			$rules = $this->getRules('page');
			
			$rules['slug'] = 'required|string|unique:pages,slug,'.$id.'|max:255';
			
			if (!empty($cleanedPage['hide_from_nav'])) {
				$rules['hide_from_nav'] = 'nullable|integer';
			}
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedPage, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// Create new model
				$page = $this->getPage($id);
				
				// Set our field data
				if ($page->id == 1) {
					$page->content = $cleanedPage['content'];
				} else {
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
