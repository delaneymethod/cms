<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use DB;
use Log;
use Exception;
use App\Models\Carousel;
use Illuminate\Http\Request;
use App\Http\Traits\CarouselTrait;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class CarouselController extends Controller
{
	use CarouselTrait;
  
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
		
		$this->cacheKey = 'carousels';
	}
	
	/**
	 * Get carousels view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
			
		if ($currentUser->hasPermission('view_carousels')) {
			$title = 'Carousels';
			
			$subTitle = '';
			
			$carousels = $this->getCache($this->cacheKey);
			
			if (is_null($carousels)) {
				$carousels = $this->getCarousels();
				
				$this->setCache($this->cacheKey, $carousels);
			}
			
			return view('cp.carousels.index', compact('currentUser', 'title', 'subTitle', 'carousels'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating a new carousel.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function create(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('create_carousels')) {
			$title = 'Create Carousel';
		
			$subTitle = 'Carousels';
			
			return view('cp.carousels.create', compact('currentUser', 'title', 'subTitle'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Creates a new carousel.
	 *
	 * @params Request 	$request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_carousels')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedCarousel = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('carousel');
			
			// At least 1 slide is required
			$rules['slide_1_image'] = 'required|string';
			$rules['slide_1_content'] = 'nullable|string';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedCarousel, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			$slides = [];
			
			foreach ($cleanedCarousel as $key => $value) {
				if (preg_match('/slide_/i', $key)) {
					$slides[$key] = $value;
					
					unset($cleanedCarousel[$key]);
				}
			}
			
			$cleanedCarousel['data'] = collect($slides)->toJson();

			DB::beginTransaction();
			
			try {
				// Create new model
				$carousel = new Carousel;
	
				// Set our field data
				$carousel->title = $cleanedCarousel['title'];
				$carousel->handle = $cleanedCarousel['handle'];
				$carousel->data = $cleanedCarousel['data'];
				
				$carousel->save();
				
				$this->setCache($this->cacheKey, $this->getCarousels());
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

			flash('Carousel created successfully.', $level = 'success');

			return redirect('/cp/carousels');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for editing a carousel.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function edit(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_carousels')) {
			$title = 'Edit Carousel';
			
			$subTitle = 'Carousels';
			
			$carousel = $this->getCarousel($id);
			
			$data = json_decode($carousel->data, true);
			
			$images = [];
			
			$contents = [];
		
			foreach ($data as $key => $value) {
				if (preg_match('/image/i', $key)) {
					$images[] = $value;
				}
				
				if (preg_match('/content/i', $key)) {
					$contents[] = $value;
				}
			}
			
			$slides = [];
				
			foreach ($images as $key => $value) {
				array_push($slides, [
					'slide_'.($key + 1).'_image' => $images[$key],
					'slide_'.($key + 1).'_content' => $contents[$key],
				]);
			}
	
			$carousel->slides = $slides;
			
			return view('cp.carousels.edit', compact('currentUser', 'title', 'subTitle', 'carousel'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Updates a specific carousel.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function update(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('edit_carousels')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedCarousel = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('carousel');
			
			$rules['handle'] = 'required|string|unique:carousels,handle,'.$id.'|max:255';
			
			// At least 1 slide is required
			$rules['slide_1_image'] = 'required|string';
			$rules['slide_1_content'] = 'nullable|string';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedCarousel, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			$slides = [];
			
			foreach ($cleanedCarousel as $key => $value) {
				if (preg_match('/slide_/i', $key)) {
					$slides[$key] = $value;
					
					unset($cleanedCarousel[$key]);
				}
			}
			
			$cleanedCarousel['data'] = collect($slides)->toJson();

			DB::beginTransaction();

			try {
				// Get our model
				$carousel = $this->getCarousel($id);
				
				// Set our field data
				$carousel->title = $cleanedCarousel['title'];
				$carousel->handle = $cleanedCarousel['handle'];
				$carousel->data = $cleanedCarousel['data'];
				$carousel->updated_at = $this->datetime;
				
				$carousel->save();
				
				$this->setCache($this->cacheKey, $this->getCarousels());
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

			flash('Carousel updated successfully.', $level = 'success');

			return redirect('/cp/carousels');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting a carousel.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_carousels')) {
			$carousel = $this->getCarousel($id);
			
			$title = 'Delete Carousel';
			
			$subTitle = 'Carousels';
			
			return view('cp.carousels.delete', compact('currentUser', 'title', 'subTitle', 'carousel'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific carousel.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_carousels')) {
			$carousel = $this->getCarousel($id);
		
			DB::beginTransaction();

			try {
				$carousel->delete();
				
				$this->setCache($this->cacheKey, $this->getCarousels());
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

			flash('Carousel deleted successfully.', $level = 'info');

			return redirect('/cp/carousels');
		}

		abort(403, 'Unauthorised action');
	}
}
