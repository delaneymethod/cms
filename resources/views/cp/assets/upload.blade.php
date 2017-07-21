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
			<div class="col-md-9 col-lg-9 main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="uploadAsset" id="uploadAsset" class="uploadAsset" role="form" method="POST" action="/cp/assets" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="files" class="control-label font-weight-bold">Assets <span class="text-danger">&#42;</span></label>
							<input type="file" name="files[]" id="files" class="form-control-file" tabindex="1" autocomplete="off" aria-describedby="helpBlockFiles" required multiple>
							@if ($errors->has('files'))
								<span id="helpBlockFiles" class="form-control-feedback form-text gf-red">- {{ $errors->first('files') }}</span>
							@endif
							<span id="helpBlockFiles" class="form-control-feedback form-text text-muted"></span>
						</div>
						<a href="/cp/assets" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
						<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" title="Upload">Upload</button>
					</form>
				</div>
			</div>
		</div>
@endsection
