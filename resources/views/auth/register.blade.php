@extends('_layouts.default')

@section('title', 'Register - '.$siteName)
@section('description', 'Register - '.$siteName)
@section('keywords', 'Register, '.$siteName)

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
					<h3>Register</h3>
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
					<form name="register" id="register" class="register" role="form" method="POST" action="{{ route('register') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="first_name" class="control-label">First Name <span class="text-danger">&#42;</span></label>
							<input type="text" name="first_name" id="first_name" class="form-control" placeholder="e.g Joe Bloggs" value="{{ old('first_name') }}" title="First Name" tabindex="1" autocomplete="off" aria-describedby="helpBlockFirstName" required autofocus>
							@if ($errors->has('first_name'))
								<span id="helpBlockFirstName" class="form-control-feedback form-text gf-red">- {{ $errors->first('first_name') }}</span>
							@endif
						</div>
						<div class="form-group">
							<label for="email" class="control-label">Email Address <span class="text-danger">&#42;</span></label>
							<input type="email" name="email" id="email" class="form-control" placeholder="e.g. joe@bloggs.com" value="{{ old('email') }}" title="Email Address" tabindex="2" autocomplete="off" aria-describedby="helpBlockEmail" required>
							@if ($errors->has('email'))
								<span id="helpBlockEmail" class="form-control-feedback form-text gf-red">- {{ $errors->first('email') }}</span>
							@endif
							<span id="didYouMeanMessage" class="form-control-feedback form-text gf-red">- Did you mean <a href="javascript:void(0);" title="Click to fix your mistake." rel="nofollow"></a> ?<br>- Click to fix your mistake.</span>
						</div>
						<div class="form-group">
							<label for="password" class="control-label">Password <span class="text-danger">&#42;</span></label>
							<input type="password" name="password" id="password" class="form-control" placeholder="e.g y1Fwc]_C" value="" title="Password" tabindex="3" autocomplete="off" aria-describedby="helpBlockPassword" required>
							@if ($errors->has('password'))
								<span id="helpBlockPassword" class="form-control-feedback form-text gf-red">- {{ $errors->first('password') }}</span>
							@endif
						</div>
						<div class="form-group">	
							<label for="password-confirm" class="control-label">Confirm Password <span class="text-danger">&#42;</span></label>
							<input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="e.g y1Fwc]_C" value="" title="Confirm Password" tabindex="4" autocomplete="off" aria-describedby="helpBlockConfirmPassword" required>
							@if ($errors->has('password_confirmation'))
								<span id="helpBlockConfirmPassword" class="form-control-feedback form-text gf-red">- {{ $errors->first('password_confirmation') }}</span>
							@endif
						</div>
						<div class="spacer"></div>
						<div class="form-group text-center text-sm-center text-md-left text-lg-left text-xl-left">	
							<button type="submit" name="submit_register" id="submit_register" class="btn btn-danger" title="Register" tabindex="5">Register</button>
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
