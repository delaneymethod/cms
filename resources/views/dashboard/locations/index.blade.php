@extends('_layouts.default')

@section('title', 'Locations - Dashboard - '.config('app.name'))
@section('description', 'Locations - Dashboard - '.config('app.name'))
@section('keywords', 'Locations, Dashboard, '.config('app.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/dashboard/css/global.css') }}">
@endpush

@push('headScripts')
	<script async>
	'use strict';
	
	window.User = {!! Auth::check() ? Auth::user() : 'null' !!};
	
	window.Laravel = {'csrfToken': '{{ csrf_token() }}'};
	</script>
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/dashboard/js/global.js') }}"></script>
@endpush

@section('content')
		<div class="row wrapper">
			@include('dashboard._partials.sidebar')
			<div class="col-md-9 col-lg-9 main">
				@include('dashboard._partials.message')
				@include('dashboard._partials.pageTitle')
				<div class="row">
					<div class="col">
						<ul class="list-unstyled list-inline buttons">
							<li class="list-inline-item"><a href="/dashboard/locations/create" title="Add Location" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Location</a></li>
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
								<td class="status text-center"><i class="fa fa-circle fa-1 status-{{ $location->status->id }}" title="{{ $location->status->title }}" aria-hidden="true"></i></td>
								<td class="actions dropdown text-center">
									<a href="javascript:void(0);" title="Location Actions" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-item gf-info"><a href="/dashboard/locations/{{ $location->id }}/edit" title="Edit Location"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Location</a></li>
										<li class="dropdown-item gf-default"><a href="/dashboard/locations/{{ $location->id }}/retire" title="Retire Location"><i class="icon fa fa-circle-o" aria-hidden="true"></i>Retire Location</a></li>
										<li class="dropdown-divider"></li>
										<li class="dropdown-item gf-danger">
											<a href="javascript:void(0);" title="Delete Location"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Location</a>
										</li>
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
