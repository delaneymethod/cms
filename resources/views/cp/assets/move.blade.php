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
	@include('cp._partials.listeners')
@endpush

@section('content')
		<div class="row wrapper">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<p>Please select the new directory you want to move the <strong>{{ $asset->filename }}</strong> asset into.</p>
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="moveAsset" id="moveAsset" class="moveAsset" role="form" method="POST" action="/cp/assets/{{ $asset->id }}/move">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label class="control-label font-weight-bold">Current Directory</label>
							<input type="text" name="_directory" id="_directory" class="form-control" value="{{ $path }}" tabindex="1" disabled>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">New Directory</label>
							<select name="new_path" id="new_path" class="form-control">
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
									<option value="{{ $directory->path }}" {{ (old('new_path') == $directory->path || $path == $directory->path) ? 'disabled' : '' }}>{{ $indent }}{{ $directory->path }}</option>
								@endforeach
							</select>
							@if ($errors->has('new_path'))
								<span id="helpBlockNewPath" class="form-control-feedback form-text gf-red">- {{ $errors->first('new_path') }}</span>
							@endif
							<span id="helpBlockNewPath" class="form-control-feedback form-text text-muted"></span>
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
