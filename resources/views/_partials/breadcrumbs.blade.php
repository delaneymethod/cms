			@if (optional($breadcrumbs)->count() > 0)
				<ul class="list-unstyled list-inline social-media breadcrumbs text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<li class="list-inline-item">You are here:</li>
					@foreach ($breadcrumbs as $breadcrumb)
						<li class="list-inline-item {{ setActive($breadcrumb->url) }}"><a href="{{ $breadcrumb->url }}" title="{{ $breadcrumb->title }}">{{ $breadcrumb->title }}</a></li>
						@if (!$loop->last)
							<li class="list-inline-item">&raquo;</li>
						@endif
					@endforeach
				</ul>
			@endif
			