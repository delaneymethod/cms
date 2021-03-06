			{{--
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>{{ $page->title }}</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			@if (!empty($page->section1Content))
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						{!! $page->section1Content !!}
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
			@endif
			--}}
			@include('_partials.productSearch', [
				'totalProducts' => $totalProducts,
				'keywords' => ''
			])
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
								<img src="/assets/img/loading.svg" data-src="{{ $productCategory->image_url }}" data-src-retina="{{ $productCategory->image_url }}" class="img-fluid" alt="{{ $productCategory->title }}">
								<div class="spacer tall"></div>
								<h4>{{ $productCategory->title }}</h4>
							</a>
							<div class="spacer very-tall"></div>
						</div>
					@endforeach
				</div>
			@endif
			