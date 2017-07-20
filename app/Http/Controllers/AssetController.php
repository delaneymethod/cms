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
	 * Get assets view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$page = [];
		
		$page['title'] = 'Assets';
		$page['subTitle'] = '';
		
		$assets = $this->getAssets();
		
		// TODO - filter by "?type="
		
		return view('cp.assets.index', compact('page', 'assets'));
	}
	
	/**
     * Creates a new asset.
     *
	 * @params	Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
		dd($request->all());
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
