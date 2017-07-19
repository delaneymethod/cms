@extends('_layouts.default')

@section('title', 'Statuses - Advanced - Dashboard - '.config('app.name'))
@section('description', 'Statuses - Advanced - Dashboard - '.config('app.name'))
@section('keywords', 'Statuses, Advanced, Dashboard, '.config('app.name'))

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
						<ul class="list-unstyled list-inline buttons">
							<li class="list-inline-item"><a href="/dashboard/advanced/statuses/create" title="Add Status" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Status</a></li>
						</ul>
					</div>
				</div>
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="no-sort">ID</th>
								<th>Title</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($statuses as $status)
							<tr>
								<td class="id">{{ $status->id }}</td>
								<td>{{ $status->title }}</td>
								<td class="actions dropdown text-center">
									<a href="javascript:void(0);" title="Status Actions" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item"><a href="/dashboard/advanced/statuses/{{ $status->id }}/edit" title="Edit Status" class="gf-info"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Status</a></li>
										<li class="dropdown-item">
											<a href="javascript:void(0);" title="Delete Status" class="gf-danger"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Status</a>
										</li>
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
