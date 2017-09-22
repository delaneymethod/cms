			<h1>{{ $product->title }}</h1>
			
			@if (!empty($product->description))
				<p>{{ $product->description }}</p>
			@endif
			
			@if (!empty($product->image_url))
				<img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->title }}">
			@endif
			
			@foreach ($product->product_attributes as $productAttribute)
				{{ $productAttribute->title }}<br>
			@endforeach
			