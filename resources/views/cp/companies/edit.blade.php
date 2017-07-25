@extends('_layouts.default')

@section('title', 'Edit Company - Companies- '.config('app.name'))
@section('description', 'Edit Company - Companies - '.config('app.name'))
@section('keywords', 'Edit, Company, Companies, '.config('app.name'))

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
				<div class="content padding bg-white">
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="editCompany" id="editCompany" class="editCompany" role="form" method="POST" action="/cp/companies/{{ $company->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') ?? $company->title }}" placeholder="e.g Grampian Fasteners" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="default_location_id" class="control-label font-weight-bold">Location</label>
							<select name="default_location_id" id="default_location_id" class="form-control" tabindex="2" aria-describedby="helpBlockDefaultLocationId" required>
								@foreach ($locations as $location)
									<option value="{{ $location->id }}" {{ (old('default_location_id') == $location->id || $company->default_location_id == $location->id) ? 'selected' : '' }}>{{ $location->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('default_location_id'))
								<span id="helpBlockDefaultLocationId" class="form-control-feedback form-text gf-red">- {{ $errors->first('default_location_id') }}</span>
							@endif
							<span id="helpBlockDefaultLocationId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-buttons">
							<a href="/cp/companies" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="4" title="Cancel">Cancel</a>
							<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" tabindex="3" title="Save Changes">Save Changes</button>
							@if ($company->id != Auth::user()->company_id)
								<a href="/cp/companies/{{ $company->id }}/delete" title="Delete Company" class="pull-right btn btn-outline-danger">Delete Company</a>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
@endsection
