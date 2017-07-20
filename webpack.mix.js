const del = require('del');
const { mix } = require('laravel-mix');

del(['public/assets/**', '!public/assets']);

mix.setPublicPath('public');

if (mix.inProduction) {
    mix.disableNotifications();
}

if (!mix.inProduction) {
	mix.sourceMaps();
}

mix.options({
	processCssUrls: false
});

mix.sass('resources/assets/sass/global.scss', 'public/assets/css/global.css');

mix.sass('resources/assets/sass/cp.scss', 'public/assets/css/cp.css');

mix.js('resources/assets/js/global.js', 'public/assets/js/global.js');

mix.js('resources/assets/js/cp.js', 'public/assets/js/cp.js');

mix.copy('resources/assets/fonts', 'public/assets/fonts');

mix.copy('node_modules/font-awesome/fonts', 'public/assets/fonts');

mix.copy('resources/assets/img', 'public/assets/img');

mix.version();
