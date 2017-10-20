			@php ($currentUserCanCreateOrders = optional($currentUser)->hasPermission('create_orders'))
			@php ($redirectTo = '?redirectTo=/'.request()->path())
			@include('_partials.productSearch', [
				'totalProducts' => $totalProducts,
				'keywords' => $keywords
			])
			@if (!empty($keywords))
				<div class="row">
					<div class="col-12 text-center">
						<h4>{{ $totalFoundPretty }} items matching &quot;{{ $keywords }}&quot;</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer very-tall"></div>
				</div>
				@if ($totalFound > 0)
					@if ($productCommodities->count() > 0)
						<div class="row">
							<div class="col-12 text-center">
								<h5 class="text-danger">{{ $productCommodities->count() }} Product Commodities @if ($products->count() > 0)<br><small class="text-muted">({{ $products->count() }} Products are listed below)</small>@endif</h5>
							</div>
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
										@foreach ($productCommodities->sortBy('code') as $productCommodity)
											<tr id="product_commodity_{{ $productCommodity->id }}">
												<td class="align-middle text-center"><a href="{{ $productCommodity->product->url }}" title="{{ $productCommodity->product->title }}">{{ $productCommodity->short_description }}</a></td>
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
															<form name="addProductCommodity{{ $productCommodity->id }}" id="addProductCommodity{{ $productCommodity->id }}" class="addProductCommodityToCart" role="form" method="POST" action="/cart{{ $redirectTo }}">
																{{ csrf_field() }}
																<input type="hidden" name="id" value="{{ $productCommodity->id }}">
																<input type="hidden" name="instance" value="cart">
																<input type="hidden" name="action" value="secret">
																<button type="submit" name="submit_add_product_commodity_{{ $productCommodity->id }}" id="submit_add_product_commodity_{{ $productCommodity->id }}" title="Add to Cart" class="btn btn-outline-success">Add To Cart</button>
															</form>
															<div style="margin-top: 10px;font-size: 12px;">
																<form name="addProductCommodity{{ $productCommodity->id }}" id="addProductCommodity{{ $productCommodity->id }}" class="addProductCommodityToCart" role="form" method="POST" action="/cart{{ $redirectTo }}">
																	{{ csrf_field() }}
																	<input type="hidden" name="id" value="{{ $productCommodity->id }}">
																	<input type="hidden" name="instance" value="wishlist">
																	<input type="hidden" name="action" value="secret">
																	<button type="submit" name="submit_add_product_commodity_{{ $productCommodity->id }}" id="submit_add_product_commodity_{{ $productCommodity->id }}" title="Add to Wishlist" class="btn-unstyled-gf-blue-gray">Add To Wishlist</button>
																</form>
															</div>	
														@endif
													@else
														<a href="javascript:void(0);" title="Add to Cart" rel="nofollow" class="btn btn-outline-sucess disabled">Add to Cart</a><br><a href="/login{{ $redirectTo }}" title="Login" class="text-gf-blue-gray">Please login first</a> 
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
								const productCommodityIds = @json($productCommodities->pluck('id'));
								
								productCommodityIds.map(productCommodityId => window.CMS.Templates.loadProductCommodityPriceQuantity('#product_commodity_' + productCommodityId));
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
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					@endif
					@if ($products->count() > 0)
						<div class="row">
							<div class="col-12 text-center">
								<h5 class="text-danger">{{ $products->count() }} Products</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
						<div class="row d-flex h-100 justify-content-center products">
							@foreach ($products as $product)
								<div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 align-self-center text-center">
									<a href="{{ $product->url }}" title="{{ $product->title }}">
										<img src="/assets/img/loading.svg" data-src="'{{ $product->image_url }}'" class="img-fluid" alt="{{ $product->title }}">
										<div class="spacer tall"></div>
										<h4>{{ $product->title }}</h4>
									</a>
									<div class="spacer very-tall"></div>
								</div>
							@endforeach
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
					@endif
				@endif
			@else
				<div class="row">
					<div class="col-12 text-center">
						<h4>Browse our Products by category</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer"></div>
				</div>
				@if ($productCategories->count() > 0)
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row d-flex h-100 justify-content-center products">
						@foreach ($productCategories as $productCategory)
							<div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 align-self-center text-center">
								<a href="{{ $productCategory->url }}" title="{{ $productCategory->title }}">
									<img src="/assets/img/loading.svg" data-src="'{{ $productCategory->image_url }}'" class="img-fluid" alt="{{ $productCategory->title }}">
									<div class="spacer tall"></div>
									<h4>{{ $productCategory->title }}</h4>
								</a>
								<div class="spacer very-tall"></div>
							</div>
						@endforeach
					</div>
				@endif
			@endif
			