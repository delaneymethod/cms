			<header>
				<h1>{{ config('cms.client.name') }}</h1>
				@include('_partials.nav', [
					'currentUser' => $currentUser,
					'cart' => $cart
				])
			</header>
