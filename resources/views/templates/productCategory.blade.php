			<h1>{{ $productCategory->title }}</h1>
			
			@if (!empty($productCategory->description))
				<p>{{ $productCategory->description }}</p>
			@endif
			
			@if ($productCategories->count())
				<div class="row">
					@foreach ($productCategories as $productCategory)
						<div class="col-sm-12 col-md-3 col-lg-3">
							<a href="{{ $productCategory->url }}" title="{{ $productCategory->title }}">
								<figure class="figure">
									<img src="{{ $productCategory->image_url }}" class="figure-img img-fluid" alt="{{ $productCategory->title }}">
									<figcaption class="figure-caption">{{ $productCategory->title }}</figcaption>
								</figure>
							</a>
						</div>
					@endforeach
				</div>
			@endif
			
			@if ($products->count())
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
							<thead>
								<tr>
									<th>Image</th>
									<th>Description</th>
									@foreach ($productAttributeHeadings as $productAttributeHeading)
										<th>{{ $productAttributeHeading }}</th>
									@endforeach
								</tr>
							</thead>
							<tbody>
								@foreach ($products as $product)
									@php ($productUrl = $product->url)
									<tr>
										<td>
											<a href="{{ $productUrl }}" title="{{ $product->title }}"><img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->title }}"></a>
										</td>	
										<td>
											<a href="{{ $productUrl }}" title="{{ $product->title }}">{{ $product->description }}</a>
										</td>
										@foreach ($productAttributeHeadings as $productAttributeHeading)
											@php ($productAttribute = $product->product_attributes->where('title', $productAttributeHeading)->first())
											@if (!empty($productAttribute))
												<td>{{ $productAttribute->title }}</td>
											@else
												<td>&nbsp;</td>	
											@endif
										@endforeach
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endif
