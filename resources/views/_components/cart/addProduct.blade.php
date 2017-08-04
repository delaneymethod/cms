<form name="addProduct{{ $product->id }}" id="addProduct{{ $product->id }}" class="addProductToCart" role="form" method="POST" action="/cart">
	{{ csrf_field() }}
	<input type="hidden" name="id" value="{{ $product->id }}">
	<input type="hidden" name="instance" value="{{ $instance }}">
	<input type="hidden" name="action" value="{{ $action }}">
	<button type="submit" name="submit_add_product_{{ $product->id }}" id="submit_add_product_{{ $product->id }}" title="Add Product to {{ ucfirst($instance) }}">Add Product to {{ ucfirst($instance) }}</button>
</form>
			