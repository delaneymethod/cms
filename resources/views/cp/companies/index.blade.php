@extends('_layouts.default')

@section('title', 'Companies - '.config('app.name'))
@section('description', 'Companies - '.config('app.name'))
@section('keywords', 'Companies, '.config('app.name'))

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
				<div class="row">
					<div class="col">
						<ul class="list-unstyled list-inline buttons">
							<li class="list-inline-item"><a href="/cp/companies/create" title="Add Company" class="btn btn-outline-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Company</a></li>
						</ul>
					</div>
				</div>
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="no-sort">ID</th>
								<th>Title</th>
								<th class="text-center">Locations</th>
								<th class="text-center">Users</th>
								<th class="no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($companies as $company)
								<tr>
									<td>{{ $company->id }}</td>
									<td>{{ $company->title }}</td>
									<td class="text-center">{{ $company->locations->count() }}</td>
									<td class="text-center">{{ $company->users->count() }}</td>
									<td class="actions dropdown text-center" id="submenu">
										<a href="javascript:void(0);" title="Company Actions" class="dropdown-toggle" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li class="dropdown-item gf-info"><a href="/cp/companies/{{ $company->id }}/edit" title="Edit Company"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Company</a></li>
											@if ($company->id != Auth::user()->company_id)
												<li class="dropdown-item gf-danger"><a href="/cp/companies/{{ $company->id }}/delete" title="Delete Company"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Company</a></li>
											@endif
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