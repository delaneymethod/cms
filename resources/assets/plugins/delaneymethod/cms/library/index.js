/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
 ;($ => {
	$.delaneyMethodCMSLibrary = options => {
		/* Support multiple elements */
		if (this.length > 1){
			this.each(() => { 
				$(this).delaneyMethodCMSLibrary(options);
			});
			
			return this;
		}

		this.name = 'DelaneyMethod CMS - Library -';
		
		this.version = '1.0.0';
		
		this.settings = {};

		this.defaults = {};
		
		this.inputTypeForPassword = 'password';
		
		this.formData = {
			'firstName': '',
			'lastName': '',
			'email': '',
			'suggestedEmail': '',
		};
		
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
			
			$('#open-menu').on('click', () => {
		 		$('.sidebar').toggleClass('d-block d-sm-block d-md-none d-lg-none d-xl-none');
			});
			
			$('.img-fluid').unveil(0, function() {
				$(this).on('load', function() {
					this.style.opacity = 1;
				});
			});
			
			/* Lookup for images in the viewport that haven't been "unveiled" yet */
			$(window).trigger('lookup');
			
			window.FastClick.attach(document.body);
		};
		
		this.loadListeners = () => {
			if (window.User) {
				window.Pusher.logToConsole = false;
			
				window.Echo = new Echo({
					broadcaster: 'pusher',
					key: '7659ca498a8f30edbbc3',
					cluster: 'eu',
					encrypted: false
				});
			}
			
			/* Checks the page for a form and email field so we can check the email address for typos and offers fixes/suggestions if any are found. */
			if ($('form').length && $('[name="email"]').length) {
				this.formData.firstName = $('[name="first_name"]');

				this.formData.lastName = $('[name="last_name"]');

				this.formData.email = $('[name="email"]');
				
				/* Listen for email address being typed */
				$('[name="email"]').on('blur', () => this.gatherFormDataAndCheck());
				
				/* If contact form, listen for submit button being clicked */
				if ($('[type="submit"]').length) {
					$('[type="submit"]').on('click', () => this.gatherFormDataAndCheck());
				}
				
				$('#did-you-mean a').on('click', () => {
					if (this.formData.suggestedEmail) {
						this.formData.email.val(this.formData.suggestedEmail);
					}
	
					this.formData.email.focus();
					
					this.gatherFormDataAndCheck();
				});
			}
			
			if ($('#editUser, #setPassword, #registerUser').length && $('[name="password"]').length) {
				$('#password').strengthify();
			
				$('#hide_show_password').on('click', event => {
					this.togglePasswordFieldType('#password', '#hide_show_password', this.inputTypeForPassword);
				});
				
				$('#hide_show_password_confirmation').on('click', event => {
					this.togglePasswordFieldType('#password_confirmation', '#hide_show_password_confirmation', this.inputTypeForPassword);
				});
			}
		};
		
		this.togglePasswordFieldType = (targetElement, triggerElement, type) => {
			if (type === 'password') {
				this.inputTypeForPassword = 'text';

				$(targetElement).attr({
					'type': 'text'
				});

				$(triggerElement).text('Hide Password');
			} else {
				this.inputTypeForPassword = 'password';

				$(targetElement).attr({
					'type': 'password'
				});

				$(triggerElement).text('Show Password');
			}	
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
						'retrieve': true,
						'deferRender': true,
						'oLanguage': {
							'sLengthMenu': '_MENU_',
							'sSearch': '',
							'sSearchPlaceholder': 'Filter by Option or Product Code e.g M3.5, DIN 931 or 25mm',
						},
						
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
					});
				} else {
					$.extend(true, $.fn.dataTable.defaults, {
						'order': [],
						'deferRender': true,
						'retrieve': true,
						'oLanguage': {
							'sLengthMenu': '_MENU_',
							'sSearch': '',
							'sSearchPlaceholder': 'Search...',
						},
						
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
					});
				}
				
				$(element).dataTable();
			}
		};
		
		this.gatherFormDataAndCheck = () => {
			this.formData.suggestedEmail = window.CMS.Library.checkForTypo({
				'firstName': this.formData.firstName.val(),
				'lastName': this.formData.lastName.val(),
				'email': this.formData.email.val(),
			});
			
			if (this.formData.suggestedEmail) {
				$('#did-you-mean a').html(this.formData.suggestedEmail);
				
				$('#did-you-mean a').tabindex = 1;
				
				$('#did-you-mean').css('display', 'inline-block');
				
				$('#did-you-mean a').focus();
			} else {
				$('#did-you-mean').hide();
	
				$('#did-you-mean a').html('');
			}
		};
		
		this.checkForCloseMatch = (longString, shortString) => {
			/* Too many false positives with very short strings */
			if (shortString.length < 3) {
				return '';
			}
		
			/* Test if the shortString is in the string (so everything is fine) */
			if (_.includes(longString, shortString)) {
				return ''; 
			}
		
			/* Split the shortString string into two at each postion e.g. g|mail gm|ail gma|il gmai|l and test that each half exists with one gap */
			for (let i = 1; i < shortString.length; i++) {
				const firstPart = shortString.substring(0, i);
				
				const secondPart = shortString.substring(i);
				
				/* Test for wrong letter */
				const wrongLetterRegEx = new RegExp(`${firstPart}.${secondPart.substring(1)}`);
				
				if (wrongLetterRegEx.test(longString)) {
					let typo = longString.replace(wrongLetterRegEx, shortString);
					
					/* Try to be even cleverer and correct TLD typos after applying original fixes */
					typo = typo.replace('es', '.es');
					typo = typo.replace('..es', '.es');

					typo = typo.replace('fr', '.fr');
					typo = typo.replace('..fr', '.fr');

					typo = typo.replace('it', '.it');
					typo = typo.replace('..it', '.it');

					typo = typo.replace('de', '.de');
					typo = typo.replace('..de', '.de');

					typo = typo.replace('be', '.be');
					typo = typo.replace('..be', '.be');

					typo = typo.replace('nl', '.nl');
					typo = typo.replace('..nl', '.nl');

					typo = typo.replace('no', '.no');
					typo = typo.replace('..no', '.no');

					typo = typo.replace('ie', '.ie');
					typo = typo.replace('..ie', '.ie');
					
					typo = typo.replace('co.uk', '.co.uk');
					typo = typo.replace('..co.uk', '.co.uk');
					
					typo = typo.replace('com', '.com');
					typo = typo.replace('..com', '.com');
					
					typo = typo.replace('org', '.org');
					typo = typo.replace('..org', '.org');
					
					typo = typo.replace('net', '.net');
					typo = typo.replace('..net', '.net');
					
					typo = typo.replace('uk', '.uk');
					typo = typo.replace('..uk', '.uk');
					
					typo = typo.replace('eu', '.eu');
					typo = typo.replace('..eu', '.eu');
					
					typo = typo.replace('ch', '.ch');
					typo = typo.replace('..ch', '.ch');
					
					typo = typo.replace('au', '.au');
					typo = typo.replace('..au', '.au');
					
					typo = typo.replace('nz', '.nz');
					typo = typo.replace('..nz', '.nz');
					
					typo = typo.replace('gov', '.gov');
					typo = typo.replace('..gov', '.gov');
					
					typo = typo.replace('info', '.info');
					typo = typo.replace('..info', '.info');
					
					typo = typo.replace('biz', '.biz');
					typo = typo.replace('..biz', '.biz');
					
					return typo;
				}

				/* Test for extra letter */
				const extraLetterRegEx = new RegExp(`${firstPart}.${secondPart}`);
				
				if (extraLetterRegEx.test(longString)) {
					return longString.replace(extraLetterRegEx, shortString);
				}

				/* Test for missing letter */
				if (secondPart !== 'mail') {
					const missingLetterRegEx = new RegExp(`${firstPart}{0}${secondPart}`);
					
					if (missingLetterRegEx.test(longString)) {
						return longString.replace(missingLetterRegEx, shortString);
					}
				}

				/* Test for switched letters */
				const switchedLetters = [
					shortString.substring(0, i - 1),
					shortString.charAt(i),
					shortString.charAt(i - 1),
					shortString.substring(i + 1),
				].join('');

				if (_.includes(longString, switchedLetters)) {
					return longString.replace(switchedLetters, shortString);
				}
			}

			/* If nothing was close, then there wasn't a typo */
			return '';
		};

		this.checkForDomainTypo = userEmail => {
			const domains = ['gmail', 'hotmail', 'outlook', 'yahoo', 'icloud', 'mail', 'zoho', 'btinternet', 'delaneymethod', 'grampianfasteners'];
			
			const [leftPart, rightPart] = userEmail.split('@');

			for (let i = 0; i < domains.length; i++) {
				const domain = domains[i];
			
				const result = this.checkForCloseMatch(rightPart, domain);
				
				if (result) {
					return `${leftPart}@${result}`;
				}
			}
			
			return '';
		};
			
		this.checkForNameTypo = (userEmail, name) => {
			const [leftPart, rightPart] = userEmail.split('@');
			
			const result = this.checkForCloseMatch(leftPart, name);
			
			if (result) {
				return `${result}@${rightPart}`;
			}
			
			return '';
		};

		this.checkForCommonTypos = userInput => {
			const commonTypos = [
				{
					pattern: /,com$/,
					fix: str => str.replace(/,com$/, '.com'),
				}, {
					pattern: /,co\.\w{2}$/,
					fix: str => str.replace(/,(co\.\w{2}$)/, '.$1'),
				}, {
					pattern: /@\w*$/,
					fix: str => str + '.com',
				},
			];
		
			typo = commonTypos.find(typo => typo.pattern.test(userInput));
			
			if (typo) {
				let correction = typo.fix(userInput);
				
				/* Try to be even cleverer and correct TLD typos after applying original fixes */
				correction = correction.replace('es.com', '.es');
				correction = correction.replace('fr.com', '.fr');
				correction = correction.replace('it.com', '.it');
				correction = correction.replace('de.com', '.de');
				correction = correction.replace('nl.com', '.nl');
				correction = correction.replace('be.com', '.be');
				correction = correction.replace('no.com', '.no');
				correction = correction.replace('ie.com', '.ie');
				correction = correction.replace('com.com', '.com');
				correction = correction.replace('couk.com', '.co.uk');
				correction = correction.replace('org.com', '.org');
				correction = correction.replace('net.com', '.net');
				correction = correction.replace('uk.com', '.uk');
				correction = correction.replace('eu.com', '.eu');
				correction = correction.replace('ch.com', '.ch');
				correction = correction.replace('au.com', '.au');
				correction = correction.replace('nz.com', '.nz');
				correction = correction.replace('gov.com', '.gov');
				correction = correction.replace('info.com', '.info');
				correction = correction.replace('biz.com', '.biz');
				correction = correction.replace('co.uk.co.uk', '.co.uk');
				
				return correction;
			}
			
			return '';
		};
		
		this.checkForTypo = userInput => {
			let firstName = '';
			
			let lastName = '';
			
			if (userInput.firstName) {
				firstName = userInput.firstName.trim().toLowerCase();
			}
			
			if (userInput.lastName) {
				lastName = userInput.lastName.trim().toLowerCase();
			}
			
			const email = userInput.email.trim().toLowerCase();
			
			return this.checkForCommonTypos(email) || this.checkForDomainTypo(email) || this.checkForNameTypo(email, firstName) || this.checkForNameTypo(email, lastName);
		};
		
		this.getNthSuffix = date => {
			switch (date) {
				case 1:
				case 21:
				case 31:
					return 'st';
				
				case 2:
				case 22:
					return 'nd';
				
				case 3:
				case 23:
					return 'rd';
				
				default:
					return 'th';
			}
		};
		
		this.getMonthName = month => {
			let months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		
			return months[month];
		};
		
		this.attachClipboard = () => {
			let clipboard = new Clipboard('[data-clipboard]');
			
			clipboard.on('success', event => {
				event.clearSelection();
				
				$('#clipboard-tooltip').tooltip('show');
				
				$('#clipboard-tooltip').on('hidden.bs.tooltip', () => {
					$('#clipboard-tooltip').tooltip('dispose');
				});
			});
			
			clipboard.on('error', event => {
				console.error('Action:', event.action);
				
				console.error('Trigger:', event.trigger);
			});
		};
		
		this.init = () => {
			console.info(this.name + ' v' + this.version + ' is ready!');
			
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
			
			this.loadAnimations();
			
			this.loadListeners();
			
			this.attachClipboard();
			
			this.attachDataTable('#datatable');
			
			return this;
		};
		
		return this.init();
	};
})(jQuery);

window.CMS.Library = $.delaneyMethodCMSLibrary();
