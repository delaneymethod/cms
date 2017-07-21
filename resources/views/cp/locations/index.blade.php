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
			<div class="col-md-9 col-lg-9 main">
				@include('cp._partials.message')
				@include('cp._partials.pageTitle')
				<div class="row">
					<div class="col">
						<ul class="list-unstyled list-inline buttons">
							<li class="list-inline-item"><a href="/cp/locations/create" title="Add Location" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Location</a></li>
						</ul>
					</div>
				</div>
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="no-sort">ID</th>
								<th>Title</th>
								<th class="text-center">Status</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($locations as $location)
								<tr>
									<td class="id">{{ $location->id }}</td>
									<td>{{ $location->title }}</td>
									<td class="status text-center"><i class="fa fa-circle fa-1 status_id-{{ $location->status->id }}" title="{{ $location->status->title }}" aria-hidden="true"></i></td>
									<td class="actions dropdown text-center" id="submenu">
										<a href="javascript:void(0);" title="Location Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li class="dropdown-item gf-info"><a href="/cp/locations/{{ $location->id }}/edit" title="Edit Location"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Location</a></li>
											<li class="dropdown-item gf-default"><a href="/cp/locations/{{ $location->id }}/retire" title="Retire Location"><i class="icon fa fa-circle-o" aria-hidden="true"></i>Retire Location</a></li>
											<li class="dropdown-divider"></li>
											<li class="dropdown-item gf-danger"><a href="/cp/locations/{{ $location->id }}/delete" title="Delete Location"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Location</a></li>
										</ul>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
@endsection
