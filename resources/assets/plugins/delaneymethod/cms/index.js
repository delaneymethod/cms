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
					
					// Make API call to get price and quantity
					axios.get(window.API.url + 'product-commodities/' + id + '/pricing').then(response => {
						$(element).find('.price').html(response.data.price);
						
						$(element).find('.price-per').html(response.data.price_per);
						
						$(element).find('.quantity-available').html(response.data.quantity_available);
						
						$(element).find('.price, .price-per, .quantity-available').removeClass('text-muted');
						
						$(element).addClass('loaded');
					}).catch(error => {
						console.error(error);
				
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
