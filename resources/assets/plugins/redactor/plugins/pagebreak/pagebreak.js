(function($) {
	$.Redactor.prototype.pagebreak = function() {
		return {
			langs: {
				en: {
					"insert-page-break": "Insert Page Break"
				}
			},
			init: function() {
				console.log('found it anyways');
				
				const button = this.button.add('pagebreak', this.lang.get('insert-page-break'));
							
				this.button.addCallback(button, this.pagebreak.insertPageBreak);
			
				/*this.button.setIcon($btn, '<i class="icon"></i>');*/
			},
			insertPageBreak: function() {
				const pagebreakNode = $('<hr class="redactor_pagebreak" style="display:none" unselectable="on" contenteditable="false" />');
				
				let currentNode = $(this.selection.current());

				if (currentNode.length && $.contains(this.$editor.get(0), currentNode.get(0))) {
					// Find the closest element to div.redactor-editor
					while (currentNode.parent().length && !currentNode.parent().is('div.redactor-layer')) {
						currentNode = currentNode.parent();
					}

					pagebreakNode.insertAfter(currentNode);
				} else {
					// Just append it to the end
					pagebreakNode.appendTo(this.$editor);
				}

				const p = $('<p><br/></p>').insertAfter(pagebreakNode);

				this.$editor.focus();

				this.code.sync();
			}
		};
	};
})(jQuery);
