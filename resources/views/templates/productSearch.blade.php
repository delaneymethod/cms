			<div class="row">
				<div class="col-12 text-center">
					<p>Type in your keywords to begin searching&hellip;</p>
				</div>
			</div>
			<div class="row d-flex h-100 justify-content-center">
				<div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-start">
					@include('_partials.search', [
						'placeholder' => 'e.g Hex Setscrew, ISO 4017/DIN 933, Brass',
						'keywords' => $keywords,
						'hideLabel' => true
					])
				</div>
			</div>
			@if ($products->count() > 0)
				<div class="row">
					<div class="col-12 spacer very-tall"></div>
				</div>
				<div class="row">
					<div class="col-12 text-center">
						<h3>{{ $products->count() }} products matching &quot;{{ $keywords }}&quot;</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer very-tall"></div>
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
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row">
					<div class="col-12 text-center">
						<a href="https://www.algolia.com/?utm_source={{ str_slug(config('cms.site.name')) }}&utm_medium=link&utm_campaign=product_search" title="Product search brought to you by Algolia" target="_blank"><img src="/assets/img/loading.svg" data-src="/assets/img/search-by-algolia.png" alt="Product search brought to you by Algolia" width="160px" class="lazyload"></a>
					</div>
				</div>
			@else
				<div class="row">
					<div class="col-12 spacer very-tall"></div>
				</div>
				<div class="row">
					<div class="col-12 text-center">
						<p>&hellip;or browse our products by category</p>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer very-tall"></div>
				</div>
				@if ($productCategories->count() > 0)
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
			