@extends('_layouts.default')

@section('title', (($page->title != 'Home') ? $page->title.' - ' : '').config('app.name'))
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
	@include('_partials.header')
	<section class="content">
		<h1>{{ $page->title }}</h1>
		{!! $page->content !!}
		
		LIST PRODUCTS HERE
		
		http://andremadarang.com/implementing-a-shopping-cart-in-laravel/	
		
	</section>
	@include('_partials.footer')
@endsection
