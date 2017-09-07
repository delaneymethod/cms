@extends('_layouts.default')

@section('title', 'Pages - '.config('app.name'))
@section('description', 'Pages - '.config('app.name'))
@section('keywords', 'Pages, '.config('app.name'))

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
				@if ($currentUser->hasPermission('create_pages'))
					<div class="row">
						<div class="col">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/pages/create/1" title="Add Page" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Page</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th>Title</th>
								<th class="no-sort">Slug</th>
								<th>Parent</th>
								<th>Template</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($pages as $page)
								<tr>
									<td>{{ $page->title }}{!! $page->hide_from_nav == 1 ? '&nbsp;<i class="text-muted-lighter">(Hidden from Nav)</i>' : '' !!}</td>
									<td>{{ $page->slug }}</td>
									<td>{{ ($page->parent) ? $page->parent->title : '' }}</td>
									<td>{{ $page->template->title }}</td>
									<td class="status text-center"><i class="fa fa-circle fa-1 status_id-{{ $page->status->id }}" title="{{ $page->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('edit_pages') || ($currentUser->hasPermission('delete_pages') && $page->id != 1))
										<td class="actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Page Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="actions dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_pages'))
													<li class="dropdown-item gf-info"><a href="/cp/pages/{{ $page->id }}/edit/{{ $page->template_id }}" title="Edit Page"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Page</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_pages') && $page->id != 1)
													<li class="dropdown-item gf-danger"><a href="/cp/pages/{{ $page->id }}/delete" title="Delete Page"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Page</a></li>
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
