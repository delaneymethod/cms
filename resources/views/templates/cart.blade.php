			<h1>{{ $page->title }}</h1>
			
			{!! $page->content !!}
			
			@php ($totalSavedCarts = $savedCarts->count())
			@if ($totalSavedCarts > 0)
				<h3>Saved Cart</h3>
				<p>You have {{ $totalSavedCarts }} saved cart{{ ($totalSavedCarts == 1) ? '' : 's' }}.</p>
				<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th class="align-middle">Identifier</th>
							<th class="align-middle text-center">Items</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($savedCarts as $savedCart)
							<tr>
								<td class="align-middle">{{ $savedCart->identifier }}</td>
								<td class="align-middle text-center">{{ $savedCart->content->count() }}</td>
								<td class="align-middle text-center"><a href="/cart/restore/{{ $savedCart->identifier }}" title="Restore Cart" class="btn btn-link text-gf-info">Restore Cart</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
			<h2>Your Cart</h2>
			@if ($cart->count > 0)
				<ul class="list-unstyled list-inline">
					<li class="list-inline-item"><a href="/cart/save" title="Save Cart for Later" class="btn btn-outline-secondary">Save Cart for Later</a></li>
					<li class="list-inline-item">
						@component('_components.cart.removeProductCommodity', [
							'id' => 0,
							'rowId' => '',
							'instance' => 'cart',
							'action' => 'delete_cart',
							'buttonLabel' => 'Empty Cart',
							'extraClasses' => 'btn btn-outline-danger'
						])
						@endcomponent
					</li>
					<li class="list-inline-item pull-right"><a href="/cart/checkout" title="Checkout" class="btn btn-primary">Checkout</a></li>
				</ul>
				<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th class="align-middle">&nbsp;</th>
							<th class="align-middle">Product</th>
							<th class="align-middle">Product Commodity</th>
							<th colspan="3" class="align-middle text-center">Qty</th>
							<th class="align-middle text-right">Price</th>
							<th class="align-middle text-right">Subtotal</th>
							<th class="align-middle">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($cart->product_commodities as $productCommodity)
							<tr>
								<td class="align-middle text-center"><a href="{{ $productCommodity->model->product->url }}" title="{{ $productCommodity->model->product->title }}" class="text-gf-info"><img data-src="{{ $productCommodity->model->product->image_url }}" class="lazyload img-fluid" alt="{{ $productCommodity->model->product->title }}"></a></td>
								<td class="align-middle"><a href="{{ $productCommodity->model->product->url }}" title="{{ $productCommodity->model->product->title }}" class="text-gf-info">{{ $productCommodity->model->product->title }}</a></td>
								<td class="align-middle">{{ $productCommodity->name }}</td>
								<td class="align-middle text-center">
									@component('_components.cart.updateProductCommodity', [
										'id' => $productCommodity->id, 
										'rowId' => $productCommodity->rowId,
										'instance' => 'cart',
										'quantity' => ($productCommodity->qty - 1),
										'buttonLabel' => '-',
										'extraClasses' => 'btn btn-outline-info'
									])
									@endcomponent
								</td>
								<td class="align-middle text-center">{{ $productCommodity->qty }}</td>
								<td class="align-middle text-center">
									@component('_components.cart.updateProductCommodity', [
										'id' => $productCommodity->id, 
										'rowId' => $productCommodity->rowId,
										'instance' => 'cart',
										'quantity' => ($productCommodity->qty + 1),
										'buttonLabel' => '+',
										'extraClasses' => 'btn btn-outline-info'
									])
									@endcomponent
								</td>
								<td class="align-middle text-right">{{ $productCommodity->price() }}</td>
								<td class="align-middle text-right">{{ $productCommodity->total() }}</td>
								<td class="align-middle text-center">
									@component('_components.cart.removeProductCommodity', [
										'id' => $productCommodity->id,
										'rowId' => $productCommodity->rowId,
										'instance' => 'cart',
										'action' => 'delete_product_commodity',
										'buttonLabel' => 'Remove',
										'extraClasses' => 'btn btn-link text-gf-red'
									])
									@endcomponent
								</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6">&nbsp;</td>
							<td class="align-middle text-right">Subtotal</td>
							<td class="align-middle text-right">{{ $cart->subtotal }}</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="6">&nbsp;</td>
							<td class="align-middle text-right">Tax</td>
							<td class="align-middle text-right">{{ $cart->tax }}</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="6">&nbsp;</td>
							<td class="align-middle text-right">Total</td>
							<td class="align-middle text-right">{{ $cart->total }}</td>
							<td>&nbsp;</td>
						</tr>
					</tfoot>
				</table>
				<ul class="list-unstyled list-inline">
					<li class="list-inline-item"><a href="/cart/save" title="Save Cart for Later" class="btn btn-outline-secondary">Save Cart for Later</a></li>
					<li class="list-inline-item">
						@component('_components.cart.removeProductCommodity', [
							'id' => 0,
							'rowId' => '',
							'instance' => 'cart',
							'action' => 'delete_cart',
							'buttonLabel' => 'Empty Cart',
							'extraClasses' => 'btn btn-outline-danger'
						])
						@endcomponent
					</li>
					<li class="list-inline-item pull-right"><a href="/cart/checkout" title="Checkout" class="btn btn-primary">Checkout</a></li>
				</ul>
			@else
				<p>There are currently no items in your cart!</p>
			@endif
			<h2>Your Wishlist</h2>
			@if ($wishlistCart->count > 0)
				<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th class="align-middle">Product</th>
							<th class="align-middle">Product Commodity</th>
							<th colspan="2">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($wishlistCart->product_commodities as $productCommodity)
							@php ($productCommodityProduct = $productCommodity->model->product)
							<tr>
								<td class="align-middle text-center"><a href="{{ $productCommodityProduct->url }}" title="{{ $productCommodityProduct->title }}" class="text-gf-info"><img data-src="{{ $productCommodityProduct->image_url }}" class="lazyload img-fluid" alt="{{ $productCommodityProduct->title }}"></a></td>
								<td class="align-middle text-left"><a href="{{ $productCommodityProduct->url }}" title="{{ $productCommodityProduct->title }}" class="text-gf-info">{{ $productCommodityProduct->title }}</a></td>
								<td class="align-middle text-left">{{ $productCommodity->name }}</td>
								<td class="align-middle text-center">	
									@component('_components.cart.addProductCommodity', [
										'id' => $productCommodity->id, 
										'instance' => 'cart', 
										'action' => 'remove_wishlist',
										'extraClasses' => 'btn btn-outline-success',
										'redirectTo' => ''
									])
									@endcomponent
								</td>
								<td class="align-middle text-center">	
									@component('_components.cart.removeProductCommodity', [
										'id' => $productCommodity->id,
										'rowId' => $productCommodity->rowId,
										'instance' => 'wishlist',
										'action' => 'delete_product_commodity',
										'buttonLabel' => 'Remove',
										'extraClasses' => 'btn btn-link text-gf-red'
									])
									@endcomponent
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p>There are currently no items in your wishlist!</p>
			@endif
		