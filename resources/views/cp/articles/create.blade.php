@extends('_layouts.default')

@section('title', 'Create Article - Articles - '.config('app.name'))
@section('description', 'Create Article - Articles - '.config('app.name'))
@section('keywords', 'Create, Article, Articles, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
	<script async>
	'use strict';
	
	function loadAssetsBrowser() {
		let assetBrowserElements = [];
	
		@foreach ($articleTemplate->fields as $field)
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
	}
		
	if (window.attachEvent) {
		window.attachEvent('onload', loadAssetsBrowser);
	} else if (window.addEventListener) {
		window.addEventListener('load', loadAssetsBrowser, false);
	} else {
		document.addEventListener('load', loadAssetsBrowser, false);
	}
	</script>
@endpush

@section('formButtons')
	<div class="form-buttons">
		@if ($currentUser->hasPermission('view_articles'))
			<a href="/cp/articles" title="Cancel" class="btn btn-link text-secondary" title="Cancel">Cancel</a>
		@endif
		<button type="submit" name="submit_create_article" id="submit_create_article" class="pull-right btn btn-primary" title="Save Changes"><i class="icon fa fa-check-circle" aria-hidden="true"></i>Save Changes</button>
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
					<form name="createArticle" id="createArticle" class="createArticle" role="form" method="POST" action="/cp/articles">
						{{ csrf_field() }}
						<input type="hidden" name="template_id" value="9">
						<input type="hidden" name="article_category_ids[]" value="1">
						@yield('formButtons')
						<div class="spacer" style="width: auto;margin-left: -15px;margin-right: -15px;"><hr></div>
						<div class="spacer"></div>
						<p><i class="fa fa-info-circle" aria-hidden="true"></i> Fields marked with <span class="text-danger">&#42;</span> are required.</p>
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="e.g Blog Post Title" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="slug" class="control-label font-weight-bold">Slug <span class="text-danger">&#42;</span></label>
							<input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="e.g blog-post-title" tabindex="2" autocomplete="off" aria-describedby="helpBlockSlug" required>
							@if ($errors->has('slug'))
								<span id="helpBlockSlug" class="form-control-feedback form-text gf-red">- {{ $errors->first('slug') }}</span>
							@endif
							<span id="helpBlockSlug" class="form-control-feedback form-text text-muted">- The slug is auto-generated based on the title but feel free to edit it.</span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="description" class="control-label font-weight-bold">Meta Description</label>
							<input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" placeholder="e.g Blog Post Description" tabindex="3" autocomplete="off" aria-describedby="helpBlockDescription">
							@if ($errors->has('description'))
								<span id="helpBlockDescription" class="form-control-feedback form-text gf-red">- {{ $errors->first('description') }}</span>
							@endif
							<span id="helpBlockDescription" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="keywords" class="control-label font-weight-bold">Meta Keywords</label>
							<input type="text" name="keywords" id="keywords" class="form-control" value="{{ old('keywords') }}" placeholder="e.g Blog, Post, Keywords" tabindex="4" autocomplete="off" aria-describedby="helpBlockKeywords">
							@if ($errors->has('keywords'))
								<span id="helpBlockKeywords" class="form-control-feedback form-text gf-red">- {{ $errors->first('keywords') }}</span>
							@endif
							<span id="helpBlockKeywords" class="form-control-feedback form-text text-muted">- The keywords are auto-generated based on the title but feel free to edit them.<br>- Remember to separate your keywords by commas.</span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="published_at" class="control-label font-weight-bold">Publish Date</label>
							<div class="input-group date">
								<span class="input-group-addon" id="helpBlockPublishedAt"><i class="fa fa-calendar" aria-hidden="true"></i></span>
								<input type="text" name="published_at" id="published_at" class="form-control" value="{{ old('published_at') }}" placeholder="e.g yyyy-mm-dd h:i:s" tabindex="5" autocomplete="off" aria-describedby="helpBlockPublishedAt">
							</div>
							@if ($errors->has('published_at'))
								<span id="helpBlockPublishedAt" class="form-control-feedback form-text gf-red">- {{ $errors->first('published_at') }}</span>
							@endif
							<span id="helpBlockPublishedAt" class="form-control-feedback form-text text-muted">- Articles will only appear on/after this date.</span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Status</label>
							@foreach ($statuses as $status)
								<div class="form-check status_id-{{ $status->id }}">
									<label for="status_id-{{ str_slug($status->title) }}" class="form-check-label">
										<input type="radio" name="status_id" id="status_id-{{ str_slug($status->title) }}" class="form-check-input" value="{{ $status->id }}" tabindex="6" aria-describedby="helpBlockStatusId" {{ (old('status_id') == $status->id) ? 'checked' : ($loop->first) ? 'checked' : '' }}>{{ $status->title }}@if (!empty($status->description))&nbsp;<i class="fa fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="{{ $status->description }}" aria-hidden="true"></i>@endif
									</label>
								</div>
							@endforeach
							@if ($errors->has('status_id'))
								<span id="helpBlockStatusId" class="form-control-feedback form-text gf-red">- {{ $errors->first('status_id') }}</span>
							@endif
							<span id="helpBlockStatusId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Article Categories</label>
							@php ($articleCategoryIds = old('article_category_ids') ?? [])
							@foreach ($articleCategories->chunk(3) as $chunk)
								<div class="row">
									@foreach ($chunk as $articleCategory)
										<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
											<div class="form-check">
												<label for="article_category_id-{{ $articleCategory->slug }}" class="form-check-label">
													<input type="checkbox" name="article_category_ids[]" id="article_category_id-{{ $articleCategory->slug }}" class="form-check-input" value="{{ $articleCategory->id }}" tabindex="7" aria-describedby="helpBlockArticleCCategoryIds" {{ (in_array($articleCategory->id, $articleCategoryIds)) ? 'checked' : '' }} {{ ($articleCategory->id == 1) ? 'disabled checked' : '' }}>{{ $articleCategory->title }}
												</label>
											</div>
										</div>
									@endforeach
								</div>
							@endforeach
							@if ($errors->has('article_category_ids'))
								<span id="helpBlockArticleCategoryIds" class="form-control-feedback form-text gf-red">- {{ $errors->first('article_category_ids') }}</span>
							@endif
							<span id="helpBlockArticleCategoryIds" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="spacer"></div>
						<div class="form-group">
							<label for="user_id" class="control-label font-weight-bold">Author</label>
							<select name="user_id" id="user_id" class="form-control" tabindex="8" aria-describedby="helpBlockUserId" required>
								@foreach ($users as $user)
									<option value="{{ $user->id }}" {{ (old('user_id') == $user->id) ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
								@endforeach
							</select>
							@if ($errors->has('user_id'))
								<span id="helpBlockUserId" class="form-control-feedback form-text gf-red">- {{ $errors->first('user_id') }}</span>
							@endif
							<span id="helpBlockUserId" class="form-control-feedback form-text text-muted"></span>
						</div>
						@foreach ($articleTemplate->fields as $field)
							<div class="spacer"></div>
							<div class="form-group">
								{{ showField($field, old($field['id']), (9 + $loop->iteration)) }}
								@if ($errors->has($field['id']))
									<span id="helpBlock_{{ $field['id'] }}" class="form-control-feedback form-text gf-red">- {{ $errors->first($field['id']) }}</span>
								@endif
							</div>
						@endforeach
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
