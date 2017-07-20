;($ => {
	$.controlPanel = options => {
		this.name = 'Control Panel';
		
		this.version = '1.0.0';
		
		this.settings = {};

		let defaults = {};
		
		let loadAnimations = () => {
			$('.sidebar #advanced').on('click', event => {
				event.preventDefault();
				
				$(event.target).toggleClass('highlight');
				
				$(event.target).next('ul').slideToggle(500);
		
				$(event.target).find('span > i').toggleClass('fa-rotate');
			});
		};
		
		let attachRedactor = element => {
			$(element).redactor({
				'focus': false,
				'fileUpload': '/cp/assets',
				'fileManagerJson': '/cp/assets',
				'imageUpload': '/cp/assets',
				'imageManagerJson': '/cp/assets?type=image',
				'imageResizable': true,
				'imagePosition': true,
				'structure': true,
				'tabAsSpaces': 4,
				'plugins': [
	        		'source',
	        		'table',
	        		'alignment',
	        		'fullscreen',
	        		'filemanager',
	        		'imagemanager',
	        		'video'
	        	]
	        });	
		};
		
		let attachDataTable = element => {
			$(element).dataTable({
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
		};
		
		let convertTitleToSlug = (element, targetElement) => {
			$(element).on('keyup change', event => {
				let slug = $(event.target).val().toString()
					.toLowerCase()
					.trim()
					.replace(/\s+/g, '-') // Replace spaces with -
					.replace(/&/g, '-and-') // Replace & with 'and'
					.replace(/[^\w\-]+/g, '') // Remove all non-word chars
					.replace(/\-\-+/g, '-'); // Replace multiple - with single -
				
				$(targetElement).val(slug);
			});
		};
		
		let logout = () => {
			$('#logout').on('click', event => {
				event.preventDefault();
			
				$('#logout-form').submit();
			});	
		};
		
		let init = () => {
			console.info(this.name + ' v' + this.version + ' is up and running!');
			
			this.settings = $.extend({}, defaults, options);
			
			loadAnimations();
			
			attachRedactor('#content');
			
			attachDataTable('#datatable');
		
			convertTitleToSlug('#createPage #title', '#createPage #slug');
			
			convertTitleToSlug('#createPage #slug', '#createPage #slug');
			
			logout();
		};

		init();
	};
})(jQuery);

$.controlPanel();
