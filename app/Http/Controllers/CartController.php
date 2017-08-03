<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\ProductTrait;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
	use ProductTrait;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('guest');
	}
	
	/**
	 * Get cart view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		dd('Cart view');
	}
	
	/**
     * Creates a new cart item.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
		Cart::add(['id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 9.99, 'options' => ['size' => 'large']]);
	}
    
    /**
	 * Updates a specific cart item.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function update(Request $request, int $id)
	{
	}
	
	/**
	 * Deletes a specific cart item.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request, int $id)
	{
	}
}
