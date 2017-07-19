@extends('_layouts.default')

@section('title', 'Orders - Dashboard - '.config('app.name'))
@section('description', 'Orders - Dashboard - '.config('app.name'))
@section('keywords', 'Orders, Dashboard, '.config('app.name'))

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
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="no-sort">ID</th>
								<th>Title</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $order)
							<tr>
								<td class="id">{{ $order->id }}</td>
								<td>{{ $order->title }}</td>
								<td class="status text-center"><i class="fa fa-circle fa-1 status-{{ $order->status->id }}" title="{{ $order->status->title }}" aria-hidden="true"></i></td>
								<td class="actions dropdown text-center">
									<a href="javascript:void(0);" title="Order Actions" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item gf-info"><a href="/dashboard/orders/{{ $order->id }}/edit" title="Edit Order"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Order</a></li>
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
