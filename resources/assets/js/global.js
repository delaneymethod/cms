/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

window.Tether = require('tether');

window.Popper = require('popper.js').default;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axiosCancel = require('axios-cancel').default;

window.axiosCancel(window.axios, {
	debug: false
});

require('lazyload');

require('jquery-inview');

require('bootstrap');

require('../plugins/delaneymethod/cms');
