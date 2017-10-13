/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
 ;($ => {
	$.delaneyMethodCMS = options => {
		/* Support multiple elements */
		if (this.length > 1){
			this.each(() => { 
				$(this).delaneyMethodCMS(options);
			});
			
			return this;
		}

		this.name = 'DelaneyMethod CMS';
		
		this.version = '1.0.0';
		
		this.settings = {};

		this.defaults = {};
		
		this.loadAnimations = () => {
			if ($('#message').length) {
				setTimeout(() => {
					$('.message.success').fadeOut('fast');
				}, 4000);
			}
		
			$('.message #hideMessage').on('click', () => {
		 		$('.message').fadeOut('fast');
			});
		
			$('[data-toggle="tooltip"]').tooltip();
			
			lazyload();
		};
		
		this.validateProductCommodityQuantity = event => {
			/* Make sure only positive numbers are entered into quantity fields */
			if (!((event.keyCode > 95 && event.keyCode < 106) || (event.keyCode > 47 && event.keyCode < 58) || event.keyCode == 8)) {
				event.target.value = 1;
			}

			if (event.target.value == '' || event.target.value == 0 || event.target.value < 0) {
				event.target.value = 1;
			}
			
			const productCommodityId = $(event.target).data('id');
			
			$('#addProductCommodity' + productCommodityId).find('input[name="quantity"]').val(event.target.value);
			
			return true;
		};
		
		this.highlight = id => {
			const hash = window.location.hash.substring(1);
			
			if ($('[id="' + hash + '"]').length) {
				$('[id="' + hash + '"]').find('td').addClass('table-active text-danger');
				
				$('[id="' + hash + '"]').hover(() => {
					$('[id="' + hash + '"]').find('td').removeClass('table-active text-danger');	
				}, () => {});
			}
		};
		
		this.loadPagination = () => {
		};
		
		this.loadMap = () => {
			if ($('.map').length) {
				const position = {
					lat: 57.215075,
					lng: -2.199492
				};
				
				const map = new google.maps.Map($('.map').get(0), {
					zoom: 16,
					center: position
				});
				
				const marker = new google.maps.Marker({
					position: position,
					map: map
				});
				
				$('.map, .map-padding, .map-info').show();
				
				google.maps.event.addDomListener(window, 'resize', () => {
					map.setCenter(position);
				});
			}
		};
		
		this.loadProductCommodity = (element, code) => {
			$(element).on('inview', (event, visible) => {
				if (visible && !$(element).hasClass('loaded')) {
					const endpoint = window.API.url + window.API.endpoints.product_commodities.pricing + '/' + code;
					
					/* Make API call to get price and quantity */
					axios.get(endpoint, {
						requestId: endpoint
					}).then(response => {
						$(element).find('.price').html(response.data.price);
						
						$(element).find('.price-per').html(response.data.price_per);
						
						$(element).find('.quantity-available').html(response.data.quantity_available);
						
						$(element).find('.price, .price-per, .quantity-available').removeClass('text-muted').css('color', '#333333');
						
						$(element).addClass('loaded');
					}).catch(error => {
						if (axios.isCancel(error)) {
							console.log('Request canceled', error.message);
						} else if (error.response) {
							/* The request was made and the server responded with a status code that falls out of the range of 2xx */
							console.log(error.response.data);
							console.log(error.response.status);
							console.log(error.response.headers);
						} else if (error.request) {
							/* The request was made but no response was received `error.request` is an instance of XMLHttpRequest in the browser and an instance of http.ClientRequest in node.js */
							console.log(error.request);
						} else {
							/* Something happened in setting up the request that triggered an Error */
							console.log('Error', error.message);
						}
						
						console.log(error.config);
						
						$(element).find('.price, .price-per, .quantity-available').html('Error').css('color', '#D30E07');
					});
				}
			});
		};
		
		this.attachDataTable = element => {
			if ($(element).length) {
				/* If we're on the product page, hide pagination and x of y records information, change the layout too! */
				if ($(element).hasClass('product-commodities')) {
					$.extend(true, $.fn.dataTable.defaults, {
						'bPaginate': false,
						'bInfo': false,
						'dom': '<"row"<"col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6"f>">',
						'order': [],
						'oLanguage': {
							'sLengthMenu': '_MENU_',
							'sSearch': '',
							'sSearchPlaceholder': 'Filter by Option or Product Code e.g M3.5, DIN 931 or 25mm',
						},
						'deferRender': true,
						'columnDefs': [{
							'targets': 'no-sort',
							'orderable': false,
						}],
						'language': {
							'zeroRecords': 'Nothing found - sorry',
							'info': 'Showing page _PAGE_ of _PAGES_',
							'infoEmpty': 'No records available',
							'infoFiltered': '(filtered from _MAX_ total records)',
						},
						'retrieve': true,
						'deferRender': true,
					});
				} else {
					$.extend(true, $.fn.dataTable.defaults, {
						'order': [],
						'oLanguage': {
							'sLengthMenu': '_MENU_',
							'sSearch': '',
							'sSearchPlaceholder': 'Search...',
						},
						'deferRender': true,
						'columnDefs': [{
							'targets': 'no-sort',
							'orderable': false,
						}],
						'language': {
							'zeroRecords': 'Nothing found - sorry',
							'info': 'Showing page _PAGE_ of _PAGES_',
							'infoEmpty': 'No records available',
							'infoFiltered': '(filtered from _MAX_ total records)',
						},
						'retrieve': true,
						'deferRender': true,
					});
				}
				
				$(element).dataTable();
			}
		};
		
		this.waitForGoogleMaps = () => {
			/*
			if (typeof window.google.maps !== 'undefined') {
				this.loadMap();
			} else {
				setTimeout(() => {
					this.waitForGoogleMaps();
				}, 1000);
			}
			*/
			
			let googleMapsLoaded = setInterval(() => {
				if (typeof window.google == 'undefined' || typeof window.google.maps == 'undefined') {
					return;
				}
				
				clearInterval(googleMapsLoaded);
        
				this.loadMap();
    		}, 1000);
		};
		
		this.init = () => {
			console.info(this.name + ' v' + this.version + ' is up and running!');
			
			this.settings = $.extend({}, this.defaults, options);
			
			let token = document.head.querySelector('meta[name="csrf-token"]');

			if (token) {
			    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
			} else {
			    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
			}
			
			/* IE10 viewport hack for Surface/desktop Windows 8 bug */
			if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
				let msViewportStyle = document.createElement('style');
				
				msViewportStyle.appendChild(document.createTextNode('@-ms-viewport{width:auto!important}'));
				
				document.head.appendChild(msViewportStyle);
			}
			
			if (window.location.hash) {
				this.highlight();
			}
				
			window.addEventListener('hashchange', () => {
				this.highlight();
			}, false);
			
			this.loadAnimations();
			
			this.loadPagination();
			
			this.attachDataTable('#datatable');
			
			this.waitForGoogleMaps();
			
			return this;
		};
		
		return this.init();
	};
})(jQuery);

window.CMS = $.delaneyMethodCMS();
