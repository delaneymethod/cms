			@if ($breadcrumbs->count() > 0)
				<ul>
					@foreach ($breadcrumbs as $breadcrumb)
						<li><a href="{{ $breadcrumb->url }}" title="{{ $breadcrumb->title }}">{{ $breadcrumb->title }}</a></li>
					@endforeach
				</ul>
			@endif
			