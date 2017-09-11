@extends('_layouts.default')

@section('title', 'Create Article - Articles - '.config('app.name'))
@section('description', 'Create Article - Articles - '.config('app.name'))
@section('keywords', 'Create, Article, Articles, '.config('app.name'))

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
					<form name="createArticle" id="createArticle" class="createArticle" role="form" method="POST" action="/cp/articles">
						{{ csrf_field() }}
						<input type="hidden" name="template_id" value="9">
						<input type="hidden" name="category_ids[]" value="1">
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="e.g Blog Post Title" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="slug" class="control-label font-weight-bold">Slug <span class="text-danger">&#42;</span></label>
							<input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="e.g blog-post-title" tabindex="2" autocomplete="off" aria-describedby="helpBlockSlug" required>
							@if ($errors->has('slug'))
								<span id="helpBlockSlug" class="form-control-feedback form-text gf-red">- {{ $errors->first('slug') }}</span>
							@endif
							<span id="helpBlockSlug" class="form-control-feedback form-text text-muted">- The slug is auto-generated based on the title but feel free to edit it.</span>
						</div>
						<div class="form-group">
							<label for="description" class="control-label font-weight-bold">Meta Description</label>
							<input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" placeholder="e.g Blog Post Description" tabindex="3" autocomplete="off" aria-describedby="helpBlockDescription">
							@if ($errors->has('description'))
								<span id="helpBlockDescription" class="form-control-feedback form-text gf-red">- {{ $errors->first('description') }}</span>
							@endif
							<span id="helpBlockDescription" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="keywords" class="control-label font-weight-bold">Meta Keywords</label>
							<input type="text" name="keywords" id="keywords" class="form-control" value="{{ old('keywords') }}" placeholder="e.g Blog, Post, Keywords" tabindex="4" autocomplete="off" aria-describedby="helpBlockKeywords">
							@if ($errors->has('keywords'))
								<span id="helpBlockKeywords" class="form-control-feedback form-text gf-red">- {{ $errors->first('keywords') }}</span>
							@endif
							<span id="helpBlockKeywords" class="form-control-feedback form-text text-muted">- Separate your keywords by commas.</span>
						</div>
						<div class="form-group">
							<label for="published_at" class="control-label font-weight-bold">Published Date <span class="text-danger">&#42;</span></label>
							<div class="input-group date">
								<span class="input-group-addon" id="helpBlockPublishedAt"><i class="fa fa-calendar" aria-hidden="true"></i></span>
								<input type="text" name="published_at" id="published_at" class="form-control" value="{{ old('published_at') }}" placeholder="e.g yyyy-mm-dd h:i:s" tabindex="5" autocomplete="off" aria-describedby="helpBlockPublishedAt" required>
							</div>
							@if ($errors->has('published_at'))
								<span id="helpBlockPublishedAt" class="form-control-feedback form-text gf-red">- {{ $errors->first('published_at') }}</span>
							@endif
							<span id="helpBlockPublishedAt" class="form-control-feedback form-text text-muted"></span>
						</div>
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
						<div class="form-group">
							<label class="control-label font-weight-bold">Categories</label>
							@php ($categoryIds = old('category_ids') ?? [])
							@foreach ($categories->chunk(3) as $chunk)
								<div class="row">
									@foreach ($chunk as $category)
										<div class="col-sm-12 col-md-4 col-lg-4">
											<div class="form-check">
												<label for="category_id-{{ $category->slug }}" class="form-check-label">
													<input type="checkbox" name="category_ids[]" id="category_id-{{ $category->slug }}" class="form-check-input" value="{{ $category->id }}" tabindex="7" aria-describedby="helpBlockCategoryIds" {{ (in_array($category->id, $categoryIds)) ? 'checked' : '' }} {{ ($category->id == 1) ? 'disabled checked' : '' }}>{{ $category->title }}
												</label>
											</div>
										</div>
									@endforeach
								</div>
							@endforeach
							@if ($errors->has('category_ids'))
								<span id="helpBlockCategoryIds" class="form-control-feedback form-text gf-red">- {{ $errors->first('category_ids') }}</span>
							@endif
							<span id="helpBlockCategoryIds" class="form-control-feedback form-text text-muted"></span>
						</div>
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
							<div class="form-group">
								{{ showField($field, old($field['id']), (9 + $loop->iteration)) }}
								@if ($errors->has($field['id']))
									<span id="helpBlock_{{ $field['id'] }}" class="form-control-feedback form-text gf-red">- {{ $errors->first($field['id']) }}</span>
								@endif
							</div>
						@endforeach
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_articles'))
								<a href="/cp/articles" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-primary" title="Save Changes">Save Changes</button>
						</div>
					</form>
					<div class="modal fade add-assets-modal-lg" tabindex="-1" role="dialog" aria-labelledby="addAssetsModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="assetModalLabel">Assets</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12">
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="float-right btn btn-outline-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="float-right btn btn-primary">Insert Assets</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
