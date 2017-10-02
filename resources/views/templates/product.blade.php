			@php ($totalProductCommodities = $product->product_commodities->count())	
			@php ($currentUserCanCreateOrders = optional($currentUser)->hasPermission('create_orders'))
			@php ($wishlistCartProductCommodityIds = $wishlistCart->product_commodities->pluck('id'))
			@php ($redirectTo = '?redirectTo=/'.request()->path())
			<h1>{{ $product->title }}</h1>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					@if (!empty($product->image_url))
						<img data-src="{{ $product->image_url }}" class="lazyload img-fluid" alt="{{ $product->title }}">
					@endif
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					@if (!empty($product->description))
						{!! $product->description !!}
					@endif
					<dl class="row">
						@foreach ($product->attributes_characteristics as $productAttributeCharacteristic)
							<dt class="col-sm-3 font-weight-normal">{{ $productAttributeCharacteristic['title'] }}</dt>
							<dd class="col-sm-9">{{ $productAttributeCharacteristic['value'] }}</dd>
						@endforeach
					</dl>
					<dl class="row">
						@foreach ($product->product_standards as $productStandard)
							<dt class="col-sm-3 font-weight-normal">{{ $productStandard->code }}</dt>
							<dd class="col-sm-9">{{ $productStandard->title }}</dd>
						@endforeach
					</dl>
					<p>{{ $totalProductCommodities }} option{{ ($totalProductCommodities == 1) ? '' : 's' }} available.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle text-center">Option</th>
								<th class="align-middle text-center">Product Code</th>
								<th class="align-middle text-center">Price (GBP)</th>
								<th class="align-middle text-center">Price Per</th>
								<th class="align-middle text-center">Availability</th>
								<th class="align-middle text-center">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($product->product_commodities as $productCommodity)
								<tr id="product_commodity_{{ $productCommodity->id }}">
									<td class="align-middle text-center">{{ $productCommodity->short_description }}</td>
									<td class="align-middle text-center">{{ $productCommodity->code }}</td>
									@if ($authenticated)
										<td class="align-middle text-center price text-muted">Please wait&hellip;</td>
										<td class="align-middle text-center price-per text-muted">Please wait&hellip;</td>
										<td class="align-middle text-center quantity-available text-muted">Please wait&hellip;</td>	
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
															'extraClasses' => 'btn-unstyled-gf-info',
															'redirectTo' => $redirectTo
														])
														@endcomponent
													</div>
												@endif
											@endif
										@else
											<a href="javascript:void(0);" title="Add to Cart" class="btn btn-outline-secondary disabled">Add to Cart</a><br><a href="/login{{ $redirectTo }}" title="Login" class="text-gf-info">Please login first</a> 
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
			