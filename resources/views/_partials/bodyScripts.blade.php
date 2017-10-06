	<script async src="{{ mix('/assets/js/global.js') }}"></script>
	@include('_partials.analytics')
	@if ($page->slug == 'contact')
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxr_6QM8lKg_bUBC7xSPTZ86LW_PzmPsE"></script>
	@endif
	