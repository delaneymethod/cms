@extends('_layouts.default')

@section('title', 'Statuses - Advanced - '.config('app.name'))
@section('description', 'Statuses - Advanced - '.config('app.name'))
@section('keywords', 'Statuses, Advanced, '.config('app.name'))

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
				@if ($currentUser->hasPermission('create_statuses'))
					<div class="row">
						<div class="col">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/advanced/statuses/create" title="Add Status" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Status</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th>Title</th>
								<th>Description</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($statuses as $status)
								<tr>
									<td>{{ $status->title }}</td>
									<td>{{ $status->description }}</td>
									@if ($currentUser->hasPermission('edit_statuses') || $currentUser->hasPermission('delete_statuses'))
										<td class="actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Status Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_statuses'))
													<li class="dropdown-item gf-info"><a href="/cp/advanced/statuses/{{ $status->id }}/edit" title="Edit Status"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Status</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_statuses'))
													<li class="dropdown-item gf-danger"><a href="/cp/advanced/statuses/{{ $status->id }}/delete" title="Delete Status"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Status</a></li>
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
