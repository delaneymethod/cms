@extends('_layouts.default')

@section('title', 'Set Password - '.$siteName)
@section('description', 'Set Password - '.$siteName)
@section('keywords', 'Set, Password, '.$siteName)

@php ($page->content = '')

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
					<h3>Set Password</h3>
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
					<form name="setPassword" id="setPassword" class="setPassword" role="form" method="POST" action="{{ route('password.request') }}">
						{{ csrf_field() }}
						<input type="hidden" name="token" value="{{ $token }}">
						<div class="form-group">
							<label for="email" class="control-label">Email Address <span class="text-danger">&#42;</span></label>
							<input type="email" name="email" id="email" class="form-control" placeholder="e.g. joe@bloggs.com" value="{{ old('email') }}" title="Email Address" tabindex="1" autocomplete="off" aria-describedby="helpBlockEmail" required autofocus>
							@if ($errors->has('email'))
								<span id="helpBlockEmail" class="form-control-feedback form-text gf-red">- {{ $errors->first('email') }}</span>
							@endif
						</div>
						<div class="form-group">
							<label for="password" class="control-label">Password <span class="text-danger">&#42;</span></label>
							<input type="password" name="password" id="password" class="form-control" placeholder="e.g y1Fwc]_C" value="" title="Password" tabindex="2" autocomplete="off" aria-describedby="helpBlockPassword" required>
							@if ($errors->has('password'))
								<span id="helpBlockPassword" class="form-control-feedback form-text gf-red">- {{ $errors->first('password') }}</span>
							@endif
						</div>
						<div class="form-group">
							<label for="password-confirm" class="control-label">Confirm Password <span class="text-danger">&#42;</span></label>
							<input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="e.g y1Fwc]_C" value="" title="Confirm Password" tabindex="3" autocomplete="off" aria-describedby="helpBlockConfirmPassword" required>
							@if ($errors->has('password_confirmation'))
								<span id="helpBlockConfirmPassword" class="form-control-feedback form-text gf-red">- {{ $errors->first('password_confirmation') }}</span>
							@endif
						</div>
						<div class="spacer"></div>
						<div class="form-group text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<button type="submit" name="submit" id="submit" class="btn btn-danger" title="Set Password" tabindex="4">Set Password</button>
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
