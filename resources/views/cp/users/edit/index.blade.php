@extends('_layouts.default')

@section('title', 'Edit User - Users - '.config('app.name'))
@section('description', 'Edit User - Users - '.config('app.name'))
@section('keywords', 'Edit, User, Users, '.config('app.name'))

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
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="editUser" id="editUser" class="editUser" role="form" method="POST" action="/cp/users/{{ $user->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						@if ($user->id == $currentUser->id)
							<input type="hidden" name="company_id" value="{{ $user->company_id }}">
							<input type="hidden" name="role_id" value="{{ $user->role_id }}">
							<input type="hidden" name="status_id" value="{{ $user->status_id }}">
						@endif
						<input type="hidden" name="password" value="{{ $user->password }}">
						<div class="form-group">
							<label for="first_name" class="control-label font-weight-bold">First Name <span class="text-danger">&#42;</span></label>
							<input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', optional($user)->first_name) }}" placeholder="e.g Joe" tabindex="1" autocomplete="off" aria-describedby="helpBlockFirstName" required autofocus>
							@if ($errors->has('first_name'))
								<span id="helpBlockFirstName" class="form-control-feedback form-text gf-red">- {{ $errors->first('first_name') }}</span>
							@endif
							<span id="helpBlockFirstName" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="last_name" class="control-label font-weight-bold">Last Name <span class="text-danger">&#42;</span></label>
							<input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', optional($user)->last_name) }}" placeholder="e.g Bloggs" tabindex="2" autocomplete="off" aria-describedby="helpBlockLastName" required>
							@if ($errors->has('last_name'))
								<span id="helpBlockLastName" class="form-control-feedback form-text gf-red">- {{ $errors->first('last_name') }}</span>
							@endif
							<span id="helpBlockLastName" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="email" class="control-label font-weight-bold">Email Address <span class="text-danger">&#42;</span></label>
							<input type="email" name="email" id="email" class="form-control" value="{{ old('email', optional($user)->email) }}" placeholder="e.g joe@bloggs.com" tabindex="3" autocomplete="off" aria-describedby="helpBlockEmailAddress" required>
							@if ($errors->has('email'))
								<span id="helpBlockEmailAddress" class="form-control-feedback form-text gf-red">- {{ $errors->first('email') }}</span>
							@endif
							<span id="helpBlockEmailAddress" class="form-control-feedback form-text text-muted">- Please enter the email address in lowercase.</span>
						</div>
						<div class="form-group">
							<label for="job_title" class="control-label font-weight-bold">Job Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="job_title" id="job_title" class="form-control" value="{{ old('job_title', optional($user)->job_title) }}" placeholder="e.g Manager" tabindex="4" autocomplete="off" aria-describedby="helpBlockJobTitle" required>
							@if ($errors->has('job_title'))
								<span id="helpBlockJobTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('job_title') }}</span>
							@endif
							<span id="helpBlockJobTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="telephone" class="control-label font-weight-bold">Telephone <span class="text-danger">&#42;</span></label>
							<input type="tel" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', optional($user)->telephone) }}" placeholder="E.g: &#43;44 1224 123456" tabindex="5" autocomplete="off" aria-describedby="helpBlockTelephone" required>
							@if ($errors->has('telephone'))
								<span id="helpBlockTelephone" class="form-control-feedback form-text gf-red">- {{ $errors->first('telephone') }}</span>
							@endif
							<span id="helpBlockTelephone" class="form-control-feedback form-text text-muted">- Please enter the telephone number in the international format starting with a plus sign (&#43;).</span>
						</div>
						<div class="form-group">
							<label for="mobile" class="control-label font-weight-bold">Mobile</label>
							<input type="tel" name="mobile" id="mobile" class="form-control" value="{{ old('mobile', optional($user)->mobile) }}" placeholder="E.g: &#43;44 7700 123 456" tabindex="6" autocomplete="off" aria-describedby="helpBlockMobile">
							@if ($errors->has('mobile'))
								<span id="helpBlockMobile" class="form-control-feedback form-text gf-red">- {{ $errors->first('mobile') }}</span>
							@endif
							<span id="helpBlockMobile" class="form-control-feedback form-text text-muted">- Please enter the mobile number in the international format starting with a plus sign (&#43;).</span>
						</div>
						<div class="form-group">
							<label for="company_id" class="control-label font-weight-bold">Company</label>
							<select name="company_id" id="company_id" class="form-control {{ ($user->id == $currentUser->id) ? 'text-disabled' : '' }}" tabindex="7" aria-describedby="helpBlockCompanyId" required>
								@foreach ($companies as $company)
									<option value="{{ $company->id }}" {{ (old('company_id') == $company->id || $user->company_id == $company->id) ? 'selected' : '' }} {{ ($user->id == $currentUser->id) ? 'disabled' : '' }}>{{ $company->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('company_id'))
								<span id="helpBlockCompanyId" class="form-control-feedback form-text gf-red">- {{ $errors->first('company_id') }}</span>
							@endif
							@if ($user->id == $currentUser->id)
								<span id="helpBlockCompanyId" class="form-control-feedback form-text text-warning">- This field is disabled. You cannot change your own company.</span>
							@endif
							<span id="helpBlockCompanyId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="location_id" class="control-label font-weight-bold">Location</label>
							<select name="location_id" id="location_id" class="form-control" tabindex="8" aria-describedby="helpBlockLocationId" required>
								@foreach ($locations as $location)
									<option value="{{ $location->id }}" {{ (old('location_id') == $location->id || $user->location_id == $location->id) ? 'selected' : '' }}>{{ $location->title }}{{ ($location->status->id == 2 || $location->status->id == 3) ? '&nbsp;('.$location->status->title.')' : '' }}{{ ($currentUser->isSuperAdmin() && $companies->count() > 1) ? '&nbsp;('.$location->company->title.')' : '' }}</option>
								@endforeach
							</select>
							@if ($errors->has('location_id'))
								<span id="helpBlockLocationId" class="form-control-feedback form-text gf-red">- {{ $errors->first('location_id') }}</span>
							@endif
							<span id="helpBlockLocationId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Role</label>
							@foreach ($roles as $role)
								<div class="form-check">
									<label for="role_id-{{ str_slug($role->title) }}" class="form-check-label {{ ($user->id == $currentUser->id) ? 'text-disabled' : '' }}">
										<input type="radio" name="role_id" id="role_id-{{ str_slug($role->title) }}" class="form-check-input" value="{{ $role->id }}" tabindex="9" aria-describedby="helpBlockRoleId" {{ (old('role_id') == $role->id || $user->role_id == $role->id) ? 'checked' : '' }} {{ ($user->id == $currentUser->id) ? 'disabled' : '' }}>{{ $role->title }}
									</label>
								</div>
							@endforeach
							@if ($errors->has('role_id'))
								<span id="helpBlockRoleId" class="form-control-feedback form-text gf-red">- {{ $errors->first('role_id') }}</span>
							@endif
							@if ($user->id == $currentUser->id)
								<span id="helpBlockRoleId" class="form-control-feedback form-text text-warning">- This field is disabled. You cannot change your own role.</span>
							@endif
							<span id="helpBlockRoleId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Status</label>
							@foreach ($statuses as $status)
								<div class="form-check status_id-{{ $status->id }}">
									<label for="status_id-{{ str_slug($status->title) }}" class="form-check-label {{ ($user->id == $currentUser->id) ? 'text-disabled' : '' }}">
										<input type="radio" name="status_id" id="status_id-{{ str_slug($status->title) }}" class="form-check-input" value="{{ $status->id }}" tabindex="10" aria-describedby="helpBlockStatusId" {{ (old('status_id') == $status->id || $user->status_id == $status->id) ? 'checked' : '' }} {{ ($user->id == $currentUser->id) ? 'disabled' : '' }}>{{ $status->title }}@if (!empty($status->description))&nbsp;<i class="fa fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="{{ $status->description }}" aria-hidden="true"></i>@endif
									</label>
								</div>
							@endforeach
							@if ($errors->has('status_id'))
								<span id="helpBlockStatusId" class="form-control-feedback form-text gf-red">- {{ $errors->first('status_id') }}</span>
							@endif
							@if ($user->id == $currentUser->id)
								<span id="helpBlockStatusId" class="form-control-feedback form-text text-warning">- This field is disabled. You cannot change your own status.</span>
							@endif
							<span id="helpBlockStatusId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_users'))
								<a href="/cp/users" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="12" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-primary" tabindex="11" title="Save Changes">Save Changes</button>
							@if ($currentUser->hasPermission('delete_users') && $user->id != $currentUser->id)
								<a href="/cp/users/{{ $user->id }}/delete" title="Delete User" class="pull-right btn btn-outline-danger">Delete User</a>
							@endif
							@if ($currentUser->hasPermission('edit_passwords_users') || $user->id == $currentUser->id)
								<a href="/cp/users/{{ $user->id }}/edit/password" title="Change Password" class="pull-right btn btn-outline-secondary {{ ($user->id != $currentUser->id) ? 'cancel-button' : '' }}">Change Password</a>
							@endif
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
