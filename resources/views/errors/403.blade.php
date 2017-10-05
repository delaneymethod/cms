@extends('_layouts.default')

@section('title', '403 Forbidden - '.config('cms.site.name'))
@section('description', '403 Forbidden - '.config('cms.site.name'))
@section('keywords', '403, Forbidden, '.config('cms.site.name'))
	
@php ($page->bannerContent = '<h2>Server Error: 403 (Forbidden)</h2>')
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
					<p>You don&#39;t have the right credentials to view the requested resource.</p>
					<p>Perhaps you would like to go <a href="javascript:window.history.back();" title="Back">back</a> or go to our <a href="/" title="Home">homepage</a> ?</p>
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
