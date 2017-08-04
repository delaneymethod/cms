@extends('_layouts.default')

@section('title', $page->title.' - '.config('app.name'))
@section('description', $page->description.' '.config('app.name'))
@section('keywords', $page->keywords.','.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/global.css') }}">
@endpush

@push('headScripts')
	<!--[if lt IE 9]>
	<script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/global.js') }}"></script>
	<!--
	<script async>
	'use strict';
	
	window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
	ga('create','XX-XXX-XXX','auto');ga('send','pageview')
	</script>
	<script async defer src="//www.google-analytics.com/analytics.js"></script>
	//-->
@endpush

@section('content')
	@include('_partials.header', [
		'currentUser' => $currentUser,
		'cart' => $cart
	])
	<div class="row wrapper">
		<div class="col main">
			@include('_partials.message')
			
			<h1>{{ $page->title }}</h1>
			{!! $page->content !!}
			
			<h2>Review your details</h2>
			<ul>
				<li>Full Name: {{ $currentUser->first_name }} {{ $currentUser->last_name }}</li>
				<li>Email: {{ $currentUser->email }}</li>
				<li>Job Title: {{ $currentUser->job_title }}</li>
				<li>Company: {{ $currentUser->company->title }}</li>
			</ul>
			
			<h2>Review your Order</h2>
			@if ($cart->count > 0)
				<table class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th>Product</th>
							<th>Qty</th>
							<th>Price</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($cart->products as $product)
							<tr>
								<td>
									<span class="productInfo">
										<a href="/products/{{ $product->model->slug }}" title="{{ $product->name }}">{{ $product->name }}</a>
										@if ($product->options->has('size'))
											<span class="productInfoSize">Size: {{ $product->options->size }}</span>
										@endif
									</span>
								</td>
								<td>
									<span class="productQuantity">{{ $product->qty }}</span>
								</td>
								<td>{{ $product->price() }}</td>
								<td>{{ $product->total() }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td>Subtotal</td>
							<td>{{ $cart->subtotal }}</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td>Tax</td>
							<td>{{ $cart->tax }}</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
							<td>Total</td>
							<td>{{ $cart->total }}</td>
						</tr>
					</tfoot>
				</table>
				
				<form name="createOrder" id="createOrder" class="createOrder" role="form" method="POST" action="/orders">
					{{ csrf_field() }}
					<input type="hidden" name="user_id" value="{{ $currentUser->id }}">
					<button type="submit" name="submit" id="submit" title="Place Order">Place Order</button>
				</form>
				
			@else
				<p>There are currently no items in your cart!</p>
				<p><a href="/products" title="Browse our Products">Browse our Products</a></p>
			@endif
		</div>
	</div>
	@include('_partials.footer', [
		'currentUser' => $currentUser,
		'cart' => $cart
	])
@endsection