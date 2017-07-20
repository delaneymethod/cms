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
			@include('cp._partials.sidebar')
			<div class="col-md-9 col-lg-9 main">
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
					<ol class="sortable list-unstyled">
						@foreach ($pages as $page)
							@component('cp._components.renderPage', ['page' => $page])
							@endcomponent
						@endforeach
					</ol>
					<form name="" id="" class="" role="form" method="POST" action="{{ url('/cp/menu') }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="tree" id="tree" value="">
						<button type="submit" name="" id="" class="btn btn-outline-primary" title="Save">Save</button>
					</form>
		    	</div>
			</div>
		</div>
@endsection
