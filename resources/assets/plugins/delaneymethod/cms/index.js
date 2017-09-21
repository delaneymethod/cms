/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

;($ => {
	$.delaneyMethodCMS = options => {
		this.name = 'DelaneyMethod CMS';
		
		this.version = '1.0.0';
		
		this.settings = {};

		let defaults = {};
		
		let loadAnimations = () => {
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
		};
		
		let init = () => {
			console.info(this.name + ' v' + this.version + ' is up and running!');
			
			this.settings = $.extend({}, defaults, options);
			
			loadAnimations();
		};

		init();
	};
})(jQuery);

$.delaneyMethodCMS();
