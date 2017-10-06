	<!--[if lt IE 9]>
	<script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@if ($page->slug == 'contact')
		<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.key') }}&callback="></script>
	@endif
	