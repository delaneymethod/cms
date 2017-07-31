@extends('_layouts.default')

@section('title', 'Menu - '.config('app.name'))
@section('description', 'Menu - '.config('app.name'))
@section('keywords', 'Menu, '.config('app.name'))

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
				<div class="row">
					<div class="col">
						<ul class="list-unstyled list-inline buttons">
							<li class="list-inline-item"><a href="/cp/pages/create" title="Add Page" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Page</a></li>
						</ul>
					</div>
				</div>
				<div class="content padding bg-white">
					<ol class="sortable list-unstyled" id="nestedSortable">
						@foreach ($pages as $page)
							@component('cp._components.renderPage', ['page' => $page, 'currentUser' => $currentUser])
							@endcomponent
						@endforeach
					</ol>
					<form name="menu" id="menu" class="menu" role="form" method="POST" action="/cp/menu">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="tree" id="tree" value="">
						<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" title="Save Changes">Save Changes</button>
					</form>
		    	</div>
			</div>
		</div>
@endsection
