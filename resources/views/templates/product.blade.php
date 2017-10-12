			@php ($totalProductCommodities = $product->product_commodities->count())	
			@php ($currentUserCanCreateOrders = optional($currentUser)->hasPermission('create_orders'))
			@php ($redirectTo = '?redirectTo=/'.request()->path())
			@include('_partials.productSearch', [
				'totalProducts' => $totalProducts,
				'keywords' => ''
			])
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $product->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row d-flex h-100 justify-content-center">
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
					@if (!empty($product->description))
						<div class="row">
							<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">	
								{!! $product->description !!}
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					@endif
					@if (count($product->attributes_characteristics) > 0)
						<div class="row">
							@foreach ($product->attributes_characteristics as $productAttributeCharacteristic)
								<div class="col-4 col-sm-3 col-md-3 col-lg-3 col-xl-3 font-weight-bold text-left">{{ $productAttributeCharacteristic['title'] }}</div>
								<div class="col-8 col-sm-9 col-md-9 col-lg-9 col-xl-9 text-left">{{ $productAttributeCharacteristic['value'] }}</div>
							@endforeach
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					@endif
					@if (count($product->product_standards) > 0)
						<div class="row">
							@foreach ($product->product_standards as $productStandard)
								<div class="col-4 col-sm-3 col-md-3 col-lg-3 col-xl-3 font-weight-bold text-left">{{ $productStandard->code }}</div>
								<div class="col-8 col-sm-9 col-md-9 col-lg-9 col-xl-9 text-left">{{ $productStandard->title }}</div>
							@endforeach
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					@endif
					<div class="row">
						<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<p>{{ $totalProductCommodities }} option{{ ($totalProductCommodities == 1) ? '' : 's' }} available.</p>
						</div>
					</div>
				</div>
				@if (!empty($product->image_url))
					<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-center text-lg-center text-xl-center align-self-start">
						<img src="/assets/img/loading.svg" data-src="{{ $product->image_url }}" class="lazyload img-fluid" alt="{{ $product->title }}">
					</div>
				@endif
			</div>
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>			
			<div class="row">
				<div class="col-12">
					<p class="d-block d-sm-block d-md-none d-lg-none d-xl-none text-center font-weight-bold">Tip: You can slide / scroll to the table below.</p>
					<table id="datatable" class="table table-responsive product-commodities" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr class="very-tall bg-default text-white">
								<th class="align-middle text-center">Option</th>
								<th class="align-middle text-center">Product Code</th>
								<th class="align-middle text-center">Price (GBP)</th>
								<th class="align-middle text-center">Price Per</th>
								<th class="align-middle text-center"><span class="d-none d-sm-none d-md-block d-lg-block d-xl-block">Availability</span><span class="d-block d-sm-block d-md-none d-lg-none d-xl-none">In Stock</span></th>
								<th class="align-middle text-center no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($product->product_commodities->sortBy('code') as $productCommodity)
								<tr class="{{ $productCommodity->id }}" id="{{ $productCommodity->code }}">
									<td class="align-middle text-center">{{ $productCommodity->short_description }}</td>
									<td class="align-middle text-center">{{ $productCommodity->code }}</td>
									@if ($authenticated)
										<td class="align-middle text-center price text-muted"><img src="/assets/img/loading.svg" class="img-fluid" alt="Please wait while we load the data&hellip;"></td>
										<td class="align-middle text-center price-per text-muted"><img src="/assets/img/loading.svg" class="img-fluid" alt="Please wait while we load the data&hellip;"></td>
									@else	
										<td class="align-middle text-center price text-muted">-</td>
										<td class="align-middle text-center price-per text-muted">-</td>
									@endauth
									<td class="align-middle text-center quantity-available">{{ $productCommodity->quantity_available }}</td>
									<td class="align-middle text-center">
										@if ($authenticated)
											@if ($currentUserCanCreateOrders)
												<form name="addProductCommodity{{ $productCommodity->id }}" id="addProductCommodity{{ $productCommodity->id }}" class="addProductCommodityToCart" role="form" method="POST" action="/cart{{-- $redirectTo }}#{{ $productCommodity->code --}}">
													{{ csrf_field() }}
													<input type="hidden" name="id" value="{{ $productCommodity->id }}">
													<input type="hidden" name="instance" value="cart">
													<input type="hidden" name="action" value="secret">
													<button type="submit" name="submit_add_product_commodity_{{ $productCommodity->id }}" id="submit_add_product_commodity_{{ $productCommodity->id }}" title="Add to Cart" class="btn btn-outline-success">Add To Cart</button>
												</form>
												<div style="margin-top: 10px;font-size: 12px;">
													<form name="addProductCommodity{{ $productCommodity->id }}" id="addProductCommodity{{ $productCommodity->id }}" class="addProductCommodityToCart" role="form" method="POST" action="/cart{{-- $redirectTo }}#{{ $productCommodity->code --}}">
														{{ csrf_field() }}
														<input type="hidden" name="id" value="{{ $productCommodity->id }}">
														<input type="hidden" name="instance" value="wishlist">
														<input type="hidden" name="action" value="secret">
														<button type="submit" name="submit_add_product_commodity_{{ $productCommodity->id }}" id="submit_add_product_commodity_{{ $productCommodity->id }}" title="Add to Wishlist" class="btn-unstyled-gf-blue-gray">Add To Wishlist</button>
													</form>
												</div>	
											@endif
										@else
											<a href="javascript:void(0);" title="Add to Cart" class="btn btn-outline-success disabled">Add to Cart</a><br><a href="/login{{ $redirectTo }}#{{ $productCommodity->code }}" title="Login" class="text-gf-blue-gray">Please login first</a> 
										@endauth
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@if ($authenticated)
				<script async>
				'use strict';
					
				window.onload = () => {
					const productCommodityIds = @json($product->product_commodities->pluck('id'));
					
					const productCommodityCodes = @json($product->product_commodities->pluck('code'));
					
					productCommodityIds.map((productCommodityId, index) => window.CMS.loadProductCommodity('.' + productCommodityId, productCommodityCodes[index]));
				};
				</script>
			@endif
			