			<footer>
				<div class="container">
					<div class="row">
						<div class="col-12 spacer very-tall"></div>
					</div>
					<div class="row">
						@if ($footerLinksLeft->count() > 0)
							<div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3 text-center text-sm-left text-md-left text-lg-left text-xl-left">
								<ul class="list-unstyled">
									@foreach ($footerLinksLeft as $link)
										<li><a href="{{ $link->url }}" title="{{ $link->title }}"{{ $link->target }}>{{ $link->title }}</a></li>
									@endforeach	
								</ul>
							</div>
						@endif
						@if ($footerLinksRight->count() > 0)
							<div class="col-6 col-sm-3 col-md-3 col-lg-3 col-xl-3 text-center text-sm-left text-md-left text-lg-left text-xl-left">
								<ul class="list-unstyled">
									@foreach ($footerLinksRight as $link)
										<li><a href="{{ $link->url }}" title="{{ $link->title }}"{{ $link->target }}>{{ $link->title }}</a></li>
									@endforeach	
								</ul>
							</div>
						@endif
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="row d-flex h-100 justify-content-center justify-content-sm-end justify-content-md-end justify-content-lg-end justify-content-xl-end">
								<div class="align-self-center align-self-sm-start align-self-md-end align-self-lg-end align-self-xl-end">
									<p class="d-block d-sm-none d-md-none d-lg-none d-xl-none">&nbsp;</p>
									<img src="https://d1g9f3g06ezg82.cloudfront.net/static/images/logos_footer_d5fb7c76e407.png" alt="Logos" class="logos img-fluid">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row">
						<div class="col-12 spacer">
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="col-12 spacer tall"></div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<p>Copyright {{ config('cms.site.name') }} &copy; {{ date('Y') }}, All Rights Reserved.</p>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center text-sm-center text-md-right text-lg-right text-xl-right">
							<ul class="list-unstyled list-inline social-media">
								<li class="list-inline-item"><a href="https://www.linkedin.com/company/grampian-fasteners" title="LinkedIn"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
								<li class="list-inline-item"><a href="/contact" title="Contact"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
								<li class="list-inline-item"><a href="https://twitter.com/fastenerpeople" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li class="list-inline-item"><a href="https://www.facebook.com/GrampianFasteners92" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-12 spacer"></div>
					</div>
				</div>
			</footer>
	