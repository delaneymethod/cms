@extends('_layouts.default')

@section('title', 'Edit Company - Companies - '.config('app.name'))
@section('description', 'Edit Company - Companies - '.config('app.name'))
@section('keywords', 'Edit, Company, Companies, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
@endpush

@section('formButtons')
	<div class="form-buttons">
		@if ($currentUser->hasPermission('view_companies'))
			<a href="/cp/companies" title="Cancel" class="btn btn-link text-secondary" tabindex="4" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit_edit_company" id="submit_edit_company" class="pull-right btn btn-primary" tabindex="3" title="Save Changes"><i class="icon fa fa-check-circle" aria-hidden="true"></i>Save Changes</button>
	</div>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<form name="editCompany" id="editCompany" class="editCompany" role="form" method="POST" action="/cp/companies/{{ $company->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="solution_id" value="{{ $company->solution_id }}">
						@yield('formButtons')
						<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;"><hr></div>
						<div class="spacer"></div>
						<p><i class="fa fa-info-circle" aria-hidden="true"></i> Fields marked with <span class="text-danger">&#42;</span> are required.</p>
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title', optional($company)->title) }}" placeholder="e.g {{ $siteName }}" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="default_location_id" class="control-label font-weight-bold">Default Location</label>
							<select name="default_location_id" id="default_location_id" class="form-control" tabindex="2" aria-describedby="helpBlockDefaultLocationId" required>
								@foreach ($locations as $location)
									<option value="{{ $location->id }}" {{ (old('default_location_id') == $location->id || $company->default_location_id == $location->id) ? 'selected' : '' }}>{{ $location->title }}{{ ($location->isPending() || $location->isRetired()) ? '&nbsp;('.$location->status->title.')' : '' }}</option>
								@endforeach
							</select>
							@if ($errors->has('default_location_id'))
								<span id="helpBlockDefaultLocationId" class="form-control-feedback form-text gf-red">- {{ $errors->first('default_location_id') }}</span>
							@endif
							<span id="helpBlockDefaultLocationId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;margin-bottom: -30px;"><hr></div>
						@yield('formButtons')
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
