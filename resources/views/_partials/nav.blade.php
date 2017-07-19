				<nav>
					<ul>
						<li><a href="{{ url('/') }}" title="Home">Home</a></li>
						@if (Auth::guest() && Route::has('login'))
							<li><a href="{{ url('/login') }}" title="Login">Login</a></li>
						@else
							<li><a href="{{ url('/dashboard') }}" title="Dashboard">Dashboard</a></li>
						@endif
					</ul>
				</nav>
		