@extends('_layouts.default')

@section('title', '500 Internal Server Error - '.config('app.name'))
@section('description', '500 Internal Server Error - '.config('app.name'))
@section('keywords', '500, Internal, Server, Error, '.config('app.name'))

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
@endpush

@section('content')
	@include('_partials.header', [
		'currentUser' => null,
		'cart' => null
	])
	<section class="content">
		<h2>Server Error: 500 (Internal Server Error)</h2>
		<h3>What does this mean?</h3>
		<p>Something went wrong on our servers while we were processing your request.</p>
		<p>We&#39;re really sorry about this, and will work hard to get this resolved as soon as possible.</p>
		<p>Perhaps you would like to go <a href="javascript:window.history.back();" title="Back">back</a> or go to our <a href="/" title="Home">homepage</a> ?</p>
		@if ($exception->getMessage())
			<h3>Exception</h3>
			<small><pre>{{ $exception->getMessage() }}</pre></small>
		@endif
	</section>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
