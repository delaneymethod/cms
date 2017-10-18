@if ($authenticated)
	<script async>
	'use strict';
	
	function loadListeners() {
		window.Echo.private('users.' + window.User.id).listen('.user.login', event => window.CMS.Templates.showWelcomeBackMessage(event.user));
	}
		
	if (window.attachEvent) {
		window.attachEvent('onload', loadListeners);
	} else if (window.addEventListener) {
		window.addEventListener('load', loadListeners, false);
	} else {
		document.addEventListener('load', loadListeners, false);
	}
	</script>
@endif
