/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
 ;($ => {
	$.delaneyMethodCMS = options => {
		// Support multiple elements
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
		
		this.loadMap = element => {
			if ($(element).length && typeof google !== 'undefined') {
				const position = {
					lat: 57.215075,
					lng: -2.199492
				};
				
				const map = new google.maps.Map($(element).get(0), {
					zoom: 16,
					center: position
				});
				
				const marker = new google.maps.Marker({
					position: position,
					map: map
				});
				
				$('.map-padding, .map-info').show();
				
				$(element).show();
	
				google.maps.event.addDomListener(window, 'resize', () => {
					map.setCenter(position);
				});
			}
		};
		
		this.loadProductCommodityPriceQuantity = element => {
			$(element).on('inview', (event, visible) => {
				if (visible && !$(element).hasClass('loaded')) {
					const id = element.replace('#product_commodity_', '');
					
					const endpoint = 'product-commodities/' + id + '/pricing';
					
					// Make API call to get price and quantity
					axios.get(window.API.url + endpoint, {
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
							// The request was made and the server responded with a status code that falls out of the range of 2xx
							console.log(error.response.data);
							console.log(error.response.status);
							console.log(error.response.headers);
						} else if (error.request) {
							// The request was made but no response was received `error.request` is an instance of XMLHttpRequest in the browser and an instance of http.ClientRequest in node.js
							console.log(error.request);
						} else {
							// Something happened in setting up the request that triggered an Error
							console.log('Error', error.message);
						}
						
						console.log(error.config);
						
						$(element).find('.price, .price-per, .quantity-available').html('Error').css('color', '#D30E07');
					});
				}
			});
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
			
			// IE10 viewport hack for Surface/desktop Windows 8 bug
			if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
				let msViewportStyle = document.createElement('style');
				
				msViewportStyle.appendChild(document.createTextNode('@-ms-viewport{width:auto!important}'));
				
				document.head.appendChild(msViewportStyle);
			}
			
			this.loadAnimations();
			
			this.loadMap('.map');
			
			return this;
		};
		
		return this.init();
	};
})(jQuery);

window.CMS = $.delaneyMethodCMS();



