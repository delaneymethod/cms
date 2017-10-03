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
	@include('cp._partials.listeners')
@endpush

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				@if ($currentUser->hasPermission('create_pages'))
					<div class="row">
						<div class="col-12">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/pages/create/1" title="Add Page" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Page</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle no-sort">Slug</th>
								<th class="align-middle">Parent</th>
								<th class="align-middle">Template</th>
								<th class="text-center">Status</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($pages as $page)
								<tr>
									<td class="align-middle">{{ $page->title }}{!! $page->isHiddenFromNav() ? '&nbsp;<i class="text-muted-lighter">(Hidden from Nav)</i>' : '' !!}</td>
									<td class="align-middle">{{ $page->slug }}</td>
									<td class="align-middle">{{ ($page->parent) ? $page->parent->title : '' }}</td>
									<td class="align-middle">{{ $page->template->title }}</td>
									<td class="align-middle status text-center"><i class="fa fa-circle fa-1 status_id-{{ $page->status->id }}" title="{{ $page->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('edit_pages') || ($currentUser->hasPermission('delete_pages') && $page->id != 1))
										<td class="align-middle actions dropdown text-center" id="submenu">
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
