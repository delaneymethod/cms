@extends('_layouts.default')

@section('title', 'Edit Status - Statuses - '.config('app.name'))
@section('description', 'Edit Status - Statuses - '.config('app.name'))
@section('keywords', 'Edit, Status, Statuses, '.config('app.name'))

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
					<form name="editStatus" id="editStatus" class="editStatus" role="form" method="POST" action="/cp/advanced/statuses/{{ $status->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title', optional($status)->title) }}" placeholder="e.g Open" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="description" class="control-label font-weight-bold">Description <span class="text-danger">&#42;</span></label>
							<input type="text" name="description" id="description" class="form-control" value="{{ old('description', optional($status)->description) }}" placeholder="" tabindex="2" autocomplete="off" aria-describedby="helpBlockDescription" required>
							@if ($errors->has('description'))
								<span id="helpBlockDescription" class="form-control-feedback form-text gf-red">- {{ $errors->first('description') }}</span>
							@endif
							<span id="helpBlockDescription" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_statuses'))
								<a href="/cp/locations" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="4" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" tabindex="3" title="Save Changes">Save Changes</button>
							@if ($currentUser->hasPermission('delete_statuses'))
								<a href="/cp/advanced/statuses/{{ $status->id }}/delete" title="Delete Status" class="pull-right btn btn-outline-danger">Delete Status</a>
							@endif
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
