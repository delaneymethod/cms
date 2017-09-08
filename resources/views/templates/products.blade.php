			<h1>{{ $page->title }}</h1>
			
			{!! $page->content !!}
			
			@foreach ($products->chunk(4) as $items)
				<div class="row">
					@foreach ($items as $product)
						<div class="col-sm-12 col-md-3 col-lg-3">
							<ul>
								<li>
									<a href="/products/{{ $product->slug }}" title="{{ $product->title }}">{{ $product->title }}</a>
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
								</li>
							</ul>
						</div>
					@endforeach
				</div>
			@endforeach
