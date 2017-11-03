@extends('_layouts.default')

@section('title', 'Carousels - '.config('app.name'))
@section('description', 'Carousels - '.config('app.name'))
@section('keywords', 'Carousels, '.config('app.name'))

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
				@if ($currentUser->hasPermission('create_carousels'))
					<div class="row">
						<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<ul class="list-unstyled list-inline buttons">
								<li class="list-inline-item"><a href="/cp/carousels/create" title="Add Carousel" class="btn btn-success"><i class="icon fa fa-plus" aria-hidden="true"></i>Add Carousel</a></li>
							</ul>
						</div>
					</div>
				@endif
				<div class="content padding bg-white">	
					<div class="spacer"></div>
					<table id="datatable" class="table table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle d-none d-sm-none d-md-table-cell d-lg-table-cell d-xl-table-cell">Handle</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($carousels as $carousel)
								<tr>
									<td class="align-middle">{{ $carousel->title }}</td>
									<td class="align-middle d-none d-sm-none d-md-table-cell d-lg-table-cell d-xl-table-cell">{{ $carousel->handle }}</td>
									@if ($currentUser->hasPermission('edit_carousels') || $currentUser->hasPermission('delete_carousels'))
										<td class="align-middle actions dropdown text-center" id="submenu">
											<a href="javascript:void(0);" title="Carousel Actions" rel="nofollow" class="dropdown-toggle needsclick" id="pageActions" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												@if ($currentUser->hasPermission('edit_carousels'))
													<li class="dropdown-item gf-info"><a href="/cp/carousels/{{ $carousel->id }}/edit" title="Edit Carousel"><i class="icon fa fa-pencil" aria-hidden="true"></i>Edit Carousel</a></li>
												@endif
												@if ($currentUser->hasPermission('delete_carousels'))
													<li class="dropdown-item gf-danger"><a href="/cp/carousels/{{ $carousel->id }}/delete" title="Delete Carousel"><i class="icon fa fa-trash" aria-hidden="true"></i>Delete Carousel</a></li>
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
