				<nav>
					<ul>
						@foreach ($pages as $page)
							@if ($page->hide_from_nav == 0 && $page->status_id == 4)
								@if ($page->slug == 'cart' && $currentUser && $currentUser->hasPermission('view_orders'))
									<li><a href="{{ $page->url }}" title="{{ $page->title }}">{{ $page->title }}{{ ($cart) ? '&nbsp;('.$cart->count.')' : '' }}</a></li>
								@else
									<li><a href="{{ $page->url }}" title="{{ $page->title }}">{{ $page->title }}</a></li>
								@endif
							@endif
						@endforeach
						@if (Auth::guest() && Route::has('login'))
							<li><a href="/login" title="Login">Login</a></li>
						@else
							<li><a href="/cp/dashboard" title="Dashboard">Dashboard</a></li>
						@endif
					</ul>
				</nav>
		