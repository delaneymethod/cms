@extends('_layouts.default')

@section('title', '404 Page not found - '.config('cms.site.name'))
@section('description', '404 Page not found - '.config('cms.site.name'))
@section('keywords', '404, Page, not, found, '.config('cms.site.name'))

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
	<div class="row wrapper">
		<div class="col main">
			<h2>Server Error: 404 (Page not found)</h2>
			<h3>What does this mean?</h3>
			<p>We couldn&#39;t find the page you requested on our servers.</p>
			<p>We&#39;re really sorry about that. It&#39;s our fault, not yours.</p>
			<p>We&#39;ll work hard to get this page back online as soon as possible.</p>
			<p>Perhaps you would like to go <a href="javascript:window.history.back();" title="Back">back</a> or go to our <a href="/" title="Home">homepage</a> ?</p>
		</div>
	</div>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
