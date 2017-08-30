<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Traits\AssetTrait;
use App\Helpers\DirectoryLister;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
			
class AssetController extends Controller
{
	use AssetTrait;
	
	protected $maxUploadFilesize;
	
	protected $mediaCollection;
	
	protected $directoryLister;
	
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
		
		$this->mediaCollection = 'assets';
		
		$this->directoryLister = new DirectoryLister();
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
		
		$hash = $request->get('hash');
		
		$zip = $request->get('zip');
		
		$directory = $request->get('directory');
		
		if (!empty($hash)) {
			// Get file hash array and JSON encode it
			$hashes = $this->directoryLister->getFileHash($hash);
			
			// Return the data
			return response()->json($hashes);
		}
		
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
			$assets = [];
			
			if (!empty($zip)) {
				$assets = $this->directoryLister->zipDirectory($zip);
			} else {
				if (!empty($directory)) {
					$assets = $this->directoryLister->listDirectory($directory);
				} else {
					$assets = $this->directoryLister->listDirectory('uploads');
				}
			}
			
			$assets = $this->recursiveObject($assets);
			
			$path = $this->directoryLister->getListedPath();
			
			$breadcrumbs = $this->recursiveObject($this->directoryLister->listBreadcrumbs());
			
			$zipEnabled = $this->directoryLister->isZipEnabled();
			
			$zipDownloadPath = $this->directoryLister->getDirectoryPath();
			
			$messages = collect($this->recursiveObject($this->directoryLister->getSystemMessages()));
			
			return view('cp.assets.index', compact('currentUser', 'title', 'subTitle', 'path', 'breadcrumbs', 'zipEnabled', 'zipDownloadPath', 'messages', 'assets'));
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
			
			// Request has come from Redactor Image Upload Plugin so we require some custom validation.
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
			// Request has come from Redactor File Upload Plugin so we require some custom validation.	
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
			// Request has come from the Assets upload view so standard validation	
			} else {
				if ($multiple) {
					// Create some custom validation rules
					$files = count($cleanedAssets['files']) - 1;
			
					foreach (range(0, $files) as $index) {
						$rules['files.'.$index] = 'required|file|max:3000';
					}
				} else {
					$rules['file'] = 'required|file|max:3000';
				}
				
				// Make sure all the input data is what we actually save
				$validator = $this->validatorInput($cleanedAssets, $rules);

				if ($validator->fails()) {
					return back()->withErrors($validator)->withInput();
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
			
			try {	
				foreach ($files as $file) {
					$asset = new Asset;
					
					$asset->save();
					
					$asset->addMedia($file)->toMediaCollection($this->mediaCollection);
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
				
				$asset->media = $asset->getMedia($this->mediaCollection)->first();
				
				if (!empty($type) && $type === 'image') {
					return response()->json([
						'id' => $asset->id,
						'url' => $asset->media->getUrl()
					]);
				} else {
					return response()->json([
						'id' => $asset->id,
						'filename' => $asset->media->file_name,
						'filelink' => $asset->media->getUrl()
					]);
				}
			}
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for selecting an assets folder.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function where(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('move_assets')) {
			$asset = $this->getAsset($id);
			
			$title = 'Move Asset';
			
			$subTitle = 'Assets';
			
			$directories = [];
			
			$directories[] = array(
				'title' => 'Top Level',
				'path' => 'uploads/',
			);
			
			$folders = Storage::disk('uploads')->allDirectories();
			
			dump($folders);
			
			foreach ($folders as $folder) {
				array_push($directories, array(
					'title' => $folder,
					'path' => 'uploads/'.$folder,
				));	
			}
			
			dd($directories);
			
			return view('cp.assets.move', compact('currentUser', 'title', 'subTitle', 'asset', 'directories'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Moves a specific asset.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 *
   	public function move(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('move_assets')) {
			$asset = $this->getAsset($id);
			
			$directory = '';

			DB::beginTransaction();

			try {
				$asset->move($directory);
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

			flash('Asset moved successfully.', $level = 'info');

			return redirect('/cp/assets');
		}

		abort(403, 'Unauthorised action');
	}
	*/
	
	/**
	 * Shows a form for deleting an asset.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_assets')) {
			$asset = $this->getAsset($id);
			
			$title = 'Delete Asset';
			
			$subTitle = 'Assets';
			
			return view('cp.assets.delete', compact('currentUser', 'title', 'subTitle', 'asset'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific asset.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_assets')) {
			$asset = $this->getAsset($id);
			
			DB::beginTransaction();

			try {
				$asset->forceDelete();
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

			flash('Asset deleted successfully.', $level = 'info');

			return redirect('/cp/assets');
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
					'title' => $asset->media->name,
					'name' => $asset->media->file_name,
					'url' => $asset->media->getUrl(),
					'size' => $asset->media->human_readable_size,
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
		
		$assets = $assets->filter(function ($asset) {
			return starts_with($asset->media->mime_type, 'image');
		});
		
		foreach ($assets as $asset) {
			array_push($images, array(
				'id' => $asset->id,
				'title' => $asset->media->name,
				'thumb' => $asset->media->getUrl('redactor'),
				'url' => $asset->media->getUrl(),
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
