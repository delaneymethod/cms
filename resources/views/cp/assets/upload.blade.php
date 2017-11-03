@extends('_layouts.default')

@section('title', 'Assets - '.config('app.name'))
@section('description', 'Assets - '.config('app.name'))
@section('keywords', 'Assets, '.config('app.name'))

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
		@if ($currentUser->hasPermission('view_assets'))
			<a href="/cp/assets" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit_upload_asset" id="submit_upload_asset" class="pull-right float-sm-right float-md-none float-lg-none float-xl-none btn btn-primary" title="Upload">Upload</button>
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
					<form name="uploadAsset" id="uploadAsset" class="uploadAsset" role="form" method="POST" action="/cp/assets" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="directory" value="{{ $directory }}">
						@yield('formButtons')
						<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;"><hr></div>
						<div class="spacer"></div>
						<p><span class="text-danger">&#42;</span> denotes a required field.</p>
						<div class="form-group">
							<label class="control-label font-weight-bold">Directory</label>
							<input type="text" class="form-control" value="{{ $directory }}" tabindex="1" aria-describedby="helpBlockDirectory" readonly>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="files" class="control-label font-weight-bold">Files <span class="text-danger">&#42;</span></label>
							<input type="file" name="files[]" id="files" class="form-control-file" tabindex="2" autocomplete="off" aria-describedby="helpBlockFiles" required multiple>
							@if ($errors->has('files'))
								<span id="helpBlockFiles" class="form-control-feedback form-text gf-red">- {{ $errors->first('files') }}</span>
							@endif
							<span id="helpBlockFiles" class="form-control-feedback form-text text-muted"></span>
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
