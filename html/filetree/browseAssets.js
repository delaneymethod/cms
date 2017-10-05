;($ => {
	$.extend($.fn, {
		browse: function(options, callback) {
			if (!options) {
				let options = {};
			}
			
			if (options.root == undefined) {
				options.root = '/';
			}
			
			if (options.script == undefined) {
				options.script = '/cp/assets/browse';
			}
			
			if (options.folderEvent == undefined) {
				options.folderEvent = 'click';
			}
			
			if (options.multiFolder == undefined) {
				options.multiFolder = true;
			}
			
			if (options.loadMessage == undefined) {
				options.loadMessage = 'Loading...';
			}
	
			$(this).each(() => {
				function showAssets(element, directory) {
					$(element).addClass('wait');
					
					$('.browseAssets.start').remove();
					
					$.post(options.script, { directory: directory }, data => {
						$(element).find('.start').html('');
					
						$(element).removeClass('wait').append(data);
					
						if (options.root == directory) {
							$(element).find('ul:hidden').show(); 
						} else {
							$(element).find('ul:hidden').slideDown();
						}
					
						bindAssets(element);
					});
				}
	
				function bindAssets(element) {
					$(element).find('li a').bind(options.folderEvent, function() {
						if ($(this).parent().hasClass('directory')) {
							if ($(this).parent().hasClass('collapsed')) {
								if (!options.multiFolder) {
									$(this).parent().parent().find('ul').slideUp();
									
									$(this).parent().parent().find('li.directory').removeClass('expanded').addClass('collapsed');
								}
								
								$(this).parent().find('ul').remove();
								
								showAssets($(this).parent(), escape($(this).attr('rel').match(/.*\//)));
								
								$(this).parent().removeClass('collapsed').addClass('expanded');
							} else {
								$(this).parent().find('ul').slideUp();
								
								$(this).parent().removeClass('expanded').addClass('collapsed');
							}
						} else {
							callback($(this).attr('rel'));
						}
						
						return false;
					});
					
					if (options.folderEvent.toLowerCase != 'click') {
						$(element).find('li a').bind('click', function() {
							return false; 
						});
					}
				}
				
				$(this).html('<ul class="browseAssets start"><li class="wait">' + options.loadMessage + '<li></ul>');
				
				showAssets($(this), escape(options.root));
			});
		}
	});
})(jQuery);
