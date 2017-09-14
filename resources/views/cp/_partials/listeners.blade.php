@if (!empty($orders) && $orders->count() > 0)
	<script async>
	'use strict';
	
	window.onload = () => {
		const orders = JSON.parse('{!! json_encode($orders) !!}');
		
		orders.map(order => window.Echo.private(`orders.${order.id}`).listen('.order.updated', event => window.CMS.ControlPanel.orderUpdated(event.order)));
	};
	</script>
@endif

@if (!empty($order))
	<script async>
	'use strict';
	
	window.onload = () => {
		const order = JSON.parse('{!! json_encode($order) !!}');
		
		window.Echo.private(`orders.${order.id}`).listen('.order.updated', event => window.CMS.ControlPanel.orderUpdated(event.order));
	};
	</script>
@endif
