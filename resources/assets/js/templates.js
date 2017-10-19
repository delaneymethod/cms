/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

window.Tether = require('tether');

window.Echo = require('laravel-echo');

window.Pusher = require('pusher-js');

window.Popper = require('popper.js').default;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axiosCancel = require('axios-cancel').default;

window.axiosCancel(window.axios, {
	debug: false
});

window.FastClick = require('fastclick');

window.Clipboard = require('clipboard');

require('lazyload');

require('jquery-inview');

require('slick-carousel');

require('bootstrap');

require('../plugins/password-strength');

require('../plugins/datatables/datatables');

require('../plugins/datatables/datatables-bootstrap');

require('../plugins/delaneymethod/cms/library');

require('../plugins/delaneymethod/cms/templates');
