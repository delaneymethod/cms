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
					<div class="row">
						<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<h1><a href="/" title="{{ config('cms.site.name') }}"><img src="/assets/img/logo.png" alt="{{ config('cms.site.name') }} logo" class="img-fluid"></a></h1>
						</div>
					</div>
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
				</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row">
						<div class="col-12 banner" style="background-image: url('https://www.grampianfasteners.com/files/1680c433-741e-4778-8522-0dcc6545d33f/bg_rigs_1_edit_darker.jpg');">
							<div class="row d-flex h-100 justify-content-center">
								<div class="col-10 col-sm-10 col-md-10 col-lg-12 col-xl-12 align-self-center text-center">
									<div class="row">
										<div class="col-12">
											<h2>We make your connections simple</h2>
											<h4>Imagine one place for everything you need to connect your equipment.</h4>
											<h4>We have a huge range of fasteners and tools to make the connections in stock.</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
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
