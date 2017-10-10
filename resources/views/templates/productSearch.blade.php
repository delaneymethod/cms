			@include('_partials.productSearch', [
				'totalProducts' => $totalProducts,
				'keywords' => $keywords
			])
			@if (!empty($keywords))
				<div class="row">
					<div class="col-12 text-center">
						<h4>{{ $products->count() }} products matching &quot;{{ $keywords }}&quot;</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer"></div>
				</div>
				@if ($products->count() > 0)
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row d-flex h-100 justify-content-center products">
						@foreach ($products as $product)
							<div class="col-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 align-self-center text-center">
								<a href="{{ $product->url }}" title="{{ $product->title }}">
									<img src="/assets/img/loading.svg" data-src="{{ $product->image_url }}" class="lazyload img-fluid" alt="{{ $product->title }}">
									<div class="spacer tall"></div>
									<h4>{{ $product->title }}</h4>
								</a>
								<div class="spacer very-tall"></div>
							</div>
						@endforeach
					</div>
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
									<img src="/assets/img/loading.svg" data-src="{{ $productCategory->image_url }}" class="lazyload img-fluid" alt="{{ $productCategory->title }}">
									<div class="spacer tall"></div>
									<h4>{{ $productCategory->title }}</h4>
								</a>
								<div class="spacer very-tall"></div>
							</div>
						@endforeach
					</div>
				@endif
			@endif
			