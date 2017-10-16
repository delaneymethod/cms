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
					<div class="col-12 spacer"></div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"><hr></div>
				</div>
			@endif
			@if ($cart->count > 0)
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row">
					<div class="col-12">
						@if ($step == 'step-1')
							<form name="checkoutStep1" id="checkoutStep1" class="checkoutStep1" role="form" method="POST" action="/cart/checkout/step-1">
								{{ csrf_field() }}
								<input type="hidden" name="user_id" value="{{ $currentUser->id }}">
								<input type="hidden" name="location_id" value="{{ session()->get('cart.location_id') }}">
								<input type="hidden" name="shipping_method_id" value="{{ session()->get('cart.shipping_method_id') }}">
								<input type="hidden" name="notes" value="{{ session()->get('cart.notes') }}">
								<input type="hidden" name="po_number" value="{{ session()->get('cart.po_number') }}">
								<div class="row d-flex">
									<div class="col-12 col-sm-12 col-md-7 col-lg-8 col-xl-8 order-2 order-sm-2 order-md-1 order-lg-1 order-xl-1">
										<div class="row bg-lighter-grey">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 text-center text-sm-center text-md-center text-lg-left text-xl-left">
												<h4>Step 1 of 3 <small class="text-muted d-block d-sm-inline-block">Billing Details</small></h4>
											</div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 spacer tall"></div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12">
												<div class="form-group">
													<label for="location_id" class="control-label">Billing Address <span class="text-danger">&#42;</span></label>
													<select name="location_id" id="location_id" class="form-control" aria-describedby="helpBlockLocationId" readonly>
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
									</div>
									<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 ml-auto text-center text-sm-center text-md-right text-lg-right text-xl-right order-1 order-sm-1 order-md-2 order-lg-2 order-xl-2">
										<div class="row">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h4>Your Order</h4>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer tall"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h5 class="text-danger">Customer Details</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<p>{{ $currentUser->first_name }} {{ $currentUser->last_name }}<br><a href="mailto:{{ $currentUser->email }}" title="Email">{{ $currentUser->email }}</a><br>{{ $currentUser->company->title }}<br>{{ $currentUser->job_title }}<br>{{ $currentUser->telephone }}<br>{{ $currentUser->mobile }}</p>
											</div>
											<div class="col-12">
												<a href="/cp/users/{{ $currentUser->id }}/edit?redirectTo=/cart/checkout/step-1" title="Edit Details" class="btn btn-outline-secondary">Edit Details</a>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row">
											<div class="col-12 spacer very-tall d-block d-sm-block d-md-none d-lg-none d-xl-none"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"></div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"><hr></div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"></div>
								</div>
								<div class="row">
									<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center text-sm-left text-md-left text-lg-left text-xl-left">
										<a href="/cart" title="Back to Cart" class="btn btn-outline-secondary">Back to Cart</a>
										<div class="spacer d-block d-sm-none d-md-none d-lg-none d-xl-none"></div>
									</div>
									<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center text-sm-right text-md-right text-lg-right text-xl-right">
										<button type="submit" name="goToStep2" id="go-to-step-2" value="goToStep2" title="Proceed to Step 2" class="btn btn-danger">Proceed to Step 2</button>
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
								<input type="hidden" name="po_number" value="{{ session()->get('cart.po_number') }}">
								<div class="row d-flex">
									<div class="col-12 col-sm-12 col-md-7 col-lg-8 col-xl-8 order-2 order-sm-2 order-md-1 order-lg-1 order-xl-1">
										<div class="row bg-lighter-grey">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 text-center text-sm-center text-md-center text-lg-left text-xl-left">
												<h4>Step 2 of 3 <small class="text-muted d-block d-sm-inline-block">Shipping Details</small></h4>
											</div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 spacer tall"></div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12">
												<div class="form-group">
													<label for="location_id" class="control-label">Shipping Address <span class="text-danger">&#42;</span></label>
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
												<div class="spacer"></div>
												<div class="form-group">
													<label for="shipping_method_id" class="control-label">Shipping Method <span class="text-danger">&#42;</span></label>
													@foreach ($shippingMethods as $shippingMethod)
														<div class="form-check">
															<label for="shipping_method_id-{{ str_slug($shippingMethod->title) }}" class="form-check-label"><input type="radio" name="shipping_method_id" id="shipping_method_id-{{ str_slug($shippingMethod->title) }}" class="form-check-input" value="{{ $shippingMethod->id }}" aria-describedby="helpBlockShippingMethodId" {{ ($loop->first || $shippingMethod->id == session()->get('cart.shipping_method_id')) ? 'checked' : '' }}>{{ $shippingMethod->title }}</label>
														</div>
													@endforeach
													<span id="helpBlockShippingMethodId" class="form-control-feedback form-text text-muted"></span>
												</div>
												<div class="spacer"></div>
												<div class="form-group">
													<label for="notes" class="control-label font-weight-bold">Notes</label>
													<textarea name="notes" id="notes" class="form-control" autocomplete="off" placeholder="" rows="10" aria-describedby="helpBlockNotes">{!! session()->get('cart.notes') !!}</textarea>
													<span id="helpBlockNotes" class="form-control-feedback form-text text-muted"></span>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer"></div>
										</div>
									</div>
									<div class="col-12 spacer d-block d-sm-block d-md-none d-lg-none d-xl-none"></div>
									<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 ml-auto text-center text-sm-center text-md-right text-lg-right text-xl-right order-1 order-sm-1 order-md-2 order-lg-2 order-xl-2">
										<div class="row">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h4>Your Order</h4>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer tall"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h5 class="text-danger">Customer Details</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<p>{{ $currentUser->first_name }} {{ $currentUser->last_name }}<br><a href="mailto:{{ $currentUser->email }}" title="Email">{{ $currentUser->email }}</a><br>{{ $currentUser->company->title }}<br>{{ $currentUser->job_title }}<br>{{ $currentUser->telephone }}<br>{{ $currentUser->mobile }}</p>
											</div>
											<div class="col-12">
												<a href="/cp/users/{{ $currentUser->id }}/edit?redirectTo=/cart/checkout/step-2" title="Edit Details" class="btn btn-outline-secondary">Edit Details</a>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer very-tall"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h5 class="text-danger">Billing Details</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<p>{!! $currentUser->location_postal_address !!}</p>
											</div>
											<div class="col-12">
												<button type="submit" name="goToStep1" id="go-to-step-1" value="goToStep1" title="Edit Billing Details" class="btn btn-outline-secondary">Edit Billing Details</button>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row">
											<div class="col-12 spacer very-tall d-block d-sm-block d-md-none d-lg-none d-xl-none"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"></div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"><hr></div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"></div>
								</div>
								<div class="row">
									<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center text-sm-left text-md-left text-lg-left text-xl-left">
										<button type="submit" name="goToStep1" id="go-to-step-1" value="goToStep1" title="Back to Step 1" class="btn btn-outline-secondary">Back to Step 1</button>
										<div class="spacer d-block d-sm-none d-md-none d-lg-none d-xl-none"></div>
									</div>
									<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center text-sm-right text-md-right text-lg-right text-xl-right">
										<button type="submit" name="goToStep3" id="go-to-step-3" value="goToStep3" title="Proceed to Step 3" class="btn btn-danger">Proceed to Step 3</button>
									</div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"></div>
								</div>
							</form>
						@elseif ($step == 'step-3')
							<form name="checkoutStep3" id="checkoutStep3" class="checkoutStep3" role="form" method="POST" action="/orders">
								{{ csrf_field() }}
								<input type="hidden" name="user_id" value="{{ $currentUser->id }}">
								<input type="hidden" name="location_id" value="{{ session()->get('cart.location_id') }}">
								<input type="hidden" name="shipping_method_id" value="{{ session()->get('cart.shipping_method_id') }}">
								<input type="hidden" name="notes" value="{{ session()->get('cart.notes') }}">
								<input type="hidden" name="solution_id" value="">
								<div class="row d-flex">
									<div class="col-12 col-sm-12 col-md-7 col-lg-8 col-xl-8 order-2 order-sm-2 order-md-1 order-lg-1 order-xl-1">
										<div class="row bg-lighter-grey">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 text-center text-sm-center text-md-center text-lg-left text-xl-left">
												<h4>Step 3 of 3 <small class="text-muted d-block d-sm-inline-block">Products</small></h4>
											</div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 spacer tall"></div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12">
												<table class="table table-responsive" cellspacing="0" border="0" cellpadding="0" width="100%">
													<thead>
														<tr class="bg-default text-white very-tall">
															<th class="align-middle d-none d-sm-none d-md-none d-lg-block d-xl-block">&nbsp;</th>
															<th class="align-middle">Product</th>
															<th class="align-middle text-center">Qty</th>
															<th class="align-middle text-center">Price&nbsp;<i class="fa fa-info-circle d-none d-sm-none d-md-inline d-lg-inline d-xl-inline" data-toggle="tooltip" data-placement="top" title="Prices are shown in British Pound (GBP)" aria-hidden="true"></i></th>
															<th class="align-middle text-right">Subtotal&nbsp;<i class="fa fa-info-circle d-none d-sm-none d-md-inline d-lg-inline d-xl-inline" data-toggle="tooltip" data-placement="top" title="Prices are shown in British Pound (GBP)" aria-hidden="true"></i></th>
														</tr>
													</thead>
													<tbody>
														@foreach ($cart->product_commodities as $productCommodity)
															@php ($productCommodityProduct = $productCommodity->model->product)
															<tr>
																<td class="align-middle d-none d-sm-none d-md-none d-lg-block d-xl-block" style="height: 122px;"><a href="{{ $productCommodityProduct->url }}#{{ $productCommodity->model->code }}" title="{{ $productCommodityProduct->title }}" target="_blank" class="text-gf-info d-flex h-100 justify-content-center"><img src="/assets/img/loading.svg" data-src="{{ $productCommodityProduct->image_url }}" class="lazyload img-fluid align-self-center" width="100px" alt="{{ $productCommodityProduct->title }}"></a></td>
																<td class="align-middle"><a href="{{ $productCommodityProduct->url }}#{{ $productCommodity->model->code }}" title="{{ $productCommodityProduct->title }}">{{ $productCommodity->name }}</a><br>Code: <span class="font-italic">{{ $productCommodity->model->code }}</span></td>
																<td class="align-middle text-center">{{ $productCommodity->qty }}</td>
																<td class="align-middle text-right">{{ $productCommodity->price() }}</td>
																<td class="align-middle text-right">{{ $productCommodity->subtotal() }}</td>
															</tr>
														@endforeach
													</tbody>
													<tfoot>
														<tr>
															<th class="align-middle d-none d-sm-none d-md-none d-lg-block d-xl-block" style="border: 0;">&nbsp;</th>
															<td class="align-middle" style="border: 0;">&nbsp;</td>
															<td class="align-middle" style="border: 0;">&nbsp;</td>
															<td class="align-middle text-right">Subtotal</td>
															<td class="align-middle text-right">{{ $cart->subtotal }}</td>
														</tr>
														<tr>
															<th class="align-middle d-none d-sm-none d-md-none d-lg-block d-xl-block" style="border: 0;">&nbsp;</th>
															<td class="align-middle" style="border: 0;">&nbsp;</td>
															<td class="align-middle" style="border: 0;">&nbsp;</td>
															<td class="align-middle text-right">Tax</td>
															<td class="align-middle text-right">{{ $cart->tax }}</td>
														</tr>
														<tr>
															<th class="align-middle d-none d-sm-none d-md-none d-lg-block d-xl-block" style="border: 0;">&nbsp;</th>
															<td class="align-middle" style="border: 0;">&nbsp;</td>
															<td class="align-middle" style="border: 0;">&nbsp;</td>
															<td class="align-middle text-right font-weight-bold text-uppercase">Total</td>
															<td class="align-middle text-right font-weight-bold">{{ $cart->total }}</td>
														</tr>
													</tfoot>
												</table>
											</div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 spacer tall"></div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 text-center text-sm-center text-md-center text-lg-left text-xl-left">
												<h5>Additional Information</h5>
											</div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12 spacer tall"></div>
										</div>
										<div class="row bg-lighter-grey">
											<div class="col-12">
												<div class="form-group">
													<label for="po_number" class="control-label">PO Number <span class="text-danger">&#42;</span></label>
													<input type="text" name="po_number" id="po_number" class="form-control" value="{{ old('po_number') ?? session()->get('cart.po_number') }}" placeholder="e.g 123456789" autocomplete="off" aria-describedby="helpBlockPoNumber">
													@if ($errors->has('po_number'))
														<span id="helpBlockPoNumber" class="form-control-feedback form-text gf-red">- {{ $errors->first('po_number') }}</span>
													@endif
													<span id="helpBlockPoNumber" class="form-control-feedback form-text text-muted"></span>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer"></div>
										</div>
									</div>
									<div class="col-12 spacer d-block d-sm-block d-md-none d-lg-none d-xl-none"></div>
									<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 ml-auto text-center text-sm-center text-md-right text-lg-right text-xl-right order-1 order-sm-1 order-md-2 order-lg-2 order-xl-2">
										<div class="row">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h4>Your Order</h4>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer tall"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h5 class="text-danger">Customer Details</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<p>{{ $currentUser->first_name }} {{ $currentUser->last_name }}<br><a href="mailto:{{ $currentUser->email }}" title="Email">{{ $currentUser->email }}</a><br>{{ $currentUser->company->title }}<br>{{ $currentUser->job_title }}<br>{{ $currentUser->telephone }}<br>{{ $currentUser->mobile }}</p>
											</div>
											<div class="col-12">
												<a href="/cp/users/{{ $currentUser->id }}/edit?redirectTo=/cart/checkout/step-3" title="Edit Details" class="btn btn-outline-secondary">Edit Details</a>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer very-tall"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h5 class="text-danger">Billing Details</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												<p>{!! $currentUser->location_postal_address !!}</p>
											</div>
											<div class="col-12">
												<button type="submit" name="goToStep1" id="go-to-step-1" value="goToStep1" title="Edit Billing Details" class="btn btn-outline-secondary">Edit Billing Details</button>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer very-tall"></div>
										</div>
										<div class="row">
											<div class="col-12">
												<h5 class="text-danger">Shipping Details</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-12">
												@php ($postalAddress = session()->get('cart.location')->postal_address)
												<p>{!! str_replace(', ', '<br>', $postalAddress) !!}</p>
												<p>{!! session()->get('cart.shipping_method')->title !!}</p>
											</div>
											<div class="col-12">
												<button type="submit" name="goToStep2" id="go-to-step-2" value="goToStep2" title="Edit Shipping Details" class="btn btn-outline-secondary">Edit Shipping Details</button>
											</div>
										</div>
										<div class="row">
											<div class="col-12 spacer"></div>
										</div>
										<div class="row">
											<div class="col-12 spacer very-tall d-block d-sm-block d-md-none d-lg-none d-xl-none"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"></div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"><hr></div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"></div>
								</div>
								<div class="row">
									<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center text-sm-left text-md-left text-lg-left text-xl-left">
										<button type="submit" name="goToStep2" id="go-to-step-2" value="goToStep2" title="Back to Step 2" class="btn btn-outline-secondary">Back to Step 2</button>
										<div class="spacer d-block d-sm-none d-md-none d-lg-none d-xl-none"></div>
									</div>
									<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center text-sm-right text-md-right text-lg-right text-xl-right">
										@if (!optional($currentUser)->isLocationSuspended())
											<button type="submit" name="submit" id="submit" title="Place Order" class="btn btn-danger">Place Order</button>
										@else
											<a href="/cart/save" title="Save Cart for Later" class="btn btn-outline-secondary">Save Cart for Later</a>
										@endif
									</div>
								</div>
								<div class="row">
									<div class="col-12 spacer tall"></div>
								</div>
							</form>
						@endif
					</div>
				</div>
			@else
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						<p>There are currently no items in your cart!</p>
						<p><a href="/products" title="Browse our Products" class="btn btn-danger">Browse Products</a></p>
					</div>
				</div>
			@endif
			