@extends('_layouts.default')

@section('title', (($page->title != 'Home') ? $page->title.' - ' : '').config('cms.site.name'))
@section('description', $page->description.' '.config('cms.site.name'))
@section('keywords', $page->keywords.','.config('cms.site.name'))

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
	@include('_partials.message', [
		'currentUser' => $currentUser
	])
	@include('_partials.header', [
		'currentUser' => $currentUser,
		'cart' => $cart
	])
	<main>
		<div class="container">
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			{!! $page->view->render() !!}
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
		</div>	
	</main>
	@include('_partials.footer', [
		'currentUser' => $currentUser,
		'cart' => $cart
	])
@endsection
