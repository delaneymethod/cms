@extends('_layouts.default')

@section('title', $notification->subject.' - Messages - Users - '.config('app.name'))
@section('description', $notification->subject.' - Messages - Users - '.config('app.name'))
@section('keywords', $notification->subject.', Messages, Users, '.config('app.name'))

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
					<div class="row">
						<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
							@php($order = json_decode($notification->data)->order)
							<p>Order <strong>#{{ $order->order_number }}</strong></p>
							<div class="row">
								<div class="col-12">
									<p></p>
									<ul class="list-unstyled list-inline">
										<li class="list-inline-item"><a href="/cp/orders/{{ $order->id }}" title="View Order" class="btn btn-primary">View Order</a></li>
										<li class="list-inline-item"><a href="/cp/users/{{ $currentUser->id }}/notifications" title="View All Messages" class="btn btn-outline-secondary">View All Messages</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
							<h3>Stats</h3>
							<dl class="row">
								<dt class="col-sm-4">Read</dt>
								<dd class="col-sm-8">{{ $notification->read_at }}</dd>
								<dt class="col-sm-4">Created</dt>
								<dd class="col-sm-8">{{ $notification->created_at->format('jS M Y H:i') }}</dd>
								<dt class="col-sm-4">Updated</dt>
								<dd class="col-sm-8">{{ $notification->updated_at->format('jS M Y H:i') }}</dd>
							</dl>
						</div>
					</div>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
	</div>
@endsection
