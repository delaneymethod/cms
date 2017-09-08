@extends('_layouts.default')

@section('title', 'Register - '.config('cms.site.name'))
@section('description', 'Register - '.config('cms.site.name'))
@section('keywords', 'Register, '.config('cms.site.name'))

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
	<section class="content">
		<h2>Register</h2>
		<form name="" id="" class="" role="form" method="POST" action="{{ route('register') }}">
			{{ csrf_field() }}
			<label for="first_name">First Name</label>
			<input type="text" name="first_name" id="first_name" class="" placeholder="" value="{{ old('first_name') }}" title="" required autofocus>
			@if ($errors->has('first_name'))
				<strong>{{ $errors->first('first_name') }}</strong>
			@endif
			<label for="email">Email Address</label>
			<input type="email" name="email" id="email" class="" placeholder="" value="{{ old('email') }}" title="" required>
			@if ($errors->has('email'))
				<strong>{{ $errors->first('email') }}</strong>
			@endif
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="" placeholder="" value="" title="" required>
			@if ($errors->has('password'))
				<strong>{{ $errors->first('password') }}</strong>
			@endif
			<label for="password-confirm">Confirm Password</label>
			<input type="password" name="password_confirmation" id="password-confirm" class="" placeholder="" value="" title="" required>
			@if ($errors->has('password_confirmation'))
				<strong>{{ $errors->first('password_confirmation') }}</strong>
			@endif
			<button type="submit" name="" id="" class="" title="">Register</button>
		</form>
	</section>
	@include('_partials.footer', [
		'currentUser' => null,
		'cart' => null
	])
@endsection
