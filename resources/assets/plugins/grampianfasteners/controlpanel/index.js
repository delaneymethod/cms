;($ => {
	$.controlPanel = options => {
		this.name = 'Control Panel';
		
		this.version = '1.0.0';
		
		this.settings = {};

		let defaults = {};
		
		let loadAllStats = () => {
			const allStats = $('#allStats');
			
			const totalUsers = allStats.data('total-users');
			
			const totalPages = allStats.data('total-pages');
			
			const totalOrders = allStats.data('total-orders');
			
			const totalAssets = allStats.data('total-assets');
			
			const totalCompanies = allStats.data('total-companies');
			
			const totalArticles = allStats.data('total-articles');
			
			const totalLocations = allStats.data('total-locations');
			
			const data = {
				datasets: [{
					data: [totalUsers, totalPages, totalOrders, totalAssets, totalCompanies, totalArticles, totalLocations],
					label: 'All Stats',
					backgroundColor: [
						'#d30e07',
						'#f0ad4e',
						'#5bc0de',
						'#f1f3f6',
						'#1e282c',
						'#4b965c',
						'#7c898e',
					]
				}],
				labels: [
					'Users',
					'Pages',
					'Orders',
					'Assets',
					'Companies',
					'Articles',
					'Locations',
				]
			};
			
			const options = {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'All Stats'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			};
			
			new Chart(allStats, {
				type: 'doughnut',
				data: data,
				options: options
			});
		};
		
		let loadOrderStats = () => {
			const orderStats = $('#orderStats');
			
			const orders = orderStats.data('orders');
			
			const data = {
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets: [{
					label: 'Pending',
					backgroundColor: '#d30e07',
					borderColor: '#d30e07',
					data: [111, 150, 313, 141, 421, 100, 200],
					fill: false,
                },{
					label: 'Approved',
					backgroundColor: '#f0ad4e',
					borderColor: '#f0ad4e',
					data: [105, 150, 100, 40, 92, 100, 182],
					fill: false,
                }]
			};
			
			const options = {
				responsive: true,
				title:{
					display: true,
					text: 'Monthly Orders'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Orders'
						},
						ticks: {
							suggestedMin: 0,
							suggestedMax: 500,
							stepSize: 100
						}
					}]
				}
			};
				
			new Chart(orderStats, {
				type: 'line',
				data: data,
				options: options
			}); 
		};
		
		let loadRoleUsersStats = () => {
			const roleUsersStats = $('#roleUsersStats');
			
			const totalSuperAdmins = roleUsersStats.data('total-super-admins');
			
			const totalAdmins = roleUsersStats.data('total-admins');
			
			const totalEndUsers = roleUsersStats.data('total-end-users');
			
			const data = {
				datasets: [{
					data: [totalSuperAdmins, totalAdmins, totalEndUsers],
					label: 'Users per Role',
					backgroundColor: [
						'#d30e07',
						'#f0ad4e',
						'#4b965c',
					]
				}],
				labels: [
					'Super Admins',
					'Admins',
					'End Users',
				]
			};
			
			const options = {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Users per Role'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			};
			
			new Chart(roleUsersStats, {
				type: 'pie',
				data: data,
				options: options
			});
		};
		
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
			let table = $(element).dataTable({
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
			
			loadAllStats();
			
			loadOrderStats();
			
			loadRoleUsersStats();
			
			loadAnimations();
			
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
			
			saveMenuChanges('#nestedSortable');
		};

		init();
	};
})(jQuery);

$.controlPanel();
