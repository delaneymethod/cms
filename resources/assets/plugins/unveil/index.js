/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

;(function($) {
	$.fn.unveil = function(threshold, callback) {
		var th = threshold || 0;
		
		var attribute = window.devicePixelRatio > 1 ? 'data-src-retina' : 'data-src';
		
		var images = this;
		
		var loaded = false;
	
		this.one('unveil', function() {
			var source = this.getAttribute(attribute);
			
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
			var inview = images.filter(function() {
				if ($(this).is(':hidden')) {
					return;
				}
				
				var wt = $(window).scrollTop();
				
				var wb = wt + $(window).height();
				
				var et = $(this).offset().top;
				
				var eb = et + $(this).height();
	
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
