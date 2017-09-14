const del = require('del');
const { mix } = require('laravel-mix');

del(['html/assets/**', '!html/assets']);

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

mix.sass('resources/assets/sass/global.scss', 'html/assets/css/global.css');

mix.sass('resources/assets/sass/cp.scss', 'html/assets/css/cp.css');

mix.js('resources/assets/js/global.js', 'html/assets/js/global.js');

mix.js('resources/assets/js/cp.js', 'html/assets/js/cp.js');

mix.copy('resources/assets/fonts', 'html/assets/fonts');

mix.copy('node_modules/font-awesome/fonts', 'html/assets/fonts');

mix.copy('resources/assets/img', 'html/assets/img');

mix.version();
