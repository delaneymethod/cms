<form name="removeProductCommodity{{ $id }}" id="removeProductCommodity{{ $id }}" class="removeProductCommodity" role="form" method="POST" action="/cart">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
	<input type="hidden" name="id" value="{{ $id }}">
	<input type="hidden" name="row_id" value="{{ $rowId }}">
	<input type="hidden" name="instance" value="{{ $instance }}">
	<input type="hidden" name="action" value="{{ $action }}">
	<button type="submit" name="submit_remove_product_commodity_{{ $id }}" id="submit_remove_product_commodity_{{ $id }}" title="{{ $buttonLabel }}" class="{{ $extraClasses }}">{{ $buttonLabel }}</button>
</form>
