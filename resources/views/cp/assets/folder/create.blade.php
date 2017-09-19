@extends('_layouts.default')

@section('title', 'Create Folder - Assets - '.config('app.name'))
@section('description', 'Create Folder - Assets - '.config('app.name'))
@section('keywords', 'Create, Folder, Assets, '.config('app.name'))

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
					<form name="createFolderAsset" id="createFolderAsset" class="createFolderAsset" role="form" method="POST" action="/cp/assets/folder">
						{{ csrf_field() }}
						<input type="hidden" name="directory" value="{{ $directory }}">
						<div class="form-group">
							<label class="control-label font-weight-bold">Directory</label>
							<input type="text" class="form-control" value="{{ $directory }}" tabindex="1" aria-describedby="helpBlockDirectory" readonly>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Folder Name</label>
							<input type="text" name="folder" id="folder" class="form-control" value="{{ old('folder') }}" tabindex="2" aria-describedby="helpBlockFolder" focus required>
							@if ($errors->has('folder'))
								<span id="helpBlockFolder" class="form-control-feedback form-text gf-red">- {{ $errors->first('folder') }}</span>
							@endif
							<span id="helpBlockFolder" class="form-control-feedback form-text text-muted"></span>
						</div>
						@if ($currentUser->hasPermission('view_assets'))
							<a href="/cp/assets" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
						@endif
						<button type="submit" name="submit" id="submit" class="btn btn-primary" title="Save Changes">Save Changes</button>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
