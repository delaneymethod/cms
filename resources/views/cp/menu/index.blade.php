@extends('_layouts.default')

@section('title', 'Menu - '.config('app.name'))
@section('description', 'Menu - '.config('app.name'))
@section('keywords', 'Menu, '.config('app.name'))

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
				@if ($currentUser->hasPermission('create_pages'))
					<div class="content padding bg-white">
						<ol class="sortable list-unstyled" id="nestedSortable">
							@foreach ($pagesHierarchy as $page)
								@component ('cp._components.renderPage', [
									'page' => $page,
									'currentUser' => $currentUser
								])
								@endcomponent
							@endforeach
						</ol>
						<form name="menu" id="menu" class="menu" role="form" method="POST" action="/cp/menu">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<input type="hidden" name="tree" id="tree" value="">
							<div class="row">
								<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
									<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;margin-top: -15px;"><hr></div>
									<button type="submit" name="submit_menu" id="submit_menu" class="pull-right btn btn-primary" title="Save Changes"><i class="icon fa fa-check-circle" aria-hidden="true"></i>Save Changes</button>
								</div>
							</div>
						</form>
					</div>
			    @endif
			    @include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
