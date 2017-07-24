<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Traits\AssetTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
	use AssetTrait;
	
	protected $folder;
	
	protected $visibility;
	
	protected $publicStorageUrl;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
		
		$this->folder = 'uploads';
	
		$this->visibility = 'public';
		
		$this->publicStorageUrl = env('APP_URL').'/storage';
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
			return view('cp.assets.index', compact('title', 'subTitle'));
		}
	}
	
	// http://demo.directorylister.com/
	
	/*
	public function browse(Request $request)
	{
		$path = $this->buildPath([
			'',
			$this->visibility,
			$this->folder
		]);
		
		$assets = [];
		
		$assets['files'] = $this->getAllFiles($path);
		
		$assets['folders'] = $this->getAllFolders($path);
		
		return $assets;
	}
	*/
	
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
			
			// If its a single file upload ("file" instead of "files"), then user is uploading via modal window so we need to track this.
			$multiple = false;
			
			if (!empty($cleanedAssets['files'])) {
				$multiple = true;
			}
			
			if ($multiple) {
				// Create some custom validation rules
				$files = count($cleanedAssets['files']) - 1;
			
				foreach (range(0, $files) as $index) {
					$rules['files.' . $index] = 'required|file|max:3000';
				}
			} else {
				$rules['file'] = 'required|file|max:3000';
			}
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedAssets, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();
			
			if ($multiple) {
				$files = $cleanedAssets['files'];
			} else {
				// Keep structure consisent so push single asset into an array.
				$files = [];
				
				array_push($files, $cleanedAssets['file']);
			}
				
			try {
				foreach ($files as $file) {
					$originalName = $file->getClientOriginalName();
						
					// Creating asset title based on original name value
					$title = substr($originalName, 0, strripos($originalName, '.'));
				
					$title = str_replace('_', ' ', $title);
				
					$title = ucwords($title);
				
					// Check if asset exists
					$asset = $this->getAssetByOriginalName($originalName);
					
					// If the assets doesn't exist, then upload it
					if (empty($asset)) {
						$path = $file->storeAs($this->folder, $originalName, $this->visibility);
					
						// Create new model
						$asset = new Asset;
						
						// Set our field data
						$asset->hash_name = $file->hashName();
						
						$asset->path = $this->buildPath([
							'',
							$path
						]);
					}
					
					// Update our field data
					$asset->title = $title;
					$asset->original_name = $originalName;
					$asset->mime_type = $file->getClientMimeType();
					$asset->extension = $file->extension();
					$asset->size = $file->getClientSize();
					
					$asset->save();
				}
			} catch (QueryException $queryException) {
				DB::rollback();
			
				Log::info('SQL: '.$queryException->getSql());

				Log::info('Bindings: '.implode(', ', $queryException->getBindings()));
				
				if ($multiple) {
					abort(500, $queryException);
				} else {
					return response()->json([
						'error' => true,
						'queryException' => true,
						'message' => $queryException->getMessage()
					]);
				}
			} catch (Exception $exception) {
				DB::rollback();
				
				if ($multiple) {
					abort(500, $exception);
				} else {
					return response()->json([
						'error' => true,
						'exception' => true,
						'message' => $exception->getMessage()
					]);
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
						'url' => $this->publicStorageUrl.$asset->path
					]);
				} else {
					return response()->json([
						'id' => $asset->id,
						'filename' => $asset->original_name,
						'filelink' => $this->publicStorageUrl.$asset->path
					]);
				}
			}
		//}

		//abort(403, 'Unauthorised action');
	}
	
	private function buildPath(array $uris)
	{
		return implode('/', $uris);
	}
	
	/**
	 * Does what it says on the tin!
	 */
	private function convertToJson($assets, $type = null) 
	{
		$json = [];
		
		if (!empty($type) && $type === 'image') {
			foreach ($assets as $asset) {
				array_push($json, array(
					'id' => $asset['id'],
					'title' => $asset['title'],
					'thumb' => $this->publicStorageUrl.$asset['thumb'],
					'url' => $this->publicStorageUrl.$asset['url'],
				));
			}
		} else {
			foreach ($assets as $asset) {
				array_push($json, array(
					'id' => $asset->id,
					'title' => $asset->title,
					'name' => $asset->original_name,
					'url' => $this->publicStorageUrl.$asset->path,
					'size' => $asset->filesize
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
				'title' => $asset->title, 
				'thumb' => $asset->path, 
				'url' => $asset->path, 
			));
		}
		
		return $images;
	}
	
	/*
	public function getAllFiles($path)
	{
		$files = Storage::allFiles($path);
		
		foreach ($files as &$file) {
			$file = str_replace(['/', $this->visibility, $this->folder], '', $file);
			
			$file = $this->getAssetByOriginalName($file);
			
			$file->thumb = $this->publicStorageUrl.$file->path;
			$file->url = $this->publicStorageUrl.$file->path;
		}
		
		return $files;
	}
	
	public function getAllFolders($path)
	{
		$folders = Storage::allDirectories($path);
	
		foreach ($folders as &$folder) {
			$folder = str_replace(['/', $this->visibility, $this->folder], '', $folder);	
		}
		
		return $folders;
	}
	*/
	
	/**
	 * Does what it says on the tin!
	 */
	public function getFileSize($bytes) 
	{
		$i = floor(log($bytes, 1024));
		
		return round($bytes / pow(1024, $i), [0,0,2,2,3][$i]).['B','kB','MB','GB','TB'][$i];
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
