@extends('_layouts.default')

@section('title', 'Login - '.config('cms.site.name'))
@section('description', 'Login - '.config('cms.site.name'))
@section('keywords', 'Login, '.config('cms.site.name'))

@push('styles')
	<link rel="stylesheet" href="{{ mix('/assets/css/global.css') }}">
@endpush

@push('headScripts')
	<!--[if lt IE 9]>
	<script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
@endpush

@push('bodyScripts')
	<script async src="{{ mix('/assets/js/global.js') }}"></script>
	<!--
	<script async>
	'use strict';
	
	window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
	ga('create','XX-XXX-XXX','auto');ga('send','pageview')
	</script>
	<script async defer src="//www.google-analytics.com/analytics.js"></script>
	//-->
@endpush

@section('content')
	@include('_partials.header', [
		'currentUser' => null,
		'cart' => null
	])
	<div class="row wrapper">
		<div class="col main">
			@include('_partials.message', [
				'currentUser' => null
			])
			<h2>Login</h2>
			@php ($redirectTo = request()->get('redirectTo'))
			@if (!empty($redirectTo))
				@php ($redirectTo = '?redirectTo='.$redirectTo)
			@endif			
			<form name="" id="" class="" role="form" method="POST" action="{{ route('login') }}{{ $redirectTo }}">
				{{ csrf_field() }}
				<label for="email">Email Address</label>
				<input type="email" name="email" id="email" class="" placeholder="" value="{{ old('email') }}" title="" required autofocus>
				@if ($errors->has('email'))
					<strong>{{ $errors->first('email') }}</strong>
				@endif
				<label for="password" >Password</label>
				<input type="password" name="password" id="password" class="" placeholder="" value="" title="" required>
				@if ($errors->has('password'))
					<strong>{{ $errors->first('password') }}</strong>
				@endif
				<label><input type="checkbox" name="remember" id="" class="" placeholder="" title="" {{ old('remember') ? 'checked' : '' }}> Remember me</label>
				<button type="submit" name="" id="" class="" title="">Login</button>
				<a href="{{ route('password.request') }}" title="">Forgot Your Password?</a>
			</form>
		</div>
	</div>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
