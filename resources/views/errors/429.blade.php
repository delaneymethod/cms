@extends('_layouts.default')

@section('title', '429 Too Many Attempts - '.config('app.name'))
@section('description', '429 Too Many Attempts - '.config('app.name'))
@section('keywords', '429, Too, Many, Attempts, '.config('app.name'))

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
	@include('_partials.header')
	<section class="content">
		<h2>Server Error: 429 (Too Many Attempts)</h2>
		<h3>What does this mean?</h3>
		<p>You have made too many requests to the same resource, and now you will have to wait for a {{ $retryAfter }} seconds before trying again.</p>
	</section>
	@include('_partials.footer')
@endsection
