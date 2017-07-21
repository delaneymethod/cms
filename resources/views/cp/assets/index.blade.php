@extends('_layouts.default')

@section('title', 'Assets - '.config('app.name'))
@section('description', 'Assets - '.config('app.name'))
@section('keywords', 'Assets, '.config('app.name'))

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
			<div class="col-md-9 col-lg-9 main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="row">
					<div class="col">
						<ul class="list-unstyled list-inline buttons">
							<li class="list-inline-item"><a href="/cp/assets/upload" title="Upload Assets" class="btn btn-outline-success"><i class="fa fa-upload" aria-hidden="true"></i>Upload Assets</a></li>
						</ul>
					</div>
				</div>
				<div class="content padding bg-white">					
					@foreach ($assets as $asset)
						{{ $asset->path }}<br>
					@endforeach
				</div>
			</div>
		</div>
@endsection
