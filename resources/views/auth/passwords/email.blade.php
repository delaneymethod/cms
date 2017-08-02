@extends('_layouts.default')

@section('title', 'Set Password - '.config('app.name'))
@section('description', 'Set Password - '.config('app.name'))
@section('keywords', 'Set, Password, '.config('app.name'))

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
	@include('_partials.header')
	<section class="content">
		<h2>Reset Password</h2>
		@if (session('status'))
			{{ session('status') }}
		@endif
		<form name="" id="" class="" role="form" method="POST" action="{{ route('password.email') }}">
			{{ csrf_field() }}
			<label for="email">Email Address</label>
			<input type="email" name="email" id="email" class="" placeholder="" value="{{ old('email') }}" title="" required autofocus>
			@if ($errors->has('email'))
				<strong>{{ $errors->first('email') }}</strong>
			@endif
			<button type="submit" name="" id="" class="" title="">Send Reset Password Link</button>
		</form>
	</section>
	@include('_partials.footer')
@endsection
