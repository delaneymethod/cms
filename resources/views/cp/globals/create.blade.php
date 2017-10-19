@extends('_layouts.default')

@section('title', 'Create Global - Globals - '.config('app.name'))
@section('description', 'Create Global - Globals - '.config('app.name'))
@section('keywords', 'Create, Global, Globals, '.config('app.name'))

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
		@if ($currentUser->hasPermission('view_globals'))
			<a href="/cp/globals" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit_create_global" id="submit_create_global" class="pull-right float-sm-right float-md-none float-lg-none float-xl-none btn btn-primary" title="Save Changes">Save Changes</button>
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
					<form name="createGlobal" id="createGlobal" class="createGlobal" role="form" method="POST" action="/cp/globals">
						{{ csrf_field() }}
						@yield('formButtons')
						<div class="spacer"></div>
						<div class="spacer"></div>
						<p><span class="text-danger">&#42;</span> denotes a required field.</p>
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="e.g Twitter" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="handle" class="control-label font-weight-bold">Handle <span class="text-danger">&#42;</span></label>
							<input type="text" name="handle" id="handle" class="form-control" value="{{ old('handle') }}" placeholder="e.g twitter" tabindex="2" autocomplete="off" aria-describedby="helpBlockHandle" required>
							@if ($errors->has('handle'))
								<span id="helpBlockHandle" class="form-control-feedback form-text gf-red">- {{ $errors->first('handle') }}</span>
							@endif
							<span id="helpBlockHandle" class="form-control-feedback form-text text-muted">- The handle is auto-generated based on the title but feel free to edit it.</span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="data" class="control-label font-weight-bold">Data</label>
							<textarea name="data" id="data" class="form-control" autocomplete="off" placeholder="e.g https://twitter.com/fastenerpeople" rows="5" cols="50" tabindex="3" aria-describedby="helpBlockData">{{ old('data') }}</textarea>
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
