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
			handle: 'i',
			items: 'li',
			toleranceElement: '> i',
			placeholder: 'ui-sortable-placeholder'
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
						<form name="" id="" class="" role="form" method="POST" action="{{ url('/dashboard/menu') }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<input type="hidden" name="tree" id="tree" value="">
							@php
								echo '<ol class="sortable">';
									
								foreach ($pages as $page) {
									renderPage($page);
								}
								
								echo '</ol>';
								
								function renderPage($page) {
									echo '<li id="page_'.$page->id.'"><i class="fa fa-bars" aria-hidden="true"></i><span>'.$page->title.'</span><a href="" title="Edit '.$page->title.'"><i class="fa fa-pencil pull-right" aria-hidden="true"></i></a>';
								
									if ($page->children()->count() > 0) {
										echo '<ol>';
									
										foreach($page->children as $child) {
											renderPage($child);
										}
									
										echo '</ol>';
									}
									
									echo '</li>';
								}
				    		@endphp
							<button type="submit" name="" id="" class="" title="">Save</button>
						</form>
					</div>
				</div>
			</div>
		</div>
@endsection
