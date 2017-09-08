			<h1>{{ $product->title }}</h1>
			
			<p>Price: {{ $product->price }}</p>
			
			@if (optional($currentUser)->hasPermission('create_orders'))
				@component('_components.cart.addProduct', [
					'product' => $product, 
					'instance' => 'cart', 
					'action' => 'secret'
				])
				@endcomponent
				
				@if (!$wishlistCart->products->pluck('id')->contains($product->id))
					@component('_components.cart.addProduct', [
						'product' => $product, 
						'instance' => 'wishlist', 
						'action' => 'secret'
					])
					@endcomponent
				@endif
			@endif
