@extends('_layouts.default')

@section('title', 'Scheduled Maintenance - '.config('cms.site.name'))
@section('description', 'Scheduled Maintenance - '.config('cms.site.name'))
@section('keywords', 'Scheduled, Maintenance, '.config('cms.site.name'))

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
			<h2>Scheduled Maintenance</h2>
			<h3>We&#39;re taking a short break for some scheduled maintenance&hellip;</h3>
			<p>{{ json_decode(file_get_contents(storage_path('framework/down')), true)['message'] }}</p>
			<p>We&#39;ll be back in a few minutes, so don&#39;t forget to refresh this page.</p>
			<p>Sorry for any inconvenience and for thanks for your patience.</p>
		</div>
	</div>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
