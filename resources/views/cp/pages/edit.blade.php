@extends('_layouts.default')

@section('title', 'Edit Page - Pages - '.config('app.name'))
@section('description', 'Edit Page - Pages - '.config('app.name'))
@section('keywords', 'Edit, Page, Pages, '.config('app.name'))

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
						<form name="" id="" class="" role="form" method="PUT" action="{{ url('/cp/pages/{id}') }}">
							{{ csrf_field() }}
							<button type="submit" name="" id="" class="btn btn-outline-primary" title="Update">Update</button>
						</form>
					</div>
				</div>
			</div>
		</div>
@endsection
