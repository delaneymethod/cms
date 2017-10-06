@extends('_layouts.default')

@section('title', 'Article Categories - Articles - '.config('app.name'))
@section('description', 'Article Categories - Articles - '.config('app.name'))
@section('keywords', 'Article, Categories, Articles, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/cp.css') }}">
@endpush

@push('headScripts')
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/cp.js') }}"></script>
	@include('cp._partials.listeners')
@endpush

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				@if ($currentUser->hasPermission('create_article_categories'))
					<div class="row">
						<div class="col-12">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/articles/categories/create" title="Add Article Category" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Article Category</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover table-responsive" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle">Slug</th>
								<th class="align-middle text-center">Status</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($articleCategories as $articleCategory)
								<tr>
									<td class="align-middle">{{ $articleCategory->title }}{!! ($articleCategory->isRetired()) ? '&nbsp;<span class="badge badge-pill badge-retired align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$articleCategory->status->title.'</span>' : '' !!}{!! ($articleCategory->isPending()) ? '&nbsp;<span class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$articleCategory->status->title.'</span>' : '' !!}</td>
									<td class="align-middle">{{ $articleCategory->slug }}</td>
									<td class="align-middle status text-center"><i class="fa fa-circle fa-1 status_id-{{ $articleCategory->status->id }}" title="{{ $articleCategory->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('edit_article_categories') || ($currentUser->hasPermission('delete_article_categories') && $articleCategory->id != 1))
										<td class="align-middle actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Article Category Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_article_categories'))
													<li class="dropdown-item gf-info"><a href="/cp/articles/categories/{{ $articleCategory->id }}/edit" title="Edit Article Category"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Article Category</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_article_categories') && $articleCategory->id != 1)
													<li class="dropdown-item gf-danger"><a href="/cp/articles/categories/{{ $articleCategory->id }}/delete" title="Delete Article Category"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Article Category</a></li>
												@endif
											</ul>
										</td>
									@else
										<td class="align-middle">&nbsp;</td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
