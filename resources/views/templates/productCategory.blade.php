			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $productCategory->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			@if (!empty($productCategory->description))
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						<p>{{ $productCategory->description }}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
			@endif
			@if ($productCategories->count() > 0)
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row d-flex h-100 justify-content-center products">
					@foreach ($productCategories as $productCategory)
						<div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 align-self-center text-center">
							<a href="{{ $productCategory->url }}" title="{{ $productCategory->title }}">
								<img src="/assets/img/loading.svg" data-src="{{ $productCategory->image_url }}" class="lazyload img-fluid" alt="{{ $productCategory->title }}">
								<div class="spacer tall"></div>
								<h4>{{ $productCategory->title }}</h4>
							</a>
							<div class="spacer very-tall"></div>
						</div>
					@endforeach
				</div>
			@endif
			@if ($products->count() > 0)
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row d-flex h-100 justify-content-start products">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						@php ($totalColumnsLeft = 10)
						@php ($totalProductAttributes = count($productAttributes))
						@php ($descriptionColumnWidth = $totalColumnsLeft - $totalProductAttributes)
						<div class="row bg-danger text-white very-tall">
							<div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2 text-center font-weight-bold align-self-center">Image</div>
							<div class="col-12 col-sm-6 col-md-9 col-lg-{{ $descriptionColumnWidth }} col-xl-{{ $descriptionColumnWidth }} text-center text-sm-left text-md-left text-lg-left text-xl-left align-self-center font-weight-bold">Description</div>
							@foreach ($productAttributes as $productAttribute)
								<div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 text-center font-weight-bold d-none d-sm-none d-mg-block d-lg-block d-xl-block align-self-center">{{ $productAttribute['title'] }}</div>
							@endforeach
						</div>
						@foreach ($products as $product)
							<div class="row">
								<div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2 align-self-center text-center"><a href="{{ $product->url }}" title="{{ $product->short_name }}"><img src="/assets/img/loading.svg" data-src="{{ $product->image_url }}" class="lazyload img-fluid" alt="{{ $product->short_name }}"></a></div>
								<div class="col-12 col-sm-6 col-md-9 col-lg-{{ $descriptionColumnWidth }} col-xl-{{ $descriptionColumnWidth }} text-center text-sm-left text-md-left text-lg-left text-xl-left align-self-center">
									<a href="{{ $product->url }}" title="{{ $product->short_name }}">{{ $product->title }}</a>
									<ul class="list-unstyled d-block d-sm-block d-mg-none d-lg-none d-xl-none" style="margin-top:10px;">
										@foreach ($productAttributes as $productAttribute)
											@if (array_key_exists($productAttribute['id'], $product->attributes_characteristics)) 
												<li>- {{ $productAttribute['title'] }}: {{ $product->attributes_characteristics[$productAttribute['id']]['value'] }}</li>
											@endif
										@endforeach
									</ul>
								</div>
								@foreach ($productAttributes as $productAttribute)
									@if (array_key_exists($productAttribute['id'], $product->attributes_characteristics)) 
										<div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 align-self-center text-center d-none d-sm-none d-mg-block d-lg-block d-xl-block">{{ $product->attributes_characteristics[$productAttribute['id']]['value'] }}</div>
									@else
										<div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 align-self-center text-center d-none d-sm-none d-mg-block d-lg-block d-xl-block">-</div>
									@endif
								@endforeach
							</div>
							@if (!$loop->last)
								<div class="row">
									<div class="col-12"><hr></div>
								</div>
							@endif
							@if ($loop->last)
								<div class="row">
									<div class="col-12 spacer very-tall"></div>
								</div>
							@endif
						@endforeach
					</div>
				</div>
			@endif
