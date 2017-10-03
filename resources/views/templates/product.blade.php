			@php ($totalProductCommodities = $product->product_commodities->count())	
			@php ($currentUserCanCreateOrders = optional($currentUser)->hasPermission('create_orders'))
			@php ($wishlistCartProductCommodityIds = $wishlistCart->product_commodities->pluck('id'))
			@php ($redirectTo = '?redirectTo=/'.request()->path())
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
					<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-center text-lg-center text-xl-center align-self-center">
						<img src="/assets/img/loading.svg" data-src="{{ $product->image_url }}" class="lazyload img-fluid" alt="{{ $product->title }}">
					</div>
				@endif
			</div>
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>			
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<p class="d-block d-sm-block d-md-none d-lg-none d-xl-none text-center font-weight-bold">Tip: You can slide / scroll to the table below.</p>
					<table class="table table-responsive" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr class="very-tall bg-danger text-white">
								<th class="align-middle text-center">Option</th>
								<th class="align-middle text-center">Product Code</th>
								<th class="align-middle text-center">Price (GBP)</th>
								<th class="align-middle text-center">Price Per</th>
								<th class="align-middle text-center"><span class="d-none d-sm-none d-md-block d-lg-block d-xl-block">Availability</span><span class="d-block d-sm-block d-md-none d-lg-none d-xl-none">In Stock</span></th>
								<th class="align-middle text-center">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($product->product_commodities as $productCommodity)
								<tr id="product_commodity_{{ $productCommodity->id }}">
									<td class="align-middle text-center">{{ $productCommodity->short_description }}</td>
									<td class="align-middle text-center">{{ $productCommodity->code }}</td>
									@if ($authenticated)
										<td class="align-middle text-center price text-muted"><img src="/assets/img/loading.svg" class="img-fluid" alt="Please wait while we load the data&hellip;"></td>
										<td class="align-middle text-center price-per text-muted"><img src="/assets/img/loading.svg" class="img-fluid" alt="Please wait while we load the data&hellip;"></td>
										<td class="align-middle text-center quantity-available text-muted"><img src="/assets/img/loading.svg" class="img-fluid" alt="Please wait while we load the data&hellip;"></td>	
									@else
										<td class="align-middle text-center price text-muted">-</td>
										<td class="align-middle text-center price-per text-muted">-</td>
										<td class="align-middle text-center quantity-available text-muted">-</td>	
									@endif
									<td class="align-middle text-center">
										@if ($authenticated)
											@if ($currentUserCanCreateOrders)
												@component('_components.cart.addProductCommodity', [
													'id' => $productCommodity->id,
													'instance' => 'cart', 
													'action' => 'secret',
													'extraClasses' => 'btn btn-outline-success',
													'redirectTo' => $redirectTo
												])
												@endcomponent
												@if (!$wishlistCartProductCommodityIds->contains($productCommodity->id))
													<div style="margin-top: 10px;font-size: 12px;">
														@component('_components.cart.addProductCommodity', [
															'id' => $productCommodity->id, 
															'instance' => 'wishlist', 
															'action' => 'secret',
															'extraClasses' => 'btn-unstyled-gf-blue-gray',
															'redirectTo' => $redirectTo
														])
														@endcomponent
													</div>
												@endif
											@endif
										@else
											<a href="javascript:void(0);" title="Add to Cart" class="btn btn-outline-secondary disabled">Add to Cart</a><br><a href="/login{{ $redirectTo }}" title="Login" class="text-gf-blue-gray">Please login first</a> 
										@endif
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
				
				productCommodityIds.map(productCommodityId => window.CMS.loadProductCommodityPriceQuantity(`#product_commodity_${productCommodityId}`));
			};
			</script>
			@endif
			