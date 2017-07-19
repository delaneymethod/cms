@extends('_layouts.default')

@section('title', 'Users - Dashboard - '.config('app.name'))
@section('description', 'Users - Dashboard - '.config('app.name'))
@section('keywords', 'Users, Dashboard, '.config('app.name'))

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
								<td>{{ $user->id }}</td>
								<td>{{ $user->first_name }} {{ $user->last_name }}</td>
								<td><a href="mailto:{{ $user->email }}" title="Email User" class="d-inline">{{ $user->email }}</a></td>
								<td>{{ $user->job_title }}</td>
								<td>{{ $user->location->title }}</td>
								<td class="text-center"><i class="fa fa-circle status-{{ $user->status->id }}" title="{{ $user->status->title }}" aria-hidden="true"></i></td>
								<td class="dropdown text-center">
									<a href="javascript:void(0);" title="User Actions" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item"><a href="/dashboard/users/{{ $user->id }}/edit" title="Edit User"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit User</a></li>
										<li class="dropdown-item">
											<a href="javascript:void(0);" title="Delete User"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete User</a>
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
