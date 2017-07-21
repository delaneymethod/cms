@extends('_layouts.default')

@section('title', 'Users - '.config('app.name'))
@section('description', 'Users - '.config('app.name'))
@section('keywords', 'Users, '.config('app.name'))

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
						<ul class="list-unstyled list-inline buttons">
							<li class="list-inline-item"><a href="/cp/users/create" title="Add User" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add User</a></li>
						</ul>
					</div>
				</div>
				<div class="content padding bg-white">
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="no-sort">ID</th>
								<th>Full Name</th>
								<th>Email</th>
								<th>Job Title</th>
								<th>Location</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
								<tr>
									<td class="id">{{ $user->id }}</td>
									<td>{{ $user->first_name }} {{ $user->last_name }}</td>
									<td><a href="mailto:{{ $user->email }}" title="Email User" class="d-inline">{{ $user->email }}</a></td>
									<td>{{ $user->job_title }}</td>
									<td>{{ $user->location->title }}</td>
									<td class="status text-center"><i class="fa fa-circle fa-1 status_id-{{ $user->status->id }}" title="{{ $user->status->title }}" aria-hidden="true"></i></td>
									<td class="actions dropdown text-center" id="submenu">
										<a href="javascript:void(0);" title="User Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li class="dropdown-item gf-info"><a href="/cp/users/{{ $user->id }}/edit" title="Edit User"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit User</a></li>
											<li class="dropdown-item gf-default"><a href="/cp/users/{{ $user->id }}/retire" title="Retire User"><i class="icon fa fa-circle-o" aria-hidden="true"></i>Retire User</a></li>
											<li class="dropdown-divider"></li>
											<li class="dropdown-item gf-danger"><a href="/cp/users/{{ $user->id }}/delete" title="Delete User"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete User</a></li>
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
