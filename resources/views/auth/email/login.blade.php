@extends('_layouts.default')

@section('title', 'Email Login - '.$siteName)
@section('description', 'Email Login - '.$siteName)
@section('keywords', 'Email Login, '.$siteName)

@php ($page->content = '<p>Please enter your email address below.</p><p>We&#39;ll email you a login link, but you&#39;ll need access to your email address (which proves your identity).</p><p><strong>Email login links expire after 15 minutes.</strong></p>')

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
					<h3>Email Login</h3>
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
					<form name="emailLoginUser" id="emailLoginUser" class="emailLoginUser" role="form" method="POST" action="/login/email">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="email" class="control-label">Email Address <span class="text-danger">&#42;</span></label>
							<input type="email" name="email" id="email" class="form-control" placeholder="e.g joe@bloggs.com" value="{{ old('email') }}" title="Email Address" tabindex="1" autocomplete="on" aria-describedby="helpBlockEmail" required autofocus>
							@if ($errors->has('email'))
								<span id="helpBlockEmail" class="form-control-feedback form-text gf-red">- {{ $errors->first('email') }}</span>
							@endif
							<span id="did-you-mean" class="form-control-feedback form-text gf-red">- Did you mean <a href="javascript:void(0);" title="Click to fix your mistake." rel="nofollow"></a>?</span>
						</div>
						<div class="spacer"></div>
						<div class="form-group text-center text-sm-center text-md-left text-lg-left text-xl-left">
							<button type="submit" name="submit_email_login" id="submit_email_login" class="btn btn-danger" title="Login" tabindex="4">Login</button>
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
