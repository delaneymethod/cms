				<nav>
					<ul>
						@foreach ($pages as $page)
							@if (!$page->isHiddenFromNav() && $page->isPublished())
								@if ($page->slug == 'cart')
									<li><a href="{{ $page->url }}" title="{{ $page->title }}">{{ $page->title }}{{ ($cart) ? '&nbsp;('.$cart->count.')' : '' }}</a></li>
								@else
									<li><a href="{{ $page->url }}" title="{{ $page->title }}">{{ $page->title }}</a></li>
								@endif
							@endif
						@endforeach
						@guest
							<li><a href="/login" title="Login">Login</a></li>
						@else
							<li><a href="/cp/dashboard" title="Dashboard">Dashboard</a></li>
						@endguest
					</ul>
				</nav>
		