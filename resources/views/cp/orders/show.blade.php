@extends('_layouts.default')

@section('title', 'Order - Orders - '.config('app.name'))
@section('description', 'Order - Orders - '.config('app.name'))
@section('keywords', 'Order, Orders, '.config('app.name'))

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
					<div class="row">
						<div class="col-sm-12 col-md-4 col-lg-4">
							<h5>Order Type</h5>
							<p class="text-muted">{{ $order->order_type->title }}</p>
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<h5>Order Number</h5>
							<p class="text-muted">{{ $order->order_number }}</p>
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<h5>PO Number</h5>
							<p class="text-muted">{{ $order->po_number }}</p>
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<h5>Order Status</h5>
							<p class="status_id-{{ $order->status->id }}">{{ $order->status->title }}</p>
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<h5>Order Date</h5>
							<p class="text-muted">{{ $order->created_at }}</p>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h5>Originator</h5>
							<p class="text-muted">{{ $order->user->first_name }} {{ $order->user->last_name }}<br><a href="mailto:{{ $order->user->email }}" title="Email {{ $order->user->first_name }}" class="text-gf-red">{{ $order->user->email }}</a><br>{{ $order->user->telephone }} / {{ $order->user->mobile }}<br>{{ $order->user->company->title }}</p>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h5>Order Shipping Method</h5>
							<p class="text-muted">{{ $order->shipping_method->title }}</p>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h5>Order Shipping Location</h5>
							<p class="text-muted">{!! nl2br($order->postal_address) !!}<br>{{ $order->user->telephone }}</p>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h5>Order Notes</h5>
							<p class="text-muted">{{ $order->notes }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h5>Order Items</h5>
							<table class="text-muted table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
								<thead>
									<tr>
										<th>Title</th>
										<th class="text-center">Qty</th>
										<th class="text-center">Tax</th>
										<th class="text-right">Price</th>
										<th class="text-right">Total</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($order->products as $product)
										<tr>
											<td>{{ $product->title }}</td>
											<td class="text-center">{{ $product->pivot->quantity }}</td>
											<td class="text-center">{{ $product->pivot->tax_rate }}&#37;</td>
											<td class="text-right">{{ $order->currency }}{{ number_format($product->pivot->price, 2, '.', ',') }}</td>
											<td class="text-right">{{ $order->currency }}{{ number_format($product->pivot->price_tax, 2, '.', ',') }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p></p>
							<ul class="list-unstyled list-inline">
								<li class="list-inline-item"><a href="/cp/orders" title="View All Orders" class="btn btn-outline-secondary">View All Orders</a></li>
								<li class="list-inline-item"><a href="/cp/orders/{{ $order->id }}/pdf" title="Download PDF Version" class="btn btn-outline-secondary">Download PDF Version</a></li>
							</ul>
						</div>
					</div>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
