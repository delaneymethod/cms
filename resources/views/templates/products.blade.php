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
			
			@foreach ($products->chunk(4) as $items)
				<div class="row">
					@foreach ($items as $product)
						<div class="col-sm-12 col-md-3 col-lg-3">
							<ul>
								<li>
									<a href="/products/{{ $product->slug }}" title="{{ $product->title }}">{{ $product->title }}</a>
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
								</li>
							</ul>
						</div>
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
	@include('_partials.footer', [
		'currentUser' => $currentUser,
		'cart' => $cart
	])
@endsection
