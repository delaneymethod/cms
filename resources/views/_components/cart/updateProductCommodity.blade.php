<form name="updateProductCommodity{{ $id }}" id="updateProductCommodity{{ $id }}" class="updateProductCommodity" role="form" method="POST" action="/cart/{{ $rowId }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<input type="hidden" name="id" value="{{ $id }}">
	<input type="hidden" name="quantity" value="{{ $quantity }}">
	<input type="hidden" name="instance" value="{{ $instance }}">
	<button type="submit" name="submit_update_product_commodity_{{ $id }}" id="submit_update_product_commodity_{{ $id }}" title="{{ $buttonLabel }}" class="{{ $extraClasses }}">{{ $buttonLabel }}</button>
</form>
