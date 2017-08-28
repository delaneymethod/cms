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
				@if (count($orders) > 0)
					<div class="content padding bg-white">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<canvas id="orderStats" data-orders="{{ $orders }}"></canvas>
							</div>
						</div>
					</div>
				@endif
				@if (count($statCards) > 0)
					<div class="content padding bg-white">
						<div class="row stats">
							@foreach ($statCards as $statCard)
								<div class="col-sm-12 col-md-2 col-lg-2 cols">
									<a href="{{ $statCard->url }}" title="{{ $statCard->label }}">
										<div class="stat-card text-center alert">
											<h5>{{ $statCard->label }}</h5>
											<p>{{ $statCard->count }}</p>
										</div>
									</a>
								</div>
							@endforeach
						</div>
					</div>
				@endif
				@if (count($roles) > 0)
					<div class="content padding bg-white">
						<div class="row">
							<div class="col-sm-12 col-md-4 col-lg-4">
								<canvas id="roleUsersStats" data-total-super-admins="{{ $roles[0]->users->count() }}" data-total-admins="{{ $roles[1]->users->count() }}" data-total-end-users="{{ $roles[2]->users->count() }}"></canvas>
							</div>
						</div>
					</div>
				@endif
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
