@extends('_layouts.default')

@section('title', 'Edit Global - Globals - '.config('app.name'))
@section('description', 'Edit Global - Globals - '.config('app.name'))
@section('keywords', 'Edit, Global, Globals, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/cp.css') }}">
@endpush

@push('headScripts')
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/cp.js') }}"></script>
	@include('cp._partials.listeners')
@endpush

@section('formButtons')
	<div class="form-buttons">
		@if ($currentUser->hasPermission('view_globals'))
			<a href="/cp/globals" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit" id="submit" class="btn btn-primary" title="Save Changes">Save Changes</button>
		@if ($currentUser->hasPermission('delete_globals'))
			<a href="/cp/globals/{{ $global->id }}/delete" title="Delete Global" class="pull-right btn btn-outline-danger">Delete Global</a>
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
					<form name="editGlobal" id="editGlobal" class="editGlobal" role="form" method="POST" action="/cp/globals/{{ $global->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="id" value="{{ $global->id }}">
						@yield('formButtons')
						<div class="spacer"></div>
						<div class="spacer"></div>
						<p><span class="text-danger">&#42;</span> denotes a required field.</p>
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title', optional($global)->title) }}" placeholder="e.g Twitter" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="handle" class="control-label font-weight-bold">Handle <span class="text-danger">&#42;</span></label>
							<input type="text" name="handle" id="handle" class="form-control" value="{{ old('handle') ?? $global->handle }}" placeholder="e.g twitter" tabindex="2" autocomplete="off" aria-describedby="helpBlockHandle" required>
							@if ($errors->has('handle'))
								<span id="helpBlockHandle" class="form-control-feedback form-text gf-red">- {{ $errors->first('handle') }}</span>
							@endif
							<span id="helpBlockHandle" class="form-control-feedback form-text text-muted">- The handle is auto-generated based on the title but feel free to edit it.</span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="data" class="control-label font-weight-bold">Data</label>
							<textarea name="data" id="data" class="form-control" autocomplete="off" placeholder="e.g https://twitter.com/fastenerpeople" rows="5" cols="50" tabindex="3" aria-describedby="helpBlockData">{{ old('data', optional($global)->data) }}</textarea>
							@if ($errors->has('data'))
								<span id="helpBlockData" class="form-control-feedback form-text gf-red">- {{ $errors->first('data') }}</span>
							@endif
							<span id="helpBlockData" class="form-control-feedback form-text text-muted"></span>
						</div>
						@yield('formButtons')
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
