@extends('_layouts.default')

@section('title', '500 Internal Server Error - '.$siteName)
@section('description', '500 Internal Server Error - '.$siteName)
@section('keywords', '500, Internal, Server, Error, '.$siteName)

@php ($page->bannerContent = '<h2>500 Internal Server Error</h2>')
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
					<h4>What does this mean?</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row">
				<div class="col-12 text-center text-sm-left text-md-left text-lg-left text-xl-left">		
					<p>Something went wrong on our servers while we were processing your request.</p>
					<p>We&#39;re really sorry about this, and will work hard to get this resolved as soon as possible.</p>
					@if ($exception->getMessage())
						<pre>{{ $exception->getMessage() }}</pre>
					@else
						<p>Perhaps you would like to go <a href="javascript:window.history.back();" title="Back">back</a> or go to our <a href="/" title="Home">homepage</a> ?</p>
					@endif
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
