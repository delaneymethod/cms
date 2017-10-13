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
			<div class="row">
				<div class="col-12">
					@if ($productManufacturers->count() > 0)
						@foreach ($productManufacturers->sortBy('title') as $productManufacturer)
							@component('_components.productManufacturer.content', [
								'productManufacturer' => $productManufacturer,
								'loop' => $loop
							])
							@endcomponent
						@endforeach
					@endif
				</div>
			</div>
			