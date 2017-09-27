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
									<th class="align-middle">Image</th>
									<th class="align-middle">Description</th>
									@foreach ($productAttributes as $productAttribute)
										<th class="align-middle">{{ $productAttribute['title'] }}</th>
									@endforeach
								</tr>
							</thead>
							<tbody>
								@foreach ($products as $product)
									@php ($productUrl = $product->url)
									<tr>
										<td class="align-middle"><a href="{{ $productUrl }}" title="{{ $product->short_name }}"><img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->short_name }}"></a></td>	
										<td class="align-middle"><a href="{{ $productUrl }}" title="{{ $product->short_name }}">{{ $product->title }}</a></td>
										@foreach ($productAttributes as $productAttribute)
											@if (array_key_exists($productAttribute['id'], $product->attributes_characteristics)) 
												<td class="align-middle">{{ $product->attributes_characteristics[$productAttribute['id']]['value'] }}</td>
											@else
												<td class="align-middle">&nbsp;</td>
											@endif
										@endforeach
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endif
