@extends('_layouts.default')

@section('title', 'Move Asset - Assets - '.config('app.name'))
@section('description', 'Move Asset - Assets - '.config('app.name'))
@section('keywords', 'Move, Asset, Assets, '.config('app.name'))

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
					<p>Please select the directory you want to move the <strong>{{ $asset->media->name }}</strong> asset too.</p>
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="moveAsset" id="moveAsset" class="moveAsset" role="form" method="POST" action="/cp/assets/{{ $asset->id }}/move">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="disk" value="{{ $asset->media->disk }}">
						<div class="form-group">
							<label class="control-label font-weight-bold">Current Directory</label>
							<input type="text" name="_directory" id="_directory" class="form-control" value="{{ $asset->media->disk }}" tabindex="1" aria-describedby="helpBlockDisk" disabled>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">New Directory</label>
							
							@if ($errors->has('directory'))
								<span id="helpBlockDirectory" class="form-control-feedback form-text gf-red">- {{ $errors->first('directory') }}</span>
							@endif
							<span id="helpBlockDirectory" class="form-control-feedback form-text text-muted"></span>
						</div>
						@if ($currentUser->hasPermission('view_assets'))
							<a href="/cp/assets" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
						@endif
						<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" title="Save Changes">Save Changes</button>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
