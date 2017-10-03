<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use DB;
use Log;
use DirectoryHelper;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Traits\AssetTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
			
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
		
		$hash = $request->get('hash');
		
		$zip = $request->get('zip');
		
		$directory = $request->get('directory') ?? $this->assetsDisk;
		
		$uploadDirectory = '';
		
		if ($directory != $this->assetsDisk) {
			$uploadDirectory = '?directory='.$directory;
		}
		
		if (!empty($hash)) {
			// Get file hash array and JSON encode it
			$hashes = DirectoryHelper::getFileHash($hash);
			
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
				$assets = DirectoryHelper::zipDirectory($zip);
			} else {
				$assets = DirectoryHelper::listDirectory($directory);
			}
			
			$deleteFolderEnabled = true;
			
			// If we are viewing top level folder, remove up icon.
			if ($directory == $this->assetsDisk) {
				$deleteFolderEnabled = false;
				
				unset($assets['..']);
			}
			
			if (count($assets) > 0) {
				$assets = recursiveObject($assets);
			}
			
			$path = DirectoryHelper::getListedPath();
			
			$breadcrumbs = recursiveObject(DirectoryHelper::listBreadcrumbs());
			
			$zipEnabled = DirectoryHelper::isZipEnabled();
			
			$zipDownloadPath = DirectoryHelper::getDirectoryPath();
			
			$messages = collect(recursiveObject(DirectoryHelper::getSystemMessages()));
			
			return view('cp.assets.index', compact('currentUser', 'title', 'subTitle', 'path', 'breadcrumbs', 'deleteFolderEnabled', 'zipEnabled', 'zipDownloadPath', 'messages', 'assets', 'uploadDirectory'));
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
			$directory = $request->get('directory');
			
			if (!empty($directory)) {
				$directory = $this->cleanDirectory($directory);
			} else {
				$directory = DIRECTORY_SEPARATOR;
			}
			
			$title = 'Upload Assets';
		
			$subTitle = 'Assets';
		
			return view('cp.assets.upload', compact('currentUser', 'title', 'subTitle', 'directory'));
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
			// Request has come from Redactor File Upload Plugin so we require some custom validation.	
			} else if ($request->query('type') == 'file') {
				$rules['file'] = 'required|file|max:3000';
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
				
				$rules['directory'] = 'required|string|max:255';
			}
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedAssets, $rules);

			if ($validator->fails()) {
				// Request has come from Redactor Image Upload Plugin so we require some custom validation.
				if ($request->query('type') == 'image' || $request->query('type') == 'file') {
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
				} else {
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
				$directory = $cleanedAssets['directory'];
				
				$directory = $this->cleanDirectory($directory);
				
				foreach ($files as $file) {
					$filename = $file->getClientOriginalName();
					
					// Check if asset exists
					$asset = $this->getAssetByFilename($filename);
					
					// If the assets doesn't exist, then upload it
					if (empty($asset)) {
						$path = $file->storeAs($directory, $filename);
						
						// Create new model
						$asset = new Asset;
						
						$asset->path = $this->buildPath([
							'',
							$this->assetsDisk,
							$path,
						]);
					}
					
					// Update our field data
					$asset->filename = $filename;
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
						'url' => $asset->path,
					]);
				} else {
					return response()->json([
						'id' => $asset->id,
						'filename' => $asset->filename,
						'filelink' => $asset->path,
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
	public function select(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('move_assets')) {
			$directory = $request->get('directory');
			
			if (!empty($directory)) {
				$directory = $this->cleanDirectory($directory);
			} else {
				$directory = DIRECTORY_SEPARATOR;
			}
			
			$directories = [];
			
			array_push($directories, [
				'path' => DIRECTORY_SEPARATOR.$this->assetsDisk,
				'depth' => 1,
			]);

			DirectoryHelper::listDirectoriesRecursive($this->assetsDisk);
			
			$folders = DirectoryHelper::getDirectories();
			
			foreach ($folders as $folder) {
				$depth = count(explode(DIRECTORY_SEPARATOR, $folder));
					
				array_push($directories, [
					'path' => DIRECTORY_SEPARATOR.$folder,
					'depth' => $depth,
				]);
			}
			
			$directories = recursiveObject($directories);
			
			$asset = $this->getAsset($id);
			
			$path = str_replace(DIRECTORY_SEPARATOR.$asset->filename, '', $asset->path);
			
			$title = 'Move Asset';
			
			$subTitle = 'Assets';
			
			return view('cp.assets.move', compact('currentUser', 'title', 'subTitle', 'asset', 'path', 'directory', 'directories'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Moves a specific asset.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function move(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('move_assets')) {
			// Remove any Cross-site scripting (XSS)
			$rules = [];
			
			$cleanedAssets = $this->sanitizerInput($request->all());

			$rules['new_path'] = 'required|string|max:255';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedAssets, $rules);
			
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$asset = $this->getAsset($id);
			
			$old = $this->getPath($asset);
			
			$new = public_path($this->assetsDisk).str_replace(DIRECTORY_SEPARATOR.$this->assetsDisk, '', $cleanedAssets['new_path'].DIRECTORY_SEPARATOR.$asset->filename);
			
			$directory = str_replace(DIRECTORY_SEPARATOR.$this->assetsDisk, $this->assetsDisk, $cleanedAssets['new_path']);
			
			DB::beginTransaction();

			try {
				$asset->path = DIRECTORY_SEPARATOR.str_replace(public_path('uploads'), $this->assetsDisk, $new);
				
				unset($asset->filesize);
				unset($asset->width);
				unset($asset->height);
				
				$asset->save();
			
				rename($old, $new);
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
			
			return redirect('/cp/assets?directory='.$directory);
		}	
		
		abort(403, 'Unauthorised action');
	}
	
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
			
			$directory = $request->get('directory');
			
			if (!empty($directory)) {
				$directory = $this->cleanDirectory($directory);
			} else {
				$directory = DIRECTORY_SEPARATOR;
			}
			
			return view('cp.assets.delete', compact('currentUser', 'title', 'subTitle', 'asset', 'directory'));
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
			$cleanedAssets = $this->sanitizerInput($request->all());
			
			$directory = $cleanedAssets['directory'];
			
			$asset = $this->getAsset($id);
			
			DB::beginTransaction();

			try {
				$path = $this->getPath($asset);
				
				// Delete our file
				array_map('unlink', glob($path));
				
				$asset->delete();
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

			return redirect('/cp/assets?directory='.$this->assetsDisk.$directory);
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating an asset folder.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function folderCreate(Request $request)
	{	
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('move_assets')) {
			$directory = $request->get('directory');
			
			if (!empty($directory)) {
				$directory = $this->cleanDirectory($directory);
			} else {
				$directory = DIRECTORY_SEPARATOR;
			}
			
			$title = 'Create Folder';
			
			$subTitle = 'Assets';
			
			return view('cp.assets.folder.create', compact('currentUser', 'title', 'subTitle', 'directory'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Creates a new asset folder.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function folderStore(Request $request)
	{	
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('move_assets')) {
			// Remove any Cross-site scripting (XSS)
			$rules = [];
			
			$cleanedAssets = $this->sanitizerInput($request->all());
			
			$rules['directory'] = 'required|string|max:255';
			$rules['folder'] = 'required|string|max:255';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedAssets, $rules);
			
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			// Build our directory
			$directory = strtolower($cleanedAssets['directory'].DIRECTORY_SEPARATOR.$cleanedAssets['folder']);
			
			$directory = $this->cleanDirectory($directory);
			
			Storage::disk($this->assetsDisk)->makeDirectory($directory);
					
			flash('Folder created successfully.', $level = 'success');
			
			return redirect('/cp/assets?directory='.$this->assetsDisk.$directory);
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting an folder.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function folderConfirm(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('move_assets')) {
			$directory = $request->get('directory');
			
			if (!empty($directory)) {
				$directory = $this->cleanDirectory($directory);
			} else {
				$directory = DIRECTORY_SEPARATOR;
			}
			
			$folders = explode(DIRECTORY_SEPARATOR, $directory);
			
			$folders = array_reverse($folders);
			
			$folder = $folders[0];
			
			$title = 'Delete Folder';
			
			$subTitle = 'Assets';
			
			return view('cp.assets.folder.delete', compact('currentUser', 'title', 'subTitle', 'folder', 'directory'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes an asset folder.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function folderDelete(Request $request)
	{	
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('move_assets')) {
			// Remove any Cross-site scripting (XSS)
			$rules = [];
			
			$cleanedAssets = $this->sanitizerInput($request->all());
			
			$rules['directory'] = 'required|string|max:255';
			$rules['folder'] = 'required|string|max:255';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedAssets, $rules);
			
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			try {
				$directory = $cleanedAssets['directory'];
				
				$assets = DirectoryHelper::listDirectory($this->assetsDisk.$directory);
				
				if (count($assets) > 0) {
					foreach ($assets as $asset) {
						if (!empty($asset['filename'])) {
							$asset = $this->getAssetByFilename($asset['filename']);
					
							$asset->delete();
						}
					}
				}
				
				// Delete our directory
				Storage::disk($this->assetsDisk)->deleteDirectory($directory);
				
				$directory = strtolower(str_replace(DIRECTORY_SEPARATOR.$cleanedAssets['folder'], '', $directory));
				
				$directory = $this->cleanDirectory($directory);
			} catch (Exception $exception) {
				abort(500, $exception);
			}	
					
			flash('Folder deleted successfully.', $level = 'success');
			
			return redirect('/cp/assets?directory='.$this->assetsDisk.$directory);
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 *
	 * @params	String 		$directory
	 * @return 	String
	 */
	protected function cleanDirectory(string $directory) : string
	{
		$directory = str_replace(['//', $this->assetsDisk], [DIRECTORY_SEPARATOR, ''], $directory);
		
		$directory = (empty($directory)) ? DIRECTORY_SEPARATOR : $directory;
		
		return $directory;
	}
	
	/**
	 * Does what it says on the tin!
	 */
	private function convertToJson($assets, $type = null) : string
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
					'url' => $asset->path,
					'size' => $asset->filesize,
				));
			}
		}
			
		return $json;
	}
	
	/**
	 * Does what it says on the tin!
	 *
	 * @params	Array 		$uris
	 * @return 	String
	 */
	private function buildPath(array $uris) : string
	{
		return implode(DIRECTORY_SEPARATOR, $uris);
	}
	
	/**
	 * Does what it says on the tin!
	 */
	private function filterByImage($assets) : array
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
				'thumb' => $asset->path, 
				'url' => $asset->path,
			));
		}
		
		return $images;
	}
}
