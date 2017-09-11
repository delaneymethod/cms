@extends('_layouts.default')

@section('title', 'Assets - '.config('app.name'))
@section('description', 'Assets - '.config('app.name'))
@section('keywords', 'Assets, '.config('app.name'))

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
					<form name="uploadAsset" id="uploadAsset" class="uploadAsset" role="form" method="POST" action="/cp/assets" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="directory" value="{{ $directory }}">
						<div class="form-group">
							<label class="control-label font-weight-bold">Directory</label>
							<input type="text" class="form-control" value="{{ $directory }}" tabindex="1" aria-describedby="helpBlockDirectory" readonly>
						</div>
						<div class="form-group">
							<label for="files" class="control-label font-weight-bold">Files <span class="text-danger">&#42;</span></label>
							<input type="file" name="files[]" id="files" class="form-control-file" tabindex="2" autocomplete="off" aria-describedby="helpBlockFiles" required multiple>
							@if ($errors->has('files'))
								<span id="helpBlockFiles" class="form-control-feedback form-text gf-red">- {{ $errors->first('files') }}</span>
							@endif
							<span id="helpBlockFiles" class="form-control-feedback form-text text-muted"></span>
						</div>
						@if ($currentUser->hasPermission('view_assets'))
							<a href="/cp/assets" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
						@endif
						<button type="submit" name="submit" id="submit" class="btn btn-primary" title="Upload">Upload</button>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
