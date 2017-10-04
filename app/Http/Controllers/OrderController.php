<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use DB;
use Log;
use App;
use Exception;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Jobs\ProcessOrderJob;
use App\Events\OrderUpdatedEvent;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Traits\{CartTrait, OrderTrait, StatusTrait, OrderTypeTrait, ShippingMethodTrait};

class OrderController extends Controller
{
	use CartTrait, OrderTrait, StatusTrait, OrderTypeTrait, ShippingMethodTrait;
	
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
				'webhook'
			]
		]);
	}

	/**
	 * Get orders view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_orders')) {
			$title = 'Orders';
		
			$subTitle = $currentUser->company->title;
		
			$orders = $this->getOrders();
			
			$orders = $this->filterOrders($orders);
			
			return view('cp.orders.index', compact('currentUser', 'title', 'subTitle', 'orders'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows an order.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function show(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_orders')) {
			$order = $this->getOrder($id);
			
			$this->authorize('userOwnsThis', $order);
			
			$title = 'View Order';
		
			$subTitle = 'Orders';
			
			return view('cp.orders.show', compact('currentUser', 'title', 'subTitle', 'order'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates a new order.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_orders')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedOrder = $this->sanitizerInput($request->all());
			
			// Get the cart instance
			$cart = $this->getCartInstance('cart');
			
			$cleanedOrder['user_id'] = $request->session()->get('cart.user_id');
			
			$cleanedOrder['location_id'] = $request->session()->get('cart.location_id');
			
			$cleanedOrder['shipping_method_id'] = $request->session()->get('cart.shipping_method_id');
			
			$cleanedOrder['notes'] = $request->session()->get('cart.notes');
			
			// Create our order based on cart content
			$cleanedOrder['product_commodities'] = [];
			
			foreach ($cart->product_commodities as $productCommodity) {
				array_push($cleanedOrder['product_commodities'], [
					'product_commodity_id' => $productCommodity->id,
					'quantity' => $productCommodity->qty,
					'price' => $productCommodity->price,
					'price_tax' => $productCommodity->priceTax,
					'tax_rate' => $productCommodity->taxRate,
				]);
			}
			
			$cleanedOrder['count'] = $cart->count;
			$cleanedOrder['tax'] = $cart->tax;
			$cleanedOrder['subtotal'] = $cart->subtotal;
			$cleanedOrder['total'] = $cart->total;
			
			$productCommodities = count($cart->product_commodities) - 1;
			
			// Set some dynamic rules to valid our order
			$rules = [];
			
			foreach (range(0, $productCommodities) as $index) {
				$rules['product_commodities.'.$index.'.product_commodity_id'] = 'required|integer';
				$rules['product_commodities.'.$index.'.quantity'] = 'required|integer';
				$rules['product_commodities.'.$index.'.price'] = 'required|numeric';
				$rules['product_commodities.'.$index.'.price_tax'] = 'required|numeric';
				$rules['product_commodities.'.$index.'.tax_rate'] = 'required|numeric';
			}
			
			$rules['count'] = 'required|integer';
			$rules['tax'] = 'required|numeric';
			$rules['subtotal'] = 'required|numeric';
			$rules['total'] = 'required|numeric';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedOrder, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			DB::beginTransaction();
			
			try {
				// Create new model
				$order = new Order;
				
				$orderType = $this->getOrderTypeBySlug('web');
				
				$status = $this->getStatusByTitle('Pending');
				
				// Set our field data
				$order->order_number = time();
				$order->order_type_id = $orderType->id;
				$order->po_number = $cleanedOrder['po_number'];
				$order->shipping_method_id = $cleanedOrder['shipping_method_id'];
				$order->user_id = $cleanedOrder['user_id'];
				$order->location_id = $cleanedOrder['location_id'];
				$order->status_id = $status->id;
				$order->notes = $cleanedOrder['notes'];
				$order->count = $cleanedOrder['count'];
				$order->tax = $cleanedOrder['tax'];
				$order->subtotal = $cleanedOrder['subtotal'];
				$order->total = $cleanedOrder['total'];
				
				$order->save();
				
				$order->setProductCommodities($cleanedOrder['product_commodities']);
				
				$request->session()->forget('cart.user_id');
			
				$request->session()->forget('cart.location_id');
				
				$request->session()->forget('cart.shipping_method_id');
				
				$request->session()->forget('cart.notes');
			
				// finally empty the cart instance
				$this->destroyCart();
				
				$minutes = config('cms.delays.jobs');
				
				$time = Carbon::now()->addMinutes($minutes);
				
				// Dispatches a new job to process the order. Sticks the job in the "orders" queue to run in 10 minutes.
				ProcessOrderJob::dispatch($order)->delay($time)->onQueue('orders.jobs');
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

			return redirect('/cart/checkout/confirmation');
		}

		abort(403, 'Unauthorised action');
    }
    
    /**
     * Creates a PDF version of an order.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function pdf(Request $request, int $id) 
    {
	    $currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_orders')) {
			$order = $this->getOrder($id);
			
			$this->authorize('userOwnsThis', $user);
			
			$pdf = app()->make('snappy.pdf.wrapper');
			
			$template = '';
			$template .= '<!doctype html>';
			$template .= '<html lang="en">';
			$template .= '<head>';
			$template .= '	<meta charset="utf-8">';
			$template .= '	<title>'.$order->order_number.' Order Details</title>';
			$template .= '</head>';
			$template .= '<body>';
			$template .= '	<p><strong>Order Type</strong></p>';
			$template .= '	<p>'.$order->order_type->title.'</p>';
			$template .= '	<p><strong>Order Number</strong></p>';
			$template .= '	<p>'.$order->order_number.'</p>';
			$template .= '	<p><strong>PO Number</strong></p>';
			$template .= '	<p>'.$order->po_number.'</p>';
			$template .= '	<p><strong>Order Status</strong></p>';
			$template .= '	<p>'.$order->status->title.'</p>';
			$template .= '	<p><strong>Order Date</strong></p>';
			$template .= '	<p>'.$order->created_at.'</p>';
			$template .= '	<p><strong>Originator</strong></p>';
			$template .= '	<p>'.$order->user->first_name.' '.$order->user->last_name.'<br>'.$order->user->email.'<br>'.$order->user->telephone.' / '.$order->user->mobile.'<br>'.$order->user->company->title.'</p>';
			$template .= '	<p><strong>Order Shipping Method</strong></p>';
			$template .= '	<p>'.$order->shipping_method->title.'</p>';
			$template .= '	<p><strong>Order Shipping Location</strong></p>';
			$template .= '	<p>'.nl2br($order->postal_address).'<br>'.$order->user->telephone.'</p>';
			$template .= '	<p><strong>Order Notes</strong></p>';
			$template .= '	<p>'.$order->notes.'</p>';
			$template .= '	<p><strong>Order Items</strong></p>';
			$template .= '	<table cellspacing="0" border="1" cellpadding="10" width="100%">';
			$template .= '		<thead>';
			$template .= '			<tr>';
			$template .= '				<th align="left">Title</th>';
			$template .= '				<th>Qty</th>';
			$template .= '				<th align="right">Tax</th>';
			$template .= '				<th align="right">Price</th>';
			$template .= '				<th align="right">Total</th>';
			$template .= '			</tr>';
			$template .= '		</thead>';
			$template .= '		<tbody>';
					
			foreach ($order->product_commodities as $productCommodity) {
				$template .= '			<tr>';
				$template .= '				<td>'.$productCommodity->title.'</td>';
				$template .= '				<td align="center">'.$productCommodity->pivot->quantity.'</td>';
				$template .= '				<td align="right">'.$productCommodity->pivot->tax_rate.'&#37;</td>';
				$template .= '				<td align="right">'.$order->currency.number_format($productCommodity->pivot->price, 2, '.', ',').'</td>';
				$template .= '				<td align="right">'.$order->currency.number_format($productCommodity->pivot->price_tax, 2, '.', ',').'</td>';
				$template .= '			</tr>';
			}
				
			$template .= '		</tbody>';
			$template .= '	</table>';
			$template .= '</body>';
			$template .= '</html>';
			
			$pdf->loadHTML($template);
			
			// return $pdf->inline();
			
			return $pdf->download($order->order_number.'.pdf');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Receives a webhook notification from 3rd party applications/services
     *
	 * @params Request 	$request
     * @return Response
     */
    public function webhook(Request $request) 
    {
	    $cleanedEvent = $this->sanitizerInput($request->all());
	    
	    if (!empty($cleanedEvent['event_id'])) {
			switch ($cleanedEvent['event_type']) {
				case 'orders.updated':
					$orders = $cleanedEvent['data'];
				
					collect($orders)->each(function ($data) {
						// Grab and update it
						$order = Order::find($data['id']);
						
						if ($order) {
							// Mass assignment
							$order->fill($data);
						
							$order->save();
						
							OrderUpdatedEvent::dispatch($order, $order->user);
						}
					});
					
					break;
			}
		}
	}
}
