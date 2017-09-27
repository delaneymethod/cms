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
											<select name="location_id" id="location_id" class="form-control" aria-describedby="helpBlockLocationId">
												@foreach ($locations as $location)
													@if (optional($currentUser)->location_id) 
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
											<span id="helpBlockLocationId" class="form-control-feedback form-text text-muted"></span>
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
														<input type="radio" name="shipping_method_id" id="shipping_method_id-{{ str_slug($shippingMethod->title) }}" class="form-check-input" value="{{ $shippingMethod->id }}" aria-describedby="helpBlockShippingMethodId" {{ $loop->first ? 'checked' : '' }}>{{ $shippingMethod->title }}
													</label>
												</div>
											@endforeach
											<span id="helpBlockShippingMethodId" class="form-control-feedback form-text text-muted"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<div class="form-group">
											<label for="notes" class="control-label font-weight-bold">Notes</label>
											<textarea name="notes" id="notes" class="form-control" autocomplete="off" placeholder="" rows="5" cols="50" aria-describedby="helpBlockNotes"></textarea>
											<span id="helpBlockNotes" class="form-control-feedback form-text text-muted"></span>
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
								<h3>Review your Cart</h3>
								<div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
											<thead>
												<tr>
													<th class="align-middle">&nbsp;</th>
													<th class="align-middle">Product</th>
													<th class="align-middle">Product Commodity</th>
													<th class="align-middle text-center">Qty</th>
													<th class="align-middle text-center">Price</th>
													<th class="align-middle text-right">Subtotal</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($cart->product_commodities as $productCommodity)
													<tr>
														<td class="align-middle text-center"><a href="{{ $productCommodity->model->product->url }}" title="{{ $productCommodity->model->product->title }}" target="_blank" class="text-gf-info"><img src="{{ $productCommodity->model->product->image_url }}" class="img-fluid" alt="{{ $productCommodity->model->product->title }}"></a></td>
														<td class="align-middle"><a href="{{ $productCommodity->model->product->url }}" title="{{ $productCommodity->model->product->title }}" target="_blank">{{ $productCommodity->model->product->title }}</a></td>
														<td class="align-middle">{{ $productCommodity->name }}</td>
														<td class="align-middle text-center">{{ $productCommodity->qty }}</td>
														<td class="align-middle text-right">{{ $productCommodity->price() }}</td>
														<td class="align-middle text-right">{{ $productCommodity->total() }}</td>
													</tr>
												@endforeach
											</tbody>
											<tfoot>
												<tr>
													<td colspan="4">&nbsp;</td>
													<td class="align-middle text-right">Subtotal</td>
													<td class="align-middle text-right">{{ $cart->subtotal }}</td>
												</tr>
												<tr>
													<td colspan="4">&nbsp;</td>
													<td class="align-middle text-right">Tax</td>
													<td class="align-middle text-right">{{ $cart->tax }}</td>
												</tr>
												<tr>
													<td colspan="4">&nbsp;</td>
													<td class="align-middle text-right">Total</td>
													<td class="align-middle text-right">{{ $cart->total }}</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-6 col-lg-6">
										<div class="form-group">
											<label for="po_number" class="control-label font-weight-bold">PO Number <span class="text-danger">&#42;</span></label>
											<input type="text" name="po_number" id="po_number" class="form-control" value="{{ old('po_number') }}" placeholder="e.g 123456789" autocomplete="off" aria-describedby="helpBlockPoNumber" required>
											@if ($errors->has('po_number'))
												<span id="helpBlockPoNumber" class="form-control-feedback form-text gf-red">- {{ $errors->first('po_number') }}</span>
											@endif
											<span id="helpBlockPoNumber" class="form-control-feedback form-text text-muted"></span>
										</div>
									</div>
								</div>
								<div class="form-buttons">
									@if (!optional($currentUser)->isLocationSuspended())
										<button type="submit" name="submit" id="submit" title="Place Order" class="btn btn-outline-secondary">Place Order</button>
									@endif
								</div>
							</div>
						</div>
					</div>
				</form>								
			@else
				<p>There are currently no items in your cart!</p>
				<p><a href="/products" title="Browse our Products">Browse our Products</a></p>
			@endif
