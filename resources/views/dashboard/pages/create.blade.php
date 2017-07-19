@extends('_layouts.default')

@section('title', 'Create Page - Pages - Dashboard - '.config('app.name'))
@section('description', 'Create Page - Pages - Dashboard - '.config('app.name'))
@section('keywords', 'Create, Page, Pages, Dashboard, '.config('app.name'))

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
		$('#redactor').redactor({
			focus: false,
			fileUpload: '/upload.php',
			fileManagerJson: '/files/files.json',
			imageUpload: '/upload.php',
			imageManagerJson: '/images/images.json',
			imageResizable: true,
			imagePosition: true,
			structure: true,
			tabAsSpaces: 4,
			plugins: [
        		'source',
        		'table',
        		'alignment',
        		'fullscreen',
        		'filemanager',
        		'imagemanager',
        		'video'
        	],
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
				<div class="content padding bg-white">
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="" id="" class="" role="form" method="POST" action="{{ url('/dashboard/pages') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="" placeholder="New Page" tabindex="1" autocomplete="on" aria-describedby="helpBlockTitle" required>
							<small id="helpBlockTitle" class="form-text text-muted"></small>
						</div>
						<div class="form-group">
							<label for="slug" class="control-label font-weight-bold">Slug <span class="text-danger">&#42;</span></label>
							<input type="text" name="slug" id="slug" class="form-control" value="" placeholder="new-page" tabindex="2" autocomplete="on" aria-describedby="helpBlockSlug" required>
							<small id="helpBlockSlug" class="form-text text-muted">The slug is auto-generated based on the title but feel free to edit it.</small>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Status <span class="text-danger">&#42;</span></label>
							<div class="form-check status-1">
								<label class="form-check-label">
									<input type="radio" name="status" id="status-active" class="form-check-input" value="1" tabindex="3" checked>Active
								</label>
							</div>
							<div class="form-check status-2">
								<label class="form-check-label">
									<input type="radio" name="status" id="status-pending" class="form-check-input" value="2" tabindex="4">Pending
								</label>
							</div>
							<div class="form-check status-3">
								<label class="form-check-label">
									<input type="radio" name="status" id="status-retired" class="form-check-input" value="3" tabindex="5">Retired
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<label for="content" class="control-label font-weight-bold">Content <span class="text-danger">&#42;</span></label>
									<textarea name="content" id="redactor" class="form-control" placeholder="New page content..." tabindex="6" aria-describedby="helpBlockContent" required></textarea>
									<small id="helpBlockContent" class="form-text text-muted"></small>
								</div>
							</div>
						</div>
						<button type="submit" name="" id="" class="btn btn-outline-primary" title="Save">Save</button>
					</form>
				</div>
			</div>
		</div>
@endsection
