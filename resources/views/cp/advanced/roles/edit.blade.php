@extends('_layouts.default')

@section('title', 'Edit Role - Roles - '.config('app.name'))
@section('description', 'Edit Role - Roles - '.config('app.name'))
@section('keywords', 'Edit, Role, Roles, '.config('app.name'))

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
				<div class="content padding bg-white">
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="editRole" id="editRole" class="editRole" role="form" method="POST" action="/cp/advanced/roles/{{ $role->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title', optional($role)->title) }}" placeholder="e.g Editor" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_roles'))
								<a href="/cp/advanced/roles" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="3" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-primary" tabindex="2" title="Save Changes">Save Changes</button>
							@if ($currentUser->hasPermission('delete_roles'))
								<a href="/cp/advanced/roles/{{ $role->id }}/delete" title="Delete Role" class="pull-right btn btn-outline-danger">Delete Role</a>
							@endif
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
