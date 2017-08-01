@extends('_layouts.default')

@section('title', 'Edit Order - Orders- '.config('app.name'))
@section('description', 'Edit Order - Orders - '.config('app.name'))
@section('keywords', 'Edit, Order, Orders, '.config('app.name'))

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
					<p><span class="text-danger">&#42;</span> denotes a required field.</p>
					<form name="editOrder" id="editOrder" class="editOrder" role="form" method="POST" action="/cp/orders/{{ $order->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label for="title" class="control-label font-weight-bold">Title <span class="text-danger">&#42;</span></label>
							<input type="text" name="title" id="title" class="form-control" value="{{ old('title') ?? $order->title }}" placeholder="e.g Order Title" tabindex="1" autocomplete="off" aria-describedby="helpBlockTitle" required autofocus>
							@if ($errors->has('title'))
								<span id="helpBlockTitle" class="form-control-feedback form-text gf-red">- {{ $errors->first('title') }}</span>
							@endif
							<span id="helpBlockTitle" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label class="control-label font-weight-bold">Status</label>
							@foreach ($statuses as $status)
								<div class="form-check status_id-{{ $status->id }}">
									<label for="status_id-{{ str_slug($status->title) }}" class="form-check-label">
										<input type="radio" name="status_id" id="status_id-{{ str_slug($status->title) }}" class="form-check-input" value="{{ $status->id }}" tabindex="3" aria-describedby="helpBlockStatusId" {{ (old('status_id') == $status->id || $order->status_id == $status->id) ? 'checked' : '' }}>{{ $status->title }}
									</label>
								</div>
							@endforeach
							@if ($errors->has('status_id'))
								<span id="helpBlockStatusId" class="form-control-feedback form-text gf-red">- {{ $errors->first('status_id') }}</span>
							@endif
							<span id="helpBlockStatusId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-group">
							<label for="user_id" class="control-label font-weight-bold">Originator</label>
							<select name="user_id" id="user_id" class="form-control" tabindex="4" aria-describedby="helpBlockUserId" required>
								@foreach ($users as $user)
									<option value="{{ $user->id }}" {{ (old('user_id') == $user->id || $order->user_id == $user->id) ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
								@endforeach
							</select>
							@if ($errors->has('user_id'))
								<span id="helpBlockUserId" class="form-control-feedback form-text gf-red">- {{ $errors->first('user_id') }}</span>
							@endif
							<span id="helpBlockUserId" class="form-control-feedback form-text text-muted"></span>
						</div>
						<div class="form-buttons">
							@if ($currentUser->hasPermission('view_orders'))
								<a href="/cp/orders" title="Cancel" class="btn btn-outline-secondary cancel-button" tabindex="6" title="Cancel">Cancel</a>
							@endif
							<button type="submit" name="submit" id="submit" class="btn btn-outline-primary" tabindex="5" title="Save Changes">Save Changes</button>
							@if ($currentUser->hasPermission('delete_orders'))
								<a href="/cp/orders/{{ $order->id }}/delete" title="Delete Order" class="pull-right btn btn-outline-danger">Delete Order</a>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
@endsection
