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
					<p>Please select the new directory you want to move the <strong>{{ $asset->media->name }}</strong> asset too.</p>
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="moveAsset" id="moveAsset" class="moveAsset" role="form" method="POST" action="/cp/assets/{{ $asset->id }}/move">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label class="control-label font-weight-bold">Current Directory</label>
							<input name="text" name="disk" id="disk" class="form-control" value="{{ $asset->media->directory }}" tabindex="1" aria-describedby="helpBlockDisk" disabled>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">New Directory</label>
							<select name="path" id="path" class="form-control" tabindex="6" aria-describedby="helpBlockPath" required>
								<option value="0" selected>Top Level</option>
								@foreach ($directories as $directory)
									@php ($indent = '')
									@php ($depth = $directory->depth)
									@while ($depth > 0)
										@php ($indent .= '-')
										@php ($depth--)
									@endwhile
									@if ($indent > '')
										@php ($indent .= '&nbsp;')
									@endif
									<option value="{{ $directory->path }}" {{ (old('path') == $directory->path || $asset->media->disk == $directory->path) ? 'selected' : '' }}>{{ $indent }}{{ $directory->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('path'))
								<span id="helpBlockPath" class="form-control-feedback form-text gf-red">- {{ $errors->first('path') }}</span>
							@endif
							<span id="helpBlockPath" class="form-control-feedback form-text text-muted"></span>
						</div>
						@if ($currentUser->hasPermission('view_assets'))
							<a href="/cp/assets" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
						@endif
						<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" title="Move">Move</button>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
