@extends('_layouts.default')

@section('title', 'Create Carousel - Carousels - '.config('app.name'))
@section('description', 'Create Carousel - Carousels - '.config('app.name'))
@section('keywords', 'Create, Carousel, Carousels, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
	@include('cp._partials.carouselBuilderScripts')
@endpush

@section('formButtons')
	<div class="form-buttons">
		@if ($currentUser->hasPermission('view_carousels'))
			<a href="/cp/carousels" title="Cancel" class="btn btn-link text-secondary cancel-button" title="Cancel">Cancel</a>
		@endif
		<button type="button" name="add_form_group" id="add_form_group" class="btn btn-outline-success add_form_group" title="Add Slide">Add Slide</button>
		<button type="submit" name="submit_create_carousel" id="submit_create_carousel" class="pull-right btn btn-primary" title="Save Changes"><i class="icon fa fa-check-circle" aria-hidden="true"></i>Save Changes</button>
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
					<form name="createCarousel" id="createCarousel" class="createCarousel" role="form" method="POST" action="/cp/carousels">
						{{ csrf_field() }}
						@yield('formButtons')
						<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;"><hr></div>
						<div class="spacer"></div>
						<p><i class="fa fa-info-circle" aria-hidden="true"></i> Fields marked with <span class="text-danger">&#42;</span> are required.</p>
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="e.g Homepage Carousel" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="handle" class="control-label font-weight-bold">Handle <span class="text-danger">&#42;</span></label>
							<input type="text" name="handle" id="handle" class="form-control" value="{{ old('handle') }}" placeholder="e.g homepage_carousel" tabindex="2" autocomplete="off" aria-describedby="helpBlockHandle" required>
							@if ($errors->has('handle'))
								<span id="helpBlockHandle" class="form-control-feedback form-text gf-red">- {{ $errors->first('handle') }}</span>
							@endif
							<span id="helpBlockHandle" class="form-control-feedback form-text text-muted">- The handle is auto-generated based on the title but feel free to edit it.</span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="slide_1_image" class="control-label font-weight-bold">Slide 1 Image <span class="text-danger">&#42;</span></label>
							<div class="input-group">
								<input type="text" name="slide_1_image" id="slide_1_image" class="form-control" autocomplete="off" placeholder="" value="{{ old('slide_1_image') }}" tabindex="3" aria-describedby="helpBlockSlideImage1" required>
								<span class="input-group-btn">
									<a href="javascript:void(0);" title="Select Asset" rel="nofollow" data-toggle="modal" data-target="#slide_1_image-browse-modal" data-field_id="slide_1_image" data-value="{{ old('slide_1_image') }}" class="btn btn-outline-secondary">Select Asset</a>
									<a href="javascript:void(0);" title="Clear Asset" rel="nofollow" id="slide_1_image-reset-field" class="btn btn-outline-secondary">Clear Asset</a>
								</span>
							</div>
							<div class="spacer"></div>
							<label for="slide_1_content" class="control-label font-weight-bold">Slide 1 Content</label>
							<textarea name="slide_1_content" id="slide_1_content" class="form-control redactor" autocomplete="off" placeholder="" rows="5" cols="50" tabindex="4" aria-describedby="helpBlockSlideContent1">{{ old('slide_1_content') }}</textarea>
							<div class="modal fade" id="slide_1_image-browse-modal" tabindex="-1" role="dialog" aria-labelledby="slide_1_image-browse-modal-label" aria-hidden="true">
								<div class="modal-dialog modal-lg modal-xl" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="slide_1_image-browse-modal-label">Assets</h5>
										</div>
										<div class="modal-body">
											<div class="container-fluid">
												<div class="row no-gutters">
													<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 text-left">
														<div id="slide_1_image-container"></div>
													</div>
													<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 text-center">
														<div id="slide_1_image-selected-asset-preview"></div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<div class="container-fluid">
												<div class="row d-flex h-100 justify-content-start">
													<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 align-self-center align-self-sm-center align-self-md-left align-self-lg-left align-self-xl-left">
														<div class="text-center text-sm-center text-md-left text-lg-left text-xl-left selected-asset" id="slide_1_image-selected-asset"></div>
													</div>
													<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center text-sm-center text-md-center text-lg-right text-xl-right align-self-center">
														<button type="button" class="btn btn-primary" id="slide_1_image-select-asset">Insert</button>
														<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="wrapper"></div>
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
