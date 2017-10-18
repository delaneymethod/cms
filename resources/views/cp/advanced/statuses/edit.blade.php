@extends('_layouts.default')

@section('title', 'Edit Status - Statuses - '.config('app.name'))
@section('description', 'Edit Status - Statuses - '.config('app.name'))
@section('keywords', 'Edit, Status, Statuses, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
@endpush

@section('formButtons')
	<div class="form-buttons">
		@if ($currentUser->hasPermission('view_statuses'))
			<a href="/cp/locations" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="4" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit_edit_status" id="submit_edit_status" class="btn btn-primary" tabindex="3" title="Save Changes">Save Changes</button>
		@if ($currentUser->hasPermission('delete_statuses'))
			<a href="/cp/advanced/statuses/{{ $status->id }}/delete" title="Delete Status" class="pull-right btn btn-outline-danger">Delete Status</a>
		@endif
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
					<form name="editStatus" id="editStatus" class="editStatus" role="form" method="POST" action="/cp/advanced/statuses/{{ $status->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						@yield('formButtons')
						<div class="spacer"></div>
						<div class="spacer"></div>
						<p><span class="text-danger">&#42;</span> denotes a required field.</p>
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title', optional($status)->title) }}" placeholder="e.g Open" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="description" class="control-label font-weight-bold">Description</label>
							<input type="text" name="description" id="description" class="form-control" value="{{ old('description', optional($status)->description) }}" placeholder="" tabindex="2" autocomplete="off" aria-describedby="helpBlockDescription">
							@if ($errors->has('description'))
								<span id="helpBlockDescription" class="form-control-feedback form-text gf-red">- {{ $errors->first('description') }}</span>
							@endif
							<span id="helpBlockDescription" class="form-control-feedback form-text text-muted"></span>
						</div>
						@yield('formButtons')
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
