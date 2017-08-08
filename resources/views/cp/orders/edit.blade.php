@extends('_layouts.default')

@section('title', 'Edit Order - Orders- '.config('app.name'))
@section('description', 'Edit Order - Orders - '.config('app.name'))
@section('keywords', 'Edit, Order, Orders, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/cp.css') }}">
@endpush

@push('headScripts')
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/cp.js') }}"></script>
@endpush

@section('content')
		<div class="row wrapper">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="editOrder" id="editOrder" class="editOrder" role="form" method="POST" action="/cp/orders/{{ $order->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="order_number" value="{{ $order->order_number }}">
						<input type="hidden" name="user_id" value="{{ $order->user_id }}">
						<input type="hidden" name="count" value="{{ $order->count }}">
						<input type="hidden" name="tax" value="{{ $order->tax }}">
						<input type="hidden" name="subtotal" value="{{ $order->subtotal }}">
						<input type="hidden" name="total" value="{{ $order->total }}">
						<div class="form-group">
							<label for="order_number" class="control-label font-weight-bold">Order Number <span class="text-danger">&#42;</span></label>
							<input type="text" name="order_number" id="order_number" class="form-control text-disabled" value="{{ old('order_number') ?? $order->order_number }}" placeholder="e.g GF-123456789" tabindex="1" autocomplete="off" aria-describedby="helpBlockOrderNumber" disabled required autofocus>
							@if ($errors->has('order_number'))
								<span id="helpBlockOrderNumber" class="form-control-feedback form-text gf-red">- {{ $errors->first('order_number') }}</span>
							@endif
							<span id="helpBlockOrderNumber" class="form-control-feedback form-text text-warning">- This field is disabled. The order number cannot be changed for the order.</span>
							<span id="helpBlockOrderNumber" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Status</label>
							@foreach ($statuses as $status)
								<div class="form-check status_id-{{ $status->id }}">
									<label for="status_id-{{ str_slug($status->title) }}" class="form-check-label">
										<input type="radio" name="status_id" id="status_id-{{ str_slug($status->title) }}" class="form-check-input" value="{{ $status->id }}" tabindex="3" aria-describedby="helpBlockStatusId" {{ (old('status_id') == $status->id || $order->status_id == $status->id) ? 'checked' : '' }}>{{ $status->title }}
									</label>
								</div>
							@endforeach
							@if ($errors->has('status_id'))
								<span id="helpBlockStatusId" class="form-control-feedback form-text gf-red">- {{ $errors->first('status_id') }}</span>
							@endif
							<span id="helpBlockStatusId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="user_id" class="control-label font-weight-bold">Originator</label>
							<input type="text" name="user_id" id="user_id" class="form-control text-disabled" value="{{ $order->user->first_name.' '.$order->user->last_name }}" placeholder="e.g Grampian Fasteners" tabindex="4" autocomplete="off" aria-describedby="helpBlockUserId" disabled required>
							@if ($errors->has('user_id'))
								<span id="helpBlockUserId" class="form-control-feedback form-text gf-red">- {{ $errors->first('user_id') }}</span>
							@endif
							<span id="helpBlockUserId" class="form-control-feedback form-text text-warning">- This field is disabled. The originator cannot be changed for the order.</span>
							<span id="helpBlockUserId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Products</label>
							@foreach ($order->products as $product)
								<div class="form-check">
									<input type="text" name="product_id" id="product_id" class="form-control text-disabled" value="{{ $product->title }} (Qty: {{ $product->pivot->quantity }}, Tax: {{ $product->pivot->tax_rate }}&#37;, Price: {{ $order->currency }}{{ number_format($product->pivot->price, 2, '.', ',') }}, Total: {{ $order->currency }}{{ number_format($product->pivot->price_tax, 2, '.', ',') }})" tabindex="5" autocomplete="off" disabled required>
								</div>
							@endforeach
						</div>
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_orders'))
								<a href="/cp/orders" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="6" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" tabindex="5" title="Save Changes">Save Changes</button>
							@if ($currentUser->hasPermission('delete_orders'))
								<a href="/cp/orders/{{ $order->id }}/delete" title="Delete Order" class="pull-right btn btn-outline-danger">Delete Order</a>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
@endsection
