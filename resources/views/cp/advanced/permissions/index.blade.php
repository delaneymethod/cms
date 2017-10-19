@extends('_layouts.default')

@section('title', 'Permissions - Advanced - '.config('app.name'))
@section('description', 'Permissions - Advanced - '.config('app.name'))
@section('keywords', 'Permissions, Advanced, '.config('app.name'))

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
				<ul>
					<li><strong>Super Administrators</strong> can see everything - no restrictions or filtering applied.</li>
					<li><strong>Administrators</strong> can see their data and <strong>End Users</strong> data - filtering applied per company.</li>
					<li><strong>End Users</strong> can only see their data - filtering applied per company.</li>
				</ul>	
				<div class="content padding bg-white">
					<div class="spacer"></div>
					<form name="createPermissions" id="createPermissions" class="createPermissions" role="form" method="POST" action="/cp/advanced/roles/permissions">
						{{ csrf_field() }}
						<table class="permissions table table-hover table-bordered table-striped">
							<thead>
								<tr>
									<th class="align-middle">&nbsp;</th>
									@foreach ($roles as $role)
										<th class="align-middle text-center">{{ $role->title }}</th>
									@endforeach
								</tr>
							</thead>
							<tbody>
								@foreach ($permissions as $group)
									@php($titleParts = explode('_', $group[0]->title))
									
									@php($groupTitle = ucfirst($titleParts[1]))
									
									@if (count($titleParts) > 2)
										@php($groupTitle = $groupTitle.' '.ucfirst($titleParts[2]))
									@endif
									@if (!$loop->first)
										<tr class="table-light">
											<td class="align-middle" colspan="4">&nbsp;</td>
										</tr>
									@endif
									<tr>
										<td class="align-middle table-light text-left" colspan="4"><strong>{{ $groupTitle }}</strong></td>
									</tr>
									@foreach ($group as $permission)
										<tr>
											<td class="align-middle text-left">{{ slugToTitle($permission->title) }}</td>
											@foreach ($roles as $role)
												@php ($rolePermissions = $role->permissions->pluck('id')->toArray())
												<td class="align-middle text-center">
													<input type="checkbox" name="{{ $role->id }}[]" value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
												</td>
											@endforeach
										</tr>
									@endforeach
								@endforeach
							</tbody>
						</table>
						<button type="submit" name="submit_create_permissions" id="submit_create_permissions" class="btn btn-primary" title="Save Changes">Save Changes</button>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
