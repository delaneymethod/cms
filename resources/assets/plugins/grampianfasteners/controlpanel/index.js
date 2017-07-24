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
			
			$('.main .content #pageActions').on('click', event => {
				event.preventDefault();
				
				$('.main .content #pageActions i').removeClass('fa-rotate');
				
				if (event.target === event.currentTarget) {
					$(event.target).find('i').toggleClass('fa-rotate');
				} else {
					$(event.target).toggleClass('fa-rotate');
				}
			});
			
			$('.main .content #submenu').on('hide.bs.dropdown', () => {
				$('.main .content #pageActions i').removeClass('fa-rotate');
			});
			
			$('.main .message.success').on('shown', () => {
				setTimeout(() => {
					$('.main .message.success').fadeOut('fast');
				}, 4000);
    		});
    		
    		$('.main .message #hideMessage').on('click', () => {
	    		$('.main .message').fadeOut('fast');
    		});
    	};
		
		let attachRedactor = element => {
			const token = window.Laravel.csrfToken;
			
			$(element).redactor({
				'focus': false,
				'fileUpload': '/cp/assets?_token=' + token,
				'fileManagerJson': '/cp/assets?format=json',
				'imageUpload': '/cp/assets?_token=' + token + '&type=image',
				'imageManagerJson': '/cp/assets?format=json&type=image',
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
	        	],
				'callbacks': {
					'imageUpload': (image, json) => {
						$(image).attr('id', json.id);
					},
					'imageUploadError': (json, xhr) => {
						alert(json);
					},
					'fileUpload': (link, json) => {
						$(link).attr('id', json.id);
					},
					'fileUploadError': json => {
						alert(json);
					}
				}
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
		
		let attachNestedSortable = element => {
			$(element).nestedSortable({
				'forcePlaceholderSize': true,
				'handle': 'div',
				'helper':	'clone',
				'items': 'li',
				'placeholder': 'sortable-placeholder',
				'tolerance': 'pointer',
				'toleranceElement': '> div',
				'isTree': true
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
			
				$('#logoutUser').submit();
			});	
		};
		
		let saveMenuChanges = element => {
			$('form#menu').submit(() => {
				const tree = $(element).nestedSortable('toArray');
					
				$('#tree').val(JSON.stringify(tree));
					
				return true;
			});	
		};
		
		let init = () => {
			console.info(this.name + ' v' + this.version + ' is up and running!');
			
			this.settings = $.extend({}, defaults, options);
			
			logout();
			
			loadAnimations();
			
			attachRedactor('#content');
			
			attachDataTable('#datatable');
			
			attachNestedSortable('#nestedSortable');
			
			convertTitleToSlug('#createPage #title', '#createPage #slug');
			
			convertTitleToSlug('#createPage #slug', '#createPage #slug');
			
			saveMenuChanges('#nestedSortable');
		};

		init();
	};
})(jQuery);

$.controlPanel();
