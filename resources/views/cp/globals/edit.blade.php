@extends('_layouts.default')

@section('title', 'Edit Global - Globals - '.config('app.name'))
@section('description', 'Edit Global - Globals - '.config('app.name'))
@section('keywords', 'Edit, Global, Globals, '.config('app.name'))

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
			<a href="/cp/globals" title="Cancel" class="btn btn-link text-secondary" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit_edit_global" id="submit_edit_global" class="pull-right btn btn-primary" title="Save Changes"><i class="icon fa fa-check-circle" aria-hidden="true"></i>Save Changes</button>
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
						<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;"><hr></div>
						<div class="spacer"></div>
						<p><i class="fa fa-info-circle" aria-hidden="true"></i> Fields marked with <span class="text-danger">&#42;</span> are required.</p>
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
