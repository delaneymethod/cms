@extends('_layouts.default')

@section('title', 'Templates - '.config('app.name'))
@section('description', 'Templates - '.config('app.name'))
@section('keywords', 'Templates, '.config('app.name'))

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
				<div class="content padding bg-white">	
					<div class="spacer"></div>
					<table id="datatable" class="table table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle d-none d-sm-none d-md-table-cell d-lg-table-cell d-xl-table-cell">Filename</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($templates as $template)
								<tr>
									<td class="align-middle">{{ $template->title }}</td>
									<td class="align-middle d-none d-sm-none d-md-table-cell d-lg-table-cell d-xl-table-cell">{{ $template->filename }}</td>
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
