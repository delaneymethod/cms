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
	@include('cp._partials.listeners')
	<script async>
	'use strict';
	
	window.onload = () => {	
		let assetBrowserElements = [];
	
		@foreach ($pageTemplate->fields as $field)
			@if (str_contains(strtolower($field['id']), 'image'))
				assetBrowserElements.push('{{ $field['id'] }}');
			@endif
		@endforeach	
		
		assetBrowserElements.map(assetBrowserElement => {
			$('#' + assetBrowserElement + '-browse-modal').on('show.bs.modal', event => {
				const button = $(event.relatedTarget);
				
				const fieldId = button.data('field_id');
				
				const value = button.data('value');
				
				window.CMS.ControlPanel.attachAssetBrowser('#' + assetBrowserElement + '-container', fieldId, value);
			});
			
			$('#' + assetBrowserElement + '-reset-field').on('click', () => {
				$('#' + assetBrowserElement).val('').blur();
				
				$('a[data-target="#' + assetBrowserElement + '-browse-modal"]').data('value', '');
			});
		});
	};
	</script>
@endpush

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="content padding bg-white">
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="editPage" id="editPage" class="editPage" role="form" method="POST" action="/cp/pages/{{ $page->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="bannerImage" value="">
						<input type="hidden" name="id" value="{{ $page->id }}">
						<input type="hidden" name="old_template_id" value="{{ $page->template_id }}">
						@if ($page->id == 1)
							<input type="hidden" name="title" value="{{ $page->title }}">
							<input type="hidden" name="slug" value="/">
							<input type="hidden" name="status_id" value="{{ $page->status_id }}">
							<input type="hidden" name="parent_id" value="0">
							<input type="hidden" name="hide_from_nav" value="0">
							<input type="hidden" name="template_id" value="{{ $page->template_id }}">
						@endif
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control {{ ($page->id == 1) ? 'text-disabled' : '' }}" value="{{ old('title', optional($page)->title) }}" placeholder="New Page" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" {{ ($page->id == 1) ? 'disabled' : 'required' }} autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							@if ($page->id == 1)
								<span id="helpBlockTitle" class="form-control-feedback form-text text-warning">- This field is disabled. The title cannot be changed for the homepage.</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="slug" class="control-label font-weight-bold">Slug <span class="text-danger">&#42;</span></label>
							<input type="text" name="slug" id="slug" class="form-control {{ ($page->id == 1) ? 'text-disabled' : '' }}" value="{{ old('slug') ?? ($page->id == 1) ? '/' : $page->slug }}" placeholder="new-page" tabindex="2" autocomplete="off" aria-describedby="helpBlockSlug" {{ ($page->id == 1) ? 'disabled' : 'required' }}>
							@if ($errors->has('slug'))
								<span id="helpBlockSlug" class="form-control-feedback form-text gf-red">- {{ $errors->first('slug') }}</span>
							@endif
							@if ($page->id == 1)
								<span id="helpBlockSlug" class="form-control-feedback form-text text-warning">- This field is disabled. The slug cannot be changed for the homepage.</span>
							@else
								<span id="helpBlockSlug" class="form-control-feedback form-text text-muted">- The slug is auto-generated based on the title but feel free to edit it.</span>
							@endif
						</div>
						<div class="form-group">
							<label for="description" class="control-label font-weight-bold">Meta Description</label>
							<input type="text" name="description" id="description" class="form-control" value="{{ old('description', optional($page)->description) }}" placeholder="e.g New Page Description" tabindex="3" autocomplete="off" aria-describedby="helpBlockDescription">
							@if ($errors->has('description'))
								<span id="helpBlockDescription" class="form-control-feedback form-text gf-red">- {{ $errors->first('description') }}</span>
							@endif
							<span id="helpBlockDescription" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="keywords" class="control-label font-weight-bold">Meta Keywords</label>
							<input type="text" name="keywords" id="keywords" class="form-control" value="{{ old('keywords', optional($page)->keywords) }}" placeholder="e.g New Page, Keywords" tabindex="4" autocomplete="off" aria-describedby="helpBlockKeywords">
							@if ($errors->has('keywords'))
								<span id="helpBlockKeywords" class="form-control-feedback form-text gf-red">- {{ $errors->first('keywords') }}</span>
							@endif
							<span id="helpBlockKeywords" class="form-control-feedback form-text text-muted">- Separate your keywords by commas.</span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Status</label>
							@foreach ($statuses as $status)
								<div class="form-check status_id-{{ $status->id }}">
									<label for="status_id-{{ str_slug($status->title) }}" class="form-check-label {{ ($page->id == 1) ? 'text-disabled' : '' }}">
										<input type="radio" name="status_id" id="status_id-{{ str_slug($status->title) }}" class="form-check-input" value="{{ $status->id }}" tabindex="5" aria-describedby="helpBlockStatusId" {{ (old('status_id') == $status->id || $page->status_id == $status->id) ? 'checked' : '' }} {{ ($page->id == 1) ? 'disabled' : '' }}>{{ $status->title }}@if (!empty($status->description))&nbsp;<i class="fa fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="{{ $status->description }}" aria-hidden="true"></i>@endif
									</label>
								</div>
							@endforeach
							@if ($errors->has('status_id'))
								<span id="helpBlockStatusId" class="form-control-feedback form-text gf-red">- {{ $errors->first('status_id') }}</span>
							@endif
							@if ($page->id == 1)
								<span id="helpBlockStatusId" class="form-control-feedback form-text text-warning">- This field is disabled. The status cannot be changed for the homepage.</span>
							@endif
							<span id="helpBlockStatusId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Parent</label>
							<select name="parent_id" id="parent_id" class="form-control {{ ($page->id == 1) ? 'text-disabled' : '' }}" tabindex="6" aria-describedby="helpBlockParentId" {{ ($page->id == 1) ? 'disabled' : 'required' }}>
								<option value="0" selected>Top Level</option>
								@foreach ($pages as $paige)
									@php ($indent = '')
									@php ($depth = $paige->depth)
									@while ($depth > 0)
										@php ($indent .= '-')
										@php ($depth--)
									@endwhile
									@if ($indent > '')
										@php ($indent .= '&nbsp;')
									@endif
									<option value="{{ $paige->id }}" {{ (old('parent_id') == $paige->id || $page->parent_id == $paige->id) ? 'selected' : '' }}>{{ $indent }}{{ $paige->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('parent_id'))
								<span id="helpBlockParentId" class="form-control-feedback form-text gf-red">- {{ $errors->first('parent_id') }}</span>
							@endif
							@if ($page->id == 1)
								<span id="helpBlockParentId" class="form-control-feedback form-text text-warning">- This field is disabled. The parent cannot be changed for the homepage.</span>
							@endif
							<span id="helpBlockParentId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Hide from Nav</label>
								<div class="form-check">
									<label for="hide_from_nav" class="form-check-label {{ ($page->id == 1) ? 'text-disabled' : '' }}">
										<input type="checkbox" name="hide_from_nav" id="hide_from_nav" class="form-check-input" value="1" tabindex="7" aria-label="..." aria-describedby="helpBlockHideFromNav" {{ ((old('hide_from_nav') && old('hide_from_nav') == $page->hide_from_nav) || $page->isHiddenFromNav() && $page->id != 1) ? 'checked' : '' }} {{ ($page->id == 1) ? 'disabled' : '' }}>
										&nbsp;
									</label>
								</div>
							@if ($errors->has('hide_from_nav'))
								<span id="helpBlockHideFromNav" class="form-control-feedback form-text gf-red">- {{ $errors->first('hide_from_nav') }}</span>
							@endif
							@if ($page->id == 1)
								<span id="helpBlockHideFromNav" class="form-control-feedback form-text text-warning">- This field is disabled. Homepage cannot be hidden from the navigation.</span>
							@endif
							<span id="helpBlockHideFromNav" class="form-control-feedback form-text text-muted">- Ticking this box will hide the page from the navigation.</span>
						</div>
						<div class="form-group">
							<label for="template_id" class="control-label font-weight-bold">Template</label>
							<select name="template_id" id="template_id" class="form-control" tabindex="8" aria-describedby="helpBlockTemplateId" {{ ($page->id == 1) ? 'disabled' : 'required' }}>
								@foreach ($templates as $template)
									<option value="{{ $template->id }}" {{ (old('template_id') == $template->id || $page->template_id == $template->id) ? 'selected' : '' }}>{{ $template->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('template_id'))
								<span id="helpBlockTemplateId" class="form-control-feedback form-text gf-red">- {{ $errors->first('template_id') }}</span>
							@endif
							@if ($page->id == 1)
								<span id="helpBlockTemplateId" class="form-control-feedback form-text text-warning">- This field is disabled. The template cannot be changed for the homepage.</span>
							@endif
							<span id="helpBlockTemplateId" class="form-control-feedback form-text text-muted"></span>
						</div>
						@foreach ($pageTemplate->fields as $field)
							<div class="form-group">
								{{ showField($field, old($field['id']), (9 + $loop->iteration)) }}
								@if (str_contains(strtolower($field['id']), 'image'))
									<div class="modal fade" id="{{ $field['id'] }}-browse-modal" tabindex="-1" role="dialog" aria-labelledby="{{ $field['id'] }}-browse-moda-label" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-xl" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="{{ $field['id'] }}-browse-modal-label">Assets</h5>
												</div>
												<div class="modal-body">
													<div class="container-fluid">
														<div class="row no-gutters">
															<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 text-left">
																<div id="{{ $field['id'] }}-container"></div>
															</div>
															<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 text-center">
																<div id="{{ $field['id'] }}-selected-asset-preview"></div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<div class="container-fluid">
														<div class="row d-flex h-100 justify-content-start">
															<div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 align-self-center align-self-sm-center align-self-md-left align-self-lg-left align-self-xl-left">
																<div class="text-center text-sm-center text-md-left text-lg-left text-xl-left selected-asset" id="{{ $field['id'] }}-selected-asset"></div>
															</div>
															<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center text-sm-center text-md-center text-lg-right text-xl-right align-self-center">
																<button type="button" class="btn btn-primary" id="{{ $field['id'] }}-select-asset">Insert</button>
																<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endif
								@if ($errors->has($field['id']))
									<span id="helpBlock_{{ $field['id'] }}" class="form-control-feedback form-text gf-red">- {{ $errors->first($field['id']) }}</span>
								@endif
							</div>
						@endforeach
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_pages'))
								<a href="/cp/pages" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-primary" title="Save Changes">Save Changes</button>
							@if ($currentUser->hasPermission('delete_pages') && $page->id != 1)
								<a href="/cp/pages/{{ $page->id }}/delete" title="Delete Page" class="pull-right btn btn-outline-danger">Delete Page</a>
							@endif
						</div>
					</form>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
