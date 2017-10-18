@extends('_layouts.default')

@section('title', 'Delete Asset - Assets - '.config('app.name'))
@section('description', 'Delete Asset - Assets - '.config('app.name'))
@section('keywords', 'Delete, Asset, Assets, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
@endpush

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<p>Please confirm that you wish to delete the <strong>{{ $asset->filename }}</strong> asset.</p>
					<p class="font-weight-bold text-warning"><i class="icon fa fa-exclamation-triangle" aria-hidden="true"></i>Caution: This action cannot be undone.</p>
					<form name="removeAsset" id="removeAsset" class="removeAsset" role="form" method="POST" action="/cp/assets/{{ $asset->id }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<input type="hidden" name="directory" value="{{ $directory }}">
						<div class="spacer blank"></div>
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_assets'))
								<a href="/cp/assets" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="2" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit_remove_asset" id="submit_remove_asset" class="btn btn-danger" tabindex="1" title="Delete">Delete</button>
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
