@extends('_layouts.default')

@section('title', $product->title.' - '.config('app.name'))
@section('description', $product->title.' '.config('app.name'))
@section('keywords', $product->title.',Products,'.config('app.name'))

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
			<h1>{{ $product->title }}</h1>
			<p>Price: {{ $product->price }}</p>
			
			@if ($currentUser && $currentUser->hasPermission('create_orders'))
				@component('_components.cart.addProduct', [
					'product' => $product, 
					'instance' => 'cart', 
					'action' => 'secret'
				])
				@endcomponent
				
				@if (!$wishlistCart->products->pluck('id')->contains($product->id))
					@component('_components.cart.addProduct', [
						'product' => $product, 
						'instance' => 'wishlist', 
						'action' => 'secret'
					])
					@endcomponent
				@endif
			@endif
		</div>
	</div>
	@include('_partials.footer', [
		'currentUser' => $currentUser,
		'cart' => $cart
	])
@endsection
