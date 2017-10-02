@extends('_layouts.default')

@section('title', 'Cart - Carts - '.config('app.name'))
@section('description', 'Cart - Carts - '.config('app.name'))
@section('keywords', 'Cart, Carts, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/cp.css') }}">
@endpush

@push('headScripts')
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/cp.js') }}"></script>
	@include('cp._partials.listeners')
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
							<h5>Identifier</h5>
							<p class="text-muted">{{ $cart->identifier }}</p>
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<h5>Instance</h5>
							<p class="text-muted">{{ $cart->instance }}</p>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h5>Originator</h5>
							<p class="text-muted">{{ $cart->user->first_name }} {{ $cart->user->last_name }}<br><a href="mailto:{{ $cart->user->email }}" title="Email {{ $cart->user->first_name }}" class="text-gf-red">{{ $cart->user->email }}</a><br>@if (!empty($cart->user->telephone) && !empty($cart->user->mobile)){{ $cart->user->telephone }} / {{ $cart->user->mobile }}@elseif (!empty($cart->user->telephone)){{ $cart->user->telephone }}@elseif (!empty($cart->user->mobile)){{ $cart->user->mobile }}@endif<br>{{ $cart->user->company->title }}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h5>Cart Items</h5>
							<table class="text-muted table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
								<thead>
									<tr>
										<th class="align-middle">&nbsp;</th>
										<th class="align-middle">Product</th>
										<th class="align-middle">Product Commodity</th>
										<th class="align-middle text-center">Qty</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($cart->cartItems as $cartItem)
										@foreach ($cartItem['product_commodities'] as $productCommodity)
											<tr>
												<td class="align-middle text-center"><a href="{{ $cartItem['product_url'] }}" title="{{ $cartItem['product_title'] }}" target="_blank" class="text-gf-info"><img data-src="{{ $cartItem['product_image_url'] }}" class="lazyload img-fluid" alt="{{ $cartItem['product_title'] }}"></a></td>
												<td class="align-middle">{{ $cartItem['product_title'] }}</td>
												<td class="align-middle">{{ $productCommodity['title'] }}</td>
												<td class="align-middle text-center">{{ $productCommodity['quantity'] }}</td>
											</tr>
										@endforeach
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<p>&nbsp;</p>
							<ul class="list-unstyled list-inline">
								<li class="list-inline-item"><a href="/cp/carts" title="View All Carts" class="btn btn-primary">View All Carts</a></li>
							</ul>
						</div>
					</div>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
