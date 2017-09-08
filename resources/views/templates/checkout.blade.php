			<h1>{{ $page->title }}</h1>
			
			{!! $page->content !!}
			
			@if ($cart->count > 0)
				<form name="createOrder" id="createOrder" class="createOrder" role="form" method="POST" action="/orders">
					{{ csrf_field() }}
					<input type="hidden" name="user_id" value="{{ $currentUser->id }}">
					<div id="accordion" role="tablist">
						<div>
							<div role="tab" id="reviewYourBillingDetails">
								<h5><a data-toggle="collapse" href="#reviewBillingDetails" aria-expanded="true" aria-controls="collapseOne">Review your Billing Details</a></h5>
							</div>
							<div id="reviewBillingDetails" class="collapse show" role="tabpanel" aria-labelledby="reviewYourBillingDetails" data-parent="#accordion">
								<h3>Review your Billing Details</h3>
								<div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<div class="form-group">
											<label for="company" class="control-label font-weight-bold">Company</label>
											<input type="text" name="company" id="company" class="form-control" value="{{ $currentUser->company->title }}" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-6 col-lg-6">
										<div class="form-group">
											<label for="first_name" class="control-label font-weight-bold">First Name</label>
											<input type="text" name="first_name" id="first_name" class="form-control" value="{{ $currentUser->first_name }}" readonly>
										</div>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-6">
										<div class="form-group">
											<label for="last_name" class="control-label font-weight-bold">Last Name</label>
											<input type="text" name="last_name" id="last_name" class="form-control" value="{{ $currentUser->last_name }}" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-6 col-lg-6">
										<div class="form-group">
											<label for="email" class="control-label font-weight-bold">Email Address</label>
											<input type="email" name="email" id="email" class="form-control" value="{{ $currentUser->email }}" readonly>
										</div>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-6">
										<div class="form-group">
											<label for="job_title" class="control-label font-weight-bold">Job Title</label>
											<input type="text" name="job_title" id="job_title" class="form-control" value="{{ $currentUser->job_title }}" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-6 col-lg-6">
										<div class="form-group">
											<label for="telephone" class="control-label font-weight-bold">Telephone</label>
											<input type="tel" name="telephone" id="telephone" class="form-control" value="{{ $currentUser->telephone }}" readonly>
										</div>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-6">
										<div class="form-group">
											<label for="mobile" class="control-label font-weight-bold">Mobile</label>
											<input type="tel" name="mobile" id="mobile" class="form-control" value="{{ $currentUser->mobile }}" readonly>
										</div>
									</div>
								</div>
								<a href="/cp/users/{{ $currentUser->id }}/edit" title="Edit my Details" class="btn btn-outline-secondary">Edit my Details</a>
							</div>
						</div>
						<div>
							<div role="tab" id="reviewYourShippingDetails">
								<h5><a class="collapsed" data-toggle="collapse" href="#reviewShippingDetails" aria-expanded="false" aria-controls="collapseTwo">Review your Shipping Details</a></h5>
							</div>
							<div id="reviewShippingDetails" class="collapse" role="tabpanel" aria-labelledby="reviewYourShippingDetails" data-parent="#accordion">
								<h3>Review your Shipping Details</h3>
								<div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<div class="form-group">
											<label for="location_id" class="control-label font-weight-bold">Shipping Location</label>
											<select name="location_id" id="location_id" class="form-control">
												@foreach ($locations as $location)
													@if (!empty($currentUser->location_id) && !is_null($currentUser->location_id)) 
														@if ($location->id == $currentUser->location->id) 
															@php($selected = ' selected')
														@else	
															@php($selected = '')
														@endif
													@else
														@if ($location->id == $currentUser->company->default_location_id)
															@php($selected = ' selected')
														@else	
															@php($selected = '')
														@endif
													@endif
													<option value="{{ $location->id }}"{{ $selected }}>{{ $location->title }} - {{ $location->postal_address }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<div class="form-group">
											<label for="shipping_method_id" class="control-label font-weight-bold">Shipping Method</label>
											@foreach ($shippingMethods as $shippingMethod)
												<div class="form-check">
													<label for="shipping_method_id-{{ str_slug($shippingMethod->title) }}" class="form-check-label">
														<input type="radio" name="shipping_method_id" id="shipping_method_id-{{ str_slug($shippingMethod->title) }}" class="form-check-input" value="{{ $shippingMethod->id }}" {{ $loop->first ? 'checked' : '' }}>{{ $shippingMethod->title }}
													</label>
												</div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
						<div>
							<div role="tab" id="reviewYourCart">
								<h5><a class="collapsed" data-toggle="collapse" href="#reviewCart" aria-expanded="false" aria-controls="collapseThree">Review your Cart</a></h5>
							</div>
							<div id="reviewCart" class="collapse" role="tabpanel" aria-labelledby="reviewYourCart" data-parent="#accordion">
								<h2>Review your Cart</h2>
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
								@if (!empty($currentUser->location_id) && !is_null($currentUser->location_id) && $currentUser->location->status->id == 7)
								
								@else
									<button type="submit" name="submit" id="submit" title="Place Order" class="btn btn-outline-secondary">Place Order</button>
								@endif
							</div>
						</div>
					</div>
				</form>								
			@else
				<p>There are currently no items in your cart!</p>
				<p><a href="/products" title="Browse our Products">Browse our Products</a></p>
			@endif
