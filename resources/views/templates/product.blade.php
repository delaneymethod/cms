			<h1>{{ $product->title }}</h1>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					@if (!empty($product->image_url))
						<img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->title }}">
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
					<p>{{ $product->product_commodities->count() }} option{{ ($product->product_commodities->count() == 1) ? '' : 's' }} available.</p>
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
								<tr>
									<td class="align-middle text-center">{{ $productCommodity->short_description }}</td>
									<td class="align-middle text-center">{{ $productCommodity->code }}</td>
									<td class="align-middle text-center">TBC</td>
									<td class="align-middle text-center">TBC</td>
									<td class="align-middle text-center">{{ $productCommodity->quantity_available }}</td>	
									<td class="align-middle text-center">
										@auth
											@if (optional($currentUser)->hasPermission('create_orders'))
												@component('_components.cart.addProductCommodity', [
													'productCommodity' => $productCommodity,
													'instance' => 'cart', 
													'action' => 'secret',
													'extraClasses' => 'btn btn-outline-success'
												])
												@endcomponent
												@if (!$wishlistCart->product_commodities->pluck('id')->contains($productCommodity->id))
													<div style="margin-top: 10px;font-size: 12px;">
														@component('_components.cart.addProductCommodity', [
															'productCommodity' => $productCommodity, 
															'instance' => 'wishlist', 
															'action' => 'secret',
															'extraClasses' => 'btn-unstyled-gf-info'
														])
														@endcomponent
													</div>
												@endif
											@endif
										@else
											<a href="javascript:void(0);" title="Add to Cart" class="btn btn-outline-secondary disabled">Add to Cart</a><br><a href="/login?redirectTo={{ $product->url }}" title="Login" class="text-gf-info">Please login first</a> 
										@endauth
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			