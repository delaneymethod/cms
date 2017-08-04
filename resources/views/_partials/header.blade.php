			<header>
				<h1>{{ config('app.name') }}</h1>
				@include('_partials.nav', [
					'currentUser' => $currentUser,
					'cart' => $cart
				])
			</header>
