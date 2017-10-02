			<header>
				<h1><a href="/" title="{{ config('cms.site.name') }}"><img src="/assets/img/logo.png" alt="{{ config('cms.site.name') }} logo" class="logo img-fluid"></a></h1>
				@include('_partials.nav', [
					'currentUser' => $currentUser,
					'cart' => $cart
				])
				@include('_partials.breadcrumbs', [
					'breadcrumbs' => $page->breadcrumbs
				])
			</header>
