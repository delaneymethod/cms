<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Traits\PageTrait;
use App\Http\Traits\StatusTrait;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
	use PageTrait;
	use StatusTrait;
	
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
		$page = [];
		
		$page['title'] = 'Pages';
		$page['subTitle'] = '';
		
		$pages = $this->getPages();
		
		return view('cp.pages.index', compact('page', 'pages'));
	}
	
	/**
	 * Get menu view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function menu(Request $request)
	{
		$page = [];
		
		$page['title'] = 'Menu';
		$page['subTitle'] = '';
		
		$pages = $this->getPagesHierarchy();
		
		return view('cp.menu.index', compact('page', 'pages'));
	}
	
	/**
	 * Shows a form for creating a new page.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
		$page = [];
		
		$page['title'] = 'Create Page';
		$page['subTitle'] = 'Pages';
		
		// Used to set parent_id
		$pages = $this->getPages();
		
		// Used to set status_id
		$statuses = $this->getStatuses();
		
		return view('cp.pages.create', compact('page', 'pages', 'statuses'));
	}
	
	/**
     * Creates a new page.
     *
	 * @params	Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
		//$currentUser = $this->getUser();

		//if ($currentUser->hasPermission('edit_pages')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedPage = $this->sanitizerInput($request->all());

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
				$page->status_id = $cleanedPage['status_id'];
				$page->content = $cleanedPage['content'];
				$page->parent_id = $cleanedPage['parent_id'];
				
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

			flash('Created successfully.', $level = 'success');

			return redirect('/cp/pages');
		//}

		//abort(403, 'Unauthorised action');
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
		return view('cp.pages.edit', compact('id'));
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
	}
	
	/**
	 * Updates the pages tree hierarchy.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function tree(Request $request)
	{
		//$currentUser = $this->getUser();

		//if ($currentUser->hasPermission('edit_pages')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedTree = $this->sanitizerInput($request->all());

			$rules = $this->getRules('tree');

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

			flash('Saved successfully.', $level = 'success');

			return redirect('/cp/menu');
		//}

		//abort(403, 'Unauthorised action');
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
