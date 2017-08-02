@extends('_layouts.default')

@section('title', 'Dashboard - '.config('app.name'))
@section('description', 'Dashboard - '.config('app.name'))
@section('keywords', 'Dashboard, '.config('app.name'))

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
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<canvas id="orderStats" data-orders="{{ $orders }}"></canvas>
						</div>
					</div>
				</div>
				<div class="content padding bg-white">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<canvas id="allStats" data-total-categories="{{ $categories->count() }}" data-total-users="{{ $users->count() }}" data-total-pages="{{ $pages->count() }}" data-total-orders="{{ $orders->count() }}" data-total-assets="{{ $assets->count() }}" data-total-companies="{{ $companies->count() }}" data-total-articles="{{ $articles->count() }}" data-total-locations="{{ $locations->count() }}"></canvas>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<canvas id="roleUsersStats" data-total-super-admins="{{ $roles[0]->users->count() }}" data-total-admins="{{ $roles[1]->users->count() }}" data-total-end-users="{{ $roles[2]->users->count() }}"></canvas>
						</div>
					</div>
				</div>	
			</div>
		</div>
@endsection
