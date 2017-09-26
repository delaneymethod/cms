@php ($redirectTo = '')
@if ($productCommodity->model)
	@php ($redirectTo = '?redirectTo='.$productCommodity->model->product->url)
@else
	@php ($redirectTo = '?redirectTo='.$productCommodity->product->url)
@endif
@if ($action == 'remove_wishlist')
	@php ($redirectTo = '')
@endif
<form name="addProductCommodity{{ $productCommodity->id }}" id="addProductCommodity{{ $productCommodity->id }}" class="addProductCommodityToCart" role="form" method="POST" action="/cart{{ $redirectTo }}">
	{{ csrf_field() }}
	<input type="hidden" name="id" value="{{ $productCommodity->id }}">
	<input type="hidden" name="instance" value="{{ $instance }}">
	<input type="hidden" name="action" value="{{ $action }}">
	<button type="submit" name="submit_add_product_commodity_{{ $productCommodity->id }}" id="submit_add_product_commodity_{{ $productCommodity->id }}" title="Add Product Commodity to {{ ucfirst($instance) }}" class="{{ $extraClasses }}">Add To {{ ucfirst($instance) }}</button>
</form>
			