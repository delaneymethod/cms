				<nav>
					<ul class="list-unstyled list-inline">
						@foreach ($pages as $page)
							@if (!$page->isHiddenFromNav() && $page->isPublished())
								@if ($page->slug == 'cart')
									<li class="list-inline-item {{ setActive('cart') }}"><a href="{{ $page->url }}" title="{{ $page->title }}">{{ $page->title }}{{ (optional($cart)->count > 0) ? '&nbsp;('.$cart->count.')' : '' }}</a></li>
									<li class="list-inline-item">|</li>
								@else
									<li class="list-inline-item {{ setActive($page->slug) }}"><a href="{{ $page->url }}" title="{{ $page->title }}">{{ $page->title }}</a></li>
									<li class="list-inline-item">|</li>
								@endif
							@endif
						@endforeach
						@if ($authenticated)
							<li class="list-inline-item"><a href="/cp/dashboard" title="My Account">My Account</a></li>
						@else
							<li class="list-inline-item {{ setActive('login') }}"><a href="/login" title="Login">Login</a></li>
						@endif
					</ul>
				</nav>
		