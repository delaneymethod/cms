@extends('_layouts.default')

@section('title', 'Menu - Dashboard - '.config('app.name'))
@section('description', 'Menu - Dashboard - '.config('app.name'))
@section('keywords', 'Menu, Dashboard, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/dashboard/css/global.css') }}">
@endpush

@push('headScripts')
	<script async>
	'use strict';
	
	window.User = {!! Auth::check() ? Auth::user() : 'null' !!};
	
	window.Laravel = {'csrfToken': '{{ csrf_token() }}'};
	</script>
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/dashboard/js/global.js') }}"></script>
	<script async>
	window.onload = () => {
		$('form').submit(() => {
			const tree = $('.sortable').nestedSortable('toArray');
				
			$('#tree').val(JSON.stringify(tree));
				
			return true;
		});
	
		$('.sortable').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			placeholder: 'sortable-placeholder',
			tolerance: 'pointer',
			toleranceElement: '> div',
			isTree: true
		});
	};
	</script>
@endpush

@section('content')
		<div class="row wrapper">
			@include('dashboard._partials.sidebar')
			<div class="col-md-9 col-lg-9 main">
				@include('dashboard._partials.message')
				@include('dashboard._partials.pageTitle')
				<div class="row">
					<div class="col">
						<ul class="list-unstyled list-inline buttons">
							<li class="list-inline-item"><a href="/dashboard/pages/create" title="Add Page" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Page</a></li>
						</ul>
					</div>
				</div>
				<div class="content padding bg-white">
					<ol class="sortable list-unstyled">
						@foreach ($pages as $page)
							@component('dashboard._components.renderPage', ['page' => $page])
							@endcomponent
						@endforeach
					</ol>
					<form name="" id="" class="" role="form" method="POST" action="{{ url('/dashboard/menu') }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="tree" id="tree" value="">
						<button type="submit" name="" id="" class="btn btn-outline-primary" title="Save">Save</button>
					</form>
		    	</div>
			</div>
		</div>
@endsection
