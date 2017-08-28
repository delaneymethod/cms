@extends('_layouts.default')

@section('title', '503 Be Right Back - '.config('cms.client.name'))
@section('description', '503 Be Right Back - '.config('cms.client.name'))
@section('keywords', '503, Be, Right, Back, '.config('cms.client.name'))

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
		<h2>Server Error: 503 (Be Right Back)</h2>
		<h3>What does this mean?</h3>
		<p>{{ json_decode(file_get_contents(storage_path('framework/down')), true)['message'] }}</p>
	</section>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
