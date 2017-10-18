@extends('_layouts.default')

@section('title', 'Statuses - Advanced - '.config('app.name'))
@section('description', 'Statuses - Advanced - '.config('app.name'))
@section('keywords', 'Statuses, Advanced, '.config('app.name'))

@push('styles')
	@include('cp._partials.styles')
@endpush

@push('headScripts')
	@include('cp._partials.headScripts')
@endpush

@push('bodyScripts')
	@include('cp._partials.bodyScripts')
@endpush

@section('content')
	<div class="container-fluid">
		<div class="row">
			@include('cp._partials.sidebar')
			<div class="{{ $mainSmCols }} {{ $mainMdCols }} {{ $mainLgCols }} {{ $mainXlCols }} main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				@if ($currentUser->hasPermission('create_statuses'))
					<div class="row">
						<div class="col-12">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/advanced/statuses/create" title="Add Status" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Status</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<div class="spacer"></div>
					<table id="datatable" class="table table-striped table-bordered table-hover table-responsive" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle">Description</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($statuses as $status)
								<tr>
									<td class="align-middle">{{ $status->title }}</td>
									<td class="align-middle">{{ $status->description }}</td>
									@if ($currentUser->hasPermission('edit_statuses') || $currentUser->hasPermission('delete_statuses'))
										<td class="align-middle actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Status Actions" rel="nofollow" class="dropdown-toggle needsclick" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
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
