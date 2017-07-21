<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Traits\AssetTrait;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
	use AssetTrait;
	
	protected $storagePath;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
		
		$this->storagePath = '/storage/';
	}

	/**
	 * Get assets view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$title = 'Assets';
		
		$subTitle = '';
		
		$assets = $this->getAssets();
		
		$type = $request->get('type');
		
		if (!empty($type) && $type === 'image') {
			$mimeTypes = [
				'image/bmp',
				'image/gif',
				'image/jpeg',
				'image/pjpeg',
				'image/png',
				'image/tiff',
			];
			
			$assets = $assets->whereIn('mime_type', $mimeTypes);
			
			$images = [];
			
			foreach ($assets as $asset) {
				array_push($images, array(
					'id' => $asset->id, 
					'title' => $asset->title, 
					'thumb' => $this->storagePath.$asset->path, 
					'url' => $this->storagePath.$asset->path, 
				));
			}
		}
		
		$format = $request->get('format');
		
		if (!empty($type) && $type === 'image' && !empty($format) && $format === 'json') {
			$json = [];
			
			foreach ($images as $image) {
				array_push($json, array(
					'id' => $image['id'], 
					'title' => $image['title'], 
					'thumb' => $image['thumb'], 
					'url' => $image['url'], 
				));
			}
			
			return response()->json($json);
		}
		
		if (!empty($format) && $format === 'json') {
			$json = [];
			
			foreach ($assets as $asset) {
				array_push($json, array(
					'id' => $asset->id, 
					'title' => $asset->title, 
					'name' => $asset->original_name, 
					'url' => $this->storagePath.$asset->path, 
					'size' => $asset->filesize
				));
			}
			
			return response()->json($json);
		}
		
		return view('cp.assets.index', compact('title', 'subTitle', 'assets'));
	}
	
	/**
	 * Shows a form for uploading files.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function upload(Request $request)
	{
		$title = 'Upload Assets';
		
		$subTitle = 'Assets';
		
		return view('cp.assets.upload', compact('title', 'subTitle'));
	}
	
	/**
     * Creates a new asset.
     *
	 * @params	Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
		//$currentUser = $this->getUser();

		//if ($currentUser->hasPermission('upload_files')) {
			// Remove any Cross-site scripting (XSS)
			$rules = [];
			
			$cleanedAssets = $this->sanitizerInput($request->all());
			
			$files = count($cleanedAssets['files']) - 1;
			
			foreach (range(0, $files) as $index) {
				$rules['files.' . $index] = 'required|file|max:3000';
			}
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedAssets, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				$files = $cleanedAssets['files'];
				
				foreach ($files as $file) {
					$originalName = $file->getClientOriginalName();
					
					$path = $file->storeAs('uploads', $originalName, 'public');
					
					$title = substr($originalName, 0, strripos($originalName, '.'));
					
					$title = str_replace('_', ' ', $title);
					
					$title = ucwords($title);
					
					// Create new model
					$asset = new Asset;
					
					// Set our field data
					$asset->title = $title;
					$asset->original_name = $originalName;
					$asset->hash_name = $file->hashName();
					$asset->mime_type = $file->getClientMimeType();
					$asset->extension = $file->extension();
					$asset->path = $this->storagePath.$path;
					$asset->size = $file->getClientSize();
					$asset->save();
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

			flash('Assets uploaded successfully.', $level = 'success');

			return redirect('/cp/assets');
		//}

		//abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushAssetsCache() 
	{
		$this->flushCache('assets');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushAssetCache($asset) 
	{
		$this->flushCache('assets:id:'.$asset->id);
	}
}
