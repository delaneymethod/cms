/**
 * @link	  https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license	  https://www.delaneymethod.com/cms/license
 */

;($ => {
	$.delaneyMethodCMSControlPanel = options => {
		/* Support multiple elements */
		if (this.length > 1){
			this.each(() => { 
				$(this).delaneyMethodCMSControlPanel(options);
			});
			
			return this;
		}
		
		this.name = 'DelaneyMethod CMS - Control Panel -';
		
		this.version = '1.0.0';
		
		this.settings = {};

		this.defaults = {};
		
		this.colours = [
			'#222D32', /* gray */
			'#5DA5DA', /* blue */
			'#FAA43A', /* orange */
			'#60BD68', /* green */
			'#F17CB0', /* pink */
			'#B2912F', /* brown */
			'#B276B2', /* purple */
			'#DECF3F', /* yellow */
			'#F15854', /* red */
		];
		
		this.loadOrderStats = () => {
			if ($('#orderTotals').length) {
				const orderTotals = $('#orderTotals');
				
				const orderStats = orderTotals.data('order-stats');
				
				let labels = [];
				
				let datasets = [];
				
				let data = [];
				
				let max = 0;
				
				_.each(orderStats.reverse(), orderStat => {
					if (max < orderStat.total) {
				 		max = orderStat.total;
				 	}
				 	
				 	labels.push(orderStat.month);
				 	
				 	data.push(orderStat.total);
				});
				
				datasets.push({
					'label': 'Total Orders',
					'backgroundColor': this.colours[0],
					'borderColor': this.colours[0],
					'data': data,
					'fill': false,
				});
				
				max = max + 2;
				
				const options = {
					'responsive': true,
					'title': {
						'display': false,
						'text': 'Recent Orders'
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
								'labelString': 'Total'
							},
							'ticks': {
								'suggestedMin': 0,
								'suggestedMax': max,
								'stepSize': Math.ceil(max % 3)
							}
						}]
					}
				};
				
				Chart.defaults.global.legend.display = false;
					
				new Chart(orderTotals, {
					'type': 'line',
					'data': {
						'labels': labels,
						'datasets': datasets
					},
					'options': options
				});
			}
		};
		
		this.loadRoleUsersStats = () => {
			if ($('#roleUsersStats').length) {
				const roleUsersStats = $('#roleUsersStats');
				
				const totalSuperAdmins = roleUsersStats.data('total-super-admins');
				
				const totalAdmins = roleUsersStats.data('total-admins');
				
				const totalEndUsers = roleUsersStats.data('total-end-users');
				
				const data = {
					'datasets': [{
						'label': 'Users per Role',
						'data': [totalSuperAdmins, totalAdmins, totalEndUsers],
						'backgroundColor': [this.colours[0], this.colours[1], this.colours[2]]
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
						'text': 'Roles'
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
		
		this.loadAnimations = () => {
			$('.sidebar #submenu').on('click', event => {
				event.preventDefault();
				
				$(event.target).toggleClass('highlight');
				
				$(event.target).next('ul').slideToggle(500);
		
				$(event.target).find('span > i').toggleClass('fa-rotate', 'fast');
			});

			$('.content #pageActions').on('click', event => {
				event.preventDefault();
				
				$('.content #pageActions i').removeClass('fa-rotate');
				
				if (event.target === event.currentTarget) {
					$(event.target).find('i').toggleClass('fa-rotate', 'fast');
				} else {
					$(event.target).toggleClass('fa-rotate', 'fast');
				}
			});

			$('.content #submenu').on('hide.bs.dropdown', () => {
				$('.content #pageActions i').removeClass('fa-rotate', 'fast');
			});
		};
		
		this.attachDatePicker = element => {
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
		
		this.detachRedactor = element => {
			$(element).unbind().removeData();
		};
		
		this.attachRedactor = element => {
			if ($(element).length) {
				const token = window.Laravel.csrfToken;
				
				let minHeight = 400;
				
				let buttons = ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'];
				
				let plugins = ['codemirror', 'inlinestyle', 'table', 'alignment', 'definedlinks', 'fullscreen', 'filemanager', 'imagemanager', 'video', 'fontcolor', 'properties', 'textexpander', /*'redbutton',*/ 'pagebreak'];
					
				if (element == '#excerpt') {
					minHeight = 100;
					
					buttons = ['format', 'bold', 'italic'];
					
					plugins = ['codemirror'];
				}
				
				$(element).redactor({
					'focus': false,
					'focusEnd': false,
					'animation': false,
					'lang': 'en',
					'direction': 'ltr',
					'spellcheck': true,
					'overrideStyles': true,
					'clickToEdit': false,
					'removeNewlines': true,
					'replaceTags': {
						'b': 'strong',
						'i': 'em',
						'strike': 'del'
					},
					'pastePlainText': false,
					'pasteImages': true,
					'pasteLinks': true,
					'linkTooltip': true,
					'linkNofollow': false,
					'linkSize': 100,
					'pasteLinkTarget': false,	
					'pasteBlockTags': ['pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'table', 'tbody', 'thead', 'tfoot', 'th', 'tr', 'td', 'ul', 'ol', 'li', 'blockquote', 'p', 'figure', 'figcaption'],
					'pasteInlineTags': ['br', 'strong', 'ins', 'code', 'del', 'span', 'samp', 'kbd', 'sup', 'sub', 'mark', 'var', 'cite', 'small', 'b', 'u', 'em', 'i'],
					'fileUpload': '/cp/assets?_token=' + token + '&type=file',
					'fileManagerJson': '/cp/assets?format=json',
					'imageUpload': '/cp/assets?_token=' + token + '&type=image',
					'imageManagerJson': '/cp/assets?format=json&type=image',
					'imageResizable': true,
					'imagePosition': true,
					'structure': true,
					'definedLinks': '/cp/links?format=json',
					'tabAsSpaces': 4,
					'minHeight': minHeight,
					'buttons': buttons,
					'plugins': plugins,
					'codemirror': {
						'lineNumbers': true,
						'mode': 'htmlmixed',
						'indentUnit': 4
					},
					'textexpander': [
						['lorem', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'],
						['gf', 'Grampian Fasteners'],
						['dm', 'DelaneyMethod']
					],
					'callbacks': {
						'imageUpload': (image, json) => {
							$(image).attr('id', json.id);
						},
						'imageUploadError': (json, xhr) => {
							alert(json.message);
						},
						'fileUpload': (link, json) => {
							$(link).attr('id', json.id);
						},
						'fileUploadError': json => {
							alert(json.message);
						}
					}
				});
			}
		};
		
		this.attachNestedSortable = element => {
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
		
		this.convertTitleToSlug = (element, targetElement, separator = '-') => {
			if ($(element).length) {
				$(element).on('keyup change', event => {
					let slug = $(event.target).val().toString()
						.toLowerCase()
						.trim()
						.replace(/\s+/g, separator) /* Replace spaces with separator */
						.replace(/&/g, separator + 'and' + separator) /* Replace & with 'and' */
						.replace(/[^\w\-]+/g, '') /* Remove all non-word chars */
						.replace(/\-\-+/g, separator) /* Replace multiple - with single separator */
						.replace(/\_\_+/g, separator); /* Replace multiple _ with single separator */
					
					$(targetElement).val(slug);
					
					if (slug == '') {
						$('#template_id').attr('disabled', true);
						
						$('#helpBlockTemplateIdWarning').show();
					} else {
						$('#template_id').attr('disabled', false);
						
						$('#helpBlockTemplateIdWarning').hide();
					}
				});
			}
		};
		
		this.convertTitleToKeywords = (element, targetElement) => {
			if ($(element).length) {
				$(element).on('keyup change', event => {
					let keywords = $(event.target).val().toString()
						.trim()
						.split(' ')
						.join(', ')
						.trim();
					
					$(targetElement).val(keywords);
				});
			}
		};
		
		this.convertFolderToSlug = (element) => {
			if ($(element).length) {
				$(element).on('keyup change', event => {
					let slug = $(event.target).val().toString()
						.toLowerCase()
						.trim()
						.replace(/\s+/g, '--') /* Replace spaces with - */
						.replace(/&/g, '-and-') /* Replace & with 'and' */
						.replace(/[^\w\-]+/g, '') /* Remove all non-word chars */
						.replace(/\-\-+/g, '-'); /* Replace multiple - with single - */
					
					$(element).val(slug);
				});
			}
		};
		
		this.logout = () => {
			if ($('#logout').length) {
				$('#logout').on('click', event => {
					event.preventDefault();
				
					$('#logoutUser').submit();
				});
			}
		};
		
		this.savePageChangesAndLoadTemplate = element => {
			if ($(element).length) {
				$(element).change(event => {
					event.preventDefault();
					
					const form = $(element).closest('form');
					
					/* Set action URL */
					$(form).attr('action', '/cp/pages/reload');
					
					/* If there is a method field, make sure to remove it - used when in edit mode */
					$(form).find('input[name="_method"]').remove();
					
					/* Submit form */
					$('[type=submit]').trigger('click');
				});
			}
		};
		
		this.saveMenuChanges = element => {
			if ($('form#menu').length) {
				$('form#menu').submit(() => {
					const tree = $(element).nestedSortable('toArray');
						
					$('#tree').val(JSON.stringify(tree));
						
					return true;
				});
			}
		};
		
		this.orderUpdated = order => {
			/* In this particular case, we're only updatig the order status column but we have the full order details so anything could be updated in the UI. */
			const element = $('#order-' + order.id + '-status');
			
			element.fadeOut(() => {
				element.attr('class', 'text-center status_id-' + order.status.id).html(order.status.title);
			}).fadeIn();
			
			/* This is for the Orders view, where an icon is used to show the status */
			const elementIcon = $('#order-' + order.id + '-status-icon');
			
			elementIcon.fadeOut(() => {
				elementIcon.attr({
					'class': 'fa fa-circle fa-1 text-center status_id-' + order.status.id,
					'title': order.status.title,
					'data-original-title': order.status.title
				});
				
				/* If the status is no longer pending, hide the badge */
				if (order.status.id != 2) {
					/* This is for the Orders view, where an icon is used to show the status */
					$('#order-' + order.id + '-status-badge').fadeOut();
				} else {
					$('#order-' + order.id + '-status-badge').fadeIn();
				}
			}).fadeIn();
		};
		
		this.showNotification = notification => {
			/* Updates the Notifications view */
			let subject = _.replace(notification.type, 'OrderUpdated', 'Order Updated');
			
			subject = _.replace(subject, 'OrderPlaced', 'Order Placed');
			subject = _.replace(subject, 'App', '');
			subject = _.replace(subject, 'Notifications', '');
			subject = _.replace(subject, '\\', '');
			subject = _.replace(subject, '\\', '');
			
			const date = new Date();
			
			const createdAt = date.getDate() + window.CMS.Library.getNthSuffix(date) + ' ' + window.CMS.Library.getMonthName(date.getMonth()).substring(0, 3) + ' ' + date.getFullYear(); + ' ' + date.getHours() + ':' + date.getMinutes();
			
			const element = $('#all-notifications');
	
			let newNotification = $('<tr class="highlight"><td>' + subject + ' &nbsp;<span class="badge badge-pill badge-suspended align-middle text-uppercase"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;Unread</span></td><td class="text-center">' + createdAt + '</td><td class="text-center"><a href="/cp/users/' + notification.order.user.id + '/notifications/' + notification.id + '" title="View Notification"><i class="icon fa fa-envelope" aria-hidden="true"></i></a></td></tr>');
			
			const table = $('#datatable').DataTable();
			
			table.destroy();
			
			element.prepend(newNotification);
			
			/* Updates counter in the sidebar */
			const elementIcon = $('#notifications-unread');
			
			let unread = 0;
			
			elementIcon.fadeOut(() => {
				unread = parseInt(elementIcon.html());
				
				unread++;
				
				elementIcon.html(unread);
			}).fadeIn();
			
			/* Updates the stats card on the dashboard */
			const elementCardCounter = $('#messages-card').find('p');
			
			unread = 0;
			
			elementCardCounter.fadeOut(() => {
				unread = parseInt(elementCardCounter.html());
				
				unread++;
				
				elementCardCounter.html(unread);
			}).fadeIn();
						
			/* Reloads the table data again */
			window.CMS.Library.attachDataTable('#datatable');
		};
		
		this.detachAssetBrowser = element => {
			$(element).unbind().removeData();
		};
		
		this.attachAssetBrowser = (element, id, value) => {
			if (value != '') {
				$('#' + id + '-selected-asset').html('<strong>Asset</strong> ' + value + '<div class="spacer d-sm-block d-md-block d-lg-none d-xl-none"></div>');
				
				$('#' + id + '-selected-asset-preview').html('<div class="spacer d-sm-block d-md-block d-lg-none d-xl-none"></div><img src="' + value + '" class="img-fluid" width="100%">');
			} else {
				$('#' + id + '-selected-asset').html('');
			
				$('#' + id + '-selected-asset-preview').html('');
			}
			
			/* Loads assets into modal window body */
			$(element).browse({
				root: '/uploads/',
				script: '/cp/assets/browse',
			}, file => {
				$('#' + id + '-selected-asset').html('<strong>Asset</strong> ' + file + '<div class="spacer d-sm-block d-md-block d-lg-none d-xl-none"></div>');
				
				/* Show preview */
				$('#' + id + '-selected-asset-preview').html('<div class="spacer d-sm-block d-md-block d-lg-none d-xl-none"></div><img src="' + file + '" class="img-fluid" width="100%">');
				
				/* Close modal when user clicks select button and set the file URL in the Banner image URL field on the form. */
				$('#' + id + '-select-asset').on('click', () => {
					$('#' + id + '-browse-modal').modal('hide');
					
					/* Update the form field and remove focus */
					$('#' + id).val(window.location.origin + file).blur();
					
					$('a[data-target="#' + id + '-browse-modal"]').data('value', file);
				});
			});
		};
		
		this.init = () => {
			console.info(this.name + ' v' + this.version + ' is ready!');
			
			this.settings = $.extend({}, this.defaults, options);
			
			this.logout();
			
			this.loadOrderStats();
			
			this.loadRoleUsersStats();
			
			this.loadAnimations();
			
			this.attachDatePicker('.input-group.date');
			
			this.attachRedactor('.redactor');
			
			this.attachNestedSortable('#nestedSortable');
			
			this.convertTitleToSlug('#createCarousel #title', '#createCarousel #handle', '_');
			
			this.convertTitleToSlug('#createCarousel #handle', '#createCarousel #handle', '_');
			
			this.convertTitleToSlug('#editCarousel #title', '#editCarousel #handle', '_');
			
			this.convertTitleToSlug('#editCarousel #handle', '#editCarousel #handle', '_');
			
			this.convertTitleToSlug('#createGlobal #title', '#createGlobal #handle', '_');
			
			this.convertTitleToSlug('#createGlobal #handle', '#createGlobal #handle', '_');
			
			this.convertTitleToSlug('#editGlobal #title', '#editGlobal #handle', '_');
			
			this.convertTitleToSlug('#editGlobal #handle', '#editGlobal #handle', '_');
			
			this.convertTitleToSlug('#createPage #title', '#createPage #slug');
			
			this.convertTitleToSlug('#createPage #slug', '#createPage #slug');
			
			this.convertTitleToSlug('#editPage #title', '#editPage #slug');
			
			this.convertTitleToSlug('#editPage #slug', '#editPage #slug');
			
			this.convertTitleToSlug('#createArticle #title', '#createArticle #slug');
			
			this.convertTitleToSlug('#createArticle #slug', '#createArticle #slug');
			
			this.convertTitleToSlug('#editArticle #title', '#editArticle #slug');
			
			this.convertTitleToSlug('#editArticle #slug', '#editArticle #slug');
			
			this.convertTitleToSlug('#createArticleCategory #title', '#createArticleCategory #slug');
			
			this.convertTitleToSlug('#createArticleCategory #slug', '#createArticleCategory #slug');
			
			this.convertTitleToSlug('#editArticleCategory #title', '#editArticleCategory #slug');
			
			this.convertTitleToSlug('#editArticleCategory #slug', '#editArticleCategory #slug');
			
			this.convertTitleToKeywords('#createPage #title', '#createPage #keywords');
			
			this.convertTitleToKeywords('#editPage #title', '#editPage #keywords');
			
			this.convertTitleToKeywords('#createArticle #title', '#createArticle #keywords');
			
			this.convertTitleToKeywords('#editArticle #title', '#editArticle #keywords');
			
			this.convertFolderToSlug('#createFolderAsset #folder');
			
			this.savePageChangesAndLoadTemplate('#createPage #template_id');
			
			this.savePageChangesAndLoadTemplate('#editPage #template_id');
			
			this.saveMenuChanges('#nestedSortable');
					
			return this;
		};
		
		return this.init();
	};
})(jQuery);

window.CMS.ControlPanel = $.delaneyMethodCMSControlPanel();
