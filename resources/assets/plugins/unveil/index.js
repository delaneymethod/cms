/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

;($ => {
	$.fn.unveil = function(threshold, callback) {
		const th = threshold || 0;
		
		const attribute = window.devicePixelRatio > 1 ? 'data-src-retina' : 'data-src';
		
		let images = this;
		
		let loaded = false;
	
		this.one('unveil', function() {
			let source = this.getAttribute(attribute);
			
			source = source || this.getAttribute('src');
			
			if (source) {
				if (this.tagName === 'IMG') {
					this.setAttribute('src', source);
				} else {
					this.style['backgroundImage'] = "url('" + source + "')";
				}
	
				if (typeof callback === 'function') {
					callback.call(this);
				}
			}
		});
	
		function unveil () {
			let inview = images.filter(function() {
				if ($(this).is(':hidden')) {
					return;
				}
				
				const wt = $(window).scrollTop();
				
				const wb = wt + $(window).height();
				
				const et = $(this).offset().top;
				
				const eb = et + $(this).height();
	
				return eb >= wt - th && et <= wb + th;
			});
	
			loaded = inview.trigger('unveil');
			
			images = images.not(loaded);
		}
	
		$(window).on('scroll.unveil resize.unveil lookup.unveil', unveil);
	
		unveil();
		
		return this;
	};
})(jQuery);
