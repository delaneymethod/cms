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
				</div>
				@if (!empty($product->image_url))
					<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-center text-lg-center text-xl-center align-self-start">
						<img src="/assets/img/loading.svg" data-src="'{{ $product->image_url }}'" class="img-fluid" alt="{{ $product->title }}">
					</div>
				@endif
			</div>
			@if ($product->product_manufacturer->id != 1)
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row">
					<div class="col-12 spacer"><hr></div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						<h4>Manufacturer</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row d-flex h-100 justify-content-center justify-content-sm-center justify-content-md-start justify-content-lg-start justify-content-xl-start">
					<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 align-self-center text-center text-sm-center text-md-left text-lg-left text-xl-left">
						<a href="{{ $product->product_manufacturer->url }}" title="{{ $product->product_manufacturer->title }}"><img data-src="'{{ $product->product_manufacturer->image_url }}'" class="img-fluid" alt="{{ $product->product_manufacturer->title }} Logo"></a>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						<p><a href="{{ $product->product_manufacturer->url }}" title="Find out more about {{ $product->product_manufacturer->title }}">Find out more about {{ $product->product_manufacturer->title }}.</a></p>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer"><hr></div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
			@endif
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<p>We have {{ $totalProductCommodities }} option{{ ($totalProductCommodities == 1) ? '' : 's' }} available.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<p class="d-block d-sm-block d-md-none d-lg-none d-xl-none text-center font-weight-bold">Tip: You can slide / scroll the table below.</p>
					<table id="datatable" class="table table-responsive product-commodities" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr class="very-tall bg-default text-white">
								<th class="align-middle text-center">Option</th>
								<th class="align-middle text-center">Product Code</th>
								<th class="align-middle text-center">Price&nbsp;<i class="fa fa-info-circle d-none d-sm-none d-md-inline d-lg-inline d-xl-inline" data-toggle="tooltip" data-placement="top" title="Prices are shown in British Pound (GBP)" aria-hidden="true"></i></th>
								<th class="align-middle text-center">Price Per&nbsp;<i class="fa fa-info-circle d-none d-sm-none d-md-inline d-lg-inline d-xl-inline" data-toggle="tooltip" data-placement="top" title="Pieces in the Pack/Case" aria-hidden="true"></i></th>
								<th class="align-middle text-center">In Stock</th>
								<th class="align-middle text-center no-sort">Quantity</th>
								<th class="align-middle text-center no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($product->product_commodities->sortBy('code') as $productCommodity)
								<tr class="{{ $productCommodity->id }}" id="{{ $productCommodity->code }}">
									<td class="align-middle text-center" scope="row">{{ $productCommodity->short_description }}</td>
									<td class="align-middle text-center">{{ $productCommodity->code }}</td>
									@if ($authenticated)
										<td class="align-middle text-center price text-muted"><img src="/assets/img/loading.svg" class="img-fluid" alt="Please wait while we load the data&hellip;"></td>
										<td class="align-middle text-center price-per text-muted"><img src="/assets/img/loading.svg" class="img-fluid" alt="Please wait while we load the data&hellip;"></td>
									@else	
										<td class="align-middle text-center price text-muted">-</td>
										<td class="align-middle text-center price-per text-muted">-</td>
									@endauth
									<td class="align-middle text-center quantity-available">{{ $productCommodity->quantity_available }}</td>
									<td class="align-middle text-center" style="width: 90px;"><input type="number" name="{{ $productCommodity->id }}_quantity" id="{{ $productCommodity->id }}_quantity" class="form-control text-center" value="1" placeholder="e.g 1" autocomplete="off" step="1" min="1" max="99999" onkeyup="return window.CMS.Templates.validateProductCommodityQuantity(event);" data-id="{{ $productCommodity->id }}" required></td>
									<td class="align-middle text-center">
										@if ($authenticated)
											@if ($currentUserCanCreateOrders)
												<form name="addProductCommodity{{ $productCommodity->id }}" id="addProductCommodity{{ $productCommodity->id }}" class="addProductCommodityToCart" role="form" method="POST" action="/cart{{-- $redirectTo }}#{{ $productCommodity->code --}}">
													{{ csrf_field() }}
													<input type="hidden" name="id" value="{{ $productCommodity->id }}">
													<input type="hidden" name="quantity" value="1">
													<input type="hidden" name="instance" value="cart">
													<input type="hidden" name="action" value="secret">
													<button type="submit" name="submit_add_product_commodity_{{ $productCommodity->id }}" id="submit_add_product_commodity_{{ $productCommodity->id }}" title="Add to Cart" class="btn btn-outline-success btn-sm">Add To Cart</button>
												</form>
												<div style="margin-top: 10px;font-size: 12px;" class="d-none d-sm-block d-md-block d-lg-block d-xl-block">
													<form name="addProductCommodity{{ $productCommodity->id }}" id="addProductCommodity{{ $productCommodity->id }}" class="addProductCommodityToCart" role="form" method="POST" action="/cart{{-- $redirectTo }}#{{ $productCommodity->code --}}">
														{{ csrf_field() }}
														<input type="hidden" name="id" value="{{ $productCommodity->id }}">
														<input type="hidden" name="instance" value="wishlist">
														<input type="hidden" name="action" value="secret">
														<button type="submit" name="submit_add_product_commodity_{{ $productCommodity->id }}" id="submit_add_product_commodity_{{ $productCommodity->id }}" title="Add to Wishlist" class="btn-unstyled-gf-blue-gray">Add To Wishlist</button>&nbsp;<i class="fa fa-info-circle d-none d-sm-none d-md-inline-block d-lg-inline-block d-xl-inline-block" data-toggle="tooltip" data-placement="top" title="&quot;Add To Wishlist&quot; means you like the product and may consider buying it later but not right now." aria-hidden="true"></i>
													</form>
												</div>	
											@endif
										@else
											<div><a href="javascript:void(0);" title="Add To Cart" rel="nofollow" class="btn btn-outline-secondary disabled">Add To Cart</a></div>
											<div style="margin-top: 10px;font-size: 12px;"><a href="/login{{ $redirectTo }}&code={{ $productCommodity->code }}" class="text-gf-blue-gray">Please Login</a>&nbsp;<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Add to Cart is only available to registered customers." aria-hidden="true"></i></div>
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
					
				function loadProductCommodities() {
					const productCommodityIds = @json($product->product_commodities->pluck('id'));
					
					const productCommodityCodes = @json($product->product_commodities->pluck('code'));
					
					productCommodityIds.map((productCommodityId, index) => window.CMS.Templates.loadProductCommodity('.' + productCommodityId, productCommodityCodes[index]));
				}
				
				if (window.attachEvent) {
					window.attachEvent('onload', loadProductCommodities);
				} else if (window.addEventListener) {
					window.addEventListener('load', loadProductCommodities, false);
				} else {
					document.addEventListener('load', loadProductCommodities, false);
				}
				</script>
			@endif
			