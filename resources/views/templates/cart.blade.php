			<h1>{{ $page->title }}</h1>
			
			{!! $page->content !!}
			
			@if ($savedCarts->count() > 0)
				<h3>Saved Cart</h3>
				<p>You have {{ $savedCarts->count() }} saved cart{{ ($savedCarts->count() == 1) ? '' : 's' }}.</p>
				<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th>Identifier</th>
							<th>Products</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($savedCarts as $savedCart)
							<tr>
								<td>{{ str_replace('_'.$currentUser->id, '', $savedCart->identifier) }}</td>
								<td>{{ $savedCart->content->count() }}</td>
								<td><a href="/cart/restore/{{ $savedCart->identifier }}" title="Restore Cart">Restore Cart</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
			
			<h2>Your Cart</h2>
			@if ($cart->count > 0)
			
				<ul>
					<li><a href="/cart/save" title="Save Cart for Later">Save Cart for Later</a></li>
					<li>
						@component('_components.cart.removeProduct', [
							'product' => (object) [
								'id' => 0,
								'rowId' => ''
							],
							'instance' => 'cart',
							'action' => 'delete_cart',
							'buttonLabel' => 'Empty Cart'
						])
						@endcomponent
					</li>
				</ul>
			
				<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th>Product</th>
							<th>Qty</th>
							<th>Price</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($cart->products as $product)
							<tr>
								<td>
									<span class="productRemove">
										@component('_components.cart.removeProduct', [
											'product' => $product, 
											'instance' => 'cart',
											'action' => 'delete_product',
											'buttonLabel' => 'Remove Product'
										])
										@endcomponent
									</span>
									<span class="productInfo">
										<a href="/products/{{ $product->model->slug }}" title="{{ $product->name }}">{{ $product->name }}</a>
										@if ($product->options->has('size'))
											<span class="productInfoSize">Size: {{ $product->options->size }}</span>
										@endif
									</span>
								</td>
								<td>
									@component('_components.cart.updateProduct', [
										'product' => $product, 
										'instance' => 'cart',
										'quantity' => ($product->qty - 1),
										'buttonLabel' => '-'
									])
									@endcomponent
									
									<span class="productQuantity">{{ $product->qty }}</span>
									
									@component('_components.cart.updateProduct', [
										'product' => $product, 
										'instance' => 'cart',
										'quantity' => ($product->qty + 1),
										'buttonLabel' => '+'
									])
									@endcomponent
								</td>
								<td>{{ $product->price() }}</td>
								<td>{{ $product->total() }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td>Subtotal</td>
							<td>{{ $cart->subtotal }}</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td>Tax</td>
							<td>{{ $cart->tax }}</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td>Total</td>
							<td>{{ $cart->total }}</td>
						</tr>
					</tfoot>
				</table>
				
				<ul>
					<li><a href="/cart/save" title="Save Cart for Later">Save Cart for Later</a></li>
					<li>
						@component('_components.cart.removeProduct', [
							'product' => (object) [
								'id' => 0,
								'rowId' => ''
							],
							'instance' => 'cart',
							'action' => 'delete_cart',
							'buttonLabel' => 'Empty Cart'
						])
						@endcomponent
					</li>
					
				</ul>
				
				
				<p><a href="/cart/checkout" title="Checkout">Checkout</a></p>
				
			@else
				<p>There are currently no items in your cart!</p>
			@endif
			
			<h2>Your Wishlist</h2>
			@if ($wishlistCart->count > 0)
				<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th>Product</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($wishlistCart->products as $product)
							<tr>
								<td>
									<span class="productRemove">
										@component('_components.cart.removeProduct', [
											'product' => $product, 
											'instance' => 'wishlist',
											'action' => 'delete_product',
											'buttonLabel' => 'Remove Product'
										])
										@endcomponent
									</span>
									<span class="productInfo">
										<a href="/products/{{ $product->model->slug }}" title="{{ $product->name }}">{{ $product->name }}</a>
									</span>
									<span class="productAdd">
										@component('_components.cart.addProduct', [
											'product' => $product, 
											'instance' => 'cart', 
											'action' => 'remove_wishlist'
										])
										@endcomponent
									</span>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p>There are currently no items in your wishlist!</p>
			@endif
		