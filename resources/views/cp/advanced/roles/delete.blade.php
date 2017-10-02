@extends('_layouts.default')

@section('title', 'Delete Role - Roles - '.config('app.name'))
@section('description', 'Delete Role - Roles - '.config('app.name'))
@section('keywords', 'Delete, Role, Roles, '.config('app.name'))

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
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<p>Please confirm that you wish to delete the <strong>{{ $role->title }}</strong> role.</p>
					<p class="font-weight-bold text-warning"><i class="icon fa fa-exclamation-triangle" aria-hidden="true"></i>Caution: This action cannot be undone.</p>
					<form name="removeRole" id="removeRole" class="removeRole" role="form" method="POST" action="/cp/advanced/roles/{{ $role->id }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_roles'))
								<a href="/cp/advanced/roles" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="2" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-danger" tabindex="1" title="Delete">Delete</button>
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
