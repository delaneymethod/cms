@extends('_layouts.default')

@section('title', 'Categories - Articles - '.config('app.name'))
@section('description', 'Categories - Articles - '.config('app.name'))
@section('keywords', 'Categories, Articles, '.config('app.name'))

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
		<div class="row wrapper">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				@if ($currentUser->hasPermission('create_categories'))
					<div class="row">
						<div class="col">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/articles/categories/create" title="Add Category" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Category</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th>Title</th>
								<th>Slug</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($categories as $category)
								<tr>
									<td>{{ $category->title }}{!! ($category->isRetired()) ? '&nbsp;<span class="badge badge-pill badge-retired align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$category->status->title.'</span>' : '' !!}{!! ($category->isPending()) ? '&nbsp;<span class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$category->status->title.'</span>' : '' !!}</td>
									<td>{{ $category->slug }}</td>
									<td class="status text-center"><i class="fa fa-circle fa-1 status_id-{{ $category->status->id }}" title="{{ $category->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('edit_categories') || ($currentUser->hasPermission('delete_categories') && $category->id != 1))
										<td class="actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Category Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_categories'))
													<li class="dropdown-item gf-info"><a href="/cp/articles/categories/{{ $category->id }}/edit" title="Edit Category"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Category</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_categories') && $category->id != 1)
													<li class="dropdown-item gf-danger"><a href="/cp/articles/categories/{{ $category->id }}/delete" title="Delete Category"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Category</a></li>
												@endif
											</ul>
										</td>
									@else
										<td>&nbsp;</td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
