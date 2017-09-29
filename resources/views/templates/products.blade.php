			<h1>{{ $page->title }}</h1>
			
			{!! $page->content !!}
			
			<div class="row">
				@foreach ($productCategories as $productCategory)
					<div class="col-sm-12 col-md-3 col-lg-3">
						<a href="{{ $productCategory->url }}" title="{{ $productCategory->title }}">
							<figure class="figure">
								<img data-src="{{ $productCategory->image_url }}" class="lazyload figure-img img-fluid rounded" alt="{{ $productCategory->title }}">
								<figcaption class="figure-caption">{{ $productCategory->title }}</figcaption>
							</figure>
						</a>
					</div>
				@endforeach
			</div>
			