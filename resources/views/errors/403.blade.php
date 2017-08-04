@extends('_layouts.default')

@section('title', '403 Forbidden - '.config('app.name'))
@section('description', '403 Forbidden - '.config('app.name'))
@section('keywords', '403, Forbidden, '.config('app.name'))

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
		<h2>Server Error: 403 (Forbidden)</h2>
		<h3>What does this mean?</h3>
		<p>You don&#39;t have the right credentials to view the requested resource.</p>
		<p>Perhaps you would like to go <a href="javascript:window.history.back();" title="Back">back</a> or go to our <a href="/" title="Home">homepage</a> ?</p>
	</section>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
