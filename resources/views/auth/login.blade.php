@extends('_layouts.default')

@section('title', 'Login - '.$siteName)
@section('description', 'Login - '.$siteName)
@section('keywords', 'Login, '.$siteName)

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
					<h3>Login</h3>
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
					@php ($redirectTo = request()->get('redirectTo'))
					@if (!empty($redirectTo))
						@php ($redirectTo = '?redirectTo='.$redirectTo)
						@php ($code = request()->get('code'))
						@if (!empty($code))
							@php ($redirectTo = $redirectTo.'&code='.$code)
						@endif
					@endif	
					<form name="loginUser" id="loginUser" class="loginUser" role="form" method="POST" action="{{ route('login') }}{{ $redirectTo }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="email" class="control-label">Email Address <span class="text-danger">&#42;</span></label>
							<input type="email" name="email" id="email" class="form-control" placeholder="e.g joe@bloggs.com" value="{{ old('email') }}" title="Email Address" tabindex="1" autocomplete="on" aria-describedby="helpBlockEmail" required autofocus>
							@if ($errors->has('email'))
								<span id="helpBlockEmail" class="form-control-feedback form-text gf-red">- {{ $errors->first('email') }}</span>
							@endif
							<span id="did-you-mean" class="form-control-feedback form-text gf-red">- Did you mean <a href="javascript:void(0);" title="Click to fix your mistake." rel="nofollow"></a>?</span>
						</div>
						<div class="form-group">
							<label for="password" class="control-label">Password <span class="text-danger">&#42;</span></label>
							<input type="password" name="password" id="password" class="form-control" placeholder="e.g y1Fwc]_C" value="" title="Password" tabindex="2" autocomplete="off" aria-describedby="helpBlockPassword" required>
							@if ($errors->has('password'))
								<span id="helpBlockPassword" class="form-control-feedback form-text gf-red">- {{ $errors->first('password') }}</span>
							@endif
						</div>
						<div class="form-group">
							<div class="form-check">
								<label class="form-check-label"><input type="checkbox" name="remember" id="remember" class="form-check-input" title="Remember me" {{ old('remember') ? 'checked' : '' }} tabindex="3" autocomplete="off"> Remember me</label>
							</div>
						</div>
						<div class="spacer"></div>
						<div class="form-group text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<button type="submit" name="submit_login" id="submit_login" class="btn btn-danger" title="Login" tabindex="4">Login</button>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer very-tall"></div>
			</div>
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<h4>Forgotten your Password?<h4>
				</div>
			</div>
			<div class="row">
				<div class="col-12 spacer"></div>
			</div>
			<div class="row">
				<div class="col-12 text-center text-sm-center text-md-left text-lg-left text-xl-left">
					<p>Not a problem, it happens!</p>
					<p><a href="{{ route('password.request') }}" title="Click here to Reset Password">Click here to Reset Password.</a></p>
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
