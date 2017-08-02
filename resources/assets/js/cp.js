window._ = require('lodash');

window.$ = window.jQuery = require('jquery');

window.Tether = require('tether');

window.axios = require('axios');

window.axios.defaults.headers.common = {
	'X-Requested-With': 'XMLHttpRequest',
	'X-CSRF-TOKEN': window.Laravel.csrfToken
};

require('bootstrap');

require('bootstrap-datetime-picker');

require('chart.js');

require('../plugins/redactor/redactor');

require('../plugins/redactor/plugins/source');

require('../plugins/redactor/plugins/table');

require('../plugins/redactor/plugins/alignment/alignment');

require('../plugins/redactor/plugins/fullscreen');

require('../plugins/redactor/plugins/filemanager');

require('../plugins/redactor/plugins/imagemanager');

require('../plugins/redactor/plugins/video');

require('../plugins/jquery-ui/sortable');

require('../plugins/jquery-ui/sortable-nested');

require('../plugins/datatables/datatables');

require('../plugins/datatables/datatables-bootstrap');

require('../plugins/grampianfasteners/controlpanel');
