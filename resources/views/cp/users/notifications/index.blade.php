@extends('_layouts.default')

@section('title', 'Messages - Users - '.config('app.name'))
@section('description', 'Messages - Users - '.config('app.name'))
@section('keywords', 'Messages, Users, '.config('app.name'))

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
								<th class="align-middle no-sort">Subject</th>
								<th class="align-middle text-center">Date Time</th>
								<th class="align-middle no-sort">&nbsp;</th>
							</tr>
						</thead>
						<tbody id="all-notifications">
							@foreach ($notifications as $notification)
								<tr>
									<td class="align-middle">{{ $notification->subject }} {!! (is_null($notification->read_at)) ? '&nbsp;<span class="badge badge-pill badge-suspended align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Unread</span>' : '' !!}</td>
									<td class="align-middle text-center">{{ $notification->created_at->format('jS M Y H:i') }}</td>
									<td class="align-middle text-center"><a href="/cp/users/{{ $currentUser->id }}/notifications/{{ $notification->id }}" title="View Notification"><i class="icon fa fa-envelope" aria-hidden="true"></i></a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@include('cp._partials.footer')
			</div>
		</div>
@endsection
