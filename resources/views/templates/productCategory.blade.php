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
					@foreach ($products as $product)
						@php ($productUrl = $product->url)
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-1">
									<a href="{{ $productUrl }}" title="{{ $product->title }}"><img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->title }}"></a>
								</div>
								<div class="col-sm-12 col-md-5 col-lg-5">
									<a href="{{ $productUrl }}" title="{{ $product->title }}">{{ $product->description }}</a>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-2">
									Thread
								</div>
								<div class="col-sm-12 col-md-3 col-lg-2">
									Material Grade
								</div>
								<div class="col-sm-12 col-md-3 col-lg-2">
									Finish
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endif
