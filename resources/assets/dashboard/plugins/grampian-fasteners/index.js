'use strict';

let GrampianFasteners = (() => {
	const name = 'Grampian Fasteners',
		version = '1.0.0';
	
	let init = () => {
		console.info(name + ' v' + version + ' is up and running!');
		
		$('#datatable').dataTable({
			'order': [],
			'deferRender': true,
			'oLanguage': {
				'sLengthMenu': '_MENU_',
				'sSearch': '',
				'sSearchPlaceholder': 'Search...'
			},
			'columnDefs': [{
				'targets': 'no-sort',
				'orderable': false,
			}],
			'language': {
				'zeroRecords': 'Nothing found - sorry',
				'info': 'Showing page _PAGE_ of _PAGES_',
				'infoEmpty': 'No records available',
				'infoFiltered': '(filtered from _MAX_ total records)',
			}
		});
		
		$('#advanced').on('click', event => {
			const element = $(event.target);
			
			element.toggleClass('highlight');
			
			element.next('ul').slideToggle(500);
	
			element.find('span > i').toggleClass('fa-rotate');
		});
		
		$('#logout').on('click', event => {
			event.preventDefault();
		
			$('#logout-form').submit();
		});
	};
	
	return {
		init: init
	};
})();

GrampianFasteners.init();
