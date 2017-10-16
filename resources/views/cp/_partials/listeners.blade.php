@if ($currentUser->canReceiveNotifications())
	<script async>
	'use strict';
		
	function loadListeners() {
		window.Echo.private('users.' + window.User.id).notification(notification => window.CMS.ControlPanel.showNotification(notification));
	
		@if (!empty($orders) && $orders->count() > 0)
			const orderIds = @json($orders->pluck('id'));
		
			orderIds.map(orderId => window.Echo.private('orders.' + orderId).listen('.order.updated', event => window.CMS.ControlPanel.orderUpdated(event.order)));
		@endif
	
		@if (!empty($order))
			const order = @json($order);
			
			window.Echo.private('orders.' + order.id).listen('.order.updated', event => window.CMS.ControlPanel.orderUpdated(event.order));
		@endif
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
