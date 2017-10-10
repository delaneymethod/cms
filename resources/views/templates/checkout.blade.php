			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			@if (!empty($page->section1Content))
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						{!! $page->section1Content !!}
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
			@endif
			@if ($cart->count > 0)
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
							@if ($step == 'step-1')
								<form name="checkoutStep1" id="checkoutStep1" class="checkoutStep1" role="form" method="POST" action="/cart/checkout/step-1">
									{{ csrf_field() }}
									<input type="hidden" name="user_id" value="{{ $currentUser->id }}">
									<div class="row">
										<div class="col-12">
											<h4>Step 1 - Review your Billing Details</h4>
										</div>
									</div>
									<div class="row">
										<div class="col-12 spacer tall"></div>
									</div>
									<div class="row">
										<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<label for="company" class="control-label">Company</label>
														<input type="text" name="company" id="company" class="form-control" value="{{ $currentUser->company->title }}" readonly>
													</div>
													<div class="form-group">
														<label for="first_name" class="control-label">First Name</label>
														<input type="text" name="first_name" id="first_name" class="form-control" value="{{ $currentUser->first_name }}" readonly>
													</div>
													<div class="form-group">
														<label for="last_name" class="control-label">Last Name</label>
														<input type="text" name="last_name" id="last_name" class="form-control" value="{{ $currentUser->last_name }}" readonly>
													</div>
													<div class="form-group">
														<label for="email" class="control-label">Email Address</label>
														<input type="email" name="email" id="email" class="form-control" value="{{ $currentUser->email }}" readonly>
													</div>
													<div class="form-group">
														<label for="job_title" class="control-label">Job Title</label>
														<input type="text" name="job_title" id="job_title" class="form-control" value="{{ $currentUser->job_title }}" readonly>
													</div>
													<div class="form-group">
														<label for="telephone" class="control-label">Telephone</label>
														<input type="tel" name="telephone" id="telephone" class="form-control" value="{{ $currentUser->telephone }}" readonly>
													</div>
													<div class="form-group">
														<label for="mobile" class="control-label">Mobile</label>
														<input type="tel" name="mobile" id="mobile" class="form-control" value="{{ $currentUser->mobile }}" readonly>
													</div>
												</div>
											</div>
											<div class="spacer"></div>
											<div class="row">
												<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-left text-lg-left text-xl-left">
													<p><a href="/cp/users/{{ $currentUser->id }}/edit?redirectTo=/cart/checkout/step-1" title="Edit my Details" class="btn btn-outline-secondary">Edit my Details</a></p>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-right text-lg-right text-xl-right">
													<button type="submit" name="submit" id="submit" title="Review your Shipping Details" class="btn btn-danger">Review your Shipping Details</button>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 spacer tall"></div>
									</div>
								</form>
							@elseif ($step == 'step-2')
								<form name="checkoutStep2" id="checkoutStep2" class="checkoutStep2" role="form" method="POST" action="/cart/checkout/step-2">
									{{ csrf_field() }}
									<input type="hidden" name="user_id" value="{{ $currentUser->id }}">
									<div class="row">
										<div class="col-12">
											<h4>Step 2 - Review your Shipping Details</h4>
										</div>
									</div>
									<div class="row">
										<div class="col-12 spacer tall"></div>
									</div>
									<div class="row">
										<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<label for="location_id" class="control-label">Shipping Location <span class="text-danger">&#42;</span></label>
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
																@if ($location->id == session()->get('cart.location_id'))
																	@php($selected = ' selected')
																@else	
																	@php($selected = '')
																@endif
																<option value="{{ $location->id }}"{{ $selected }}>{{ $location->title }} - {{ $location->postal_address }}</option>
															@endforeach
														</select>
														<span id="helpBlockLocationId" class="form-control-feedback form-text text-muted"></span>
													</div>
													<div class="form-group">
														<label for="shipping_method_id" class="control-label">Shipping Method <span class="text-danger">&#42;</span></label>
														@foreach ($shippingMethods as $shippingMethod)
															<div class="form-check">
																<label for="shipping_method_id-{{ str_slug($shippingMethod->title) }}" class="form-check-label"><input type="radio" name="shipping_method_id" id="shipping_method_id-{{ str_slug($shippingMethod->title) }}" class="form-check-input" value="{{ $shippingMethod->id }}" aria-describedby="helpBlockShippingMethodId" {{ ($loop->first || $shippingMethod->id == session()->get('cart.shipping_method_id')) ? 'checked' : '' }}>{{ $shippingMethod->title }}</label>
															</div>
														@endforeach
														<span id="helpBlockShippingMethodId" class="form-control-feedback form-text text-muted"></span>
													</div>
													<div class="form-group">
														<label for="notes" class="control-label font-weight-bold">Notes</label>
														<textarea name="notes" id="notes" class="form-control" autocomplete="off" placeholder="" rows="10" aria-describedby="helpBlockNotes">{!! session()->get('cart.notes') !!}</textarea>
														<span id="helpBlockNotes" class="form-control-feedback form-text text-muted"></span>
													</div>
												</div>
											</div>
											<div class="spacer"></div>
											<div class="row">
												<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-left text-lg-left text-xl-left">
													<p><a href="/cart/checkout/step-1" title="Back to Billing Details" class="btn btn-outline-secondary">Back to Billing Details</a></p>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-right text-lg-right text-xl-right">
													<button type="submit" name="submit" id="submit" title="Review your Cart" class="btn btn-danger">Review your Cart</button>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 spacer tall"></div>
									</div>
								</form>	
							@elseif ($step == 'step-3')
								<form name="checkoutStep3" id="checkoutStep3" class="checkoutStep3" role="form" method="POST" action="/orders">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-12">
											<h4>Step 3 - Review your Cart</h4>
										</div>
									</div>
									<div class="row">
										<div class="col-12 spacer tall"></div>
									</div>
									<div class="row">
										<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-12">
													<table class="table table-responsive" cellspacing="0" border="0" cellpadding="0" width="100%">
														<thead>
															<tr class="bg-default text-white very-tall">
																<th class="align-middle">&nbsp;</th>
																<th class="align-middle">Product</th>
																<th class="align-middle text-center">Qty</th>
																<th class="align-middle text-center">Price</th>
																<th class="align-middle text-right">Subtotal</th>
															</tr>
														</thead>
														<tbody>
															@foreach ($cart->product_commodities as $productCommodity)
																@php ($productCommodityProduct = $productCommodity->model->product)
																<tr>
																	<td class="align-middle text-center d-none d-sm-none d-md-block d-lg-block d-xl-block"><a href="{{ $productCommodityProduct->url }}" title="{{ $productCommodityProduct->title }}" target="_blank" class="text-gf-info"><img src="/assets/img/loading.svg" data-src="{{ $productCommodityProduct->image_url }}" class="lazyload img-fluid" width="100px" alt="{{ $productCommodityProduct->title }}"></a></td>
																	<td class="align-middle"><a href="{{ $productCommodityProduct->url }}" title="{{ $productCommodityProduct->title }}" target="_blank">{{ $productCommodity->name }}</a></td>
																	<td class="align-middle text-center">{{ $productCommodity->qty }}</td>
																	<td class="align-middle text-right">{{ $productCommodity->price() }}</td>
																	<td class="align-middle text-right">{{ $productCommodity->total() }}</td>
																</tr>
															@endforeach
														</tbody>
														<tfoot>
															<tr>
																<td colspan="3">&nbsp;</td>
																<td class="align-middle text-right">Subtotal</td>
																<td class="align-middle text-right">{{ $cart->subtotal }}</td>
															</tr>
															<tr>
																<td colspan="3">&nbsp;</td>
																<td class="align-middle text-right">Tax</td>
																<td class="align-middle text-right">{{ $cart->tax }}</td>
															</tr>
															<tr>
																<td colspan="3">&nbsp;</td>
																<td class="align-middle text-right">Total</td>
																<td class="align-middle text-right">{{ $cart->total }}</td>
															</tr>
														</tfoot>
													</table>
													<div class="spacer"></div>
													<div class="form-group col-6">
														<label for="po_number" class="control-label">PO Number <span class="text-danger">&#42;</span></label>
														<input type="text" name="po_number" id="po_number" class="form-control" value="{{ old('po_number') }}" placeholder="e.g 123456789" autocomplete="off" aria-describedby="helpBlockPoNumber" required>
														@if ($errors->has('po_number'))
															<span id="helpBlockPoNumber" class="form-control-feedback form-text gf-red">- {{ $errors->first('po_number') }}</span>
														@endif
														<span id="helpBlockPoNumber" class="form-control-feedback form-text text-muted"></span>
													</div>
												</div>
											</div>
											<div class="spacer"></div>
											<div class="row">
												<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-left text-lg-left text-xl-left">
													<p><a href="/cart/checkout/step-2" title="Back to Shipping Details" class="btn btn-outline-secondary">Back to Shipping Details</a></p>
												</div>
												@if (!optional($currentUser)->isLocationSuspended())
													<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-right text-lg-right text-xl-right">
														<button type="submit" name="submit" id="submit" title="Place Order" class="btn btn-danger">Place Order</button>
													</div>
												@endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 spacer tall"></div>
									</div>
								</form>
							@endif
						</form>								
					</div>
				</div>
			@else
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						<p>There are currently no items in your cart!</p>
						<p><a href="/products" title="Browse our Products">Browse our Products</a></p>
					</div>
				</div>
			@endif
			