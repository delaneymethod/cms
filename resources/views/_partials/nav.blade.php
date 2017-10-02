				<nav>
					<ul class="list-unstyled list-inline">
						@foreach ($pages as $page)
							@if (!$page->isHiddenFromNav() && $page->isPublished())
								@if ($page->slug == 'cart')
									<li class="list-inline-item"><a href="{{ $page->url }}" title="{{ $page->title }}">{{ $page->title }}{{ (optional($cart)->count > 0) ? '&nbsp;('.$cart->count.')' : '' }}</a></li>
								@else
									<li class="list-inline-item"><a href="{{ $page->url }}" title="{{ $page->title }}">{{ $page->title }}</a></li>
								@endif
							@endif
						@endforeach
						@if ($authenticated)
							<li class="list-inline-item"><a href="/cp/dashboard" title="Dashboard">Dashboard</a></li>
						@else
							<li class="list-inline-item"><a href="/login" title="Login">Login</a></li>
						@endif
					</ul>
				</nav>
		