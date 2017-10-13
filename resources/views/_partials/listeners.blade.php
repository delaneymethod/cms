@if ($authenticated)
	<script async>
	'use strict';
		
	window.onload = () => {
		window.Echo.private(`users.${window.User.id}`).listen('.user.login', event => window.CMS.showWelcomeBackMessage(event.user));
	};
	</script>
@endif
