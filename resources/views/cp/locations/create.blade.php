@extends('_layouts.default')

@section('title', 'Create Location - Locations - '.config('app.name'))
@section('description', 'Create Location - Locations - '.config('app.name'))
@section('keywords', 'Create, Location, Locations, '.config('app.name'))

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
		@if ($currentUser->hasPermission('view_locations'))
			<a href="/cp/locations" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="16" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit_create_location" id="submit_create_location" class="btn btn-primary" tabindex="15" title="Save Changes">Save Changes</button>
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
					<form name="createLocation" id="createLocation" class="createLocation" role="form" method="POST" action="/cp/locations">
						{{ csrf_field() }}
						<input type="hidden" name="solution_id" value="">
						@yield('formButtons')
						<div class="spacer"></div>
						<div class="spacer"></div>
						<p><span class="text-danger">&#42;</span> denotes a required field.</p>
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="e.g Dyce Office" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="unit" class="control-label font-weight-bold">Unit</label>
							<input type="text" name="unit" id="unit" class="form-control" value="{{ old('unit') }}" placeholder="" tabindex="2" autocomplete="off" aria-describedby="helpBlockUnit">
							@if ($errors->has('unit'))
								<span id="helpBlockUnit" class="form-control-feedback form-text gf-red">- {{ $errors->first('unit') }}</span>
							@endif
							<span id="helpBlockUnit" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="building" class="control-label font-weight-bold">Building</label>
							<input type="text" name="building" id="building" class="form-control" value="{{ old('building') }}" placeholder="e.g Grampian House" tabindex="3" autocomplete="off" aria-describedby="helpBlockBuilding">
							@if ($errors->has('building'))
								<span id="helpBlockBuilding" class="form-control-feedback form-text gf-red">- {{ $errors->first('building') }}</span>
							@endif
							<span id="helpBlockBuilding" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="street_address_1" class="control-label font-weight-bold">Street Address 1 <span class="text-danger">&#42;</span></label>
							<input type="text" name="street_address_1" id="street_address_1" class="form-control" value="{{ old('street_address_1') }}" placeholder="e.g Pitmedden Road" tabindex="4" autocomplete="off" aria-describedby="helpBlockStreetAddress1" required>
							@if ($errors->has('street_address_1'))
								<span id="helpBlockStreetAddress1" class="form-control-feedback form-text gf-red">- {{ $errors->first('street_address_1') }}</span>
							@endif
							<span id="helpBlockStreetAddress1" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="street_address_2" class="control-label font-weight-bold">Street Address 2</label>
							<input type="text" name="street_address_2" id="street_address_2" class="form-control" value="{{ old('street_address_2') }}" placeholder="e.g Dyce" tabindex="5" autocomplete="off" aria-describedby="helpBlockStreetAddress2">
							@if ($errors->has('street_address_2'))
								<span id="helpBlockStreetAddress2" class="form-control-feedback form-text gf-red">- {{ $errors->first('street_address_2') }}</span>
							@endif
							<span id="helpBlockStreetAddress2" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="street_address_3" class="control-label font-weight-bold">Street Address 3</label>
							<input type="text" name="street_address_3" id="street_address_3" class="form-control" value="{{ old('street_address_3') }}" placeholder="" tabindex="6" autocomplete="off" aria-describedby="helpBlockStreetAddress3">
							@if ($errors->has('street_address_3'))
								<span id="helpBlockStreetAddress3" class="form-control-feedback form-text gf-red">- {{ $errors->first('street_address_3') }}</span>
							@endif
							<span id="helpBlockStreetAddress3" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="street_address_4" class="control-label font-weight-bold">Street Address 4</label>
							<input type="text" name="street_address_4" id="street_address_4" class="form-control" value="{{ old('street_address_4') }}" placeholder="" tabindex="7" autocomplete="off" aria-describedby="helpBlockStreetAddress4">
							@if ($errors->has('street_address_4'))
								<span id="helpBlockStreetAddress4" class="form-control-feedback form-text gf-red">- {{ $errors->first('street_address_4') }}</span>
							@endif
							<span id="helpBlockStreetAddress4" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="town_city" class="control-label font-weight-bold">Town / City <span class="text-danger">&#42;</span></label>
							<input type="text" name="town_city" id="town_city" class="form-control" value="{{ old('town_city') }}" placeholder="e.g Aberdeen" tabindex="8" autocomplete="off" aria-describedby="helpBlockTownCity" required>
							@if ($errors->has('town_city'))
								<span id="helpBlockTownCity" class="form-control-feedback form-text gf-red">- {{ $errors->first('town_city') }}</span>
							@endif
							<span id="helpBlockTownCity" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="postal_code" class="control-label font-weight-bold">Postal Code</label>
							<input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code') }}" placeholder="e.g AB21 0DP" tabindex="9" autocomplete="off" aria-describedby="helpBlockPostalCode">
							@if ($errors->has('postal_code'))
								<span id="helpBlockPostalCode" class="form-control-feedback form-text gf-red">- {{ $errors->first('postal_code') }}</span>
							@endif
							<span id="helpBlockPostalCode" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="county_id" class="control-label font-weight-bold">County</label>
							<select name="county_id" id="county_id" class="form-control" tabindex="10" aria-describedby="helpBlockCountyId" required>
								@foreach ($counties as $county)
									<option value="{{ $county->id }}" {{ (old('county_id') == $county->id) ? 'selected' : '' }}>{{ $county->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('county_id'))
								<span id="helpBlockCountyId" class="form-control-feedback form-text gf-red">- {{ $errors->first('county_id') }}</span>
							@endif
							<span id="helpBlockCountyId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="country_id" class="control-label font-weight-bold">Country</label>
							<select name="country_id" id="country_id" class="form-control" tabindex="11" aria-describedby="helpBlockCountryId" required>
								@foreach ($countries as $country)
									<option value="{{ $country->id }}" {{ (old('country_id') == $country->id) ? 'selected' : '' }}>{{ $country->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('country_id'))
								<span id="helpBlockCountryId" class="form-control-feedback form-text gf-red">- {{ $errors->first('country_id') }}</span>
							@endif
							<span id="helpBlockCountryId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="telephone" class="control-label font-weight-bold">Telephone <span class="text-danger">&#42;</span></label>
							<input type="tel" name="telephone" id="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="e.g +44 1224 772 777" tabindex="12" autocomplete="off" aria-describedby="helpBlockTelephone" required>
							@if ($errors->has('telephone'))
								<span id="helpBlockTelephone" class="form-control-feedback form-text gf-red">- {{ $errors->first('telephone') }}</span>
							@endif
							<span id="helpBlockTelephone" class="form-control-feedback form-text text-muted">- Please enter the telephone number in the international format starting with a plus sign (&#43;).</span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="company_id" class="control-label font-weight-bold">Company</label>
							<select name="company_id" id="company_id" class="form-control" tabindex="13" aria-describedby="helpBlockCompanyId" required>
								@foreach ($companies as $company)
									<option value="{{ $company->id }}" {{ (old('company_id') == $company->id) ? 'selected' : '' }}>{{ $company->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('company_id'))
								<span id="helpBlockCompanyId" class="form-control-feedback form-text gf-red">- {{ $errors->first('company_id') }}</span>
							@endif
							<span id="helpBlockCompanyId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Status</label>
							@foreach ($statuses as $status)
								<div class="form-check status_id-{{ $status->id }}">
									<label for="status_id-{{ str_slug($status->title) }}" class="form-check-label">
										<input type="radio" name="status_id" id="status_id-{{ str_slug($status->title) }}" class="form-check-input" value="{{ $status->id }}" tabindex="14" aria-describedby="helpBlockStatusId" {{ (old('status_id') == $status->id) ? 'checked' : ($loop->first) ? 'checked' : '' }}>{{ $status->title }}@if (!empty($status->description))&nbsp;<i class="fa fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="{{ $status->description }}" aria-hidden="true"></i>@endif
									</label>
								</div>
							@endforeach
							@if ($errors->has('status_id'))
								<span id="helpBlockStatusId" class="form-control-feedback form-text gf-red">- {{ $errors->first('status_id') }}</span>
							@endif
							<span id="helpBlockStatusId" class="form-control-feedback form-text text-muted"></span>
						</div>
						@yield('formButtons')
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
