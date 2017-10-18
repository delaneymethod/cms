@extends('_layouts.default')

@section('title', 'Users - '.config('app.name'))
@section('description', 'Users - '.config('app.name'))
@section('keywords', 'Users, '.config('app.name'))

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
				@if ($currentUser->hasPermission('create_users'))
					<div class="row">
						<div class="col-12">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/users/create" title="Add User" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add User</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">
					<div class="spacer"></div>
					<table id="datatable" class="table table-striped table-bordered table-hover table-responsive" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Full Name</th>
								<th class="align-middle">Email</th>
								<th class="align-middle">Job Title</th>
								<th class="align-middle">Telephone</th>
								<th class="align-middle">Mobile</th>
								<th class="align-middle">Location</th>
								<th class="align-middle text-center">Status</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
								<tr class="{{ str_slug($user->status->title) }}">
									<td class="align-middle">{{ $user->first_name }} {{ $user->last_name }}{!! ($user->id == $currentUser->id) ? '&nbsp;<span class="badge badge-pill badge-primary align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;You</span>' : '' !!}{!! ($user->isRetired()) ? '&nbsp;<span class="badge badge-pill badge-retired align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$user->status->title.'</span>' : '' !!}{!! ($user->isPending()) ? '&nbsp;<span class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$user->status->title.'</span>' : '' !!}</td>
									<td class="align-middle"><a href="mailto:{{ $user->email }}" title="Email User" class="d-inline text-gf-red">{{ $user->email }}</a></td>
									<td class="align-middle">{{ $user->job_title }} {{ $user->canBeImpersonated() ? 'yes' : 'no' }}</td>
									<td class="align-middle">{{ $user->telephone }}</td>
									<td class="align-middle">{{ $user->mobile }}</td>
									<td class="align-middle">{{ $user->location->title }}</td>
									<td class="align-middle status text-center"><i class="fa fa-circle fa-1 status_id-{{ $user->status->id }}" title="{{ $user->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									@if ($currentUser->isAdmin() && $user->isSuperAdmin())
										<td class="align-middle">&nbsp;</td>
									@else
										<td class="align-middle actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="User Actions" rel="nofollow" class="dropdown-toggle needsclick" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_users') || $currentUser->id == $user->id)
													<li class="dropdown-item gf-info"><a href="/cp/users/{{ $user->id }}/edit" title="Edit User"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit User</a></li>
												@endif
												@if ($currentUser->hasPermission('retire_users') && !$user->isRetired() && $user->id != $currentUser->id)
													<li class="dropdown-item gf-default"><a href="/cp/users/{{ $user->id }}/retire" title="Retire User"><i class="icon fa fa-circle-o" aria-hidden="true"></i>Retire User</a></li>
												@endif
												@if ($currentUser->hasPermission('impersonate_users') && $user->canBeImpersonated() && $user->id != $currentUser->id)
													<li class="dropdown-item gf-impersonate"><a href="{{ route('impersonate', $user->id) }}" title="Impersonate User"><i class="icon fa fa-user-secret" aria-hidden="true"></i>Impersonate User</a></li>
												@endif
												@if ($currentUser->hasPermission('edit_passwords_users') || $currentUser->id == $user->id)
													<li class="dropdown-item gf-info"><a href="/cp/users/{{ $user->id }}/edit/password" title="Change User"><i class="icon fa fa-key" aria-hidden="true"></i>Change Password</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_users') && $user->id != $currentUser->id)
													<li class="dropdown-item gf-danger"><a href="/cp/users/{{ $user->id }}/delete" title="Delete User"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete User</a></li>
												@endif
											</ul>
										</td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
