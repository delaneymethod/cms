						<div class="row">
							<div class="col-12 spacer very-tall"></div>
						</div>
						<div class="row d-flex">
							@php ($columnsLeft = 12)
							@if (!empty($productManufacturer->logo_image))
								@php ($columnsLeft = 9)
							@endif
							<div class="col-12 col-sm-12 col-md-{{ $columnsLeft }} col-lg-{{ $columnsLeft }} col-xl-{{ $columnsLeft }} order-2 order-sm-2 order-md-2 order-lg-1 order-xl-1">
								<div class="row">
									<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
										<h4><a href="{{ $productManufacturer->url }}" title="{{ $productManufacturer->title }}">{{ $productManufacturer->title }}</a></h4>
									</div>
									<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
										<div class="spacer"></div>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
										<p><a href="{{ $productManufacturer->url }}" title="More About {{ $productManufacturer->title }}" class="btn btn-danger btn-sm">More About {{ $productManufacturer->title }}</a></p>
									</div>
								</div>
							</div>
							@if (!empty($productManufacturer->logo_image))
								<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 text-center order-1 order-sm-1 order-md-1 order-lg-2 order-xl-2">
									<a href="{{ $productManufacturer->url }}" title="{{ $productManufacturer->title }}"><img src="{{ $productManufacturer->image_url }}" alt="{{ $productManufacturer->title }} Logo" class="lazyload img-fluid"></a>
									<div class="spacer very-tall d-block d-sm-block d-md-block d-lg-none d-xl-none"></div>
								</div>
							@endif
						</div>
						<div class="row">
							<div class="col-12 spacer tall"></div>
						</div>
						@if (!$loop->last)
							<div class="row">
								<div class="col-12 spacer"><hr></div>
							</div>
						@endif
						