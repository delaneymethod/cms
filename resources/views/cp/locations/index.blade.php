@extends('_layouts.default')

@section('title', 'Locations - '.config('app.name'))
@section('description', 'Locations - '.config('app.name'))
@section('keywords', 'Locations, '.config('app.name'))

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
				@if ($currentUser->hasPermission('create_locations'))
					<div class="row">
						<div class="col">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/locations/create" title="Add Location" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Location</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th>Title</th>
								<th>Postal Address</th>
								<th>Telephone</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($locations as $location)
								<tr class="{{ str_slug($location->status->title) }}">
									<td>{{ $location->title }}{!! ($location->status->id == 3) ? '&nbsp;<span class="badge badge-pill badge-retired align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$location->status->title.'</span>' : '' !!}{!! ($location->status->id == 2) ? '&nbsp;<span class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$location->status->title.'</span>' : '' !!}</td>
									<td>{{ $location->postal_address }}</td>
									<td>{{ $location->telephone }}</td>
									<td class="status text-center"><i class="fa fa-circle fa-1 status_id-{{ $location->status->id }}" title="{{ $location->status->title }}" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('edit_locations') || ($currentUser->hasPermission('retire_locations') && !in_array($location->id, $defaultLocationIds) && $location->status_id != 3) || ($currentUser->hasPermission('delete_locations') && !in_array($location->id, $defaultLocationIds)))
										<td class="actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Location Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_locations'))
													<li class="dropdown-item gf-info"><a href="/cp/locations/{{ $location->id }}/edit" title="Edit Location"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Location</a></li>
												@endif
												@if ($currentUser->hasPermission('retire_locations') && !in_array($location->id, $defaultLocationIds) && $location->status_id != 3)
													<li class="dropdown-item gf-default"><a href="/cp/locations/{{ $location->id }}/retire" title="Retire Location"><i class="icon fa fa-circle-o" aria-hidden="true"></i>Retire Location</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_locations') && !in_array($location->id, $defaultLocationIds))
													<li class="dropdown-item gf-danger"><a href="/cp/locations/{{ $location->id }}/delete" title="Delete Location"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Location</a></li>
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
