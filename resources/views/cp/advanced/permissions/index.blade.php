@extends('_layouts.default')

@section('title', 'Permissions - Advanced - '.config('app.name'))
@section('description', 'Permissions - Advanced - '.config('app.name'))
@section('keywords', 'Permissions, Advanced, '.config('app.name'))

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
					<form name="createPermissions" id="createPermissions" class="createPermissions" role="form" method="POST" action="/cp/advanced/roles/permissions">
						{{ csrf_field() }}
						@php ($disabledPermissions = [
							'create_roles', 
							'edit_roles', 
							'delete_roles', 
							'view_permissions', 
							'create_permissions', 
							'edit_permissions', 
							'delete_permissions', 
							'create_statuses', 
							'edit_statuses', 
							'delete_statuses'
						])
						<table class="permissions table table-hover table-bordered table-striped">
							<thead>
								<tr>
									<th>Permission</th>
									@foreach ($roles as $role)
										<th class="text-center">{{ $role->title }}</th>
									@endforeach
								</tr>
							</thead>
							<tbody>
								@foreach ($permissions as $permission)
									<tr>
										<td class="text-left">{{ slugToTitle($permission->title) }}</td>
										@foreach ($roles as $role)
											@php ($rolePermissions = $role->permissions->pluck('id')->toArray())
											<td class="text-center">
												<input type="checkbox" name="{{ $role->id }}[]" value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
											</td>
										@endforeach
									</tr>
								@endforeach
							</tbody>
						</table>
						<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" title="Save Changes">Save Changes</button>
					</form>
				</div>
			</div>
		</div>
@endsection
