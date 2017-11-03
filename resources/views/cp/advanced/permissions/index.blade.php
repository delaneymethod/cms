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
					<form name="createPermissions" id="createPermissions" class="createPermissions" role="form" method="POST" action="/cp/advanced/roles/permissions">
						{{ csrf_field() }}
						<table class="permissions table table-hover">
							<tbody>
								@foreach ($permissions as $group)
									@php($titleParts = explode('_', $group[0]->title))
									
									@php($groupTitle = ucfirst($titleParts[1]))
									
									@if (count($titleParts) > 2)
										@php($groupTitle = $groupTitle.' '.ucfirst($titleParts[2]))
									@endif
									@if (!$loop->first)
										<tr class="thead">
											<td class="blank align-middle" colspan="4">&nbsp;</td>
										</tr>
									@endif
									<tr class="thead">
										<td class="align-middle group-title text-left font-weight-bold">{{ $groupTitle }}</td>
										@foreach ($roles as $role)
											<td class="align-middle group-title text-center font-weight-bold">{{ $role->title }}</td>
										@endforeach
									</tr>
									@foreach ($group as $permission)
										<tr>
											<td scope="row" class="align-middle text-left permissionTitle">{{ slugToTitle($permission->title) }}</td>
											@foreach ($roles as $role)
												@php ($rolePermissions = $role->permissions->pluck('id')->toArray())
												<td data-label="{{ $role->title }}" class="align-middle text-right text-sm-right text-md-center text-lg-center text-xl-center">
													<label class="switch form-check-label"> 
														<input type="checkbox" name="{{ $role->id }}[]" value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
														<span class="slider round"></span>
													</label>
												</td>
											@endforeach
										</tr>
									@endforeach
								@endforeach
							</tbody>
						</table>
						<div class="row">
							<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
								<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;"><hr></div>
								<button type="submit" name="submit_create_permissions" id="submit_create_permissions" class="pull-right btn btn-primary" title="Save Changes">Save Changes</button>
							</div>
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
