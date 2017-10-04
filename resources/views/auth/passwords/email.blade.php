@extends('_layouts.default')

@section('title', 'Reset Password - '.config('cms.site.name'))
@section('description', 'Reset Password - '.config('cms.site.name'))
@section('keywords', 'Reset, Password, '.config('cms.site.name'))

@php ($page->content = '<p>Please type in the email address you use to login with. We'll email you a link to create a new password.</p>')

@push('styles')
	@include('_partials.styles')
@endpush

@push('headScripts')
	@include('_partials.headScripts')
@endpush

@push('bodyScripts')
	@include('_partials.bodyScripts')
@endpush

@section('content')
	@include('_partials.message', [
		'currentUser' => null
	])
	@include('_partials.header', [
		'currentUser' => null,
		'cart' => null
	])
	<main>
		<div class="container">
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h3>Reset Password</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			@if (!empty($page->content))
				<div class="row">
					<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
						{!! $page->content !!}
					</div>
				</div>
				<div class="row">
					<div class="col-12 spacer tall"></div>
				</div>
			@endif
			<div class="row d-flex h-100 justify-content-center justify-content-sm-center justify-content-md-start justify-content-lg-start justify-content-xl-start">
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 align-self-center">
					<form name="sendResetPasswordLink" id="sendResetPasswordLink" class="sendResetPasswordLink" role="form" method="POST" action="{{ route('password.email') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="email" class="control-label">Email Address <span class="text-danger">&#42;</span></label>
							<input type="email" name="email" id="email" class="form-control" placeholder="e.g. joe@bloggs.com" value="{{ old('email') }}" title="Email Address" tabindex="1" autocomplete="off" aria-describedby="helpBlockEmail" required autofocus>
							@if ($errors->has('email'))
								<span id="helpBlockFirstName" class="form-control-feedback form-text gf-red">- {{ $errors->first('email') }}</span>
							@endif
						</div>
						<div class="spacer"></div>
						<div class="form-group text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<button type="submit" name="submit" id="submit" class="btn btn-danger" title="Send Reset Password Link" tabindex="2">Send Reset Password Link</button>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row">
				<div class="col-12 spacer tall"></div>
			</div>
		</div>	
	</main>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
