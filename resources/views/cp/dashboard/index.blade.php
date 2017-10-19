@extends('_layouts.default')

@section('title', 'Dashboard - '.config('app.name'))
@section('description', 'Dashboard - '.config('app.name'))
@section('keywords', 'Dashboard, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
@endpush

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				@if (count($orders) > 0)
					<div class="content padding bg-white">
						<div class="row">
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
								<h4>Recent Orders</h4>
							</div>
							<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
								<canvas id="orderTotals" data-order-stats="{{ $orderStats }}"></canvas>
							</div>
							<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
								<table class="table table-striped table-bordered table-hover table-responsive" style="margin-top: 5px;">
									<thead>
										<tr>
											<th class="align-middle">Order Number</th>
											<th class="align-middle">Date</th>
											<th class="align-middle text-center">Status</th>
										</tr>
									</thead>
									<tbody>
										@php($chunk = $orders->take(5))
										@foreach ($chunk->all() as $order)
											<tr>
												<td class="align-middle">{{ $order->order_number }}</td>
												<td class="align-middle">{{ $order->created_at }}</td>
												<td id="order-{{ $order->id }}-status" class="align-middle text-center status_id-{{ $order->status->id }}">{{ $order->status->title }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				@endif
				@if (count($statCards) > 0)
					<div class="content padding bg-white">
						<div class="row stats">
							@foreach ($statCards as $statCard)
								<div class="col-12 col-sm-4 col-md-3 col-lg-3 col-xl-2 cols">
									<a href="{{ $statCard->url }}" title="{{ $statCard->label }}">
										<div class="stat-card text-center alert" id="{{ $statCard->id }}-card">
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
							<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
								<canvas id="roleUsersStats" data-total-super-admins="{{ $roles[0]->users->count() }}" data-total-admins="{{ $roles[1]->users->count() }}" data-total-end-users="{{ $roles[2]->users->count() }}"></canvas>
							</div>
						</div>
					</div>
				@endif
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
