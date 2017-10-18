@extends('_layouts.default')

@section('title', 'Delete Global - Globals - '.config('app.name'))
@section('description', 'Delete Global - Globals - '.config('app.name'))
@section('keywords', 'Delete, Global, Globals, '.config('app.name'))

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
					<p>Please confirm that you wish to delete the <strong>{{ $global->title }}</strong> global.</p>
					<p class="font-weight-bold text-warning"><i class="icon fa fa-exclamation-triangle" aria-hidden="true"></i>Caution: This action cannot be undone.</p>
					<form name="removeGlobal" id="removeGlobal" class="removeGlobal" role="form" method="POST" action="/cp/globals/{{ $global->id }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<div class="spacer blank"></div>
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_globals'))
								<a href="/cp/globals" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="2" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit_remove_global" id="submit_remove_global" class="btn btn-danger" tabindex="1" title="Delete">Delete</button>
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
