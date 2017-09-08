			<header>
				<h1>{{ config('cms.site.name') }}</h1>
				@include('_partials.nav', [
					'currentUser' => $currentUser,
					'cart' => $cart
				])
			</header>
