<form name="addProductCommodity{{ $id }}" id="addProductCommodity{{ $id }}" class="addProductCommodityToCart" role="form" method="POST" action="/cart{{ $redirectTo }}">
	{{ csrf_field() }}
	<input type="hidden" name="id" value="{{ $id }}">
	<input type="hidden" name="instance" value="{{ $instance }}">
	<input type="hidden" name="action" value="{{ $action }}">
	<button type="submit" name="submit_add_product_commodity_{{ $id }}" id="submit_add_product_commodity_{{ $id }}" title="Add Product Commodity to {{ ucfirst($instance) }}" class="{{ $extraClasses }}">Add To {{ ucfirst($instance) }}</button>
</form>
			