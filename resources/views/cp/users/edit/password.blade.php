@extends('_layouts.default')

@section('title', 'Edit Password - Users - '.config('app.name'))
@section('description', 'Edit Password - Users - '.config('app.name'))
@section('keywords', 'Edit, Password, Users, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
	<script async defer src="/assets/js/zxcvbn.js"></script>
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
@endpush

@section('formButtons')
	<div class="form-buttons">
		@if ($currentUser->hasPermission('view_users'))
			<a href="/cp/users" title="Cancel" class="btn btn-outline-secondary" tabindex="4" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit_edit_user" id="submit_edit_user" class="pull-right btn btn-primary" tabindex="3" title="Save Changes">Save Changes</button>
	</div>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<form name="editUser" id="editUser" class="editUser" role="form" method="POST" action="/cp/users/{{ $user->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						@yield('formButtons')
						<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;"><hr></div>
						<div class="spacer"></div>
						<p><span class="text-danger">&#42;</span> denotes a required field.</p>
						@if ($user->id != $currentUser->id)
							<div class="form-group">
								<label class="control-label font-weight-bold">User Account</label>
								<input type="text" class="form-control text-disabled" value="{{ $user->first_name }} {{ $user->last_name }}" disabled>
							</div>
							<div class="spacer"></div>
						@endif
						<div class="form-group">
							<label for="password" class="control-label font-weight-bold">Password <span class="text-danger">&#42;</span></label>
							<div class="input-group">
								<input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" placeholder="e.g y1Fwc]_C" tabindex="1" autocomplete="off" aria-describedby="helpBlockPassword" required autofocus>
								<span class="input-group-btn">
									<button type="button" name="hide_show_password" id="hide_show_password" class="btn btn-outline-secondary" title="Hide / Show Password">Show Password</button>
								</span>
							</div>
							@if ($errors->has('password'))
								<span id="helpBlockPassword" class="form-control-feedback form-text gf-red">- {{ $errors->first('first_name') }}</span>
							@endif
							<span id="helpBlockPassword" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="password_confirmation" class="control-label font-weight-bold">Password Confirmation <span class="text-danger">&#42;</span></label>
							<div class="input-group">
								<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" placeholder="e.g y1Fwc]_C" tabindex="2" autocomplete="off" aria-describedby="helpBlockPasswordConfirmation" required>
								<span class="input-group-btn">
									<button type="button" name="hide_show_password_confirmation" id="hide_show_password_confirmation" class="btn btn-outline-secondary" title="Hide / Show Password">Show Password</button>
								</span>
							</div>
							@if ($errors->has('password_confirmation'))
								<span id="helpBlockPasswordConfirmation" class="form-control-feedback form-text gf-red">- {{ $errors->first('password_confirmation') }}</span>
							@endif
							<span id="helpBlockPasswordConfirmation" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;margin-bottom: -30px;"><hr></div>
						@yield('formButtons')
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
