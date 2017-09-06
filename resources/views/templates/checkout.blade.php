			<h1>{{ $page->title }}</h1>
			
			{!! $page->content !!}
			
			@if ($cart->count > 0)
				<h2>Review your details</h2>
				<ul>
					<li>Full Name: {{ $currentUser->first_name }} {{ $currentUser->last_name }}</li>
					<li>Email: {{ $currentUser->email }}</li>
					<li>Job Title: {{ $currentUser->job_title }}</li>
					<li>Company: {{ $currentUser->company->title }}</li>
				</ul>
				
				<h2>Review your Order</h2>
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
									<span class="productInfo">
										<a href="/products/{{ $product->model->slug }}" title="{{ $product->name }}">{{ $product->name }}</a>
										@if ($product->options->has('size'))
											<span class="productInfoSize">Size: {{ $product->options->size }}</span>
										@endif
									</span>
								</td>
								<td>
									<span class="productQuantity">{{ $product->qty }}</span>
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
				
				@if ($currentUser->location->status->id == 7)
				
				@else
					<form name="createOrder" id="createOrder" class="createOrder" role="form" method="POST" action="/orders">
						{{ csrf_field() }}
						<input type="hidden" name="user_id" value="{{ $currentUser->id }}">
						<button type="submit" name="submit" id="submit" title="Place Order">Place Order</button>
					</form>
				@endif
				
			@else
				<p>There are currently no items in your cart!</p>
				<p><a href="/products" title="Browse our Products">Browse our Products</a></p>
			@endif
