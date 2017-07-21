				<nav>
					<ul>
						<li><a href="'/" title="Home">Home</a></li>
						@if (Auth::guest() && Route::has('login'))
							<li><a href="/login" title="Login">Login</a></li>
						@else
							<li><a href="/cp/dashboard" title="Dashboard">Dashboard</a></li>
						@endif
					</ul>
				</nav>
		