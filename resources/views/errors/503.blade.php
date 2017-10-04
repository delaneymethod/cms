@extends('_layouts.default')

@section('title', 'Scheduled Maintenance - '.config('cms.site.name'))
@section('description', 'Scheduled Maintenance - '.config('cms.site.name'))
@section('keywords', 'Scheduled, Maintenance, '.config('cms.site.name'))

@php ($page->bannerMessage = '<h2>Scheduled, Maintenance<</h2>')
@php ($page->bannerImage = '')

@push('styles')
	@include('_partials.styles')
@endpush

@push('headScripts')
	@include('_partials.headScripts')
@endpush

@push('bodyScripts')
	@include('_partials.bodyScripts')
@endpush

@section('content')
	@include('_partials.header', [
		'currentUser' => null,
		'cart' => null
	])
	<main>
		<div class="container">
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row">
				<div class="col-12 text-center text-sm-left text-md-left text-lg-left text-xl-left">
					<h4>We&#39;re taking a short break for some scheduled maintenance&hellip;</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row">
				<div class="col-12 text-center text-sm-left text-md-left text-lg-left text-xl-left">		
					<p>{{ json_decode(file_get_contents(storage_path('framework/down')), true)['message'] }}</p>
					<p>We&#39;ll be back in a few minutes, so don&#39;t forget to refresh this page.</p>
					<p>Sorry for any inconvenience and for thanks for your patience.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
		</div>	
	</main>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
