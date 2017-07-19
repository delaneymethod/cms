@extends('_layouts.default')

@section('title', 'Roles - Advanced - Dashboard - '.config('app.name'))
@section('description', 'Roles - Advanced - Dashboard - '.config('app.name'))
@section('keywords', 'Roles, Advanced, Dashboard, '.config('app.name'))

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
							<li class="list-inline-item"><a href="/dashboard/advanced/roles/create" title="Add Role" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Role</a></li>
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
							@foreach ($roles as $role)
							<tr>
								<td class="id">{{ $role->id }}</td>
								<td>{{ $role->title }}</td>
								<td class="actions dropdown text-center">
									<a href="javascript:void(0);" title="Role Actions" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item"><a href="/dashboard/advanced/roles/{{ $role->id }}/edit" title="Edit Role" class="gf-info"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Role</a></li>
										<li class="dropdown-item">
											<a href="javascript:void(0);" title="Delete Role" class="gf-danger"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Role</a>
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
