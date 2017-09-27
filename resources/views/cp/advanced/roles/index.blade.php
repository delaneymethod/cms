@extends('_layouts.default')

@section('title', 'Roles - Advanced - '.config('app.name'))
@section('description', 'Roles - Advanced - '.config('app.name'))
@section('keywords', 'Roles, Advanced, '.config('app.name'))

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
				@if ($currentUser->hasPermission('create_roles'))
					<div class="row">
						<div class="col">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/advanced/roles/create" title="Add Role" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Role</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($roles as $role)
								<tr>
									<td class="align-middle">{{ $role->title }}</td>
									@if ($currentUser->hasPermission('edit_roles') || $currentUser->hasPermission('delete_roles'))
										<td class="align-middle actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Role Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_roles'))
													<li class="dropdown-item gf-info"><a href="/cp/advanced/roles/{{ $role->id }}/edit" title="Edit Role"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Role</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_roles'))
													<li class="dropdown-item gf-danger"><a href="/cp/advanced/roles/{{ $role->id }}/delete" title="Delete Role"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Role</a></li>
												@endif
											</ul>
										</td>
									@else
										<td class="align-middle">&nbsp;</td>
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
