/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
 ;($ => {
	$.delaneyMethodCMSTemplates = options => {
		/* Support multiple elements */
		if (this.length > 1){
			this.each(() => { 
				$(this).delaneyMethodCMSTemplates(options);
			});
			
			return this;
		}

		this.name = 'DelaneyMethod CMS - Templates -';
		
		this.version = '1.0.0';
		
		this.settings = {};

		this.defaults = {};
		
		this.highlight = id => {
			const hash = window.location.hash.substring(1);
			
			if ($('[id="' + hash + '"]').length) {
				$('[id="' + hash + '"]').find('td').addClass('table-active text-danger');
				
				$('[id="' + hash + '"]').hover(() => {
					$('[id="' + hash + '"]').find('td').removeClass('table-active text-danger');	
				}, () => {});
			}
		};
		
		this.loadCarousel = element => {
			if ($(element).length) {
				$(element).slick({
					'dots': true,
					'autoplay': true,
					'autoplaySpeed': 10000,
					'fade': true,
					'speed': 1000,
					'centerMode': true,
				});
			}
		};
		
		this.loadPagination = element => {
			const limit = 15;
			
			const length = $('#pagination .paginate').length;
			
			if (length > limit) {
				$('#pagination .paginate:gt(' + (limit - 1) + ')').hide();
			
				const totalPages = Math.round(length / limit);
			
				$(element).show().append('<nav aria-label="Page pagination"><ul class="pagination justify-content-center"></ul></nav>');
				
				for (let i = 1; i <= totalPages; i++) {
					$(element + ' .pagination').append('<li class="page-item"><a href="javascript:void(0);" title="Page ' + i + '" class="page-link">' + i + '</a></li>');
				}
				
				$(element + ' .pagination li:first').addClass('active');
				
				$(element + ' .pagination li a').click(function () {
					const index = $(this).parent().index() + 1;
					
					const gt = limit * index;
					
					$(element + ' .pagination li').removeClass('active');
					
					$(this).parent().addClass('active');
					
					$('#pagination .paginate').hide();
					
					for (let i = gt - limit; i < gt; i++) {
						$('#pagination .paginate:eq(' + i + ')').show();
					}
				});
			} else {
				$(element).hide();
			}
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
		
		this.showWelcomeBackMessage = user => {
			/*
			$('#my-account').tooltip('show');
			
			$('#my-account').on('shown.bs.tooltip', () => {
				setTimeout(() => {
					$('#my-account').tooltip('hide');
				}, 5000);
			});
			
			$('#my-account').on('hidden.bs.tooltip', () => {
				$('#my-account').attr('data-original-title', '<p style="margin-top: 10px;">Click here to access your Account and the Customer Dashboard.</p>');
			});
			*/
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
			console.info(this.name + ' v' + this.version + ' is ready!');
			
			this.settings = $.extend({}, this.defaults, options);
			
			if (window.location.hash) {
				this.highlight();
			}
				
			window.addEventListener('hashchange', () => {
				this.highlight();
			}, false);
			
			this.loadPagination('#templatePagination');
			
			this.loadCarousel('#slider');
			
			this.waitForGoogleMaps();
			
			return this;
		};
		
		return this.init();
	};
})(jQuery);

window.CMS.Templates = $.delaneyMethodCMSTemplates();
