/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

window.Tether = require('tether');

if (window.User) {
	window.Echo = require('laravel-echo');

	window.Pusher = require('pusher-js');
}

window.Popper = require('popper.js').default;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axiosCancel = require('axios-cancel').default;

window.axiosCancel(window.axios, {
	debug: false
});

window.FastClick = require('fastclick');

window.Clipboard = require('clipboard');

require('jquery-inview');

require('slick-carousel');

require('bootstrap');

require('../plugins/unveil');

require('../plugins/password-strength');

require('../plugins/datatables/datatables');

require('../plugins/datatables/datatables-bootstrap');

require('../plugins/delaneymethod/cms/library');

window.IndexedDB = require('../plugins/delaneymethod/cms/library/idb');

require('../plugins/delaneymethod/cms/library/store');

require('../plugins/delaneymethod/cms/templates');
