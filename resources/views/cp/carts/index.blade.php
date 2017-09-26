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
	@include('cp._partials.listeners')
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
								<th class="align-middle">Identifier</th>
								<th class="align-middle">Instance</th>
								<th class="align-middle">User</th>
								<th class="align-middle">Company</th>
								<th class="align-middle text-center">Saved</th>
								<th class="align-middle text-center">Items</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($carts as $cart)
								<tr>
									<td class="align-middle">{{ $cart->identifier }}</td>
									<td class="align-middle">{{ $cart->instance }}</td>
									<td class="align-middle">{{ $cart->user->first_name }} {{ $cart->user->last_name }}</td>
									<td class="align-middle">{{ $cart->user->company->title }}</td>
									<td class="align-middle text-center">{{ $cart->created_at }}</td>
									<td class="align-middle text-center">{{ $cart->cartTotalItems }}</td>
									<td class="align-middle text-center">
										<a href="javascript:void(0);" title="View Cart" data-toggle="modal" data-target=".cart-{{ $cart->identifier }}-modal-lg">View Cart</a>
										<div class="modal fade cart-{{ $cart->identifier }}-modal-lg" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="cartModalLabel">Cart Contents</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													</div>
													<div class="modal-body">
														@foreach ($cart->cartItems as $cartItem)
															<div class="row">
																<div class="col-sm-12 col-md-3 col-lg-3 text-center">
																	<a href="{{ $cartItem['product_url'] }}" title="{{ $cartItem['product_title'] }}"><img src="{{ $cartItem['product_image_url'] }}" class="img-fluid" alt="{{ $cartItem['product_title'] }}"></a>
																</div>
																<div class="col-sm-12 col-md-9 col-lg-9 text-left">
																	<p><strong><a href="{{ $cartItem['product_url'] }}" title="{{ $cartItem['product_title'] }}" class="text-gf-red">{{ $cartItem['product_title'] }}</a></strong></p>
																	<dl class="row">
																		<dt class="col-sm-9 font-weight-normal font-italic">Commodities</dt>
																		<dd class="col-sm-3 font-weight-normal font-italic text-center">Quantity</dd>
																		@foreach ($cartItem['product_commodities'] as $productCommodity)
																			<dt class="col-sm-9 font-weight-normal">- {{ $productCommodity['title'] }}</dt>
																			<dd class="col-sm-3 font-weight-normal text-center">{{ $productCommodity['quantity'] }}</dd>
																		@endforeach
																	</dl>
																</div>
															</div>
															@if (!$loop->last)
																<hr>
															@endif
														@endforeach
													</div>
													<div class="modal-footer">
														<button type="button" class="float-right btn btn-outline-secondary" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
