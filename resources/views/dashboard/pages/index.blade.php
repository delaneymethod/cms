@extends('_layouts.default')

@section('title', 'Pages - Dashboard - '.config('app.name'))
@section('description', 'Pages - Dashboard - '.config('app.name'))
@section('keywords', 'Pages, Dashboard, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/dashboard/css/global.css') }}">
@endpush

@push('headScripts')
	<script async>
	'use strict';
	
	window.User = {!! Auth::check() ? Auth::user() : 'null' !!};
	
	window.Laravel = {'csrfToken': '{{ csrf_token() }}'};
	</script>
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/dashboard/js/global.js') }}"></script>
@endpush

@section('content')
		<div class="row wrapper">
			@include('dashboard._partials.sidebar')
			<div class="col-md-9 col-lg-9 main">
				@include('dashboard._partials.message')
				@include('dashboard._partials.pageTitle')
				<div class="row">
					<div class="col">
						<p><a href="/dashboard/pages/create" title="Add Page"><i class="fa fa-plus" aria-hidden="true"></i>Add Page</a></p>
					</div>
				</div>
			</div>
		</div>
@endsection
