<form name="removeProduct{{ $product->id }}" id="removeProduct{{ $product->id }}" class="removeProduct" role="form" method="POST" action="/cart">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
	<input type="hidden" name="id" value="{{ $product->id }}">
	<input type="hidden" name="row_id" value="{{ $product->rowId }}">
	<input type="hidden" name="instance" value="{{ $instance }}">
	<input type="hidden" name="action" value="{{ $action }}">
	<button type="submit" name="submit_remove_product_{{ $product->id }}" id="submit_remove_product_{{ $product->id }}" title="{{ $buttonLabel }}">{{ $buttonLabel }}</button>
</form>
