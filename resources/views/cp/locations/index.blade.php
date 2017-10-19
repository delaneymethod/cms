@extends('_layouts.default')

@section('title', 'Locations - '.config('app.name'))
@section('description', 'Locations - '.config('app.name'))
@section('keywords', 'Locations, '.config('app.name'))

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
				@if ($currentUser->hasPermission('create_locations'))
					<div class="row">
						<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/locations/create" title="Add Location" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Location</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<div class="spacer"></div>
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle">Postal Address</th>
								<th class="align-middle">Telephone</th>
								<th class="align-middle text-center">Status</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($locations as $location)
								<tr class="{{ str_slug($location->status->title) }}">
									<td class="align-middle">{{ $location->title }}{!! ($location->isRetired()) ? '&nbsp;<span class="badge badge-pill badge-retired align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$location->status->title.'</span>' : '' !!}{!! ($location->isSuspended()) ? '&nbsp;<span class="badge badge-pill badge-suspended align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$location->status->title.'</span>' : '' !!}{!! ($location->isPending()) ? '&nbsp;<span class="badge badge-pill badge-warning align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;'.$location->status->title.'</span>' : '' !!}</td>
									<td class="align-middle">{{ $location->postal_address }}</td>
									<td class="align-middle">{{ $location->telephone }}</td>
									<td class="align-middle status text-center"><i class="fa fa-circle fa-1 status_id-{{ $location->status->id }}" title="{{ $location->status->title }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i></td>
									@if ($currentUser->hasPermission('edit_locations') || ($currentUser->hasPermission('retire_locations') && !in_array($location->id, $defaultLocationIds) && !$location->isRetired()) || ($currentUser->hasPermission('delete_locations') && !in_array($location->id, $defaultLocationIds)))
										<td class="align-middle actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Location Actions" rel="nofollow" class="dropdown-toggle needsclick" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_locations'))
													<li class="dropdown-item gf-info"><a href="/cp/locations/{{ $location->id }}/edit" title="Edit Location"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Location</a></li>
												@endif
												@if ($currentUser->hasPermission('retire_locations') && !in_array($location->id, $defaultLocationIds) && !$location->isRetired())
													<li class="dropdown-item gf-default"><a href="/cp/locations/{{ $location->id }}/retire" title="Retire Location"><i class="icon fa fa-circle-o" aria-hidden="true"></i>Retire Location</a></li>
												@endif
												@if ($currentUser->hasPermission('suspend_locations') && !in_array($location->id, $defaultLocationIds) && !$location->isSuspended())
													<li class="dropdown-item gf-default"><a href="/cp/locations/{{ $location->id }}/suspend" title="Suspend Location"><i class="icon fa fa-ban" aria-hidden="true"></i>Suspend Location</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_locations') && !in_array($location->id, $defaultLocationIds))
													<li class="dropdown-item gf-danger"><a href="/cp/locations/{{ $location->id }}/delete" title="Delete Location"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Location</a></li>
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
