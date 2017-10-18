@extends('_layouts.default')

@section('title', 'Edit Carousel - Carousels - '.config('app.name'))
@section('description', 'Edit Carousel - Carousels - '.config('app.name'))
@section('keywords', 'Edit, Carousel, Carousels, '.config('app.name'))

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
			<a href="/cp/carousels" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
		@endif
		<button type="button" name="add_form_group" id="add_form_group" class="btn btn-outline-success add_form_group cancel-button" title="Add Slide">Add Slide</button>
		<button type="submit" name="submit_edit_carousel" id="submit_edit_carousel" class="btn btn-primary" title="Save Changes">Save Changes</button>
		@if ($currentUser->hasPermission('delete_carousels'))
			<a href="/cp/carousels/{{ $carousel->id }}/delete" title="Delete Carousel" class="pull-right btn btn-outline-danger">Delete Carousel</a>
		@endif
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
					<form name="editCarousel" id="editCarousel" class="editCarousel" role="form" method="POST" action="/cp/carousels/{{ $carousel->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="id" value="{{ $carousel->id }}">
						@yield('formButtons')
						<div class="spacer"></div>
						<div class="spacer"></div>
						<p><span class="text-danger">&#42;</span> denotes a required field.</p>
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title', optional($carousel)->title) }}" placeholder="e.g Homepage Carousel" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="handle" class="control-label font-weight-bold">Handle <span class="text-danger">&#42;</span></label>
							<input type="text" name="handle" id="handle" class="form-control" value="{{ old('handle') ?? $carousel->handle }}" placeholder="e.g homepage_carousel" tabindex="2" autocomplete="off" aria-describedby="helpBlockHandle" required>
							@if ($errors->has('handle'))
								<span id="helpBlockHandle" class="form-control-feedback form-text gf-red">- {{ $errors->first('handle') }}</span>
							@endif
							<span id="helpBlockHandle" class="form-control-feedback form-text text-muted">- The handle is auto-generated based on the title but feel free to edit it.</span>
						</div>
						<div id="wrapper">
							@foreach ($carousel->slides as $key => $slide)
								@php ($key = $key + 1)
								@if ($loop->index == 0)
									<div class="spacer"></div>
								@endif
								<div class="form-group">
									@if ($loop->index > 0)
										<div class="spacer"></div>
										<div class="spacer"><hr></div>
										<div class="spacer"></div>
									@endif
									<label for="slide_{{ $key }}_image" class="control-label font-weight-bold">Slide {{ $key }} Image @if ($loop->index == 0)<span class="text-danger">&#42;</span>@endif</label>
									<div class="input-group">
										<input type="text" name="slide_{{ $key }}_image" id="slide_{{ $key }}_image" class="form-control" autocomplete="off" placeholder="" value="{{ old('slide_'.$key.'_image', $slide['slide_'.$key.'_image']) }}" tabindex="{{ ($key + 2) }}" aria-describedby="helpBlockSlideImage{{ $key }}" @if ($loop->index == 0) required @endif>
										<span class="input-group-btn">
											<a href="javascript:void(0);" title="Select Asset" rel="nofollow" data-toggle="modal" data-target="#slide_{{ $key }}_image-browse-modal" data-field_id="slide_{{ $key }}_image" data-value="{{ old('slide_'.$key.'_image', $slide['slide_'.$key.'_image']) }}" class="btn btn-outline-secondary">Select Asset</a>
											<a href="javascript:void(0);" title="Clear Asset" rel="nofollow" id="slide_{{ $key }}_image-reset-field" class="btn btn-outline-secondary">Clear Asset</a>
										</span>
									</div>
									<div class="spacer"></div>
									<label for="slide_{{ $key }}_content" class="control-label font-weight-bold">Slide {{ $key }} Content</label>
									<textarea name="slide_{{ $key }}_content" id="slide_{{ $key }}_content" class="form-control redactor" autocomplete="off" placeholder="" rows="5" cols="50" tabindex="{{ ($key + 3) }}" aria-describedby="helpBlockSlideContent{{ $key }}">{{ old('slide_'.$key.'_content', $slide['slide_'.$key.'_content']) }}</textarea>
									@if ($loop->index > 0)
										<div class="spacer"></div>
										<div class="text-right">
											<a href="javascript:void(0);" title="Remove Slide" rel="nofollow" class="btn btn-outline-warning remove_field" data-counter="{{ $key }}">Remove Slide {{ $key }}</a>
										</div>
									@endif
									<div class="modal fade" id="slide_{{ $key }}_image-browse-modal" tabindex="-1" role="dialog" aria-labelledby="slide_{{ $key }}_image-browse-modal-label" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-xl" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="slide_{{ $key }}_image-browse-modal-label">Assets</h5>
												</div>
												<div class="modal-body">
													<div class="container-fluid">
														<div class="row no-gutters">
															<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 text-left">
																<div id="slide_{{ $key }}_image-container"></div>
															</div>
															<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 text-center">
																<div id="slide_{{ $key }}_image-selected-asset-preview"></div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<div class="container-fluid">
														<div class="row d-flex h-100 justify-content-start">
															<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 align-self-center align-self-sm-center align-self-md-left align-self-lg-left align-self-xl-left">
																<div class="text-center text-sm-center text-md-left text-lg-left text-xl-left selected-asset" id="slide_{{ $key }}_image-selected-asset"></div>
															</div>
															<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center text-sm-center text-md-center text-lg-right text-xl-right align-self-center">
																<button type="button" class="btn btn-primary" id="slide_{{ $key }}_image-select-asset">Insert</button>
																<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
						@yield('formButtons')
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
