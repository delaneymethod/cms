/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

const del = require('del');
const { mix } = require('laravel-mix');

del(['html/assets/css/**', 'html/assets/img/**', 'html/assets/fonts/**', 'html/assets/js/control-panel.js', 'html/assets/js/templates.js']);

mix.setPublicPath('html');

if (mix.inProduction) {
    mix.disableNotifications();
}

if (!mix.inProduction) {
	mix.sourceMaps();
}
	
mix.options({
	processCssUrls: false
});

mix.sass('resources/assets/sass/templates.scss', 'html/assets/css/templates.css');

mix.sass('resources/assets/sass/control-panel.scss', 'html/assets/css/control-panel.css');

mix.js('resources/assets/js/templates.js', 'html/assets/js/templates.js');

mix.js('resources/assets/js/control-panel.js', 'html/assets/js/control-panel.js');

mix.copy('resources/assets/fonts', 'html/assets/fonts');

mix.copy('node_modules/font-awesome/fonts', 'html/assets/fonts');

mix.copy('node_modules/slick-carousel/slick/fonts', 'html/assets/fonts');

mix.copy('resources/assets/img', 'html/assets/img');

mix.version();
