<?php

namespace App\Http\Controllers;

use DB;
use Log;
use MediaUploader;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Traits\AssetTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Exceptions\MediaUpload\FileSizeException;
use Plank\Mediable\Exceptions\MediaUpload\FileNotSupportedException;

// http://demo.directorylister.com/
	
class AssetController extends Controller
{
	use AssetTrait;
	
	protected $maxUploadFilesize;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
		
		// 30 MB
		$this->maxUploadFileSize = 30000000;
	}

	/**
	 * Get assets view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		$title = 'Assets';
		
		$subTitle = '';
		
		$type = $request->get('type');
		
		$format = $request->get('format');
		
		// Filter based on type and/or format 
		if (!empty($type) && $type === 'image' && !empty($format) && $format === 'json') {
			$assets = $this->getAssets();
			
			$assets = $this->filterByImage($assets);
			
			$json = $this->convertToJson($assets, $type);
			
			return response()->json($json);
		} else if (!empty($format) && $format === 'json') {
			$assets = $this->getAssets();
			
			$json = $this->convertToJson($assets);
			
			return response()->json($json);
		} else {
			$assets = $this->getAssets();
			
			return view('cp.assets.index', compact('currentUser', 'title', 'subTitle', 'assets'));
		}
	}
	
	/**
	 * Shows a form for uploading files.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function upload(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('upload_assets')) {
			$title = 'Upload Assets';
		
			$subTitle = 'Assets';
		
			return view('cp.assets.upload', compact('currentUser', 'title', 'subTitle'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates a new asset.
     *
	 * @params	Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();
	    
		if ($currentUser->hasPermission('upload_assets')) {
			// Remove any Cross-site scripting (XSS)
			$rules = [];
			
			$cleanedAssets = $this->sanitizerInput($request->all());
			
			// If its a single file upload ("file" instead of "files"), then user is uploading via modal window so we need to track this.
			$multiple = false;
			
			if (!empty($cleanedAssets['files'])) {
				$multiple = true;
			}
			
			/*
			if ($multiple) {
				// Create some custom validation rules
				$files = count($cleanedAssets['files']) - 1;
			
				foreach (range(0, $files) as $index) {
					$rules['files.'.$index] = 'required|file|max:3000';
				}
			} else {
				$rules['file'] = 'required|file|max:3000';
			}
			*/
			
			// Request has come from Redactor so custom validation is required.
			if ($request->query('type') == 'image') {
				// Only allow files of specific extensions ['jpg', 'jpeg', 'png', 'gif'] and under 30MB
				$rules['file'] = 'required|file|max:3000|mimes:jpg,jpeg,png,gif';
				
				// Make sure all the input data is what we actually save
				$validator = $this->validatorInput($cleanedAssets, $rules);

				if ($validator->fails()) {
					$messages = $validator->errors();
					
					$message = '';
					
					if ($messages->has('file')) {
						$message = $messages->get('file');
						
						$message = $message[0];
					}

					return response()->json([
						'error' => true,
						'message' => $message[0]
					]);				
				}
			} else if ($request->query('type') == 'file') {
				$rules['file'] = 'required|file|max:3000';
				
				// Make sure all the input data is what we actually save
				$validator = $this->validatorInput($cleanedAssets, $rules);

				if ($validator->fails()) {
					$messages = $validator->errors();
					
					$message = '';
					
					if ($messages->has('file')) {
						$message = $messages->get('file');
						
						$message = $message[0];
					}

					return response()->json([
						'error' => true,
						'message' => $message[0]
					]);
				}
			}

			DB::beginTransaction();
			
			if ($multiple) {
				$files = $cleanedAssets['files'];
			} else {
				// Keep structure consistent so push single asset into an array.
				$files = [];
				
				array_push($files, $cleanedAssets['file']);
			}
				
			foreach ($files as $file) {
				try {
					$asset = MediaUploader::fromSource($file)->setMaximumSize($this->maxUploadFileSize)->upload();
				} catch (FileNotSupportedException $fileNotSupportedException) {
					$errors = [
						'files' => $fileNotSupportedException->getMessage()
					];
					
					return back()->withErrors($errors)->withInput();
				} catch (FileSizeException $fileSizeException) {
					$errors = [
						'files' => $fileSizeException->getMessage()
					];
					
					return back()->withErrors($errors)->withInput();
				}		
			}
			
			DB::commit();
			
			if ($multiple) {
				flash('Assets uploaded successfully.', $level = 'success');

				return redirect('/cp/assets');
			} else {
				$type = $request->get('type');
				
				if (!empty($type) && $type === 'image') {
					return response()->json([
						'id' => $asset->id,
						'url' => $asset->getUrl()
					]);
				} else {
					return response()->json([
						'id' => $asset->id,
						'filename' => $asset->filename,
						'filelink' => $asset->getUrl()
					]);
				}
			}
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	private function convertToJson($assets, $type = null) 
	{
		$json = [];
		
		if (!empty($type) && $type === 'image') {
			foreach ($assets as $asset) {
				array_push($json, $asset);
			}
		} else {
			foreach ($assets as $asset) {
				array_push($json, array(
					'id' => $asset->id,
					'title' => $asset->filename,
					'name' => $asset->filename,
					'url' => $asset->getUrl(),
					'size' => $asset->filesize,
				));
			}
		}
			
		return $json;
	}
	
	/**
	 * Does what it says on the tin!
	 */
	private function filterByImage($assets)
	{
		$images = [];
		
		$mimeTypes = [
			'image/jpg',
			'image/jpeg',
			'image/png',
			'image/gif',
		];
			
		$assets = $assets->whereIn('mime_type', $mimeTypes);
			
		foreach ($assets as $asset) {
			array_push($images, array(
				'id' => $asset->id, 
				'title' => $asset->filename, 
				'thumb' => $asset->getUrl(), 
				'url' => $asset->getUrl(), 
			));
		}
		
		return $images;
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
