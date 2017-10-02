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
			
			$('[data-toggle="tooltip"]').tooltip();
			
			lazyload();
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
						
						$(element).find('.price, .price-per, .quantity-available').removeClass('text-muted');
						
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
						
						$(element).find('.price, .price-per, .quantity-available').html('Error').css('color', '#FF0000');
					});
				}
			});
		};
		
		this.init = () => {
			console.info(this.name + ' v' + this.version + ' is up and running!');
			
			this.settings = $.extend({}, this.defaults, options);
			
			this.loadAnimations();
			
			return this;
		};
		
		return this.init();
	};
})(jQuery);

window.CMS = $.delaneyMethodCMS();
