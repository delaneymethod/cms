@extends('_layouts.default')

@section('title', (($page->title != 'Home') ? $page->title.' - ' : '').$siteName)
@section('description', $page->description.' '.$siteName)
@section('keywords', $page->keywords.','.$siteName)

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
		@if ($page->slug != 'products')
			<div class="container-fluid bg-light-grey search">
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
				<div class="row">
					<div class="col-12 spacer"></div>
				</div>
				<div class="row">
					<div class="col-12 text-center">
						<div class="container">
							<div class="row">
								<div class="col-12">
									<h4 class="text-danger">Search our Products&hellip;</h4>
								</div>
							</div>
							<div class="row d-flex h-100 justify-content-center">
								<div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 align-self-center">
									@include('_partials.search', [
										'placeholder' => 'e.g Hex Setscrew, ISO 4017/DIN 933, Brass',
										'keywords' => '',
										'hideLabel' => false
									])
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
			</div>
		@endif
	</main>
	@include('_partials.footer', [
		'currentUser' => $currentUser,
		'cart' => $cart
	])
@endsection
