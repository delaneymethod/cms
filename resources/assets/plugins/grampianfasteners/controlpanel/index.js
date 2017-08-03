;($ => {
	$.controlPanel = options => {
		this.name = 'Control Panel';
		
		this.version = '1.0.0';
		
		this.settings = {};

		let defaults = {};
		
		let colours = [
			'#4D4D4D', // gray
			'#5DA5DA', // blue
			'#FAA43A', // orange
			'#60BD68', // green
			'#F17CB0', // pink
			'#B2912F', // brown
			'#B276B2', // purple
			'#DECF3F', // yellow
			'#F15854', // red
		];
		
		let loadAllStats = () => {
			if ($('#allStats').length) {
				const allStats = $('#allStats');
				
				const totalCategories = allStats.data('total-categories');
				
				const totalUsers = allStats.data('total-users');
				
				const totalPages = allStats.data('total-pages');
				
				const totalOrders = allStats.data('total-orders');
				
				const totalAssets = allStats.data('total-assets');
				
				const totalCompanies = allStats.data('total-companies');
				
				const totalArticles = allStats.data('total-articles');
				
				const totalLocations = allStats.data('total-locations');
				
				const data = {
					'datasets': [{
						'data': [totalCategories, totalUsers, totalPages, totalOrders, totalAssets, totalCompanies, totalArticles, totalLocations],
						'label': 'All Stats',
						'backgroundColor': [colours[0], colours[1], colours[2], colours[3], colours[4], colours[5], colours[6], colours[7]]
					}],
					'labels': ['Categories', 'Users', 'Pages', 'Orders', 'Assets', 'Companies', 'Articles', 'Locations']
				};
				
				const options = {
					'responsive': true,
					'legend': {
						'position': 'top',
					},
					'title': {
						'display': true,
						'text': 'All Stats'
					},
					'animation': {
						'animateScale': true,
						'nimateRotate': true
					}
				};
				
				new Chart(allStats, {
					'type': 'pie',
					'data': data,
					'options': options
				});
			}
		};
		
		let loadOrderStats = () => {
			if ($('#orderStats').length) {
				const orderStats = $('#orderStats');
				
				const orders = orderStats.data('orders');
				
				const data = {
					'labels': ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
					'datasets': [{
						'label': 'Pending',
						'backgroundColor': colours[0],
						'borderColor': colours[0],
						'data': [111, 150, 313, 141, 421, 100, 200],
						'fill': false,
	                },{
						'label': 'Approved',
						'backgroundColor': colours[1],
						'borderColor': colours[1],
						'data': [105, 150, 100, 40, 92, 100, 182],
						'fill': false,
	                }]
				};
				
				const options = {
					'responsive': true,
					'title': {
						'display': true,
						'text': 'Monthly Orders'
					},
					'tooltips': {
						'mode': 'index',
						'intersect': false,
					},
					'hover': {
						'mode': 'nearest',
						'intersect': true
					},
					'scales': {
						'xAxes': [{
							'display': true,
							'scaleLabel': {
								'display': true,
								'labelString': 'Month'
							}
						}],
						'yAxes': [{
							'display': true,
							'scaleLabel': {
								'display': true,
								'labelStrin': 'Orders'
							},
							'ticks': {
								'suggestedMin': 0,
								'suggestedMax': 500,
								'stepSize': 100
							}
						}]
					}
				};
					
				new Chart(orderStats, {
					'type': 'line',
					'data': data,
					'options': options
				});
			}
		};
		
		let loadRoleUsersStats = () => {
			if ($('#roleUsersStats').length) {
				const roleUsersStats = $('#roleUsersStats');
				
				const totalSuperAdmins = roleUsersStats.data('total-super-admins');
				
				const totalAdmins = roleUsersStats.data('total-admins');
				
				const totalEndUsers = roleUsersStats.data('total-end-users');
				
				const data = {
					'datasets': [{
						'label': 'Users per Role',
						'data': [totalSuperAdmins, totalAdmins, totalEndUsers],
						'backgroundColor': [colours[0], colours[1], colours[2]]
					}],
					'labels': [
						'Super Admins',
						'Admins',
						'End Users',
					]
				};
				
				const options = {
					'responsive': true,
					'legend': {
						'position': 'top',
					},
					'title': {
						'display': true,
						'text': 'Users per Role'
					},
					'animation': {
						'animateScale': true,
						'animateRotate': true
					}
				};
				
				new Chart(roleUsersStats, {
					'type': 'doughnut',
					'data': data,
					'options': options
				});
			}
		};
		
		let loadAnimations = () => {
			if ($('.sidebar #advanced').length) {
				$('.sidebar #advanced').on('click', event => {
					event.preventDefault();
					
					$(event.target).toggleClass('highlight');
					
					$(event.target).next('ul').slideToggle(500);
			
					$(event.target).find('span > i').toggleClass('fa-rotate');
				});
			}
			
			if ($('.main .content #pageActions').length) {
				$('.main .content #pageActions').on('click', event => {
					event.preventDefault();
					
					$('.main .content #pageActions i').removeClass('fa-rotate');
					
					if (event.target === event.currentTarget) {
						$(event.target).find('i').toggleClass('fa-rotate');
					} else {
						$(event.target).toggleClass('fa-rotate');
					}
				});
			}
			
			if ($('.main .content #submenu').length) {	
				$('.main .content #submenu').on('hide.bs.dropdown', () => {
					$('.main .content #pageActions i').removeClass('fa-rotate');
				});
			}
				
			if ($('.main .message.success').length) {	
				$('.main .message.success').on('shown', () => {
					setTimeout(() => {
						$('.main .message.success').fadeOut('fast');
					}, 4000);
				});
			}
			
			if ($('.main .message #hideMessage').length) {	
				$('.main .message #hideMessage').on('click', () => {
			 		$('.main .message').fadeOut('fast');
				});
			}
		};
		
		let attachDatePicker = element => {
			if ($(element).length) {
				$(element).datetimepicker({
					'weekStart': 1,
					'format': 'yyyy-mm-dd hh:ii:00',
					'autoclose': true,
					'todayHighlight': true,
					'toggleActive': true,
					'todayBtn': true,
					'fontAwesome': true,
				});
			}
		};
		
		let attachRedactor = element => {
			if ($(element).length) {
				const token = window.Laravel.csrfToken;
				
				let minHeight = 400;
				
				let buttons = ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'];
				
				let plugins = ['source', 'table', 'alignment', 'fullscreen', 'filemanager', 'imagemanager', 'video'];
					
				if (element == '#excerpt') {
					minHeight = 100;
					
					buttons = ['format', 'bold', 'italic'];
					
					plugins = ['source'];
				}
				
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
					'minHeight': minHeight,
					'buttons': buttons,
					'plugins': plugins,
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
			}
		};
		
		let attachDataTable = element => {
			if ($(element).length) {
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
			}
		};
		
		let attachNestedSortable = element => {
			if ($(element).length) {
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
			}
		};
		
		let convertTitleToSlug = (element, targetElement) => {
			if ($(element).length) {
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
			}
		};
		
		let logout = () => {
			if ($('#logout').length) {
				$('#logout').on('click', event => {
					event.preventDefault();
				
					$('#logoutUser').submit();
				});
			}
		};
		
		let saveMenuChanges = element => {
			if ($('form#menu').length) {
				$('form#menu').submit(() => {
					const tree = $(element).nestedSortable('toArray');
						
					$('#tree').val(JSON.stringify(tree));
						
					return true;
				});
			}
		};
		
		let init = () => {
			console.info(this.name + ' v' + this.version + ' is up and running!');
			
			this.settings = $.extend({}, defaults, options);
			
			logout();
			
			loadAllStats();
			
			loadOrderStats();
			
			loadRoleUsersStats();
			
			loadAnimations();
			
			attachDatePicker('.input-group.date');
			
			attachRedactor('#excerpt');
			
			attachRedactor('#content');
			
			attachDataTable('#datatable');
			
			attachNestedSortable('#nestedSortable');
			
			convertTitleToSlug('#createPage #title', '#createPage #slug');
			
			convertTitleToSlug('#createPage #slug', '#createPage #slug');
			
			convertTitleToSlug('#editPage #title', '#editPage #slug');
			
			convertTitleToSlug('#editPage #slug', '#editPage #slug');
			
			convertTitleToSlug('#createArticle #title', '#createArticle #slug');
			
			convertTitleToSlug('#createArticle #slug', '#createArticle #slug');
			
			convertTitleToSlug('#editArticle #title', '#editArticle #slug');
			
			convertTitleToSlug('#editArticle #slug', '#editArticle #slug');
			
			convertTitleToSlug('#createCategory #title', '#createCategory #slug');
			
			convertTitleToSlug('#createCategory #slug', '#createCategory #slug');
			
			convertTitleToSlug('#editCategory #title', '#editCategory #slug');
			
			convertTitleToSlug('#editCategory #slug', '#editCategory #slug');
			
			saveMenuChanges('#nestedSortable');
		};

		init();
	};
})(jQuery);

$.controlPanel();
