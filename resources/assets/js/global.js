window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

window.Tether = require('tether');

window.axios = require('axios');

window.axios.defaults.headers.common = {
	'X-Requested-With': 'XMLHttpRequest',
	'X-CSRF-TOKEN': window.Laravel.csrfToken
};

require('bootstrap');
