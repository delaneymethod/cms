@extends('_layouts.default')

@section('title', 'Carts - '.config('app.name'))
@section('description', 'Carts - '.config('app.name'))
@section('keywords', 'Carts, '.config('app.name'))

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
				<div class="content padding bg-white">	
					<table id="datatable" class="table table-striped table-bordered table-hover" cellspacing="0" border="0" cellpadding="0" width="100%">
						<thead>
							<tr>
								<th>Identifier</th>
								<th>Instance</th>
								<th>Product</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($carts as $cart)
								<tr>
									<td>{{ $cart->identifier }}</td>
									<td>{{ $cart->instance }}</td>
									<td>{{ $cart->count }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
