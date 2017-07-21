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
				<div class="content padding bg-white">
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="editPage" id="editPage" class="editPage" role="form" method="POST" action="/cp/pages/{{ $page->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						@if ($page->id === 1)
							<input type="hidden" name="title" value="{{ $page->title }}">
							<input type="hidden" name="slug" value="/">
							<input type="hidden" name="status_id" value="{{ $page->status_id }}">
							<input type="hidden" name="parent_id" value="0">
						@endif
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') ?? $page->title }}" placeholder="New Page" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" {{ ($page->id === 1) ? 'disabled' : 'required' }} autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							@if ($page->id === 1)
								<span id="helpBlockTitle" class="form-control-feedback form-text text-muted">- This field is disabled. The title cannot be changed for the homepage.</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="slug" class="control-label font-weight-bold">Slug <span class="text-danger">&#42;</span></label>
							<input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') ?? ($page->id === 1) ? '/' : $page->slug }}" placeholder="new-page" tabindex="2" autocomplete="off" aria-describedby="helpBlockSlug" {{ ($page->id === 1) ? 'disabled' : 'required' }}>
							@if ($errors->has('slug'))
								<span id="helpBlockSlug" class="form-control-feedback form-text gf-red">- {{ $errors->first('slug') }}</span>
							@endif
							@if ($page->id === 1)
								<span id="helpBlockSlug" class="form-control-feedback form-text text-muted">- This field is disabled. The slug cannot be changed for the homepage.</span>
							@else
								<span id="helpBlockSlug" class="form-control-feedback form-text text-muted">- The slug is auto-generated based on the title but feel free to edit it.</span>
							@endif
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Status</label>
							@foreach ($statuses as $status)
								<div class="form-check status_id-{{ $status->id }}">
									<label class="form-check-label">
										<input type="radio" name="status_id" id="status_id-{{ str_slug($status->title) }}" class="form-check-input" value="{{ $status->id }}" tabindex="3" aria-describedby="helpBlockStatusId" {{ (old('status_id') === $status->id || $page->status_id === $status->id) ? 'checked' : '' }} {{ ($page->id === 1) ? 'disabled' : '' }}>{{ $status->title }}
									</label>
								</div>
							@endforeach
							@if ($errors->has('status_id'))
								<span id="helpBlockStatusId" class="form-control-feedback form-text gf-red">- {{ $errors->first('status_id') }}</span>
							@endif
							@if ($page->id === 1)
								<span id="helpBlockStatusId" class="form-control-feedback form-text text-muted">- This field is disabled. The status cannot be changed for the homepage.</span>
							@endif
							<span id="helpBlockStatusId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Parent</label>
							<select name="parent_id" id="parent_id" class="form-control" tabindex="4" aria-describedby="helpBlockParentId" {{ ($page->id === 1) ? 'disabled' : 'required' }}>
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
									<option value="{{ $paige->id }}" {{ (old('parent_id') === $paige->id || $page->parent_id === $paige->id) ? 'selected' : '' }}>{{ $indent }}{{ $paige->title }}</option>
								@endforeach
							</select>
							@if ($errors->has('parent_id'))
								<span id="helpBlockParentId" class="form-control-feedback form-text gf-red">- {{ $errors->first('parent_id') }}</span>
							@endif
							@if ($page->id === 1)
								<span id="helpBlockParentId" class="form-control-feedback form-text text-muted">- This field is disabled. The parent cannot be changed for the homepage.</span>
							@endif
							<span id="helpBlockParentId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="content" class="control-label font-weight-bold">Content</label>
							<textarea name="content" id="content" placeholder="New page content..." tabindex="5" aria-describedby="helpBlockContent">{{ old('content') ?? $page->content }}</textarea>
							@if ($errors->has('content'))
								<span id="helpBlockContent" class="form-control-feedback form-text gf-red">- {{ $errors->first('content') }}</span>
							@endif
							<span id="helpBlockContent" class="form-control-feedback form-text text-muted"></span>
						</div>
						<a href="/cp/pages" title="Cancel" class="btn btn-outline-secondary cancel-button" title="Cancel">Cancel</a>
						<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" title="Save Changes">Save Changes</button>
						@if ($page->id > 1)
							<a href="/cp/pages/{{ $page->id }}/delete" title="Delete Page" class="pull-right btn btn-outline-danger">Delete Page</a>
						@endif
					</form>
				</div>
			</div>
		</div>
@endsection
