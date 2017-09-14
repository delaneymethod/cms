<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Sean Delaney (delaneymethod.com)">
	<meta name="description" content="@yield('description')">
	<meta name="keywords" content="@yield('keywords')">
	<meta name="robots" content="noindex, nofollow, noarchive">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!--[if IE]>
	<meta http-equiv="cleartype" content="on">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<![endif]-->
	<title>@yield('title')</title>
	<link rel="home" href="{{ config('cms.site.url') }}">
	@stack('styles')
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" sizes="57x57" href="/assets/img/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/assets/img/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/assets/img/apple-icon-144x144.png">
	<link rel="dns-prefetch" href="{{ config('cms.site.url') }}">
	<base href="/">
	<script async>
	'use strict';
	
	@auth
	window.CMS = {};
	@endauth
	
	window.User = {!! Auth::check() ? Auth::user() : 'null' !!};
	
	window.Laravel = {'csrfToken': '{{ csrf_token() }}'};
	</script>
	@stack('headScripts')
</head>
<body>
	<div class="container-fluid">
		@yield('content')
	</div>
	@stack('bodyScripts')
</body>
</html>
