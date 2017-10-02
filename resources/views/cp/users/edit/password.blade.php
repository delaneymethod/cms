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
	@include('cp._partials.listeners')
@endpush

@section('content')
		<div class="row wrapper">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="editUser" id="editUser" class="editUser" role="form" method="POST" action="/cp/users/{{ $user->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="first_name" value="{{ $user->first_name }}">
						<input type="hidden" name="last_name" value="{{ $user->last_name }}">
						<input type="hidden" name="email" value="{{ $user->email }}">
						<input type="hidden" name="job_title" value="{{ $user->job_title }}">
						<input type="hidden" name="telephone" value="{{ $user->telephone }}">
						<input type="hidden" name="mobile" value="{{ $user->mobile }}">
						<input type="hidden" name="company_id" value="{{ $user->company_id }}">
						<input type="hidden" name="location_id" value="{{ $user->location_id }}">
						<input type="hidden" name="role_id" value="{{ $user->role_id }}">
						<input type="hidden" name="status_id" value="{{ $user->status_id }}">
						@if ($user->id != $currentUser->id)
							<div class="form-group">
								<label class="control-label font-weight-bold">User Account</label>
								<input type="text" class="form-control text-disabled" value="{{ $user->first_name }} {{ $user->last_name }}" disabled>
							</div>
						@endif
						<div class="form-group">
							<label for="password" class="control-label font-weight-bold">Password <span class="text-danger">&#42;</span></label>
							<input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" placeholder="e.g y1Fwc]_C" tabindex="1" autocomplete="off" aria-describedby="helpBlockPassword" required autofocus>
							@if ($errors->has('password'))
								<span id="helpBlockPassword" class="form-control-feedback form-text gf-red">- {{ $errors->first('first_name') }}</span>
							@endif
							<span id="helpBlockPassword" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="password_confirmation" class="control-label font-weight-bold">Password Confirmation <span class="text-danger">&#42;</span></label>
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" placeholder="e.g y1Fwc]_C" tabindex="2" autocomplete="off" aria-describedby="helpBlockPasswordConfirmation" required>
							@if ($errors->has('password_confirmation'))
								<span id="helpBlockPasswordConfirmation" class="form-control-feedback form-text gf-red">- {{ $errors->first('password_confirmation') }}</span>
							@endif
							<span id="helpBlockPasswordConfirmation" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_users'))
								<a href="/cp/users" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="4" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-primary" tabindex="3" title="Save Changes">Save Changes</button>
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
