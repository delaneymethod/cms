@extends('_layouts.default')

@section('title', 'Permissions - Advanced - '.config('app.name'))
@section('description', 'Permissions - Advanced - '.config('app.name'))
@section('keywords', 'Permissions, Advanced, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/cp.css') }}">
@endpush

@push('headScripts')
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/cp.js') }}"></script>
@endpush

@section('content')
		<div class="row wrapper">
			@include('cp._partials.sidebar')
			<div class="col-md-9 col-lg-9 main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="row">
					<div class="col">
					</div>
				</div>
			</div>
		</div>
@endsection
