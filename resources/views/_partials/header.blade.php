			<header>
				<div class="container">
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row">
						<div class="col-12 text-center text-sm-center text-md-right text-lg-right text-xl-right">
							@include('_partials.nav', [
								'currentUser' => $currentUser,
								'cart' => $cart
							])
						</div>
					</div>
					<div class="row d-block d-sm-none d-md-none d-lg-none d-xl-none">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row d-flex h-100 justify-content-center">
						<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 text-center text-sm-center text-md-left text-lg-left text-xl-left align-self-center">
							<h1><a href="/" title="{{ $siteName }}"><img src="/assets/img/loading.svg" data-src="'{{ $siteLogo }}'" alt="{{ $siteName }} logo" class="img-fluid"></a></h1>
							<div class="spacer tall d-block d-sm-block d-md-none d-lg-none d-xl-none"></div>
						</div>
						<div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 ml-auto text-center text-sm-center text-md-right text-lg-right text-xl-right align-self-center">
							@include('_partials.search', [
								'placeholder' => 'Search our Products&hellip; e.g Hex Setscrew, ISO 4017/DIN 933, Brass',
								'keywords' => '',
								'hideLabel' => false
							])
						</div>
					</div>
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
				</div>
				@if (optional($page)->carousel)
					<div>
						<div class="row no-gutters">
							<div class="col-12 spacer tall"></div>
						</div>
						<div class="row no-gutters">
							<div class="col-12" id="slider">
								@foreach ($page->carousel as $slide)
									<div class="banner hidden" style="background-image: url({{ $slide['image'] }});">
										<div class="row d-flex h-100 justify-content-center">
											<div class="col-10 col-sm-10 col-md-10 col-lg-12 col-xl-12 align-self-center text-center">
												<div class="row">
													<div class="col-12">
														{!! $slide['content'] !!}
													</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				@else
					@php ($bannerImage = '')	
					@if (!empty($page->bannerImage))
						@php ($bannerImage = ' style="background-image: url(\''.$page->bannerImage.'\');"')
					@endif
					@if (!empty($page->bannerContent))
						<div>
							<div class="row no-gutters">
								<div class="col-12 spacer tall"></div>
							</div>
							<div class="row no-gutters">
								<div class="col-12 banner"{!! $bannerImage !!}>
									<div class="row d-flex h-100 justify-content-center">
										<div class="col-10 col-sm-10 col-md-10 col-lg-12 col-xl-12 align-self-center text-center">
											<div class="row">
												<div class="col-12">
													{!! $page->bannerContent !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif
				@endif
				<div class="container">	
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row">
						<div class="col-12">
							@include('_partials.breadcrumbs', [
								'breadcrumbs' => $page->breadcrumbs
							])
						</div>
					</div>
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
				</div>
			</header>
