@extends('_layouts.default')

@section('title', 'Orders - '.config('app.name'))
@section('description', 'Orders - '.config('app.name'))
@section('keywords', 'Orders, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/cp.css') }}">
@endpush

@push('headScripts')
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/cp.js') }}"></script>
	@include('cp._partials.listeners')
@endpush

@section('content')
		<div class="row wrapper">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th>Order Type</th>
								<th>Order Number</th>
								<th>PO Number</th>
								<th>Location</th>
								<th>Date</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $order)
								<tr>
									<td data-search="{{ $order->user->company->title }}">{{ $order->order_type->title }}</td>
									<td>{{ $order->order_number }}{!! ($order->isPending()) ? '&nbsp;<span id="order-'.$order->id.'-status-badge" class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$order->status->title.'</span>' : '' !!}</td>
									<td>{{ $order->po_number }}</td>
									<td>{{ str_replace('<br>', ', ', $order->postal_address) }}</td>
									<td data-search="{{ $order->created_at->format('d F Y H:i:s A') }}">{{ $order->created_at }}</td>
									<td class="status text-center"><i id="order-{{ $order->id }}-status-icon" class="fa fa-circle fa-1 status_id-{{ $order->status->id }}" title="{{ $order->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('view_orders'))
										<td class="actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Order Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('view_orders'))
													<li class="dropdown-item gf-info"><a href="/cp/orders/{{ $order->id }}" title="View Order"><i class="icon fa fa-eye" aria-hidden="true"></i>View Order</a></li>
												@endif
											</ul>
										</td>
									@else
										<td>&nbsp;</td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
