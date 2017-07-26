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
								<th class="no-sort">ID</th>
								<th>Title</th>
								<th>Full Name</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $order)
								<tr>
									<td>{{ $order->id }}</td>
									<td>{{ $order->title }}{!! ($order->status->id == 2) ? '&nbsp;<span class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$order->status->title.'</span>' : '' !!}</td>
									<td>{!! ($order->user) ? $order->user->first_name.' '.$order->user->last_name.(($order->user->id == $currentUser->id) ? '&nbsp;<span class="badge badge-pill badge-primary align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;You</span>' : '').(($order->user->status->id == 3) ? '&nbsp;<span class="badge badge-pill badge-retired align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$order->user->status->title.'</span>' : '').(($order->user->status->id == 2) ? '&nbsp;<span class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$order->user->status->title.'</span>' : '') : '&nbsp;<span class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Null</span>' !!}</td>
									<td class="status text-center"><i class="fa fa-circle fa-1 status_id-{{ $order->status->id }}" title="{{ $order->status->title }}" aria-hidden="true"></i></td>
									<td class="actions dropdown text-center" id="submenu">
										<a href="javascript:void(0);" title="Order Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li class="dropdown-item gf-info"><a href="/cp/orders/{{ $order->id }}/edit" title="Edit Order"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Order</a></li>
										</ul>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
@endsection
